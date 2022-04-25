<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\Platform;

class PlatformManager
{

    public function getPlatformByName(string $platformName): Platform
    {
        $platform = new Platform();
        $stmt  = DB::getPDO()->query("
            SELECT * FROM jvp_platform WHERE plateform_name = '".$platformName."'
        ");
        if ($stmt && $platformData = $stmt->fetch()) {
            $platform->setId($platformData['id']);
            $platform->setPlatformName($platformData['category_name']);
        }
        return $platform;
    }
}