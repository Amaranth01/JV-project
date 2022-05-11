<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\Platform;

class PlatformManager
{
    public const PREFIXTABLE = 'jvp_';

    /**
     * @param string $platformName
     * @return Platform
     */
    public static function getPlatformByName(string $platformName): Platform
    {
        $platform = new Platform();
        $stmt  = DB::getPDO()->query("
            SELECT * FROM " . self::PREFIXTABLE . "platform WHERE platform_name = '".$platformName."'
        ");
        if ($stmt && $platformData = $stmt->fetch()) {
            $platform->setId($platformData['id']);
            $platform->setPlatformName($platformData['platform_name']);
        }
        return $platform;
    }

    /**
     * @param $id
     * @return array
     */
    public static function getPlatformById($id): array
    {
        $platform = [];
        $stmt  = DB::getPDO()->query("
            SELECT * FROM " . self::PREFIXTABLE . "platform WHERE id = '$id'");

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
        $stmt = DB::getPDO()->query("SELECT *FROM " . self::PREFIXTABLE . "platform ORDER BY id");
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