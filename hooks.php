<?php
declare(strict_types=1);
require_once __DIR__ . '/ComposerDependencies.php';
\Ksfraser\FrontAccounting\HRM\Training\Utils\ComposerDependencies::ensure(__DIR__);
$autoload_path = dirname(__FILE__) . '/vendor/autoload.php';
if (file_exists($autoload_path)) { require_once $autoload_path; }
require_once __DIR__ . '/includes/common.inc';
require_once __DIR__ . '/includes/events.inc';
use ksfraser\RelatedTo\DTO\RelatedRecordDto;
define('SS_ksf_FA_HRM_Training', 193 << 8);
if (!defined('SA_HRM_TRAINING_VIEW')) {
    define('SA_HRM_TRAINING_VIEW', SS_ksf_FA_HRM_Training | 1);
    define('SA_HRM_TRAINING_MANAGE', SS_ksf_FA_HRM_Training | 2);
    define('SA_HRM_TRAINING_ADMIN', SS_ksf_FA_HRM_Training | 3);
}
class hooks_ksf_FA_HRM_Training extends hooks {
    const RESPONDERS = array('RELATED_TO_FIELDS', 'TRAINING_RESOLVE', 'TRAINING_FIELDS', 'TRAINING_LIST');
    var $module_name = 'ksf_FA_HRM_Training';
    var $version = '1.0.0';
    function install_tabs($app) { }
    function install_options($app) { }
    function install_access() {
        $security_sections[SS_ksf_FA_HRM_Training] = _("Training");
        $security_areas['SA_HRM_TRAINING_VIEW'] = array(SA_HRM_TRAINING_VIEW, _("View training courses"));
        $security_areas['SA_HRM_TRAINING_MANAGE'] = array(SA_HRM_TRAINING_MANAGE, _("Manage training courses"));
        $security_areas['SA_HRM_TRAINING_ADMIN'] = array(SA_HRM_TRAINING_ADMIN, _("Administer training"));
        return array($security_areas, $security_sections);
    }
    function activate_extension($company, $check_only = true) {
        if ($check_only) { return true; }
        \Ksfraser\FrontAccounting\HRM\Training\Utils\ComposerDependencies::ensure(__DIR__);
        $this->update_databases($company, array(
            '0_hrm_training_courses.sql' => array('hrm_training_courses'),
            '0_hrm_training_enrollments.sql' => array('hrm_training_enrollments'),
        ), false);
        return true;
    }
    private function ensure_composer_dependencies() {
        \Ksfraser\FrontAccounting\HRM\Training\Utils\ComposerDependencies::ensure(__DIR__);
    }
    public function getModuleConstants(&$data, $opts = null) {
        $data['constants'] = array(
            'SS_ksf_FA_HRM_Training' => SS_ksf_FA_HRM_Training,
            'SA_HRM_TRAINING_VIEW' => SA_HRM_TRAINING_VIEW,
            'SA_HRM_TRAINING_MANAGE' => SA_HRM_TRAINING_MANAGE,
            'SA_HRM_TRAINING_ADMIN' => SA_HRM_TRAINING_ADMIN,
        );
        return true;
    }
    public function getModuleCapabilities(&$data, $opts = null) {
        $data['capabilities'] = self::RESPONDERS;
        return true;
    }
    public function hasCapability(&$data, $opts) {
        $capability = is_array($opts) && isset($opts['capability']) ? $opts['capability'] : null;
        if ($capability === null && isset($data['capability'])) { $capability = $data['capability']; }
        $data['has_capability'] = in_array($capability, self::RESPONDERS, true);
        return $data['has_capability'];
    }
    public function respondToCapabilityRequest(&$data, $opts = null) {
        $request = is_array($opts) && isset($opts['request']) ? $opts['request'] : (isset($data['request']) ? $data['request'] : 'capabilities');
        $data['request'] = $request;
        $data['module'] = $this->module_name;
        if (strpos($request, 'has:') === 0) { return $this->hasCapability($data, array('capability' => substr($request, 4))); }
        switch ($request) {
            case 'capabilities': return $this->getModuleCapabilities($data, $opts);
            case 'constants': return $this->getModuleConstants($data, $opts);
            default: $data['error'] = 'Unknown request type: ' . $request; return null;
        }
    }
    public function RELATED_TO_FIELDS(&$data, $opts = null) {
        if (!isset($data['module']) || !is_string($data['module'])) { $data['error'] = 'RELATED_TO_FIELDS requires data[module]'; return null; }
        if (!isset($data['type']) || !is_string($data['type'])) { $data['error'] = 'RELATED_TO_FIELDS requires data[type]'; return null; }
        if ($data['type'] !== 'hrm_training_course') { return null; }
        if (!isset($data['fields']) || !is_array($data['fields'])) { $data['fields'] = array(); }
        $data['fields'] = array_merge($data['fields'], array(
            'course_id' => _('Course ID'),
            'course_code' => _('Course Code'),
            'title' => _('Title'),
            'provider' => _('Provider'),
            'duration_hours' => _('Duration (hours)'),
            'expiry_months' => _('Expiry (months)'),
        ));
        return null;
    }
    public function TRAINING_RESOLVE(&$data, $opts = null) {
        if (!isset($data['course_id']) || !is_numeric($data['course_id'])) { $data['error'] = 'TRAINING_RESOLVE requires data[course_id]'; return null; }
        if (!isset($data['dto']) || !$data['dto'] instanceof RelatedRecordDto) { $data['error'] = 'TRAINING_RESOLVE requires data[dto] as RelatedRecordDto'; return null; }
        $service = new \Ksfraser\FrontAccounting\HRM\Training\Service\TrainingService();
        $data['result'] = $service->resolveById((int) $data['course_id'], $data['dto']);
        return null;
    }
    public function TRAINING_FIELDS(&$data, $opts = null) {
        $data['fields'] = array(
            'course_id' => _('Course ID'),
            'course_code' => _('Course Code'),
            'title' => _('Title'),
            'provider' => _('Provider'),
            'duration_hours' => _('Duration (hours)'),
            'expiry_months' => _('Expiry (months)'),
        );
        return null;
    }
    public function TRAINING_LIST(&$data, $opts = null) {
        $service = new \Ksfraser\FrontAccounting\HRM\Training\Service\TrainingService();
        $data['result'] = $service->listAll();
        return null;
    }
}
