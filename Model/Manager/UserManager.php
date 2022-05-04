<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\User;
use PDOStatement;

class UserManager
{
    /**
     * @param array $data
     * @return User
     */
    public static function createUser(array $data): User
    {
        $role = RoleManager::getRoleById($data['role_id']);
        return (new User())
            ->setId($data['id'])
            ->setUsername($data['username'])
            ->setEmail($data['email'])
            ->setPassword($data['password'])
            ->setImage($data['image'])
            ->setToken($data['token'])
            ->setRole($role)
            ;
    }

    /**
     * @return array
     */
    public static function getAllUser(): array
    {
        $user = [];
        $stmt = DB::getPDO()->query("SELECT * FROM jvp_user");

        if($stmt) {
            foreach ($stmt->fetchAll() as $data) {
                $user[] = self::createUser($data);
            }
        }
        return $user;
    }

    /**
     * Returns a user by their mail
     * @param string $email
     * @return mixed|null
     */
    public static function getUserByMail(string $email)
    {
        $stmt = DB::getPDO()->query("SELECT * FROM jvp_user WHERE email = '$email'");
        return $stmt ? self::mailExist($stmt->fetch()) : null;
    }

    /**
     * Check if the mail exist
     * @param string $email
     * @return mixed|null
     */
    public static function mailExist(string $email)
    {
        $stmt = DB::getPDO()->query("SELECT count(*) FROM jvp_user WHERE email = '$email'");
        return $stmt ? $stmt->fetch()['count(*)'] : null;
    }

    /**
     * @param string $username
     * @return User|null
     */
    public static function getUserByName(string $username): ?User
    {
        $stmt = DB::getPDO()->prepare("SELECT * FROM jvp_user WHERE username = :username");

        $stmt->bindValue('username', $username);

        if($stmt->execute() && $data = $stmt->fetch()) {
            return self::createUser($data);
        }
        return null;
    }

    /**
     * @param User $user
     * @return bool
     */
    public static function addUser(User $user): bool
    {
        $stmt = DB::getPDO()->prepare("
            INSERT INTO jvp_user (username, email, password, image, token, role_id)
            VALUES (:username, :email, :password, :image, :token, :role_id) 
        ");

        $stmt->bindValue('username', $user->getUsername());
        $stmt->bindValue('email', $user->getEmail());
        $stmt->bindValue('password', $user->getPassword());
        $stmt->bindValue('image', $user->getImage());
        $stmt->bindValue('token', 'getToken()');
        $stmt->bindValue('role_id', $user->getRole()->getId());

        $stmt = $stmt->execute();
        $user->setId(DB::getPDO()->lastInsertId());

        return $stmt;
    }

    /**
     * Return a user based on its id.
     * @param int $id
     * @return User
     */
    public static function getUser(int $id): ?User
    {
        $stmt = DB::getPDO()->query("SELECT * FROM jvp_user WHERE id = '$id'");
        return $stmt ? self::createUser($stmt->fetch()) : null;
    }

    /**
     * @param $newUsername
     * @param $id
     */
    public function updateUsername($newUsername,$id)
    {
        $stmt = DB::getPDO()->prepare("
            UPDATE jvp_user SET username = :newUsername WHERE id = :id
        ");

        $stmt->bindParam('newUsername', $newUsername);
        $stmt->bindParam('id', $id);

        $stmt->execute();
    }

    public function updateEmail($newEmail, $id)
    {
        $stmt = DB::getPDO()->prepare("
            UPDATE jvp_user SET email = :newEmail WHERE id = :id
        ");

        $stmt->bindParam('newEmail', $newEmail);
        $stmt->bindParam('id', $id);

        $stmt->execute();
    }

    public function updatePassword($newPassword, $id)
    {
        $stmt = DB::getPDO()->prepare("
            UPDATE jvp_user SET password = :newPassword WHERE id = :id
        ");

        $stmt->bindParam('newPassword', $newPassword);
        $stmt->bindParam('id', $id);

        $stmt->execute();
    }

    /**
     * @param $newRole
     * @param $newUsername
     */
    public static function updateRoleUser($newRole, $newUsername)
    {
        $stmt = DB::getPDO()->prepare("UPDATE jvp_user SET role_id = :newRole WHERE username = :newUsername");

        $stmt->bindParam('newRole', $newRole);
        $stmt->bindParam('newUsername', $newUsername);

        $stmt->execute();
    }

    /**
     * Delete a user
     * @param User $user
     * @return bool
     */
    public static function deleteUser(User $user): bool {
        if(self::getUser($user->getId())) {
            return DB::getPDO()->exec("
            DELETE FROM jvp_user WHERE id = {$user->getId()}
        ");
        }
        return false;
    }

    /**
     * @param $newImage
     * @param $id
     * @return false|PDOStatement
     */
    public static function userImage($newImage, $id)
    {
        return DB::getPDO()->query("UPDATE jvp_user SET image = '$newImage' WHERE id = '$id'");
    }
}