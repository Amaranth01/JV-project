<?php

namespace App\Model\Entity;

use DateTime;

class Article extends AbstractEntity
{
    private string $title;
    private string $content;
    private string $image;
    private string $resume;
    private DateTime $date;
    private User $user;
    private Platform $platform;
    private Category $category;
    private Section $section;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Article
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Article
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getResume(): string
    {
        return $this->resume;
    }

    /**
     * @param string $resume
     * @return Article
     */
    public function setResume(string $resume): self
    {
        $this->resume = $resume;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return Article
     */
    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

//    /**
//     * @return DateTime
//     */
//    public function getDate(): DateTime
//    {
//        return $this->date;
//    }
//
//    /**
//     * @param DateTime $date
//     * @return Article
//     */
//    public function setDate(DateTime $date): self
//    {
//        $this->date = $date;
//        return $this;
//    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Article
     */
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Platform
     */
    public function getPlatform(): Platform
    {
        return $this->platform;
    }

    /**
     * @param Platform $platform
     * @return Article
     */
    public function setPlatform(Platform $platform): self
    {
        $this->platform = $platform;
        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return Article
     */
    public function setCategory(Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return Section
     */
    public function getSection(): Section
    {
        return $this->section;
    }

    /**
     * @param Section $section
     * @return Article
     */
    public function setSection(Section $section): self
    {
        $this->section = $section;
        return $this;
    }

}