<?php

namespace app\controllers;

use app\models\Person;
use app\models\SearchPerson;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use function MongoDB\BSON\toJSON;

/**
 * PersonController implements the CRUD actions for Person model.
 */
class PersonController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access'=>[
                    'class'=>AccessControl::class,
                    'rules'=>[
                        [
                            'allow'=>true,
                            'roles'=>['@']
                        ]
                    ]
                ]
            ]
        );
    }

    /**
     * Lists all Person models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchPerson();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Person model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Person model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Person();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Person model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Person model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Person model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Person the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Person::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    //This is for dependent drop down
    public function actionProvince()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $region_c = $parents[0];
                $out = Person::getProvinces($region_c);
                return Json::encode(['output'=>$out,'selected'=>'']);
            }
        }
        return Json::encode(['output'=>$out,'selected'=>'']);
    }
    public function actionCity() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $region = empty($ids[0]) ? null : $ids[0];
            $province = empty($ids[1]) ? null : $ids[1];
            if ($region != null) {
                $out = Person::getCityMun($region, $province);
                return Json::encode(['output'=>$out['out'],'selected'=>$out['selected']]);
            }
        }
        return Json::encode([['output'=>$out,'selected'=>'']]);
    }
    public function actionCityw() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $region = empty($ids[0]) ? null : $ids[0];
            $province = empty($ids[1]) ? null : $ids[1];
            if ($region != null) {
                $out = Person::getCityMun($region, $province);
                return Json::encode(['output'=>$out['out'],'selected'=>$out['selected']]);
            }
        }
        return Json::encode([['output'=>$out,'selected'=>'']]);
    }
    public function actionDistrict() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $region = empty($ids[0]) ? null : $ids[0];
            $province = empty($ids[1]) ? null : $ids[1];
            $city = empty($ids[2]) ? null : $ids[2];
            if ($region != null) {
                $out = Person::getDistrict($region, $province,$city);
                return Json::encode(['output'=>$out['out'],'selected'=>$out['selected']]);
            }
        }
        return Json::encode([['output'=>$out,'selected'=>'']]);
    }
}
