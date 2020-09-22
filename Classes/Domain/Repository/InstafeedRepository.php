<?php

namespace MarekSkopal\MsInstafeed\Domain\Repository;

use MarekSkopal\MsInstafeed\Domain\Model\Post;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use TYPO3\CMS\Core\Resource\DuplicationBehavior;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2020 Marek Skopal <skopal.marek@gmail.com>
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
class InstafeedRepository implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /** @var \RestClient */
    private $client;

    /**
     * InstafeedRepository constructor.
     * @param string $accessToken
     */
    public function __construct(string $accessToken)
    {
        $this->client = new \RestClient([
            'base_url' => 'https://graph.instagram.com/',
            'user_agent' => 'ms_instafeed',
            'parameters' => [
                'access_token' => $accessToken
            ],
        ]);
    }

    /**
     * Finds posts
     * @param int|null $limit
     * @return array
     */
    public function findPosts(?int $limit = null): array
    {
        $parameters = [
            'fields' => 'id,caption,comments_count,like_count,media_type,media_url,permalink,username,timestamp'
        ];

        if ($limit > 0) {
            $parameters['limit'] = $limit;
        }

        $posts = [];

        try {
            $response = $this->client->get('me/media', $parameters);
            $mediaItems = $response->decode_response();

            if (isset($mediaItems->error)) {
                $this->logger->error('Instagram feed can\'t be loaded. - ' . $mediaItems->error->message);
            }

            if (isset($mediaItems->data)) {
                foreach ($mediaItems->data as $mediaItem) {
                    $post = $this->createPostFromMediaItem($mediaItem);

                    if ($post !== null) {
                        $posts[] = $post;
                    }
                }
            }
        } catch (\RestClientException $exception) {
            $this->logger->warning('Instagram feed can\'t be loaded. - ' . $exception->getMessage());
        }

        return $posts;
    }

    /**
     * Creates Post entity from media item object
     * @param \stdClass $mediaItem
     * @return Post|null
     * @throws \Exception
     */
    private function createPostFromMediaItem(\stdClass $mediaItem): ?Post
    {
        if (empty($mediaItem->media_url)) {
            return null;
        }

        $tempFile = GeneralUtility::tempnam('ms_instafeed_' . $mediaItem->id . '_');
        GeneralUtility::writeFile($tempFile, file_get_contents($mediaItem->media_url));

        $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
        $storage = $resourceFactory->getDefaultStorage();

        if (!$storage->hasFolder('ms_instafeed')) {
            $folder = $storage->createFolder('ms_instafeed');
        } else {
            $folder = $storage->getFolder('ms_instafeed');
        }

        $imageFile = $storage->addFile(
            $tempFile,
            $folder,
            'ms_instafeed_' . $mediaItem->id . '.jpg',
            DuplicationBehavior::REPLACE
        );

        /** @var Post $post */
        $post = GeneralUtility::makeInstance(Post::class);
        $post->setId($mediaItem->id);
        $post->setUsername($mediaItem->username);
        $post->setImage($imageFile);
        $post->setLink($mediaItem->permalink);
        $post->setCreatedTime(new \DateTime($mediaItem->timestamp));
        $post->setCaption($mediaItem->caption);

        return $post;
    }

}