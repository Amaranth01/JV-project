<?php

namespace Classes;

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../Model/Manager/UserManager.php';
require __DIR__ . '/../../Model/Entity/AbstractEntity.php';
require __DIR__ . '/../../Model/Entity/User.php';
require __DIR__ . '/../../Model/DB.php';
require __DIR__ . '/../../Config.php';
require __DIR__ . '/../../Model/Manager/RoleManager.php';
require __DIR__ . '/../../Model/Entity/Role.php';

use App\Model\Entity\User;
use App\Model\Manager\UserManager;
use PHPUnit\Framework\TestCase;

class UserManagerTest extends TestCase
{
    private UserManager $userManager;

    public function __construct()
    {
        parent::__construct();
        $this->userManager = new UserManager;
    }

    public function testGetUser() {
        $result = $this->userManager->getUser(1);
        $this->assertIsInt(1, "L'ID est bien récupéré");
    }

    public function testDeleteUser() {
        $result = $this->userManager->deleteUser(1);
        $this->assertNotNull($result);
    }
}