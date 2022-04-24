<?php

namespace App\Model\Entity;

class Platform extends AbstractEntity
{
    private string $plateformeName;

    /**
     * @return string
     */
    public function getPlateformeName(): string
    {
        return $this->plateformeName;
    }

    /**
     * @param string $plateformeName
     * @return Platform
     */
    public function setPlateformeName(string $plateformeName): self
    {
        $this->plateformeName = $plateformeName;
        return $this;
    }


}