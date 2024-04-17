<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Collection;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Jobs\CreatePermissionsJob;

class RoleController extends Controller
{
    public function index()
    {
        $list_permissions = config('role-permission.permissions');
        foreach ($list_permissions as $permission) {
            $arr = collect($permission);
            $arr->filter(function ($value, $key) {
                $permiss = Permission::where('name', $key)->first();
                if (is_null($permiss)) {
                    CreatePermissionsJob::dispatch();
                }
            });
           
        }
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

        return Inertia::render('Roles/Index', [
            'roles' => $roles,
        ])->table(function (InertiaTable $table) {
            $table
              ->withGlobalSearch()
              ->defaultSort('name')
              ->column(key: 'id')
              ->column(key: 'name', searchable: true, sortable: true, canBeHidden: false)
              ->column(label: 'Actions');
        });
    }
    public function create()
    {
        $permissions = Permission::all();
        $list_permissions = config('role-permission.permissions');
        return Inertia::render('Roles/Create',[
            'permissions'=>$permissions,
            'list_permissions'=>$list_permissions
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'data_permissions' => 'required',
        ]);
        // dd($request->all());
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);
        $role->syncPermissions($request->data_permissions);

        return redirect()->route('roles.index');
    }

    // public function listsSchedule()
    // {
    //     $start_date = "";

    //     $period = CarbonPeriod::create('2024-01-01', '2024-01-31');

    //     $result=[];
    //     foreach ($period as $date) {
    //         $date = $date->format('Y-m-d');
    //         $result[] = $date;
    //     }

    //     // dd($result);
    // }
}
