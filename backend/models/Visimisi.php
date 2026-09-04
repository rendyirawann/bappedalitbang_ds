<?php

namespace backend\models;

use Yii;
use yii\helpers\HtmlPurifier;
use backend\components\ActivityLogBehavior; // <-- Jangan lupa ini

/**
 * This is the model class for table "visimisi".
 *
 * @property int $id
 * @property string|null $visiJudul
 * @property string|null $visiTeks
 * @property string|null $misiJudul
 * @property string|null $misiTeks
 */
class Visimisi extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'visimisi';
    }

    public function rules()
    {
        return [
            [['visiJudul', 'visiTeks', 'misiJudul', 'misiTeks'], 'string'],
            
            // PROTEKSI INJECTION: Gunakan HTML Purifier untuk membersihkan script jahat
            [['visiJudul', 'visiTeks', 'misiJudul', 'misiTeks'], 'filter', 'filter' => function ($value) {
                // Konfigurasi agar tag <script>, <iframe>, onEvent hilang, tapi formatting teks aman
                return HtmlPurifier::process($value, [
                    'HTML.Allowed' => 'p,b,i,u,ul,ol,li,br,strong,em', // Tentukan tag apa yang BOLEH masuk
                ]);
            }],
        ];
    }

public function behaviors()
{
    return [
        [
            'class' => ActivityLogBehavior::class,
            'mainAttribute' => 'misiTeks', // <-- Sesuaikan
        ],
    ];
}

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'visiJudul' => 'Visi Judul',
            'visiTeks' => 'Visi Teks',
            'misiJudul' => 'Misi Judul',
            'misiTeks' => 'Misi Teks',
        ];
    }

    /**
     * PROTEKSI 1 ROW SAJA
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // Cek jika mencoba membuat data baru padahal data sudah ada
        if ($insert && self::find()->count() > 0) {
             Yii::$app->session->setFlash('error', 'Data Visi Misi sudah ada. Hanya boleh satu baris data.');
             return false;
        }

        return true;
    }
}