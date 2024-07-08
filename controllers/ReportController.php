<?php

namespace app\controllers;

use app\models\Person;
use app\models\Tblcitymun;
use app\models\Tblprovince;
use app\models\Tblregion;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Response;

class ReportController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index',['regions'=>$this->getRegions()]);
    }

    public function actionProvince($region){
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->getProvince($region);
    }

    public function actionCity($region,$province){
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->getCityMun($region,$province);
    }

    function getRegions(){
        $regions = TblRegion::find()->all();
        return ArrayHelper::map($regions, 'region_c', 'region_m');
    }

    function getProvince($region){
        $province = TblProvince::find()->where(['region_c'=>$region])->all();
        return ArrayHelper::map($province, 'province_c', 'province_m');
    }

    function getCityMun($region,$province){
        $citymun = Tblcitymun::find()
            ->andWhere(['region_c'=>$region])
            ->andWhere(['province_c'=>$province])
            ->orderBy(['citymun_m'=>SORT_ASC])
            ->all();

        return ArrayHelper::map($citymun,'citymun_c','citymun_m');
    }

    public function actionChartone($region = null,$province= null,$citymun = null){
        $params = [];
        if(isset($region)){
            $params += ['region_c'=>$region];
        }
        if(isset($province)){
            $params += ['province_c'=>$province];
        }
        if(isset($citymun)){
            $params += ['citymun_c'=>$citymun];
        }

        // Step 1: Fetch status counts
        $statusCounts = Person::find()
            ->getGroupedStatusCount()
            ->andWhere($params)
            ->groupBy('person.status') // Group by status to count each status separately
            ->asArray()
            ->all();
        $chartData = [
            'name' => 'Status',
            'colorByPoint' => true,
            'data' => []
        ];
        foreach ($statusCounts as $status) {
            $chartData['data'][] = [
                'name' => $status['status_text'],
                'y' => (int) $status['count'], // Use the count from statusCounts
                'drilldown' => $status['status_text'] // Assuming you want to use status_text as drilldown
            ];
        }
        return Json::encode($chartData);
    }

   function actionCharttwo($region = null,$province= null,$citymun = null){
       $params = [];
       if(isset($region)){
           $params += ['region_c'=>$region];
       }
       if(isset($province)){
           $params += ['province_c'=>$province];
       }
       if(isset($citymun)){
           $params += ['citymun_c'=>$citymun];
       }

        $population = Person::getPopulation($params)->count();

       // Step 1: Fetch status counts
        $statusCounts = Person::find()
           ->getGroupedStatusCount()
           ->andWhere($params)
           ->groupBy('person.status') // Group by status to count each status separately
           ->asArray()
           ->all();
        $chartData = [];
        foreach ($statusCounts as $status) {
           $chartData[] = [ $status['status_text'],(float) ($status['count']/$population)*100];
        }
       return Json::encode($chartData);
   }

   function actionChartthree($region=null,$province=null,$citymun=null){
       $params = [];
       if(isset($region)){
           $params += ['region_c'=>$region];
       }
       if(isset($province)){
           $params += ['province_c'=>$province];
       }
       if(isset($citymun)){
           $params += ['citymun_c'=>$citymun];
       }

       // Define age groups
       $ageGroups = [
           '0-12' => [0, 12],
           '13-18' => [13, 18],
           '19-25' => [19, 25],
           '26-35' => [26, 35],
           '36-50' => [36, 50],
           '51-65' => [51, 65],
           '65-Above' => [66, 120]
       ];

       $status = [0,1,2,3,4];
       $stats = ['Under Investigation','Surrendered','Apprehended','Escaped','Deceased'];

       $result=[];
       foreach ($status as $stats_idx){
           $inner_result =[ 'name' => $stats[$stats_idx], 'data' => []];
           foreach ($ageGroups as $label=>$range){
                $statusCounts = Person::getStatusCountsByAge($range,$params,$stats_idx);
                $inner_result['data'][] = $statusCounts[0]['count'];
           }
              $result[] = $inner_result;
       }

        return Json::encode($result);


   }
}
