<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TblIndividu2023;

/**
 * TblIndividu2023Search represents the model behind the search form of `backend\models\TblIndividu2023`.
 */
class TblIndividu2023Search extends TblIndividu2023
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'no', 'satuan', 'hargaSatuan', 'jumlah'], 'integer'],
            [['kode_kegiatan', 'kode_sub', 'kode_rekening', 'namaKegiatan', 'kecamatan', 'keterangan'], 'safe'],
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
        $query = TblIndividu2023::find();

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
            'satuan' => $this->satuan,
            'hargaSatuan' => $this->hargaSatuan,
            'jumlah' => $this->jumlah,
        ]);

        $query->andFilterWhere(['like', 'kode_kegiatan', $this->kode_kegiatan])
            ->andFilterWhere(['like', 'kode_sub', $this->kode_sub])
            ->andFilterWhere(['like', 'kode_rekening', $this->kode_rekening])
            ->andFilterWhere(['like', 'namaKegiatan', $this->namaKegiatan])
            ->andFilterWhere(['like', 'kecamatan', $this->kecamatan])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
