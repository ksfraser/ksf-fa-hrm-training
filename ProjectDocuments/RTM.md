# ksf_FA_HRM_Training — Requirements Traceability Matrix

| Req ID | Requirement | Source | Implemented In | Verified By |
|--------|-------------|--------|----------------|-------------|
| BR-HRM-08 | Training management | HR-CRM_gaps.md H8 | TrainingService | unit tests |
| FR-TR-01 | Create course | BR-HRM-08 | TrainingRepository::insertCourse | TrainingDtoTest |
| FR-TR-02 | List courses | BR-HRM-08 | TrainingService::listAll | (tab controller) |
| FR-TR-03 | Resolve course by id | BR-HRM-08 | TrainingService::resolveById | (capability hook) |
| FR-TR-04 | Update course | BR-HRM-08 | TrainingService::updateState | (service) |
| FR-TR-05 | RELATED_TO_FIELDS | BR-HRM-08 | hooks.php RELATED_TO_FIELDS | (capability) |
| NF-TR-01 | Native db_* calls | AGENTS_ARCH | repository | code review |
| NF-TR-02 | PHP 7.3 compatible | AGENTS_ARCH | all src | code review |
| NF-TR-03 | Unit tests | AGENTS_ARCH | tests/Unit | phpunit |
