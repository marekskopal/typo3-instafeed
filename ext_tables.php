<?php

defined('TYPO3_MODE') or die();

call_user_func(function() {

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'MsInstafeed',
        'Instafeed',
        'Instafeed'
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('ms_instafeed', 'Configuration/TypoScript', 'Instafeed');

});
