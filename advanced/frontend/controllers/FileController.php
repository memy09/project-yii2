<?php

namespace frontend\controllers;

use Yii;
use frontend\models\file;
use frontend\models\FileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\phpoffice\phpexcel;
use yii\web\UploadFile;

/**
 * FileController implements the CRUD actions for file model.
 */
class FileController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all file models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single file model.
     * @param integer $_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        try{
            $file = Yii::getAlias('@webroot').'/'.$model->uploadPath.'/'.$model->file;
            $inputFile = \PHPExcel_IOFactory::identify($file);
            $objReader = \PHPExcel_IOFactory::createReader($inputFile);
            $objPHPExcel = $objReader->load($file);
        }catch (Exception $e){
            Yii::$app->session->addFlash('error', 'เกิดข้อผิดพลาด'. $e->getMessage());
        }

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $objWorksheet = $objPHPExcel->getActiveSheet();

        foreach($objWorksheet->getRowIterator() as $rowIndex => $row){
            $arr[] = $objWorksheet->rangeToArray('A'.$rowIndex.':'.$highestColumn.$rowIndex);
        }

        /*
         * Post Register from active form
         */
        if(Yii::$app->request->post('register')){
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $register = Yii::$app->request->post('register');
                //var_dump($register);
                //die();
                foreach ($objWorksheet->getRowIterator() as $rowIndex => $row) {

                    $tmpdata = $objWorksheet->rangeToArray('A' . $rowIndex . ':' . $highestColumn . $rowIndex);
                    $data[] = $tmpdata[0];

                }

                foreach ($register as $key => $val) {
                    //Check if specific
                    if (!empty($val)) {//ถ้าเลือกส่ง
                        //var_dump($data[$key]);
                        //มีการ Import หรือยัง
                        $import = HospitalImport::find()->where(['name' => $data[$key][1]])
                            ->andFilterWhere(['like', 'id_card', $data[$key][4]])
                            ->one();
                        if (!$import) {//ถ้ายังไม่มีการ Import


                            $gender = $data[$key][2] == 'หญิง' ? 1 : 0;


                            $import = new HospitalImport();
                            $import->token_action = $model->token_action;
                            $import->hospital_id = Yii::$app->user->identity->hospital_id;
                            $import->prefix = $data[$key][0];
                            $import->name = $data[$key][1];
                            $import->gender = $gender;
                            $import->race = $data[$key][3];
                            $import->id_card = $data[$key][4];
                            $import->birthdate = $data[$key][5];
                            $import->age = $data[$key][6];
                            $import->age_unit = $data[$key][7];
                            $import->h_n = $data[$key][8];
                            $import->a_n = $data[$key][9];
                            $import->ward = $data[$key][10];
                            $import->doctor = $data[$key][11];
                            $import->clinical_diagnosis = $data[$key][12];
                            $import->collected_at = $data[$key][13];
                            $import->regist_type = $val;

                            if($import->save()){
                                Yii::$app->session->addFlash('success', $import->name.' '.$import->regist_type.' นำเข้าข้อมูลเรียบร้อยแล้ว');
                            }else{
                                Yii::$app->session->addFlash('error', 'เกิดข้อผิดพลาดในการนำเข้าข้อมูล');
                                //var_dump($import);
                                //die();
                            }

                        }else{//รายการนี้ส่งแล้ว
                            Yii::$app->session->addFlash('info', $data[$key][1].' รายการนี้ส่งเข้าระบบแล้ว');
                        }

                    }else{//ถ้าไม่ได้เลือกส่ง
                        Yii::$app->session->addFlash('warning', $data[$key][1].' ไม่ได้เลือกส่ง');
                    }
                }//end foreach

                $transaction->commit();
                Yii::$app->session->addFlash('success', 'ดำเนินการนำเข้าข้อมูลเรียบร้อยแล้ว กรุณาตรวจสอบความถูกต้องอีกครั้ง');
                return $this->redirect(['view', 'id' => $model->id]);

            }catch (Exception $e){
                $transaction->rollBack();
                Yii::$app->session->addFlash('error', 'เกิดข้อผิดพลาด');
            }
        }///end if post


        $dataProvider = new ArrayDataProvider([
            'allModels' => $arr,
            'pagination' => false,
        ]);

        $dataProviderImport = new ActiveDataProvider([
            'query' => HospitalImport::find()
                ->where(['token_action' => $model->token_action])
                ->orderBy(['id' => SORT_DESC])
        ]);

        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'dataProviderImport' => $dataProviderImport,
        ]);
    }

    /**
     * Creates a new file model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new file();

        if ($model->load(Yii::$app->request->post())) {

            $model->file = $model->uploadFile($model, 'file');
            $model->save();

            Yii::$app->session->setFlash('success', 'เพิ่มข้อมูลเรียบร้อยแล้ว');
            return $this->redirect(['view', 'id' => $model->_id]);

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing file model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->file = $model->uploadFile($model, 'file');
            $model->save();

            Yii::$app->session->setFlash('success', 'แก้ไขข้อมูลเรียบร้อยแล้ว');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing file model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        @unlink(Yii::getAlias('@webroot').'/'.$model->uploadPath.'/'.$model->file);
        $model->delete();

        Yii::$app->session->setFlash('success', 'ลบข้อมูลเรียบร้อยแล้ว');
        return $this->redirect(['index']);
    }

    /**
     * Finds the file model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return file the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = file::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
