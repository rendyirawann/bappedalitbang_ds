<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TblIpald;

/**
 * TblIpaldSearch represents the model behind the search form of `backend\models\TblIpald`.
 */
class TblIpaldSearch extends TblIpald
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'no', 'thn_pembangunan', 'thn_rehabilitasi', 'kapasitas_desain', 'kapasitas_pakai'], 'integer'],
            [['enumerator', 'fasilitas', 'wilayah', 'sistem', 'kondisi', 'pengelola', 'pengecekan', 'nama_lembaga', 'bentuk_lembaga', 'jlh_anggota', 'kel_bidang', 'operasional', 'asset', 'status'], 'safe'],
            [['latitude', 'longitude'], 'number'],
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
        $query = TblIpald::find();

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
            'thn_rehabilitasi' => $this->thn_rehabilitasi,
            'kapasitas_desain' => $this->kapasitas_desain,
            'kapasitas_pakai' => $this->kapasitas_pakai,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ]);

        $query->andFilterWhere(['like', 'enumerator', $this->enumerator])
            ->andFilterWhere(['like', 'fasilitas', $this->fasilitas])
            ->andFilterWhere(['like', 'wilayah', $this->wilayah])
            ->andFilterWhere(['like', 'sistem', $this->sistem])
            ->andFilterWhere(['like', 'kondisi', $this->kondisi])
            ->andFilterWhere(['like', 'pengelola', $this->pengelola])
            ->andFilterWhere(['like', 'pengecekan', $this->pengecekan])
            ->andFilterWhere(['like', 'nama_lembaga', $this->nama_lembaga])
            ->andFilterWhere(['like', 'bentuk_lembaga', $this->bentuk_lembaga])
            ->andFilterWhere(['like', 'jlh_anggota', $this->jlh_anggota])
            ->andFilterWhere(['like', 'kel_bidang', $this->kel_bidang])
            ->andFilterWhere(['like', 'operasional', $this->operasional])
            ->andFilterWhere(['like', 'asset', $this->asset])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
