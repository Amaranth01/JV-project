<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\Role;

class RoleManager
{

    /**
     * @param int $id
     * @return Role
     */
    public static function getRoleById(int $id): Role
    {
        $role = new Role();
        $stmt = DB::getPDO()->prepare("SELECT * FROM jvp_role WHERE id = :id");

        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if($roleData = $stmt->fetch()) {
            $role->setId($roleData['id']);
            $role->setRoleName($roleData['role_name']);
        }
        return $role;
    }

    /**
     * @param string $roleName
     * @return Role
     */
    public static function getRoleByName(string $roleName): Role
    {
        $role = new Role();
        $request = DB::getPDO()->query("
            SELECT * FROM jvp_role WHERE role_name = '".$roleName."'
        ");
        if($request && $roleData = $request->fetch()) {
            $role->setId($roleData['id']);
            $role->setRoleName($roleData['role_name']);
        }
        return $role;
    }
}