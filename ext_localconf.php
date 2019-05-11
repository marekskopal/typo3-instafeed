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

});
