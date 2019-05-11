<?php

namespace MarekSkopal\MsInstafeed\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2019 Marek Skopal <skopal.marek@gmail.com>
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

    /** @var User */
    protected $user;

    /** @var Image */
    protected $imageThumbnail;

    /** @var Image */
    protected $imageLowResolution;

    /** @var Image */
    protected $imageStandardResolution;

    /** @var \DateTime */
    protected $createdTime;

    /** @var Caption */
    protected $caption;

    /** @var bool */
    protected $userHasLiked;

    /** @var int */
    protected $likes;

    /** @var array */
    protected $tags;

    /** @var string */
    protected $filter;

    /** @var string */
    protected $type;

    /** @var string */
    protected $link;

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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Image
     */
    public function getImageThumbnail(): Image
    {
        return $this->imageThumbnail;
    }

    /**
     * @param Image $imageThumbnail
     */
    public function setImageThumbnail(Image $imageThumbnail): void
    {
        $this->imageThumbnail = $imageThumbnail;
    }

    /**
     * @return Image
     */
    public function getImageLowResolution(): Image
    {
        return $this->imageLowResolution;
    }

    /**
     * @param Image $imageLowResolution
     */
    public function setImageLowResolution(Image $imageLowResolution): void
    {
        $this->imageLowResolution = $imageLowResolution;
    }

    /**
     * @return Image
     */
    public function getImageStandardResolution(): Image
    {
        return $this->imageStandardResolution;
    }

    /**
     * @param Image $imageStandardResolution
     */
    public function setImageStandardResolution(Image $imageStandardResolution): void
    {
        $this->imageStandardResolution = $imageStandardResolution;
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
     * @return Caption
     */
    public function getCaption(): Caption
    {
        return $this->caption;
    }

    /**
     * @param Caption $caption
     */
    public function setCaption(Caption $caption): void
    {
        $this->caption = $caption;
    }

    /**
     * @return bool
     */
    public function isUserHasLiked(): bool
    {
        return $this->userHasLiked;
    }

    /**
     * @param bool $userHasLiked
     */
    public function setUserHasLiked(bool $userHasLiked): void
    {
        $this->userHasLiked = $userHasLiked;
    }

    /**
     * @return int
     */
    public function getLikes(): int
    {
        return $this->likes;
    }

    /**
     * @param int $likes
     */
    public function setLikes(int $likes): void
    {
        $this->likes = $likes;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return string
     */
    public function getFilter(): string
    {
        return $this->filter;
    }

    /**
     * @param string $filter
     */
    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
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

}
