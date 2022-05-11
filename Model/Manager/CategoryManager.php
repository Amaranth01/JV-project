<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\Category;

class CategoryManager
{

    public const PREFIXTABLE = 'jvp_';

    /**
     * @param string $name
     * @return Category
     */
    public static function getCategoryByName(string $name): Category {
        $category = new Category();
        $request  = DB::getPDO()->query("
            SELECT * FROM " . self::PREFIXTABLE . "category WHERE category_name = '".$name."'
        ");
        if ($request && $categoryData = $request->fetch()) {
            $category->setId($categoryData['id']);
            $category->setCategoryName($categoryData['category_name']);
        }
        return $category;
    }

    /**
     * @return array
     */
    public static function getAllCategories(): array
    {
        $stmt = DB::getPDO()->query("SELECT * FROM " . self::PREFIXTABLE . "category ORDER BY id");
        $categories = [];
        foreach ($stmt->fetchAll() as $data) {
            $categories[] = (new Category())
                ->setId($data['id'])
                ->setCategoryName($data['category_name'])
            ;
        }
        return $categories;
    }
}