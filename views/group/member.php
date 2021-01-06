<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap4\Modal;
use yii\widgets\ActiveForm;
use app\models\GroupUser;
use app\models\Contest;
use yii\bootstrap4\Nav;

/* @var $this yii\web\View */
/* @var $model app\models\Group */
/* @var $contestDataProvider yii\data\ActiveDataProvider */
/* @var $userDataProvider yii\data\ActiveDataProvider */
/* @var $newContest app\models\Contest */
/* @var $newGroupUser app\models\GroupUser */

$this->title = $model->name;

// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Groups'), 'url' => Yii::$app->user->isGuest ? ['/group/index'] : ['/group/my-group']];
// $this->params['breadcrumbs'][] = $this->title;


$scoreboardFrozenTime = Yii::$app->setting->get('scoreboardFrozenTime') / 3600;
?>


<h3><?= Html::encode($this->title) ?></h3>

<?php
    $menuItems = [
    [
        'label' => Yii::t('app', 'Information'),
        'url' => ['group/view', 'id' => $model->id],
    ],
    [
        'label' => Yii::t('app', 'Contest'),
        'url' => ['group/contest', 'id' => $model->id],
    ],
    [
        'label' => Yii::t('app', 'Member'),
        'url' => ['group/member', 'id' => $model->id],
    ]
    ];
    echo Nav::widget([
        'items' => $menuItems,
        'options' => ['class' => 'nav nav-pills hidden-print'],
        'encodeLabels' => false
    ]) ?>
<p></p>

<?php if ($model->hasPermission()): ?>
    <?php Modal::begin([
        'title' => Yii::t('app', 'Invite Member'),
        'toggleButton' => [
            'label' => Yii::t('app', 'Invite Member'),
            'tag' => 'a',
            'class' => 'btn btn-outline-danger btn-block'
        ]
            ]); ?>
    <?php $form = ActiveForm::begin(); ?>
    <p class="hint-block">1. 一个用户占据一行，每行格式为<code>username</code>。</p>
    <p class="hint-block">2. 必须是已经注册过的用户。</p>
    <?= $form->field($newGroupUser, 'username')->textarea(['rows' => 10]) ?>
    <?php if (Yii::$app->setting->get('isGroupJoin')): ?>
    <?= $form->field($newGroupUser, 'role')->radioList(['2'=>'邀请中','4'=>'普通成员'],['value'=>[4]]) ?>
    <?php else: ?>
    <?= $form->field($newGroupUser, 'role')->radioList(['2'=>'邀请中'],['value'=>[2]]) ?>
    <?php endif; ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <?php Modal::end(); ?>
    <p></p>
<?php endif; ?>

<div class="row">

    <?= GridView::widget([
        'layout' => '{items}{pager}',
        'dataProvider' => $userDataProvider,
        // 'tableOptions' => ['class' => 'table table-striped table-bordered'],
         'tableOptions' => ['class' => 'table'],
        'options' => ['class' => 'table-responsive'],
        'columns' => [
            [
        'attribute' => 'role',
        'value' => function ($model, $key, $index, $column) {
            return $model->getRole(true);
        },
        'format' => 'raw',
        'options' => ['style' => 'min-width:100px'],
        'enableSorting' => false
            ],
            [
        'attribute' => Yii::t('app', 'Nickname'),
        'value' => function ($model, $key, $index, $column) {
            return Html::a(Html::encode($model->user->nickname), ['/user/view', 'id' => $model->user->id], ['class' => 'text-dark']);
        },
        'format' => 'raw',
        'options' => ['style' => 'min-width:200px'],
        'enableSorting' => false
            ],
            [
        'attribute' => 'created_at',
        'value' => function ($model, $key, $index, $column) {
            return Yii::$app->formatter->asRelativeTime($model->created_at);
        },
        'options' => ['style' => 'min-width:100px'],
        'enableSorting' => false
            ],
            [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{user-update} {user-delete}',
        'buttons' => [
            'user-update' => function ($url, $model, $key) {
                $options = [
            'title' => Yii::t('yii', 'Update'),
            'aria-label' => Yii::t('yii', 'Update'),
            'onclick' => 'return false',
            'data-click' => "user-manager",
            'class' => 'text-dark'
                ];
                return Html::a('<i class="fas fa-sm fa-pen"></i>', $url, $options);
            },
            'user-delete' => function ($url, $model, $key) {
                $options = [
            'title' => Yii::t('yii', 'Delete'),
            'aria-label' => Yii::t('yii', 'Delete'),
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
            'class' => 'text-dark'
                ];
                return Html::a('<span class="fas fa-sm fa-trash"></span>', $url, $options);
            }
        ],
        'visible' => $model->hasPermission(),
        'options' => ['width' => '90px']
            ]
        ],
        'pager' => [
            'linkOptions' => ['class' => 'page-link'],
            'maxButtonCount' => 5,
        ]
    ]); ?>
</div>

<?php
$js = <<<EOF
$('[data-click=user-manager]').click(function() {
    $.ajax({
        url: $(this).attr('href'),
        type:'post',
        error: function(){alert('error');},
        success:function(html){
        $('#solution-content').html(html);
        $('#solution-info').modal('show');
    }
    });
});
EOF;
$this->registerJs($js);
?>
<?php Modal::begin([
    'options' => ['id' => 'solution-info']
]); ?>
<div id="solution-content">
</div>
<?php Modal::end(); ?>