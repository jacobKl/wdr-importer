<?php

use WdrGsheetsImporter\Admin\Synchronizer;

define('WP_USE_THEMES', false);
require_once(__DIR__ . '/../../.././wp-load.php');

$sync = new Synchronizer();
$sync->sync();