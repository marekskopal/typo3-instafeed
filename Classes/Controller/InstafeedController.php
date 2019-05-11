<?php

namespace MarekSkopal\MsInstafeed\Controller;

use MarekSkopal\MsInstafeed\Domain\Repository\InstafeedRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Object\ObjectManager;

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
 * Instafeed controller
 */
class InstafeedController extends ActionController
{

    /**
     * @var InstafeedRepository
     */
    protected $instafeedRepository = null;

    /**
     * InstafeedController constructor
     */
    public function __construct()
    {
        parent::__construct();

        /** @var ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var ConfigurationManager $configurationManager */
        $configurationManager = $objectManager->get(ConfigurationManager::class);
        $settings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'MsInstafeed');

        $this->instafeedRepository = $objectManager->get(InstafeedRepository::class, $settings['accessToken']);
    }

    /**
     * Action for posts list
     * @return void
     */
    public function listAction(): void
    {
        $limit = null;
        if (is_numeric($this->settings['list']['limit'])) {
            $limit = $this->settings['list']['limit'];
        }

        $posts = $this->instafeedRepository->findPosts($limit);

        $this->view->assign('posts', $posts);
    }

}
