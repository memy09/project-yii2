<?php

namespace backend\modules\personal\controllers;

use Yii;
use common\models\Person;
use backend\modules\personal\models\PersonSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use yii\web\UploadedFile;
use yii\helpers\Json;

use yii\filters\AccessControl;



/**
 * PersonController implements the CRUD actions for Person model.
 */
class PersonController extends Controller
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
     * Lists all Person models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PersonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model =  User::find()->all();
        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Person model.
     * @param integer $_id
     * @return mixed
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
     * @return mixed
     */

    public function actionShow()
    {


        $persons = Person::find()->all();
        $users   = User::find()->all();
        foreach ($users as $user){
            $listUsers['' .$user->_id] = $user->username;
        }

        $data["persons"] = $persons;


        return $this->render("showtest", $data);

    }
    public function actionCreate()
    {
        $model = new Person();
        $users =  User::find()->all();

        foreach ($users as $user){
            $listUsers['' .$user->_id] = $user->username;
        }
        if($model->load($_POST)){
            $UploadedFiles = UploadedFile::getInstances($model,'img');
            if ($UploadedFiles!==null){
                $filenameAr = [];
                $model_new = new Person();
                foreach ($UploadedFiles as $file){
                    $fileName =  $file -> getBaseName() . '.' . $file -> getExtension() ;
                    if($file ->saveAs('uploads/person/'.$fileName)){
                        $filenameAr[] = $fileName;
                    }
                }



                $model_new->user_id = $user->username;
                $model_new->fname =$model->fname;
                $model_new->lname =$model->lname;
                $model_new->address =$model->address;
                $model_new->tel =$model->tel;
                $model_new->img = $filenameAr;
                $model_new->dept = $model->dept;


                if($model_new->save()){

                }else{
                    return Json::encode($model_new->errors);
                }
                return $this->redirect(['index']);
            }
        }

       return $this->render('create', [
            'model' => $model,
            'user' => $user,
            'listUsers' => $listUsers,
      ]);
    }

    /**
     * Updates an existing Person model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $users =  User::find()->all();

        foreach ($users as $user){
            $listUsers['' .$user->_id] = $user->username;
        }
//
//        print_r($model);




        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => (string)$model->_id]);
        }
        $user = '';

        return $this->render('update', [
            'model' => $model,
            'user' => $user,
            'listUsers' => $listUsers,
        ]);
    }

    /**
     * Deletes an existing Person model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
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
     * @param integer $_id
     * @return Person the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Person::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function deleteFile($type='file',$ref,$fileName){
        if(in_array($type, ['file','thumbnail'])){
            if($type==='file'){
                $filePath = Person::getUploadPath().$ref.'/'.$fileName;
            } else {
                $filePath = Person::getUploadPath().$ref.'/thumbnail/'.$fileName;
            }
            @unlink($filePath);
            return true;
        }
        else{
            return false;
        }
    }
    public function actionDownload($id,$file,$file_name){
        $model = $this->findModel($id);
        if(!empty($model->img) ){
            Yii::$app->response->sendFile($model->getUploadPath().'/'.$model->img.'/'.$file,$file_name);
        }else{
            $this->redirect(['/person/view','_id'=>$id]);
        }
    }


    private function uploadSingleFile($model,$tempFile=null){
        $file = [];
        $json = '';
        try {
            $UploadedFile = UploadedFile::getInstance($model,'covenant');
            if($UploadedFile !== null){
                $oldFileName = $UploadedFile->basename.'.'.$UploadedFile->extension;
                $newFileName = md5($UploadedFile->basename.time()).'.'.$UploadedFile->extension;
                $UploadedFile->saveAs(Person::UPLOAD_FOLDER.'/'.$model->img.'/'.$newFileName);
                $file[$newFileName] = $oldFileName;
                $json = Json::encode($file);
            }else{
                $json=$tempFile;
            }
        } catch (Exception $e) {
            $json=$tempFile;
        }
        return $json ;
    }
    private function uploadMultipleFile($model,$tempFile=null){
        $files = [];
        $json = '';
        $tempFile = Json::decode($tempFile);
        $UploadedFiles = UploadedFile::getInstances($model,'img');
        if($UploadedFiles!==null){
            foreach ($UploadedFiles as $file) {
                try {   $oldFileName = $file->basename.'.'.$file->extension;
                    $newFileName = md5($file->basename.time()).'.'.$file->extension;
                    $file->saveAs(Person::UPLOAD_FOLDER.'/'.$model->img.'/'.$newFileName);
                    $files[$newFileName] = $oldFileName ;
                } catch (Exception $e) {

                }
            }
            $json = json::encode(ArrayHelper::merge($tempFile,$files));
        }else{
            $json = $tempFile;
        }
        return $json;
    }

    private function CreateDir($folderName){
        if($folderName != NULL){
            $basePath = Person::getUploadPath();
            if(BaseFileHelper::createDirectory($basePath.$folderName,0777)){
                BaseFileHelper::createDirectory($basePath.$folderName.'/thumbnail',0777);
            }
        }
        return;
    }
    private function removeUploadDir($dir){
        BaseFileHelper::removeDirectory(Person::getUploadPath().$dir);
    }

}
