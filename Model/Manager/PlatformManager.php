<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\Platform;

class PlatformManager
{

    public static function getPlatformByName(string $platformName): Platform
    {
        $platform = new Platform();
        $stmt  = DB::getPDO()->query("
            SELECT * FROM jvp_platform WHERE platform_name = '".$platformName."'
        ");
        if ($stmt && $platformData = $stmt->fetch()) {
            $platform->setId($platformData['id']);
            $platform->setPlatformName($platformData['platform_name']);
        }
        return $platform;
    }

    public static function getPlatformById($id): array
    {
        $platform = [];
        $stmt  = DB::getPDO()->query("
            SELECT * FROM jvp_platform WHERE id = '$id'");

        if ($stmt) {
            foreach ($stmt->fetchAll() as $data) {
                $comment[] = (new Platform())
                    ->setId($data['id'])
                    ->setPlatformName($data['platform_name'])
                ;
            }
        }
        return $platform;
    }

    /**
     * @return array
     */
    public static function getAllPlatforms(): array
    {
        $stmt = DB::getPDO()->query("SELECT *FROM jvp_platform ORDER BY id");
        $platforms = [];
        foreach ($stmt->fetchAll() as $data) {
            $platforms[] = (new Platform())
                ->setId($data['id'])
                ->setPlatformName($data['platform_name'])
            ;
        }
        return $platforms;
    }
}