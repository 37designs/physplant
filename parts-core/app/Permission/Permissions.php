<?php

namespace App\Permission;

use App\Permission;
use App\Role;

class Permissions
{
	const R_Foreperson = "foreperson";
	const R_Material = "material";
	const R_Admin = "admin";
	const R_New = "new";

	const P_Shop_Request = "shop_request";
	const P_Material_Request = "material_request";
	const P_Settings_Page = "settings_page";
	const P_Change_Shop = "change_shop";
	const P_Access_User_Permissions = "access_user_permissions_page";
	const P_Access_Techs = "access_techs_page";
	const P_Access_All_Requests = "access_all_requests";
	const P_Access_Received_Manager = "access_received_manager";


	public static function GeneratePermissions()
	{
		$shop_req = Permissions::newPermission(Permissions::P_Shop_Request, "Shop Request", "Allows access to use/see shop requests page.");
		$material_req = Permissions::newPermission(Permissions::P_Material_Request, "Material Request", "Allows access to use/see materials request page.");
		$settings_page = Permissions::newPermission(Permissions::P_Settings_Page, "Settings Page", "Allows access to use/see settings page.");
		$change_shop = Permissions::newPermission(Permissions::P_Change_Shop, "Change Shop", "Allows access to change shops.");
		$access_user_permissions = Permissions::newPermission(Permissions::P_Access_User_Permissions, "Access User Permissions", "Allows access to user permissions page.");
		$access_techs = Permissions::newPermission(Permissions::P_Access_Techs, "Access Techs settings", "Allows access to techs page.");
		$access_all_requests = Permissions::newPermission(Permissions::P_Access_All_Requests, "Access All Requests", "Allows access to all requests page.");
		$access_received_manager = Permissions::newPermission(Permissions::P_Access_Received_Manager, "Access Received Manager", "Allows access to received manager page.");

		Permissions::newRole(Permissions::R_Foreperson, "Foreperson", "",
				[
						$shop_req,
						$settings_page,
						$change_shop,
						$access_techs,
						$access_all_requests
				]);

		Permissions::newRole(Permissions::R_Material, "Material", "",
				[
						$material_req,
						$settings_page,
						$access_all_requests,
						$access_received_manager
				]);

		Permissions::newRole(Permissions::R_Admin, "Admin", "Allows access to everything.",
				[
						$change_shop,
						$settings_page,
						$material_req,
						$shop_req,
						$access_user_permissions,
						$access_techs,
						$access_all_requests,
						$access_received_manager
				]);

		Permissions::newRole(Permissions::R_New, "New", "A person that is new to the system.");
	}

	public static function newPermission($name, $displayName, $description)
	{
		$perm = new Permission();
		$perm->name = $name;
		$perm->display_name = $displayName; // optional
		$perm->description = $description; // optional
		$perm->save();

		return $perm;
	}

	public static function newRole($name, $displayName, $description, $permissions = null)
	{
		$role = new Role();
		$role->name = $name;
		$role->display_name = $displayName;
		$role->description = $description;
		$role->save();

		if ($permissions !== null)
		{
			$role->attachPermissions($permissions);
		}

		return $role;
	}
}