<?php

declare(strict_types=1);

namespace Ksfraser\FrontAccounting\HRM\Training\App;

use ksfraser\FrontAccounting\Common\App\AbstractFrontController;

class TrainingFrontController extends AbstractFrontController
{
    public function __construct(
        TrainingAppShell $appShell,
        string $fallbackSecurityArea,
        string $path_to_root
    ) {
        parent::__construct($appShell, $fallbackSecurityArea, $path_to_root);
    }
}
