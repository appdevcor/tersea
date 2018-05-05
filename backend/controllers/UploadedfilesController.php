<?php

namespace backend\controllers;

use Yii;
use backend\models\Uploadedfiles;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\helpers\Json;


/**
 * UploadedfilesController implements the CRUD actions for Uploadedfiles model.
 */
class UploadedfilesController extends Controller
{
    /**
     * @inheritdoc
     */
    public $items =  array();
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
     * Lists all Uploadedfiles models.
     * @return mixed
     */
    public function actionIndex()
    {
        
       
        $model = new Uploadedfiles();
         return $this->render('index', [
            'model' => $model,
             'message' => ''
        ]);
    }
    
    public function actionCarousel()
    {
        $model = new Uploadedfiles(); 
        return $this->render('carousel', [
            'model' => $model,
             'items' => $items
        ]);
    }
    
    /**
     * Displays a single Uploadedfiles model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
   
public function actionImageUpload()
{
    $model = new Uploadedfiles();
    
    $imageFile = UploadedFile::getInstance($model, 'image');
    $directory = Yii::getAlias('@backend/web/img/temp/'. Yii::$app->user->id . '/') ;
    if (!is_dir($directory)) {
        FileHelper::createDirectory($directory);
    }
    if ($imageFile) {
        $uid = uniqid(time(), true);
        $fileName = $uid . '.' . $imageFile->extension;
        $filePath = $directory . $fileName;
        if ($imageFile->saveAs($filePath)) {
            $pathh = 'img/temp/'  . Yii::$app->user->id . '/' .$fileName;           
            $model->user_id = Yii::$app->user->id;
            $model->type = $imageFile->extension;
            $model->url = $pathh;
            $model->etat = 1;
            $model->save();
            array_push($items, $pathh);
            return Json::encode([
                'files' => [
                    [
                        'name' => $imageFile->name,
                        'size' => $imageFile->size,
                        'url' => $pathh,
                       // 'thumbnailUrl' => $path,
                        'deleteUrl' => '?r=uploadedfiles/image-delete&id='.$model->id,
                        'deleteType' => 'POST',
                    ],
                ],
            ]);
            
        }
    }

    return '';
}

public function actionImageDelete($id)
{
    $directory = Yii::getAlias('@backend/web/img/temp/');
    $model = Uploadedfiles::findOne($id);
    $model->etat=0;
    $model->save();
    $files = FileHelper::findFiles($directory);
    $output = [];
    foreach ($files as $file) {
        $fileName = basename($file);
        $path = 'img/temp' . DIRECTORY_SEPARATOR . Yii::$app->session->id . DIRECTORY_SEPARATOR . $fileName;
        $output['files'][] = [
            'name' => $fileName,
            'size' => filesize($file),
            'url' => $path,
            //'thumbnailUrl' => $path,
            'deleteUrl' => $path.'/image-delete?name=' . $fileName,
            'deleteType' => 'POST',
        ];
    }
    return Json::encode($output);
}
 
}
