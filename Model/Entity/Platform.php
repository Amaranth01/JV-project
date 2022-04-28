<?php

namespace App\Model\Entity;

class Platform extends AbstractEntity
{
    private string $platformName;

    /**
     * @return string
     */
    public function getPlatformName(): string
    {
        return $this->platformName;
    }

    /**
     * @param string $platformName
     * @return Platform
     */
    public function setPlatformName(string $platformName): self
    {
        $this->platformName = $platformName;
        return $this;
    }


}