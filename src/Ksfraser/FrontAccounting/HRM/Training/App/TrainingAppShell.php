<?php

declare(strict_types=1);

namespace Ksfraser\FrontAccounting\HRM\Training\App;

use ksfraser\FrontAccounting\Common\App\AbstractAppShell;
use ksfraser\FrontAccounting\Common\App\TabRegistration;

class TrainingAppShell extends AbstractAppShell
{
    public function __construct()
    {
        parent::__construct('training', 'index.php', 'view', 'training_courses');

        $this->registerTab(new TabRegistration(
            'training_courses',
            'Training Courses',
            'SA_TRAINING_VIEW',
            null,
            10,
            0,
            null,
            null,
            array()
        ));
    }
}
