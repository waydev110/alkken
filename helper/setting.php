<?php
    
    require_once __DIR__ . '/../model/Setting.php';
    
    define('SITE_HOST', (new Setting())->show('site_host'));
    define('SITENAME', (new Setting())->show('sitename'));
    define('SITE_PT', (new Setting())->show('site_pt'));