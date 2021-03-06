<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'News');
?>
<div class="discuss-index">

    <p class="lead">创建和管理新闻。</p>
    <?= Html::a(Yii::t('app', 'Release news'), ['create'], ['class' => 'btn btn-outline-success btn-block']) ?>
    <p></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => ['class' => 'table-responsive'],
        'tableOptions' => ['class' => 'table table-bordered'],
        'layout' => '{items}{pager}',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'title',
                'enableSorting' => false,
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a(Html::encode($model->title), ['news/view', 'id' => $key]);
                },
            ],
            [
                'attribute' => 'created_at',
                'enableSorting' => false,
            ],
            [
                'attribute' => 'status',
                'value' => function ($model, $key, $index, $column) {
                    if ($model->status) {
                        return Yii::t('app', 'Visible');
                    } else {
                        return Yii::t('app', 'Hidden');
                    }
                },
                'format' => 'raw',
                'enableSorting' => false,
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'class' => 'text-dark'
                        ];
                        return Html::a('<i class="fas fa-sm fa-eye"></i>', $url, $options);
                    },
                    'update' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'class' => 'text-dark'
                        ];
                        return Html::a('<i class="fas fa-sm fa-pen"></i>', $url, $options);
                    },
                    'delete' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                            'class' => 'text-dark'
                        ];
                        return Html::a('<span class="fas fa-sm fa-trash"></span>', $url, $options);
                    }
                ]
            ]
        ],
    ]); ?>
</div>