<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Artisan;
// use App\Models\Role;
use App\Models\Permission;

class PermissionsServiceProvider extends ServiceProvider
{
    public $permission_is_use = false;
    public $role_is_use = false;
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    public function __construct()
    {
        if (config('auth.permission.type') === 'U' || config('auth.permission.type') === 'M') {
            $this->permission_is_use = true;
        } else {
            $this->permission_is_use = false;
        }

        if (config('auth.permission.type') === 'R' || config('auth.permission.type') === 'M') {
            $this->role_is_use = true;
        } else {
            $this->role_is_use = false;
        }
      
        $pObj = $this;
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Permission::get()->map(function ($permission) {         
            Artisan::call('view:clear');
            Gate::define($permission->slug, function ($user) use ($permission) {
                return $user->hasPermissionTo($permission);
            });
        });

        //Blade directives
        Blade::directive('role', function ($role) {
            $isUse = $this->role_is_use;
            return "<?php if( (auth()->check() && auth()->user()->hasRole({$role})) || ('{$isUse}' == false)) : ?>";
        });

        Blade::directive('elserole', function ($role) {
            $isUse = $this->role_is_use;
            return "<?php elseif((auth()->check() && auth()->user()->hasRole({$role})) || ('{$isUse}' == false)): ?>";
        });

        Blade::directive('endrole', function ($role) {
            return "<?php endif; ?>";
        });

        Blade::directive('permissions', function ($permissions) {
            $isUse = $this->permission_is_use;
            return "<?php if( (auth()->check() && auth()->user()->can({$permissions})) || ('{$isUse}' == false) ):  ?>";
        });

        Blade::directive('elsepermissions', function ($permissions) {
            $isUse = $this->permission_is_use;
            return "<?php elseif( (auth()->check() && auth()->user()->can({$permissions})) || ('{$isUse}' == false)): ?>";
        });

        Blade::directive('endpermissions', function ($permissions) {

            return "<?php endif; ?>";
        });

        Blade::directive('anypermissions', function ($permissions) {
            $isUse = $this->permission_is_use;

            $permissions = explode('|', str_replace('\'', '', $permissions));

            $expression = "<?php if( (auth()->check() && ( false";
           
                        foreach ($permissions as $permission) {
                
                            $expression .= " || auth()->user()->can('{$permission}')";
                        }
            
                        $aa =  $expression . ")) || ('{$isUse}' == false) ): ?>";
           
            return $aa;
        });

        Blade::directive('endanyppermissions', function ($permissions) {

            return "<?php endif; ?>";
        });

        Blade::directive('anygrouppermissions',function ($permissions) {
            $isUse = $this->permission_is_use;
            $permissions = explode('|', str_replace('\'', '', $permissions));
            $expression = "<?php if( (auth()->check() && ( false";

            foreach ($permissions as $permission) {
                
                $expression .= " || auth()->user()->hasGroupPermission('{$permission}') ";
            }

            $aa =  $expression . ")) || ('{$isUse}' == false) ): ?>";

            return $aa;

        });
        Blade::directive('endanygrouppermissions', function ($permissions) {
            return "<?php endif; ?>";
        });
    }

    function multiPermissions($permissions){
       
        return $permissions;
    }
}
