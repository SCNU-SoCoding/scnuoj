<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;

/**
 * Update controller for the `admin` module
 */
class UpdateController extends Controller
{
    public $layout = 'main';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'ruleConfig' => [
                    'class' => AccessRule::class,
                ],
                'rules' => [
                    [
                        'allow' => true,
                        // Allow users, moderators and admins to create
                        'roles' => [
                            User::ROLE_ADMIN
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $changelog = file_get_contents('https://gitee.com/bobby285271/scnuoj/raw/master/CHANGELOG.md');
        return $this->render('index', [
            'changelog' => $changelog
        ]);
    }
}
