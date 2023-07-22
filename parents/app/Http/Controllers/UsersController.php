<?php

namespace App\Http\Controllers;

// use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Collection;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;


class UsersController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:users.index|users.create|users.edit|users-destroy', ['only' => ['index','show']]);
         $this->middleware('permission:users.create', ['only' => ['create','store']]);
         $this->middleware('permission:users.edit', ['only' => ['edit','update']]);
         $this->middleware('permission:users.destroy', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('name', 'LIKE', "%{$value}%")
                        ->orWhere('email', 'LIKE', "%{$value}%");
                });
            });
        });

        $users = QueryBuilder::for(User::class)
            ->where(function ($query) {
                $query->whereNull('user_level')
                      ->orWhere('user_level','!=','2');
            })
            ->defaultSort('name')
            ->allowedSorts(['name', 'email'])
            ->allowedFilters(['name', 'email', $globalSearch])
            ->paginate()
            ->withQueryString();

        return Inertia::render('Users/Index', [
            'users' => $users,
        ])->table(function (InertiaTable $table) {
            $table
              ->withGlobalSearch()
              ->defaultSort('name')
              ->column(key: 'id')
              ->column(key: 'name', searchable: true, sortable: true, canBeHidden: false)
              ->column(key: 'email', searchable: true, sortable: true)
              ->column(label: 'Actions');
        });
    }

    public function create()
    {
        $roles = app(Role::class)
        ->where('name','!=','super-admin')
        ->pluck('name','id')->toArray();
        return Inertia::render('Users/Create',[
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $filed = $request->validate([
            'name' => 'required|string',
            'email' => [
                'required',
                'max:50',
                'email',
                'unique:users',
            ],
            'password' => [
                'required',
                'string',
                'same:password_confirmation',
                'min:6',             // must be at least 6 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            'password_confirmation' => [
                'required',
                'min:6',
            ],
            'roles' => ['required']
        ]);
        $user =User::create([
            'name' => $filed['name'],
            'email' => $filed['email'],
            'password' => bcrypt($filed['password'])
        ]);
        $user->assignRole($filed['roles']);
        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        $roles = app(Role::class)->pluck('name','id')->toArray();
        $userRole = $user->roles->pluck('name','id')->toArray();
        return Inertia::render('Users/Edit',[
            'user' => $user,
            'roles' => $roles,
            'userRole'=>$userRole
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return Inertia::render('Users/Show',[
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $filed = $request->validate([
            'name' => 'required|string',
            'email' => [
                'required',
                'max:50',
                'unique:users,email,'.$user->id
            ],
            'roles' => ['required'],
        ]);
        $user->update([
            'name' => $filed['name'],
            'email' => $filed['email']
        ]);
        DB::table('model_has_roles')->where('model_id',$user['id'])->delete();
        $user->assignRole($filed['roles']);
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }

    public function faceUser()
    {
        return Inertia::render('Users/FaceUser');
    }

}
