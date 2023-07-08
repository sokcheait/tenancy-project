<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Collection;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DB;    


class RolesController extends Controller
{
    public function __construct()
    {
         $this->middleware('permission:role-index|role-create|role-edit|role-destroy', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-destroy', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Inertia::render('Role/Index');
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('name', 'LIKE', "%{$value}%");
                });
            });
        });

        $roles = QueryBuilder::for(Role::class)
            ->defaultSort('name')
            ->allowedSorts(['name'])
            ->allowedFilters(['name', $globalSearch])
            ->paginate()
            ->withQueryString();
        $view = "Role/Index";
        return Inertia::render($view, [
            'roles' => $roles
        ])->table(function (InertiaTable $table) {
            $table
              ->withGlobalSearch()
              ->column(key: 'id')
              ->column(key: 'name', searchable: true, sortable: true, canBeHidden: false)
              ->column(label: 'Actions');
        });
    }

    public function create()
    {
        $permissions = Permission::all();
        $list_permissions = config('role-permission.permissions');
        return Inertia::render('Role/Create',[
            'permissions'=>$permissions,
            'list_permissions'=>$list_permissions
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
        $request->validate([
            'name' => 'required',
            'permissions' => 'required',
        ]);
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);
        $role->syncPermissions($request->permissions);
        return Inertia::render('Role/Index');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $list_permissions = config('role-permission.permissions');
        $role->permissions->all();
        return Inertia::render('Role/Edit',[
            'role' => $role,
            'permissions'=>$permissions,
            'list_permissions'=>$list_permissions,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => 'required',
        ]);
        $role->update([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);
        $role->syncPermissions($request->permissions);
        
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
