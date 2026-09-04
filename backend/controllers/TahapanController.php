<?php

namespace backend\controllers;

use Yii;
use common\models\Tahapan;
use common\models\TahapanItem;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * TahapanController implements the CRUD actions for Tahapan model.
 */
class TahapanController extends Controller
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
            ]
        );
    }

    /**
     * Lists all Tahapan models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Tahapan::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tahapan model.
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
     * Creates a new Tahapan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Tahapan();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $items = $this->request->post('TahapanItem', []);
                foreach ($items as $index => $itemData) {
                    $item = new \common\models\TahapanItem();
                    $item->tahapan_id = $model->id;
                    $item->nama_tahapan = $itemData['nama_tahapan'];
                    $item->urutan = $itemData['urutan'];
                    $item->tanggal = $itemData['tanggal'];

                    // Handle file uploads
                    $fileImage = \yii\web\UploadedFile::getInstanceByName("TahapanItem[$index][fileImage]");
                    $fileDocument = \yii\web\UploadedFile::getInstanceByName("TahapanItem[$index][fileDocument]");

                    if ($fileImage) {
                        $imageName = 'tahapan_icon_' . time() . '_' . $index . '.' . $fileImage->extension;
                        $fileImage->saveAs(\Yii::getAlias('@frontend/web/uploads/tahapan/') . $imageName);
                        $item->icon_gambar = $imageName;
                    }
                    if ($fileDocument) {
                        $docName = 'tahapan_doc_' . time() . '_' . $index . '.' . $fileDocument->extension;
                        $fileDocument->saveAs(\Yii::getAlias('@frontend/web/uploads/tahapan/') . $docName);
                        $item->dokumen = $docName;
                    }

                    $item->save(false);
                }
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
     * Updates an existing Tahapan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            
            // For simplicity in update, we can either delete all items and recreate, or update existing.
            // A common pattern for repeaters without complex sync is to delete existing items and recreate them,
            // BUT we must preserve the old images if no new image is uploaded.
            
            $existingItems = \common\models\TahapanItem::find()->where(['tahapan_id' => $model->id])->indexBy('id')->all();
            $postItems = $this->request->post('TahapanItem', []);
            $processedIds = [];

            foreach ($postItems as $index => $itemData) {
                $itemId = isset($itemData['id']) ? $itemData['id'] : null;
                if ($itemId && isset($existingItems[$itemId])) {
                    $item = $existingItems[$itemId];
                    $processedIds[] = $itemId;
                } else {
                    $item = new \common\models\TahapanItem();
                    $item->tahapan_id = $model->id;
                }

                $item->nama_tahapan = $itemData['nama_tahapan'];
                $item->urutan = $itemData['urutan'];
                $item->tanggal = $itemData['tanggal'];

                $fileImage = \yii\web\UploadedFile::getInstanceByName("TahapanItem[$index][fileImage]");
                $fileDocument = \yii\web\UploadedFile::getInstanceByName("TahapanItem[$index][fileDocument]");

                if ($fileImage) {
                    if ($item->icon_gambar && file_exists(\Yii::getAlias('@frontend/web/uploads/tahapan/') . $item->icon_gambar)) {
                        unlink(\Yii::getAlias('@frontend/web/uploads/tahapan/') . $item->icon_gambar);
                    }
                    $imageName = 'tahapan_icon_' . time() . '_' . $index . '.' . $fileImage->extension;
                    $fileImage->saveAs(\Yii::getAlias('@frontend/web/uploads/tahapan/') . $imageName);
                    $item->icon_gambar = $imageName;
                }
                if ($fileDocument) {
                    if ($item->dokumen && file_exists(\Yii::getAlias('@frontend/web/uploads/tahapan/') . $item->dokumen)) {
                        unlink(\Yii::getAlias('@frontend/web/uploads/tahapan/') . $item->dokumen);
                    }
                    $docName = 'tahapan_doc_' . time() . '_' . $index . '.' . $fileDocument->extension;
                    $fileDocument->saveAs(\Yii::getAlias('@frontend/web/uploads/tahapan/') . $docName);
                    $item->dokumen = $docName;
                } else {
                    $removeDoc = Yii::$app->request->post('TahapanItem')[$index]['removeDocument'] ?? 0;
                    if ($removeDoc == 1 && $item->dokumen) {
                        if (file_exists(\Yii::getAlias('@frontend/web/uploads/tahapan/') . $item->dokumen)) {
                            unlink(\Yii::getAlias('@frontend/web/uploads/tahapan/') . $item->dokumen);
                        }
                        $item->dokumen = null;
                    }
                }
                $item->save(false);
            }

            // Delete removed items
            foreach ($existingItems as $eId => $eItem) {
                if (!in_array($eId, $processedIds)) {
                    if ($eItem->icon_gambar && file_exists(\Yii::getAlias('@frontend/web/uploads/tahapan/') . $eItem->icon_gambar)) {
                        unlink(\Yii::getAlias('@frontend/web/uploads/tahapan/') . $eItem->icon_gambar);
                    }
                    if ($eItem->dokumen && file_exists(\Yii::getAlias('@frontend/web/uploads/tahapan/') . $eItem->dokumen)) {
                        unlink(\Yii::getAlias('@frontend/web/uploads/tahapan/') . $eItem->dokumen);
                    }
                    $eItem->delete();
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tahapan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        // Delete physical files of children before deleting parent
        foreach ($model->tahapanItems as $item) {
            if ($item->icon_gambar && file_exists(\Yii::getAlias('@frontend/web/uploads/tahapan/') . $item->icon_gambar)) {
                unlink(\Yii::getAlias('@frontend/web/uploads/tahapan/') . $item->icon_gambar);
            }
            if ($item->dokumen && file_exists(\Yii::getAlias('@frontend/web/uploads/tahapan/') . $item->dokumen)) {
                unlink(\Yii::getAlias('@frontend/web/uploads/tahapan/') . $item->dokumen);
            }
        }
        
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tahapan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Tahapan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tahapan::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
