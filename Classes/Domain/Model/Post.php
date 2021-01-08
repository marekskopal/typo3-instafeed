<?php

namespace MarekSkopal\MsInstafeed\Domain\Model;

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\ResourceFactory;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Marek Skopal <skopal.marek@gmail.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Post model
 */
class Post
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $username;

    /** @var int */
    protected $imageUid;

    /** @var string */
    protected $link;

    /** @var \DateTime */
    protected $createdTime;

    /** @var string */
    protected $caption;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return int
     */
    public function getImageUid(): int
    {
        return $this->imageUid;
    }

    /**
     * @param string $image
     */
    public function setImageUid(int $imageUid): void
    {
        $this->imageUid = $imageUid;
    }

    /**
     * @return File
     */
    public function getImage(): File
    {
        $resourceFactory = ResourceFactory::getInstance();
        return $resourceFactory->getFileObject($this->getImageUid());
    }

    /**
     * @param string $image
     */
    public function setImage(File $image): void
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedTime(): \DateTime
    {
        return $this->createdTime;
    }

    /**
     * @param \DateTime $createdTime
     */
    public function setCreatedTime(\DateTime $createdTime): void
    {
        $this->createdTime = $createdTime;
    }

    /**
     * @return string
     */
    public function getCaption(): string
    {
        return $this->caption;
    }

    /**
     * @param string $caption
     */
    public function setCaption(string $caption): void
    {
        $this->caption = $caption;
    }
}
