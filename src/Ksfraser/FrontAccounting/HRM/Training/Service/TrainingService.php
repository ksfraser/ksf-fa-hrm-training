<?php
declare(strict_types=1);
namespace Ksfraser\FrontAccounting\HRM\Training\Service;
use Ksfraser\FrontAccounting\HRM\Training\DTO\TrainingDTO;
use Ksfraser\FrontAccounting\HRM\Training\Repository\TrainingRepository;
use ksfraser\RelatedTo\DTO\RelatedRecordDto;
final class TrainingService {
    private $repo;
    public function __construct(?TrainingRepository $repo = null) { $this->repo = $repo ?? new TrainingRepository(); }
    public function resolveById(int $id, ?RelatedRecordDto $dto = null): array {
        $row = $this->repo->findById($id);
        if ($row === null) {
            return array('dto' => new RelatedRecordDto('hrm_training_course', '0', 'hrm_training_course', '0', null), 'fields' => $this->fieldMap(), 'labels' => $this->labelMap(), 'url' => '#', 'label' => _('Training Course #') . (string) $id);
        }
        $r = TrainingDTO::fromArray($row);
        $dto = $dto ?? new RelatedRecordDto('hrm_training_course', (string) $r->course_id, 'hrm_training_course', (string) $r->course_id, null);
        return array(
            'dto' => $dto,
            'fields' => array(
                'course_id' => (string) $r->course_id,
                'course_code' => $r->course_code,
                'title' => $r->title,
                'provider' => $r->provider,
                'duration_hours' => $r->duration_hours,
                'expiry_months' => $r->expiry_months,
            ),
            'labels' => $this->labelMap(),
            'url' => '/modules/ksf_FA_HRM_Training/pages/training_course_form.php?action=edit&course_id=' . $r->course_id,
            'label' => $r->getDisplayLabel(),
        );
    }
    public function listAll(): array {
        $rows = $this->repo->findAll();
        $results = array();
        foreach ($rows as $row) {
            $r = TrainingDTO::fromArray($row);
            $results[] = array(
                'id' => $r->course_id,
                'dto' => new RelatedRecordDto('hrm_training_course', (string) $r->course_id, 'hrm_training_course', (string) $r->course_id, null),
                'fields' => array(
                    'course_id' => (string) $r->course_id,
                    'course_code' => $r->course_code,
                    'title' => $r->title,
                    'provider' => $r->provider,
                    'duration_hours' => $r->duration_hours,
                    'expiry_months' => $r->expiry_months,
                ),
                'labels' => $this->labelMap(),
                'url' => '/modules/ksf_FA_HRM_Training/pages/training_course_form.php?action=edit&course_id=' . $r->course_id,
                'label' => $r->getDisplayLabel(),
            );
        }
        return $results;
    }
    public function insertCourse(array $data): int {
        return $this->repo->insertCourse($data);
    }
    public function updateState(int $courseId, string $expiryMonths, string $provider = null): void {
        $this->repo->updateState($courseId, $expiryMonths, $provider);
        training_course_state_changed((string) $courseId, '', 'updated', array('expiry_months' => $expiryMonths));
    }
    public function fieldMap(): array { return $this->labelMap(); }
    public function labelMap(): array {
        return array(
            'course_id' => _('Course ID'),
            'course_code' => _('Course Code'),
            'title' => _('Title'),
            'provider' => _('Provider'),
            'duration_hours' => _('Duration (hours)'),
            'expiry_months' => _('Expiry (months)'),
        );
    }
    public function getStateTransitions(string $currentState): array {
        return array();
    }
    public function isAllowedTransition(string $fromState, string $toState): bool {
        return false;
    }
}
