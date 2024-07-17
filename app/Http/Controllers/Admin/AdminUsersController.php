<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AdminUsersDataTable;
use App\Enums\Role\AdminEnum;
use App\Enums\UserStatusEnum;
use App\Http\Requests\AdminUser\StoreRequest;
use App\Http\Requests\AdminUser\UpdateRequest;
use App\Models\Consumer;
use App\Models\User;
use App\Services\AdminUserService;
use Illuminate\Http\Request;
use JavaScript;

class AdminUsersController extends Controller
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
    public function __construct(AdminUserService $service)
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
        $roles = AdminEnum::toSelectArray();

        return view('admin.users.admin.index', compact('roles'));
    }

    /**
     * Fetch the users data for datatable.
     *
     * @param AdminUsersDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(AdminUsersDataTable $dataTable)
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
        $roles = AdminEnum::toSelectArray();

        return view('admin.users.admin.create', compact('status', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $user = $this->service->invite(
            $request->all()
        );

        if ($user) {
            flash('Admin user created successfully')->success();
        } else {
            flash('Admin user could not be created. Please try again.')->error();
        }

        return redirect()->route('admin.users.admin.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $status = UserStatusEnum::toSelectArray();
        $roles = AdminEnum::toSelectArray();
        JavaScript::put([
            'user' => $user->id,
        ]);

        return view('admin.users.admin.edit', compact('user', 'status', 'roles'));
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
        $user = $this->service->update(
            $user,
            $request->all()
        );

        if ($user) {
            flash('Admin user updated successfully')->success();
        } else {
            flash('Admin user could not be updated. Please try again.')->error();
        }

        return redirect()->route('admin.users.admin.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {
            flash('Admin user deleted successfully')->success();
        } else {
            flash('Admin user could not be deleted. Please try again.')->error();
        }

        return redirect()->route('admin.users.admin.index');
    }

    public function validateEmail(Request $request, $user = null)
    {
        $query = User::where('email', $request->get('email'));
        if ($user) {
            $query = $query->where('id', '!=', $user);
        }
        if ($query->count() === 0) {
            return 'true';
        }

        return 'false';
    }

    public function validateUserName(Request $request, $user = null)
    {
        $query = User::where('username', $request->get('username'));
        if ($user) {
            $query = $query->where('id', '!=', $user);
        }
        if ($query->count() === 0) {
            return 'true';
        }

        return 'false';
    }

    public function search(Request $request)
    {
        $params = explode('+', $request->all()['search']);

        $fname = $lname = $params[0];

        if (count($params) > 1) {
            $search = str_replace('+', ' ', $request->all()['search']);
            $lname = substr($search, strpos($search, ' ') + 1);
        }

        $consumers = Consumer::join('users', function ($query) use ($fname, $lname) {
            $query->on('users.id', '=', 'consumers.user_id')
                                        ->where(function ($q) use ($fname, $lname) {
                                            $q->where('users.first_name', 'LIKE', '%'.$fname.'%');
                                            if ($fname == $lname) {
                                                $q->orWhere('users.last_name', 'LIKE', '%'.$lname.'%');
                                            } else {
                                                $q->where('users.last_name', 'LIKE', '%'.$lname.'%');
                                            }
                                        });
        })
                    ->selectRaw('consumers.id as id, concat(users.first_name, " ", users.last_name) as text')
                    ->limit(100)
                    ->get();

        return $consumers;
    }

    public function searchEmail(Request $request)
    {
        $params = explode('+', $request->all()['search']);

        $fname = $lname = $params[0];

        if (count($params) > 1) {
            $search = str_replace('+', ' ', $request->all()['search']);
            $lname = substr($search, strpos($search, ' ') + 1);
        }

        $consumers = Consumer::join('users', function ($query) use ($fname, $lname) {
            $query->on('users.id', '=', 'consumers.user_id')
                                        ->where(function ($q) use ($fname, $lname) {
                                            $q->where('users.first_name', 'LIKE', '%'.$fname.'%');
                                            if ($fname == $lname) {
                                                $q->orWhere('users.last_name', 'LIKE', '%'.$lname.'%');
                                            } else {
                                                $q->where('users.last_name', 'LIKE', '%'.$lname.'%');
                                            }
                                        });
        })
                            ->selectRaw('consumers.id as id, concat(users.first_name, " ", users.last_name, " (", users.email , ")") as text')
                            ->limit(100)
                            ->get();

        return $consumers;
    }
}
