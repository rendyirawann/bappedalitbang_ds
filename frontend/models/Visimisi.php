<?php

namespace frontend\models;

use Yii;

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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'visimisi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['visiJudul', 'visiTeks', 'misiJudul', 'misiTeks'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
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
}
