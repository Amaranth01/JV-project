<?php

use App\Model\Entity\AbstractEntity;
use App\Model\Entity\Article;
use App\Model\Manager\ArticleManager;

require __DIR__ .'/../../Model/Entity/AbstractEntity.php';
require __DIR__ .'/../../Model/Entity/Article.php';
require __DIR__ . '/../../Model/Manager/ArticleManager.php';
require  __DIR__ . '/../../Model/DB.php';
require  __DIR__ . '/../../Config.php';

session_start();

$payload = json_decode(file_get_contents('php://input'));

//We quit if the field is missing

if(empty($payload->content)) {
    // 400 = Bad Request.
    http_response_code(400);
    exit;
}
$array = [];
//Retrieve data
$content = trim(strip_tags($payload->content));
//Instantiate a new object
echo json_encode(ArticleManager::getArticleBySearch($content));

http_response_code(200);
exit;