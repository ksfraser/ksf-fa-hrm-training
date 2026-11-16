-- ksf_FA_HRM_Training: training course and enrollment tables

CREATE TABLE IF NOT EXISTS `0_hrm_training_courses` (
  `course_id`     INT(11) NOT NULL AUTO_INCREMENT,
  `course_code`   VARCHAR(32) NOT NULL,
  `title`         VARCHAR(255) NOT NULL,
  `provider`      VARCHAR(255) DEFAULT NULL,
  `cost`          DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `duration_hours` DECIMAL(5,2) NOT NULL DEFAULT 0.00,
  `expiry_months` INT(11) NOT NULL DEFAULT 12,
  `created_at`    DATETIME NOT NULL,
  `updated_at`    DATETIME NOT NULL,
  PRIMARY KEY (`course_id`),
  UNIQUE KEY `uq_course_code` (`course_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `0_hrm_training_enrollments` (
  `enrollment_id` INT(11) NOT NULL AUTO_INCREMENT,
  `course_id`     INT(11) NOT NULL,
  `person_id`     INT(11) NOT NULL COMMENT 'FK to crm_persons.id (employee)',
  `enrolled_at`   DATETIME NOT NULL,
  `completed_at`  DATETIME DEFAULT NULL,
  `status`        VARCHAR(24) NOT NULL DEFAULT 'enrolled' COMMENT 'enrolled|in_progress|completed|expired',
  `certificate_no` VARCHAR(64) DEFAULT NULL,
  `score`         DECIMAL(5,2) DEFAULT NULL,
  PRIMARY KEY (`enrollment_id`),
  KEY `idx_course` (`course_id`),
  KEY `idx_person` (`person_id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
