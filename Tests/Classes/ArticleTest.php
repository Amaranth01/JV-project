<?php

namespace Classes;

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../Model/Entity/AbstractEntity.php';
require __DIR__ . '/../../Model/Entity/Article.php';


use App\Model\Entity\Article;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    Private Article $article;

    public function __construct(string $title = null)
    {
        parent::__construct($title);
        $this->article = new Article;
    }

    public function testGetTitle(): void
    {
        $this->article->setTitle('Valhalla');
        $result = $this->article->getTitle();
        $this->assertNotNull($result);
    }

    public function testGetContent(): void
    {
        $this->article->setContent('Hey');
        $result = $this->article->getContent();
        $this->assertNotNull($result);
    }
}