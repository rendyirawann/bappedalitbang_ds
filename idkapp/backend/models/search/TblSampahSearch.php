<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TblSampah;

/**
 * TblSampahSearch represents the model behind the search form of `backend\models\TblSampah`.
 */
class TblSampahSearch extends TblSampah
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'no', 'thn_pembangunan', 'thn_optimalisasi'], 'integer'],
            [['enumerator', 'fasilitas', 'lokasi', 'kondisi', 'kegiatan_pengurangan', 'jlh_sampah_masuk', 'jlh_sampah_terolah', 'jlh_sampah_residu', 'pengelola', 'nama_lembaga', 'bentuk_lembaga', 'jlh_anggota', 'kel_bidang', 'wilayah', 'operasional', 'asset', 'status', 'latitude', 'longitude'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TblSampah::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'no' => $this->no,
            'thn_pembangunan' => $this->thn_pembangunan,
            'thn_optimalisasi' => $this->thn_optimalisasi,
        ]);

        $query->andFilterWhere(['like', 'enumerator', $this->enumerator])
            ->andFilterWhere(['like', 'fasilitas', $this->fasilitas])
            ->andFilterWhere(['like', 'lokasi', $this->lokasi])
            ->andFilterWhere(['like', 'kondisi', $this->kondisi])
            ->andFilterWhere(['like', 'kegiatan_pengurangan', $this->kegiatan_pengurangan])
            ->andFilterWhere(['like', 'jlh_sampah_masuk', $this->jlh_sampah_masuk])
            ->andFilterWhere(['like', 'jlh_sampah_terolah', $this->jlh_sampah_terolah])
            ->andFilterWhere(['like', 'jlh_sampah_residu', $this->jlh_sampah_residu])
            ->andFilterWhere(['like', 'pengelola', $this->pengelola])
            ->andFilterWhere(['like', 'nama_lembaga', $this->nama_lembaga])
            ->andFilterWhere(['like', 'bentuk_lembaga', $this->bentuk_lembaga])
            ->andFilterWhere(['like', 'jlh_anggota', $this->jlh_anggota])
            ->andFilterWhere(['like', 'kel_bidang', $this->kel_bidang])
            ->andFilterWhere(['like', 'wilayah', $this->wilayah])
            ->andFilterWhere(['like', 'operasional', $this->operasional])
            ->andFilterWhere(['like', 'asset', $this->asset])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'latitude', $this->latitude])
            ->andFilterWhere(['like', 'longitude', $this->longitude]);

        return $dataProvider;
    }
}
