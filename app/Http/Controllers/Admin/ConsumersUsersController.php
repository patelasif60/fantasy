<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ConsumerUsersDataTable;
use App\Enums\UserStatusEnum;
use App\Exports\UsersExport;
use App\Http\Requests\Consumer\StoreRequest;
use App\Http\Requests\Consumer\UpdateRequest;
use App\Models\User;
use App\Services\ConsumerUserService;
use JavaScript;
use Maatwebsite\Excel\Facades\Excel;

class ConsumersUsersController extends Controller
{
    /**
     * @var ConsumerService
     */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @param ConsumerService $service
     */
    public function __construct(ConsumerUserService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        JavaScript::put([
            'status' => UserStatusEnum::toArray(),
        ]);

        return view('admin.users.consumer.index');
    }

    /**
     * Fetch the users data for datatable.
     *
     * @param AdminUsersDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(ConsumerUsersDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = UserStatusEnum::toSelectArray();

        return view('admin.users.consumer.create', compact('status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $data = $request->all();
        $data['dob'] = carbon_create_from_date($data['dob']);
        $consumer = $this->service->create($data);

        if ($consumer) {
            if ($request->hasFile('avatar')) {
                $avatar = $consumer->addMediaFromRequest('avatar');
                if ($crop = $request->imageshouldBeCropped('avatar')) {
                    $avatar->withManipulations([
                        'thumb' => [
                            'manualCrop' => $request->getCropParameters($crop),
                        ],
                    ]);
                }
                $avatar->toMediaCollection('avatar');
            }
            flash('Consumer created successfully')->success();
        } else {
            flash('Consumer could not be created. Please try again.')->error();
        }

        return redirect()->route('admin.users.consumers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $avatarObject = $user->consumer->getMedia('avatar')->last();

        $avatar = '';
        if ($avatarObject) {
            $avatar = [
                'name' => $avatarObject->file_name,
                'type' => $avatarObject->mime_type,
                'size' => $avatarObject->size,
                'file' => $avatarObject->getUrl('thumb'),
                'data' => [
                    'url' => $avatarObject->getUrl('thumb'),
                    'id' => $avatarObject->id,
                ],
            ];
            $avatar = json_encode($avatar);
        }
        $status = UserStatusEnum::toSelectArray();
        JavaScript::put([
            'user' => $user->id,
        ]);

        return view('admin.users.consumer.edit', compact('user', 'avatar', 'status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, User $user)
    {
        $data = $request->all();
        $data['dob'] = carbon_create_from_date($data['dob']);

        $consumer = $this->service->update(
            $user,
            $data
        );

        if ($consumer) {
            if ($request->hasFile('avatar')) {
                $avatar = $consumer->addMediaFromRequest('avatar');

                if ($crop = $request->imageshouldBeCropped('avatar')) {
                    $avatar->withManipulations([
                        'thumb' => [
                            'manualCrop' => $request->getCropParameters($crop),
                        ],
                    ]);
                }

                $avatar->toMediaCollection('avatar');
            } else {
                $returnVal = $request->imageShouldBeDeleted('avatar');
                if ($returnVal) {
                    $this->service->avatarDestroy($consumer);
                }
            }

            flash('Consumer updated successfully')->success();
        } else {
            flash('Consumer could not be updated. Please try again.')->error();
        }

        return redirect()->route('admin.users.consumers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->service->avatarDestroy($user->consumer);

        if ($user->delete()) {
            flash('Consumer deleted successfully')->success();
        } else {
            flash('Consumer could not be deleted. Please try again.')->error();
        }

        return redirect()->route('admin.users.consumers.index');
    }

    public function export()
    {
        $name = 'User List-'.config('app.name').'-'.date('d-m-Y');

        return Excel::download(new UsersExport, $name.'.csv');
    }
}
