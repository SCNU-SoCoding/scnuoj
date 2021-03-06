<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SolutionSearch */
/* @var $form yii\widgets\ActiveForm */
/* @var $contest_id integer */
/* @var $nav string */
?>

<?php $form = ActiveForm::begin([
    'action' => ['status', 'id' => $contest_id],
    'method' => 'get',
    'options' => [
        'class' => '',
    ],
]); ?>

<div class="row">
    <div class="col-lg-2" style="margin-bottom: 1rem;">
        <?= $form->field($model, 'problem_id', [
            'template' => "<div class=\"input-group\">{input}</div>",
            'options' => ['class' => ''],
        ])->dropDownList($nav, ['class' => 'form-control custom-select'])->label(false) ?>
    </div>

    <div class="col-lg-4" style="margin-bottom: 1rem;">
        <?= $form->field($model, 'username', [
            'template' => "<div class=\"input-group\">{input}</div>",
            'options' => ['class' => ''],
        ])->textInput(['maxlength' => 128, 'autocomplete' => 'off', 'placeholder' => Yii::t('app', 'Who')])->label(false) ?>
    </div>

    <div class="col-lg-2" style="margin-bottom: 1rem;">
        <?= $form->field($model, 'result', [
            'template' => "<div class=\"input-group\">{input}</div>",
            'options' => ['class' => ''],
        ])->dropDownList($model::getResultList(), ['class' => 'form-control custom-select'])->label(false) ?>
    </div>

    <div class="col-lg-2" style="margin-bottom: 1rem;">
        <?= $form->field($model, 'language', [
            'template' => "<div class=\"input-group\">{input}</div>",
            'options' => ['class' => ''],
        ])->dropDownList($model::getLanguageLiteList(), ['class' => 'form-control custom-select'])->label(false) ?>
    </div>

    <div class="col-lg-2" style="margin-bottom: 1rem;">
        <div class="btn-group btn-block search-submit">
            <?= Html::submitButton('<i class="fas fa-fw fa-search"></i> ' . Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>