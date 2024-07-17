<?php

namespace App\Http\Controllers\Manager;

use Mail;
use JavaScript;
use App\Models\Team;
use App\Models\Pitch;
use App\Models\Season;
use App\Enums\YesNoEnum;
use App\Models\Division;
use App\Services\TeamService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\PredefinedCrest;
use App\Services\DivisionService;
use App\Http\Controllers\Controller;
use App\Services\LeaguePaymentService;
use App\Http\Requests\Team\CreateRequest;
use App\Http\Requests\Budget\UpdateRequest;
use App\Http\Requests\Team\UpdateOwnRequest;
use App\Mail\Manager\Divisions\LeagueJoinMail;
use App\Events\Manager\Divisions\TeamIgnoreEvent;
use App\Events\Manager\Divisions\TeamApprovalEvent;

class TeamsController extends Controller
{
    /**
     * @var InviteService
     */
    protected $service;

    /**
     * @var LeaguePaymentService
     */
    protected $leaguePaymentService;

    /**
     * @var DivisionService
     */
    protected $divisionService;

    /**
     * InviteManagersController constructor.
     *
     * @param InviteService $service
     * @param LeaguePaymentService $leaguePaymentService
     */
    public function __construct(TeamService $service, LeaguePaymentService $leaguePaymentService, DivisionService $divisionService)
    {
        $this->service = $service;
        $this->leaguePaymentService = $leaguePaymentService;
        $this->divisionService = $divisionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Division $division)
    {
        $user = $request->user();
        $predefinedCrests = PredefinedCrest::where('is_published', 1)->get();
        $crests = collect($predefinedCrests);

        $via = $skipUrl = null;

        if ($request->get('via')) {
            $via = $request->get('via');
        } else {
            $skipUrl = route('manage.division.teams.index');
            if ($request->user()->isNewUser()) {
                $skipUrl = route('manage.division.app.info', ['division' => $division]);
            }
        }

        return view('manager.divisions.create_team', compact('division', 'user', 'crests', 'via', 'skipUrl'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateTeamName(Request $request)
    {
        return $this->service->validateTeamName($request->get('name'));
    }

    public function edit(Division $division, Team $team)
    {
        $this->authorize('isChairmanOrManager', $division);

        $crests = PredefinedCrest::where('is_published', 1)->get();

        $crestObject = $team->getMedia('crest')->last();
        $teamCrest = '';
        if ($crestObject) {
            $crest = [
                'name' => $crestObject->file_name,
                'type' => $crestObject->mime_type,
                'size' => $crestObject->size,
                'file' => $crestObject->getUrl('thumb'),
                'data' => [
                    'url' => $crestObject->getUrl('thumb'),
                    'id' => $crestObject->id,
                    'readerForce'=> true,
                ],
            ];
            $teamCrest = json_encode($crest);
        }

        return view('manager.divisions.edit_team', compact('division', 'team', 'crests', 'teamCrest'));
    }

    public function store(CreateRequest $request, Division $division)
    {
        if (! $request->user()->can('checkMaxTeamsQuota', $division)) {

            flash(__('messages.divisions.max_team'))->error()->important();

            return redirect(route('landing'));
        }

        if ($division->package->private_league == YesNoEnum::NO) {
            
            $team = $division->divisionTeams()->where('manager_id', $request->user()->consumer->id);
            if ($team->count() > 0) {
                $price = $prize = $division->getPrice();
                $teamPayment = $checkPaymentForSocialLeague = $this->leaguePaymentService->checkPaymentForSocialLeague($request->user()->consumer->id, $division);
                $team = team::find($teamPayment->team_id);
                $via = 'social';
                $teamId = $teamPayment->team_id;
                if ($teamPayment->payment_id > 0) {
                    return redirect(route('manage.division.join.already.social-league'));
                } else {
                    $teamId = $teamPayment->team_id;

                    return  view(
                    'manager.divisions.payment.checkout',
                     $this->leaguePaymentService->getCheckoutData(['teams'=>[$teamId => $prize], '_token'=>csrf_token()], $division, $request->user()),
                     compact('team', 'via', 'teamId', 'prize')
                    );
                }
            }
        }
        $preUrl = parse_url(url()->previous());
        $data = $request->all();
        $data['manager_id'] = $request->user()->consumer->id;
        $data['email'] = $request->user()->email;
        $data['division_id'] = $division->id;
        $data['is_approved'] = $division->package->private_league == YesNoEnum::NO ? 1 : 0;
        $data['max_free_places'] = $division->package->max_free_places;
        $sendMail = false;
        $data['private_league'] = $division->package->private_league;
        $sendTeamConformationMail = false;
        if (isset($preUrl['query']) && $preUrl['query'] == 'via=invite' || $request->user()->can('ownLeagues', $division)) {
            $data['is_approved'] = 1;
            $sendTeamConformationMail = true;
        }

        if (isset($preUrl['query']) && ($preUrl['query'] == 'via=invite' || $preUrl['query'] == 'via=join') && ! $request->user()->can('ownLeagues', $division)) {
            $sendMail = true;
        }

        $team = $this->service->create($data);
        if ($team) {
            if ($request->hasFile('crest')) {
                $crest = $team->addMediaFromRequest('crest');

                $manipulations = [];
                if ($crop = $request->imageshouldBeCropped('crest')) {
                    $manipulations['manualCrop'] = $request->getCropParameters($crop);
                }
                if ($rotation = $request->imageShouldBeRotated('crest')) {
                    $manipulations['orientation'] = 360 - (int) $rotation;
                }
                $crest->withManipulations([
                    'thumb' => $manipulations,
                ]);
                $crest->toMediaCollection('crest');
                $team = $this->service->updateCrest($team, []);
            } else {
                $returnVal = $request->imageShouldBeDeleted('crest');
                if ($returnVal) {
                    $this->service->crestDestroy($team);
                }
                $team = $this->service->updateCrest($team, $request->all());
            }

            if ($sendMail) {
                Mail::to($division->consumer->user->email)->send(new LeagueJoinMail($team));
            }
            if ($sendTeamConformationMail || $division->package->private_league == YesNoEnum::NO) {
                $this->service->sendTeamConformationMail($team);
            }
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();
        }

        $via = '';

        if (! empty($request->get('via'))) {
            $via = $request->get('via');
        }

        if ($request->user()->isNewUser() && $via != 'social') {
            return redirect(route('manage.division.app.info', ['division' => $division, 'via' => $via]));
        }

        if ($request->user()->isNewUser() && $via == 'social') {
            $teamId = $team->id;
            $prize = $division->getPrice();

            return view(
                'manager.divisions.payment.checkout',
                $this->leaguePaymentService->getCheckoutData(['teams'=>[$team->id => $prize], '_token'=>$data['_token']], $division, $request->user()),
                compact('team', 'via', 'teamId', 'prize')
            );
        }

        return redirect(route('manage.division.info', ['division' => $division, 'team' => $team, 'via' => $via]));
    }

    public function update(CreateRequest $request, Division $division, Team $team)
    {
        $this->authorize('isChairmanOrManager', $division);

        $data = $request->all();
        $data['crest_id'] = $team->crest_id;
        $data['pitch_id'] = $team->pitch_id;
        $data['manager_id'] = $request->user()->consumer->id;
        $team = $this->service->update($team, $data);

        if ($team) {
            if ($request->hasFile('crest')) {
                $crest = $team->addMediaFromRequest('crest');

                if ($crop = $request->imageshouldBeCropped('crest')) {
                    $crest->withManipulations([
                        'thumb' => [
                            'manualCrop' => $request->getCropParameters($crop),
                        ],
                    ]);
                }
                $crest->toMediaCollection('crest');
                $team = $this->service->updateCrest($team, []);
            } else {
                $returnVal = $request->imageShouldBeDeleted('crest');
                if ($returnVal) {
                    $this->service->crestDestroy($team);
                }
                $team = $this->service->updateCrest($team, $request->all());
            }

            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();
        }
        if ($team->divisionTeam->payment_id == null) {
            $via = 'social';
            $teamId = $team->id;
            $prize = $division->getPrice();

            return view(
                'manager.divisions.payment.checkout',
                $this->leaguePaymentService->getCheckoutData(['teams'=>[$team->id => $prize], '_token'=>$data['_token']], $division, $request->user()),
                compact('team', 'via', 'teamId', 'prize')
            );
        }

        return redirect(route('manage.division.select.pitch', ['division' => $division, 'team' => $team]));
    }

    public function selectPitch(Request $request, Division $division, Team $team)
    {
        $this->authorize('update', $team);

        $pitches = Pitch::where('is_published', '1')->get();

        $via = '';

        if (! empty($request->get('via'))) {
            $via = $request->get('via');
        }

        return view('manager.divisions.select_pitch', compact('team', 'pitches', 'division', 'via'));
    }

    public function assignPitch(Request $request, Division $division, Team $team)
    {
        $this->authorize('update', $team);

        $team = $this->service->updatePitch($team, $request->all());

        if ($team) {
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();
        }

        $div = $request->user()->consumer->divisions->where('id', $division->id)->count();

        if ($request->get('via') && $request->get('via') == 'social') {
            return redirect(route('manage.division.payment.teams', ['division'=>$division, 'via'=>'social']));
        }

        return redirect(route('manage.teams.index', ['division' => $division]));
    }

    public function index(Request $request)
    {
        $divisions = $request->user()->consumer->ownDivisionWithRegisterTeam();
        if ($divisions) {
            $division = $divisions->first();

            if (! $division->isLeagueAccessible()) {
                return redirect(route('manage.division.payment.index', ['division' => $division, 'type'=>'league']));
            }

            if ($division->isInAuctionState()) {
                return redirect(route('manage.auction.index', ['division' => $division]));
            }

            if ($division->isPostAuctionState()) {
                return redirect(route('manage.division.info', ['division' => $division]));
            }
        }

        return redirect(route('manage.teams.index', ['division' => $division]));
    }

    public function teamIndex(\Illuminate\Http\Request $request, Division $division)
    {
        $teams = $division->divisionTeams()->approve()->get();
        $user = $request->user();
        $ownTeam = $user->consumer->ownTeamDetails($division);

        return view('manager.divisions.teams.index', compact('division', 'teams', 'user', 'ownTeam'));
    }

    public function teamSettings(Division $division, Team $team)
    {
        return view('manager.divisions.teams.settings', compact('division', 'team'));
    }

    public function teamSettingsEdit(Division $division, Team $team)
    {
        $this->authorize('isChairmanOrManager', [$division, $team]);

        //$pitches = $this->service->getPitches();
        $crests = $this->service->getPredefinedCrests();
        $crestObject = $team->getMedia('crest')->last();
        $ownCrest = '';
        if ($crestObject) {
            $ownCrest = [
                'name' => $crestObject->file_name,
                'type' => $crestObject->mime_type,
                'size' => $crestObject->size,
                'file' => $crestObject->getUrl('thumb'),
                'data' => [
                    'url' => $crestObject->getUrl('thumb'),
                    'id' => $crestObject->id,
                    'readerForce'=> true,
                ],
            ];
            $ownCrest = json_encode($ownCrest);
        }

        return view('manager.divisions.teams.settings_edit', compact('division', 'team', 'crests', 'ownCrest'));
    }

    public function teamSettingsUpdate(Division $division, Team $team, UpdateOwnRequest $request)
    {
        $this->authorize('isChairmanOrManager', [$division, $team]);

        $data = $request->all();
        $data['manager_id'] = $team->manager_id;

        $team = $this->service->update(
            $team,
            $data
        );
        if ($team) {
            if ($request->hasFile('crest')) {
                $crest = $team->addMediaFromRequest('crest');

                $manipulations = [];
                if ($crop = $request->imageshouldBeCropped('crest')) {
                    $manipulations['manualCrop'] = $request->getCropParameters($crop);
                }
                if ($rotation = $request->imageShouldBeRotated('crest')) {
                    $manipulations['orientation'] = 360 - (int) $rotation;
                }
                $crest->withManipulations([
                    'thumb' => $manipulations,
                ]);
                $crest->toMediaCollection('crest');
                $team = $this->service->updateCrest($team, []);
            } else {
                $returnVal = $request->imageShouldBeDeleted('crest');
                if ($returnVal) {
                    $this->service->crestDestroy($team);
                }
            }

            flash(__('messages.data.updated.success'))->success();
        } else {
            flash(__('messages.data.updated.error'))->error();
        }
        if ($team->isTeamSquadFull()) {
            return redirect()->route('manage.team.lineup', ['division' => $division, 'team' => $team]);
        }

        return redirect()->route('manage.division.info', ['division' => $division]);
    }

    public function approveTeam(Division $division, Team $team)
    {
        $this->authorize('ownLeagues', $division);

        $teamTmp = $team;
        $team = $this->service->approveTeam($team);

        $this->service->sendTeamConformationMail($team);
        // Fire off the event
        event(new TeamApprovalEvent($teamTmp, $teamTmp->consumer->user));

        $team_approvals = $this->divisionService->teamApprovals($division);

        if ($team_approvals->count() == 0) {
            // return ['redirect' => route('manage.division.info', ['division' => $division])];
            return ['redirect' => route('manage.division.payment.index', ['division' => $division, 'type'=>'league'])];
        }

        return ['success' => true];
    }

    public function ignoreTeam(Division $division, Team $team)
    {
        $this->authorize('ownLeagues', $division);

        $teamTmp = $team;
        $team = $this->service->ignoreTeam($team);
        $team->teamDivision()->attach($division->id, ['season_id'=> Season::getLatestSeason(), 'is_free'=>false]);
        // Fire off the event
        event(new TeamIgnoreEvent($teamTmp, $teamTmp->consumer->user));
        $team_approvals = $this->divisionService->teamApprovals($division);

        if ($team_approvals->count() == 0) {
            return ['redirect' => route('manage.division.info', ['division' => $division])];
        }

        return ['success' => true];
    }

    public function appInfo(Division $division, Team $team)
    {
        return view('manager.divisions.user_app_info', ['division' => $division]);
    }

    public function delete(Team $team, Request $request)
    {
        $division = $team->teamDivision->first();

        $this->authorize('isChairmanOrManager', [$division, $team]);
        
        $delete = $this->service->delete($team);

        if ($delete) {
            flash(__('messages.data.deleted.success'))->success();
        } else {
            flash(__('messages.data.deleted.error'))->error();
        }

        if (request()->method() === 'DELETE') {

            return redirect()->route('manage.division.payment.index', ['division' => $division, 'type'=>'league']);
        }

        return redirect(route('manage.division.teams.index'));
    }

    public function teamBudget(Division $division)
    {
        $consumer = auth()->user()->consumer;

        $this->authorize('isChairmanOrManager', [$division, $consumer->ownTeamDetails($division)]);

        JavaScript::put([
            'ownLeague' => $consumer->ownLeagues($division),
            'ownTeam' => $consumer->ownTeamDetails($division),
            'division' => $division,
        ]);

        return view('manager.divisions.teams.team_budget', compact('division'));
    }

    public function teamsBudgetList(Division $division)
    {
        $consumer = auth()->user()->consumer;

        $this->authorize('isChairmanOrManager', [$division, $consumer->ownTeamDetails($division)]);
        
        $divisionTeams = $this->service->getDivisionTeamsDetails($division);

        return response()->json([
            'data' => $divisionTeams,
        ]);
    }

    public function teamsBudgetUpdate(Division $division, UpdateRequest $request)
    {
        $this->authorize('ownLeagues', $division);

        $data = $this->service->teamsBudgetUpdate($division, $request->all());
        
        if ($data) {
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();
        }

        return redirect()->route('manage.transfer.index', ['division' => $division]);
    }

    public function teamSquads(Request $request, Division $division)
    {
        $players = $this->service->getTeamDivisionPoints($division, $request->get('team_id'));

        return view('manager.divisions.info.team_squad', compact('players'));
    }
}
