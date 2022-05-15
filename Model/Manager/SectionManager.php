<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\Section;

class SectionManager
{
    public const PREFIXTABLE = 'jvp_';

    /**
     * @param string $sectionName
     * @return Section
     */
    public static function getSectionByName(string $sectionName): Section
    {
        $section = new Section();
        $stmt  = DB::getPDO()->query("
            SELECT * FROM " . self::PREFIXTABLE . "section WHERE section_name = '".$sectionName."'
        ");
        if ($stmt && $sectionData = $stmt->fetch()) {
            $section->setId($sectionData['id']);
            $section->setSectionName($sectionData['section_name']);
        }
        return $section;
    }
}