<?php

defined('TYPO3_MODE') or die();

call_user_func(function() {

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'MarekSkopal.MsInstafeed',
        'Instafeed',
        [
            \MarekSkopal\MsInstafeed\Controller\InstafeedController::class => 'list'
        ]
    );

    if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['msinstafeed_posts'] ?? null)) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['msinstafeed_posts'] = [];
    }

});