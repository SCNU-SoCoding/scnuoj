<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\User;
use yii\db\Query;
use yii\data\Pagination;

class RatingController extends BaseController
{
    public function actionIndex()
    {
        // $query = User::find()->orderBy('rating DESC');
        $query = (new Query())->select('u.id, u.nickname, p.student_number, u.rating, s.solved')
            ->from('{{%user}} AS u')
            ->leftJoin(
                '(SELECT COUNT(DISTINCT problem_id) AS solved, created_by FROM {{%solution}} WHERE result=4 GROUP BY created_by ORDER BY solved DESC) as s',
                'u.id=s.created_by'
            )
            ->leftJoin('`user_profile` `p` ON `p`.`user_id`=`u`.`id`')
            ->orderBy('rating DESC, id');
        $top3users = $query->limit(3)->all();
        $defaultPageSize = 50;
        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => $defaultPageSize
        ]);
        $users = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'top3users' => $top3users,
            'users' => $users,
            'pages' => $pages,
            'currentPage' => $pages->page,
            'defaultPageSize' => $defaultPageSize
        ]);
    }

    public function actionProblem()
    {
        $query = (new Query())->select('u.id, u.nickname, p.student_number, u.rating, s.solved')
            ->from('{{%user}} AS u')
            ->leftJoin(
                '(SELECT COUNT(DISTINCT problem_id) AS solved, created_by FROM {{%solution}} WHERE result=4 GROUP BY created_by ORDER BY solved DESC) as s',
                'u.id=s.created_by'
            )
            ->leftJoin('`user_profile` `p` ON `p`.`user_id`=`u`.`id`')
            ->orderBy('solved DESC, id');
        $top3users = $query->limit(3)->all();
        $defaultPageSize = 50;
        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => $defaultPageSize
        ]);
        $users = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('problem', [
            'top3users' => $top3users,
            'users' => $users,
            'pages' => $pages,
            'currentPage' => $pages->page,
            'defaultPageSize' => $defaultPageSize
        ]);
    }
}
