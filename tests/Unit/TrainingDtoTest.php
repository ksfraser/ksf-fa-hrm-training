<?php
declare(strict_types=1);
namespace Ksfraser\FrontAccounting\HRM\Training\Tests\Unit;
use PHPUnit\Framework\TestCase;
use Ksfraser\FrontAccounting\HRM\Training\DTO\TrainingDTO;
class TrainingDtoTest extends TestCase
{
    public function testDtoRoundTripsThroughArray(): void {
        $dto = new TrainingDTO(5, 'TRN-101', 'Workplace Safety', 'Acme Training', '299.00', '8.00', '12');
        $arr = $dto->toArray();
        $this->assertSame(5, $arr['course_id']);
        $this->assertSame('TRN-101', $arr['course_code']);
        $this->assertSame('Workplace Safety', $arr['title']);
        $this->assertSame('Acme Training', $arr['provider']);
        $this->assertSame('299.00', $arr['cost']);
        $this->assertSame('8.00', $arr['duration_hours']);
        $this->assertSame('12', $arr['expiry_months']);
        $dto2 = TrainingDTO::fromArray($arr);
        $this->assertSame($dto->course_id, $dto2->course_id);
        $this->assertSame($dto->course_code, $dto2->course_code);
        $this->assertSame($dto->title, $dto2->title);
    }
    public function testDisplayLabelUsesCodeAndTitleWhenSet(): void {
        $dto = new TrainingDTO(1, 'TRN-1', 'Safety Basics', '', '0.00', '0.00', '12');
        $this->assertStringContainsString('TRN-1', $dto->getDisplayLabel());
        $this->assertStringContainsString('Safety Basics', $dto->getDisplayLabel());
    }
    public function testDisplayLabelFallsBackToId(): void {
        $dto = new TrainingDTO(9, '', '', '', '0.00', '0.00', '12');
        $this->assertStringContainsString('Training Course #9', $dto->getDisplayLabel());
    }
}
