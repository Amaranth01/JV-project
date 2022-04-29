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

    public static function getAllCategories()
    {
        $stmt = DB::getPDO()->query("SELECT * FROM jvp_category ORDER BY id");
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