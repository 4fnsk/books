<?php

namespace frontend\controllers;

use common\models\UpdateBookForm;
use yii\filters\AccessControl;
use common\models\Books;
use common\models\BooksSearch;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;


class BooksController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Displays view page.
     * @return mixed
     */
    public function actionView($id)
    {
        $book = $this->findModel($id);
        return $this->renderPartial('view', [
            'book' => $book
        ]);
    }

    /**
     * Deletes book and redirects to index
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $book = $this->findModel($id);
        \Yii::$app->getSession()->setFlash('info', $book->name . ' deleted');
        $book->delete();
        return $this->redirect('index');
    }

    /**
     * Updates book and redirects to index
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $book = $this->findModel($id);
        $model = new UpdateBookForm($book);

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->preview = UploadedFile::getInstance($model, 'preview');
            $model->update();
            return $this->redirect('index');
        }

        return $this->render('update',[
            'model' => $model,
        ]);
    }


    /**
     * Displays index page.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BooksSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Books model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Books the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Books::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
