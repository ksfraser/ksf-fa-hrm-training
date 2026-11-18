<?php
declare(strict_types=1);

use Ksfraser\FrontAccounting\HRM\Training\Controller\TrainingTabController;

$path_to_root = '../..';

require_once($path_to_root . '/includes/session.inc');

if (!function_exists('page_security')) {
    define('page_security', 'SA_HRM_TRAINING_VIEW');
}

$controller = new TrainingTabController(null, array());
$controller->render();
