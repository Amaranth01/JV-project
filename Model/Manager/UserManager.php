<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\User;
use App\Model\Manager\RoleManager;

class UserManager
{
    /**
     * @param array $data
     * @return User
     */
    public static function createUser(array $data): User
    {
        return (new User())
            ->setId($data['id'])
            ->setUsername($data['username'])
            ->setEmail($data['email'])
            ->setPassword($data['password'])
            ->setImage($data['image'])
            ->setToken($data['token'])
            ->setRole(RoleManager::getRoleById($data['role_id']))
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
     * Returns a user by their id
     * @param int $id
     * @return User|null
     */
    public static function getUserById(int $id): ?User
    {
        $stmt = DB::getPDO()->query("SELECT * FROM jvp_user WHERE id = '$id'");
        return $stmt ? self::userExists($stmt->fetch()) : null;
    }

    /**
     * Check if the user exist by mail
     * @param string $email
     * @return mixed|null
     */
    public static function userExists(string $email)
    {
        $stmt = DB::getPDO()->query("SELECT count(*) FROM jvp_user WHERE email = '$email'");
        return $stmt ? $stmt->fetch() : null;
    }

    /**
     * @param string $username
     * @return User|null
     */
    public static function getUserByName(string $username): ?User
    {
        $stmt = DB::getPDO()->query("SELECT * FROM jvp_user WHERE username = '$username'");
        return $stmt ? self::usernameExist($stmt->fetch()['username']) : null;
    }

    /**
     * @param string $username
     * @return User|null
     */
    public static function usernameExist(string $username): ?User
    {
        $stmt = DB::getPDO()->query("SELECT * FROM jvp_user WHERE username = '$username'");
        return $stmt ? self::createUser($stmt->fetch()) : null;
    }

    /**
     * @param User $user
     * @return bool
     */
    public static function addUser(User $user): bool
    {
        $stmt = DB::getPDO()->prepare("
            INSERT INTO jvp_user (username, email, password, token, role_id)
            VALUES (:username, :email, :password, :token, :role_id) 
        ");

        $stmt->bindValue('username', $user->getUsername());
        $stmt->bindValue('email', $user->getEmail());
        $stmt->bindValue('password', $user->getPassword());
        $stmt->bindValue('token', 'getToken()');
        $stmt->bindValue('role_id', $user->getRole()->getId());

        $stmt = $stmt->execute();
        $user->setId(DB::getPDO()->lastInsertId());

        return $stmt;
    }

    private static function updateUser()
    {

    }

    private static function updateRoleUser()
    {

    }

    /**
     * Delete a user
     * @param User $user
     * @return bool
     */
    public static function deleteUser(User $user): bool {
        if(self::userExists($user->getId())) {
            return DB::getPDO()->exec("
            DELETE FROM jvp_user WHERE id = {$user->getId()}
        ");
        }
        return false;
    }
}