<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Closure;

class RolePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roles = null, $permission = null)
    {

        if (config('auth.permission.type') === 'U' || config('auth.permission.type') === 'M') {
            $permission_is_use = true;
        } else {
            $permission_is_use = false;
        }

        if (config('auth.permission.type') === 'R' || config('auth.permission.type') === 'M') {
            $role_is_use = true;
        } else {
            $role_is_use = false;
        }

        if ($role_is_use) {
            
            if ($roles !== null && $roles !== '' && $roles !== '*') {   
                $roles = explode('|', $roles);
                if (!$request->user()->hasRole($roles)) {
                    // Log::channel('appsyslog')->info(
                    //     '#log#',
                    //     [
                    //         'username' => Auth::user()->username,
                    //         'ip' => $request->ip(),
                    //         'date' =>  date("Y-m-d H:i:s"),
                    //         'uri' => Route::current()->uri,
                    //         'parameters' => Route::current()->parameters(),
                    //         'route' => Route::currentRouteName(),
                    //         'request' => $request->all(),
                    //         'response_code' => 404,
                    //         'methods' => Route::current()->methods
                    //     ]
                    // );  
                    abort(404);
                }
            }
        }
        
        if ($permission_is_use) {
            //dd($permission);
            if ($permission === null) {
                $permission = $this->mapping_action($request);
            }

            if ($permission !== null && !$request->user()->can($permission)) {
                // Log::channel('appsyslog')->info(
                //     '#log#',
                //     [
                //         'username' => Auth::user()->username,
                //         'ip' => $request->ip(),
                //         'date' =>  date("Y-m-d H:i:s"),
                //         'uri' => Route::current()->uri,
                //         'parameters' => Route::current()->parameters(),
                //         'Route' => Route::currentRouteName(),
                //         'request' => $request->all(),
                //         'response_code' => 404
                //     ]
                // );  
                abort(404);

            }

        }

        return $next($request);
    }

    public function mapping_action($request)
    {
        $permission = false;
        $defaultSlugName = array();
        $defaultSlugName['store'] = 'create';
        $defaultSlugName['show'] = 'read';
        $defaultSlugName['edit'] = 'update';
        $defaultSlugName['destroy'] = 'del';

        list($controller, $action) = explode('.', Route::currentRouteName());
        //dd($controller, $action); 
        if ($action !== 'index') {
            
            if (@isset($defaultSlugName[$action])) {
                $permission = $defaultSlugName[$action] . '.' . $controller;
            } else {
                $permission = $action . '.' . $controller;
            }
          //  dd($controller, $action, $permission);
        } else {

            foreach ($defaultSlugName as $k => $v) {
                $n = $v . '.' . $controller;
              // dd($controller, $action,$n, $request->user()->can($n));
                if ($request->user()->can($n)) {
                    $permission = $n;
                    break;
                }
            }
        }

        return $permission;
    }
}
