<?php

defined('TYPO3_MODE') or die();

call_user_func(function() {

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'MarekSkopal.MsInstafeed',
        'Instafeed',
        [
            'Instafeed' => 'list'
        ]
    );

    if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['msinstafeed_posts'])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['msinstafeed_posts'] = [];
    }

});
