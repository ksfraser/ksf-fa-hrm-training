<?php

declare(strict_types=1);

namespace Ksfraser\FrontAccounting\HRM\Training\App;

use ksfraser\FrontAccounting\Common\App\AbstractAppShell;
use ksfraser\FrontAccounting\Common\Menu\FAModuleMenu;
use Ksfraser\FrontAccounting\HRM\Training\Controller\TrainingTabController;

class TrainingAppShell extends AbstractAppShell
{
    public function __construct()
    {
        parent::__construct('training', 'index.php', 'view', 'training_courses');

        $this->add_module(_("Training"));

        $menu = new FAModuleMenu(
            'modules/ksf_FA_HRM_Training/index.php',
            'view',
            ''
        );

        $menu->addItem('training_courses', _("Training Courses"), MENU_INQUIRY)
             ->registerWithApp($this, 'SA_TRAINING_VIEW');

        $this->add_extensions();
    }
}
