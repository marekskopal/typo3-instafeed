<?php

namespace MarekSkopal\MsInstafeed\Domain\Repository;

use Http\Client\Exception\NetworkException;
use MarekSkopal\MsInstafeed\Domain\Model\Caption;
use MarekSkopal\MsInstafeed\Domain\Model\Image;
use MarekSkopal\MsInstafeed\Domain\Model\Post;
use MarekSkopal\MsInstafeed\Domain\Model\User;
use Psr\Log\LoggerAwareTrait;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use Vinkla\Instagram\Instagram;
use Vinkla\Instagram\InstagramException;

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
 * Instafeed repository
 */
class InstafeedRepository
{
    use LoggerAwareTrait;

    /** @var Instagram */
    private $instagram;

    public function __construct(string $accessToken)
    {
        $this->instagram = GeneralUtility::makeInstance(Instagram::class, $accessToken);
    }

    /**
     * Finds posts
     * @param int|null $limit
     * @return array
     */
    public function findPosts(?int $limit = null): array
    {
        $parameters = [];
        if ($limit > 0) {
            $parameters['count'] = $limit;
        }

        $posts = [];

        try {
            $mediaItems = $this->instagram->media($parameters);
            foreach ($mediaItems as $mediaItem) {
                $posts[] = $this->createPostFromMediaItem($mediaItem);
            }
        } catch (NetworkException | InstagramException $exception) {
            $this->logger->warning('Instagram feed can\'t be loaded. - ' . $exception->getMessage());
        }

        return $posts;
    }

    /**
     * Creates Post entity from media item object
     * @param \stdClass $mediaItem
     * @return Post
     * @throws \Exception
     */
    private function createPostFromMediaItem(\stdClass $mediaItem): Post
    {
        /** @var Post $post */
        $post = GeneralUtility::makeInstance(Post::class);
        $post->setId($mediaItem->id);

        /** @var User $user */
        $user = GeneralUtility::makeInstance(User::class);
        $user->setId($mediaItem->user->id);
        $user->setFullname($mediaItem->user->full_name);
        $user->setProfilePicture($mediaItem->user->profile_picture);
        $user->setUsername($mediaItem->user->username);

        $post->setUser($user);

        /** @var Image $imageThumbnail */
        $imageThumbnail = GeneralUtility::makeInstance(Image::class);
        $imageThumbnail->setUrl($mediaItem->images->thumbnail->url);
        $imageThumbnail->setWidth($mediaItem->images->thumbnail->width);
        $imageThumbnail->setHeight($mediaItem->images->thumbnail->height);

        $post->setImageThumbnail($imageThumbnail);

        /** @var Image $imageLowResolution */
        $imageLowResolution = GeneralUtility::makeInstance(Image::class);
        $imageLowResolution->setUrl($mediaItem->images->low_resolution->url);
        $imageLowResolution->setWidth($mediaItem->images->low_resolution->width);
        $imageLowResolution->setHeight($mediaItem->images->low_resolution->height);

        $post->setImageLowResolution($imageLowResolution);

        /** @var Image $imageStandardResolution */
        $imageStandardResolution = GeneralUtility::makeInstance(Image::class);
        $imageStandardResolution->setUrl($mediaItem->images->standard_resolution->url);
        $imageStandardResolution->setWidth($mediaItem->images->standard_resolution->width);
        $imageStandardResolution->setHeight($mediaItem->images->standard_resolution->height);

        $post->setImageStandardResolution($imageStandardResolution);

        $cretatedTime = new \DateTime();
        $cretatedTime->setTimestamp((int)$mediaItem->created_time);
        $post->setCreatedTime($cretatedTime);

        /** @var Caption $caption */
        $caption = GeneralUtility::makeInstance(Caption::class);
        $caption->setId($mediaItem->caption->id);
        $caption->setText($mediaItem->caption->text);
        $captionCretatedTime = new \DateTime();
        $captionCretatedTime->setTimestamp((int)$mediaItem->caption->created_time);
        $caption->setCreatedTime($captionCretatedTime);

        $post->setCaption($caption);

        $post->setUserHasLiked($mediaItem->user_has_liked);
        $post->setLikes($mediaItem->likes->count);
        $post->setTags($mediaItem->tags);
        $post->setFilter($mediaItem->filter);
        $post->setType($mediaItem->type);
        $post->setLink($mediaItem->link);

        return $post;
    }

}