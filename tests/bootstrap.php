<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Ksfraser\FrontAccounting\HRM\Training\Service\TrainingService;

if (!defined('TB_PREF')) {
    define('TB_PREF', '0_');
}
if (!function_exists('db_query')) {
    function db_query($sql, $errorMsg = null) { return false; }
}
if (!function_exists('db_fetch_assoc')) {
    function db_fetch_assoc($result) { return false; }
}
if (!function_exists('db_num_rows')) {
    function db_num_rows($result) { return 0; }
}
if (!function_exists('db_escape')) {
    function db_escape($value) { return addslashes((string) $value); }
}
if (!function_exists('db_insert_id')) {
    function db_insert_id() { return 0; }
}
if (!function_exists('_')) {
    function _($str) { return $str; }
}
