<?php

use app\models\Group;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Group */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">" . Yii::t('app', 'Names') . "</span></div>{input}</div>",
    ])->textInput(['maxlength' => true]) ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 小组描述所有人可见。</div>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true])->label(false) ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 小组成员加入方式。</div>

    <?= $form->field($model, 'join_policy')->radioList([
        Group::JOIN_POLICY_INVITE => Yii::t('app', 'Invite Only'),
        Group::JOIN_POLICY_APPLICATION => Yii::t('app', 'Application & Approve'),
        Group::JOIN_POLICY_FREE => Yii::t('app', 'Free')
    ])->label(false) ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 设置可见后用户可在探索页面发现这个小组。</div>

    <?= $form->field($model, 'status')->radioList([
        Group::STATUS_VISIBLE => Yii::t('app', 'Visible'),
        Group::STATUS_HIDDEN => Yii::t('app', 'Hidden')
    ])->label(false) ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 小组公告仅小组成员可见。</div>

    <?= $form->field($model, 'kanban', [
        'template' => "{input}",
    ])->widget('app\widgets\editormd\Editormd'); ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>