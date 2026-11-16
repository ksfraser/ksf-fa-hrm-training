# ksf_FA_HRM_Training — Requirements

## Purpose
Manage training courses and certifications: course catalog, enrollments, expiry tracking and completion records.

## Business Rules (BR-HRM-08)
- A training course has a code, title, provider, cost, duration and expiry (months).
- Course codes are unique.
- Enrollments link an employee to a course with a status and optional certificate number/score.
- Expiry is tracked in months from creation/completion.

## Functional Requirements
- FR-TR-01: Create a training course.
- FR-TR-02: List all training courses (summary table).
- FR-TR-03: Resolve a single course by id (related-record linking).
- FR-TR-04: Update course expiry/provider.
- FR-TR-05: Expose training course fields via RELATED_TO_FIELDS.

## Non-Functional Requirements
- NF-TR-01: All database access uses native FA db_* calls.
- NF-TR-02: PHP 7.3 compatible runtime.
- NF-TR-03: Unit tests cover DTO round-trip and label resolution.
