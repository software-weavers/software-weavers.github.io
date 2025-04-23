<?php

require_once './i18n/i18n.php';

define('LANG', Language::from(getenv('LANG') ?: 'en'));