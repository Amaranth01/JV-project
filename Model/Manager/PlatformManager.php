<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\Platform;

class PlatformManager
{
    public const PREFIXTABLE = 'jvp_';

    /**
     * Get the platform for the sort
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