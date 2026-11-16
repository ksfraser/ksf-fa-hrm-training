<?php
declare(strict_types=1);
namespace Ksfraser\FrontAccounting\HRM\Training\Repository;
final class TrainingRepository {
    private string $table = 'hrm_training_courses';
    public function findAll(): array {
        if (!function_exists('db_query') || !defined('TB_PREF')) { return array(); }
        $sql = "SELECT * FROM " . TB_PREF . $this->table . " ORDER BY course_code ASC, course_id ASC";
        $result = db_query($sql, 'Could not load training courses');
        if ($result === false) { return array(); }
        $rows = array();
        while (($row = db_fetch_assoc($result)) !== false && $row !== null) { $rows[] = $row; }
        return $rows;
    }
    public function findById(int $id): ?array {
        if (!function_exists('db_query') || !defined('TB_PREF')) { return null; }
        $sql = "SELECT * FROM " . TB_PREF . $this->table . " WHERE course_id = " . (int) $id;
        $result = db_query($sql, 'Could not load training course');
        if ($result === false) { return null; }
        $row = db_fetch_assoc($result);
        return $row === false ? null : $row;
    }
    public function insertCourse(array $data): int {
        if (!function_exists('db_query') || !defined('TB_PREF')) { return 0; }
        $sql = "INSERT INTO " . TB_PREF . $this->table . " (
                course_code, title, provider, cost, duration_hours, expiry_months, created_at, updated_at)
            VALUES ("
            . $this->escape($data['course_code'] ?? '') . ", "
            . $this->escape($data['title'] ?? '') . ", "
            . $this->escape($data['provider'] ?? '') . ", "
            . $this->floatVal($data['cost'] ?? 0) . ", "
            . $this->floatVal($data['duration_hours'] ?? 0) . ", "
            . $this->intVal($data['expiry_months'] ?? 12) . ", "
            . $this->escape(date('Y-m-d H:i:s')) . ", "
            . $this->escape(date('Y-m-d H:i:s')) . ")";
        $this->dbQuery($sql);
        return $this->dbInsertId();
    }
    public function updateState(int $courseId, string $expiryMonths, string $provider = null): void {
        if (!function_exists('db_query') || !defined('TB_PREF')) { return; }
        $sets = ["expiry_months = " . $this->intVal($expiryMonths)];
        $sets[] = "provider = " . $this->escape($provider ?? '');
        $sets[] = "updated_at = " . $this->escape(date('Y-m-d H:i:s'));
        $sql = "UPDATE " . TB_PREF . $this->table . " SET " . implode(', ', $sets)
            . " WHERE course_id = " . $this->intVal($courseId);
        $this->dbQuery($sql);
    }
    private function dbQuery($sql, $errorMsg = null) {
        return db_query($sql, $errorMsg);
    }
    private function dbInsertId() {
        return db_insert_id();
    }
    private function escape($value): string {
        if ($value === null) { return 'NULL'; }
        return function_exists('db_escape') ? db_escape($value) : addslashes((string) $value);
    }
    private function intVal($value): int {
        return (int) $value;
    }
    private function floatVal($value): float {
        return (float) $value;
    }
}
