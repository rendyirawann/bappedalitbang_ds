<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pegawai".
 *
 * @property int $id
 * @property int $statusAparatur
 * @property string $namaLengkap
 * @property string|null $nip
 * @property int $eselon
 * @property int $kodeBidang
 * @property int $kodeTitle
 * @property string|null $no_hp
 */
class Pegawai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pegawai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['statusAparatur', 'namaLengkap', 'eselon', 'kodeBidang', 'kodeTitle'], 'required'],
            [['statusAparatur', 'eselon', 'kodeBidang', 'kodeTitle'], 'integer'],
            [['namaLengkap'], 'string', 'max' => 100],
            [['nip'], 'string', 'max' => 22],
            [['no_hp'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'statusAparatur' => 'Status Aparatur',
            'namaLengkap' => 'Nama Lengkap',
            'nip' => 'Nip',
            'eselon' => 'Eselon',
            'kodeBidang' => 'Kode Bidang',
            'kodeTitle' => 'Kode Title',
            'no_hp' => 'No Hp',
        ];
    }

    public function getPegawaiEselon()
    {
        return $this->hasOne(PegawaiEselon::class, ['id' => 'eselon']);
    }

    public function getBidang()
    {
        return $this->hasOne(Bidang::class, ['id' => 'kodeBidang']);

    }
    public function getTitle()
    {
        return $this->hasOne(Title::class, ['id' => 'kodeTitle']);
    }

}
