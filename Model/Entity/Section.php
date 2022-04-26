<?php

namespace App\Model\Entity;

class Section extends AbstractEntity
{
    private string $sectionName;

    /**
     * @return string
     */
    public function getSectionName(): string
    {
        return $this->sectionName;
    }

    /**
     * @param string $sectionName
     * @return Section
     */
    public function setSectionName(string $sectionName): self
    {
        $this->sectionName = $sectionName;
        return $this;
    }


}