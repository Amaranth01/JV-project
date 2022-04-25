<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\Category;

class CategoryManager
{

    public static function getCategoryByName(string $name): Category {
        $category = new Category();
        $request  = DB::getPDO()->query("
            SELECT * FROM jvp_category WHERE category_name = '".$name."'
        ");
        if ($request && $categoryData = $request->fetch()) {
            $category->setId($categoryData['id']);
            $category->setCategoryName($categoryData['category_name']);
        }
        return $category;
    }
}