<?php

namespace app\commands;

use app\modules\admin\rbac\Rbac as AdminRbac;
use Yii;
use yii\console\Controller;

/**
 * RBAC generator
 */
class RbacController extends Controller
{
    /**
     * Generates roles
     */
    public function actionInit()
    {
        $auth = Yii::$app->getAuthManager();
        $auth->removeAll();

        $adminPanel = $auth->createPermission(AdminRbac::PERMISSION_ADMIN_PANEL);
        $adminPanel->description = 'Admin panel';
        $auth->add($adminPanel);

        $adminRoot = $auth->createPermission(AdminRbac::PERMISSION_ADMIN_ROOT);
        $adminRoot->description = 'Admin root';
        $auth->add($adminRoot);

        $user = $auth->createRole('user');
        $user->description = 'User';
        $auth->add($user);

        $admin = $auth->createRole('admin');
        $admin->description = 'Admin';
        $auth->add($admin);

        $root = $auth->createRole('root');
        $root->description = 'Root';
        $auth->add($root);

        $auth->addChild($admin, $user);
        $auth->addChild($root, $admin);
        $auth->addChild($admin, $adminPanel);
        $auth->addChild($root, $adminRoot);

        $this->stdout('Done!' . PHP_EOL);
    }
}