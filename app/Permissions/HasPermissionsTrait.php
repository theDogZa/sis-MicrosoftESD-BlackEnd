<?php

namespace App\Permissions;

use App\Models\Permission;
use App\Models\Role;

trait HasPermissionsTrait
{

	public function givePermissionsTo(...$permissions)
	{
		$permissions = $this->getAllPermissions($permissions);
		if ($permissions === null) {
			return $this;
		}
		$this->permissions()->saveMany($permissions);
		return $this;
	}

	public function withdrawPermissionsTo(...$permissions)
	{
		$permissions = $this->getAllPermissions($permissions);
		$this->permissions()->detach($permissions);
		return $this;
	}

	public function refreshPermissions(...$permissions)
	{
		$this->permissions()->detach();
		return $this->givePermissionsTo($permissions);
	}

	public function hasPermissionTo($permission)
	{
		if (config('auth.permission.type') === 'R') {
			//---- only role_Permission
			return $this->hasPermissionThroughRole($permission);
		} elseif (config('auth.permission.type') === 'U') {
			//---- only user_Permission
			return $this->hasPermission($permission);
		} elseif (config('auth.permission.type') === 'M') {
			//---- muti Permission sum by role_Permission + user_Permission
			return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
		} else {
			//--- not use role && Permission
			return true;
		}
	}

	public function hasPermissionThroughRole($permission)
	{
		//foreach ($permission->roles as $role) {
		foreach ($permission->roles->where('active', 1) as $role) {
			
			if ($this->roles->contains($role)) {
				
				return true;
			}
		}
		return false;
	}

	public function hasRole(...$roles)
	{
		foreach ($roles as $role) {
			
			if (!is_string($role)) {
				$role = $role[0];
			}
			if ($this->roles->contains('slug', $role)) {
				return true;	
			}
		}
		return false;
	}

	public function hasGroupPermission(...$permissions){
		foreach ($permissions as $permission) {

			if (!is_string($permission)) {
				$permission = $permission[0];
			}
			$firstCharacter = substr($permission, 0, 1);

			if($firstCharacter == '*'){
				$per = '%.users';
				$gps =$this->getGroupPermissions($per);
				
				foreach($gps as $p ){
					
					$c = $this->hasPermissionTo($p);
					if ($c) {
						return true;
					}
				}
			}else{
				$per = (object)[];
				$per->slug = $permission;
				
				$c = $this->can($per);
					if ($c) {
						return true;
					}
			}

		}
		return false;
	}

	public function roles()
	{
		return $this->belongsToMany(Role::class, 'users_roles')->where('users_roles.active', 1)->where('roles.active', 1);
	}

	public function permissions()
	{
		return $this->belongsToMany(Permission::class, 'users_permissions')->where('users_permissions.active', 1);
	}

	protected function hasPermission($permission)
	{

		return (bool) $this->permissions->where('slug', $permission->slug)->where('active', 1)->where('roles.active', 1)->count();
	}

	protected function getAllPermissions(array $permissions)
	{
		
		return Permission::whereIn('slug', $permissions)->where('active', 1)->get();
	}
	protected function getGroupPermissions($permissions)
	{

		return Permission::where('slug', 'like', $permissions)->where('active', 1)->get();
	}
	// protected function hasGPermission($permission)
	// {
		
	// 	return (bool) $this->permissions->where('slug', 'like', $permission)->where('active', 1)->where('roles.active', 1)->count();
	// }
}