<?php

namespace West\ForumPassword;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Alter;

class Setup extends AbstractSetup
{
    use StepRunnerInstallTrait;
    use StepRunnerUpgradeTrait;
    use StepRunnerUninstallTrait;

    public function installStep1()
    {
        $this->alterTable('xf_forum', function (Alter $table)
        {
            $table->addColumn('wfp_password', 'varchar', 64)->nullable();
        });
    }

    public function uninstallStep1()
    {
        $this->alterTable('xf_forum', function (Alter $table)
        {
            $table->dropColumns(['wfp_password']);
        });
    }
}