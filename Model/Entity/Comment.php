<?php

namespace App\Model\Entity;

class Comment extends AbstractEntity
{
    private String $content;
    private User $user;

    /**
     * @return String
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param String $content
     * @return Comment
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Comment
     */
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

}