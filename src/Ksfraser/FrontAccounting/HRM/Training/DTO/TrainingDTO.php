<?php
declare(strict_types=1);
namespace Ksfraser\FrontAccounting\HRM\Training\DTO;
final class TrainingDTO {
    public $course_id;
    public $course_code;
    public $title;
    public $provider;
    public $cost;
    public $duration_hours;
    public $expiry_months;
    public $created_at;
    public $updated_at;
    public function __construct(
        int $course_id,
        string $course_code = '',
        string $title = '',
        string $provider = '',
        string $cost = '0.00',
        string $duration_hours = '0.00',
        string $expiry_months = '12',
        string $created_at = '',
        string $updated_at = ''
    ) {
        $this->course_id = $course_id;
        $this->course_code = $course_code;
        $this->title = $title;
        $this->provider = $provider;
        $this->cost = $cost;
        $this->duration_hours = $duration_hours;
        $this->expiry_months = $expiry_months;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
    public function getDisplayLabel(): string {
        if ($this->course_code !== '' && $this->title !== '') {
            return sprintf(_('%s — %s'), $this->course_code, $this->title);
        }
        return _('Training Course #') . (string) $this->course_id;
    }
    public function toArray(): array {
        return array(
            'course_id' => $this->course_id,
            'course_code' => $this->course_code,
            'title' => $this->title,
            'provider' => $this->provider,
            'cost' => $this->cost,
            'duration_hours' => $this->duration_hours,
            'expiry_months' => $this->expiry_months,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        );
    }
    public static function fromArray(array $data): self {
        return new self(
            (int) ($data['course_id'] ?? 0),
            (string) ($data['course_code'] ?? ''),
            (string) ($data['title'] ?? ''),
            (string) ($data['provider'] ?? ''),
            (string) ($data['cost'] ?? '0.00'),
            (string) ($data['duration_hours'] ?? '0.00'),
            (string) ($data['expiry_months'] ?? '12'),
            (string) ($data['created_at'] ?? ''),
            (string) ($data['updated_at'] ?? '')
        );
    }
}
