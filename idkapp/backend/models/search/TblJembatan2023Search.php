<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TblJembatan2023;

/**
 * TblJembatan2023Search represents the model behind the search form of `backend\models\TblJembatan2023`.
 */
class TblJembatan2023Search extends TblJembatan2023
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'no'], 'integer'],
            [['namaPekerjaan', 'penyedia', 'nilaiPagu', 'nilaiKontrak', 'nilaiKontrakAdd', 'noSpmk', 'noKontrak', 'noKontrakAdd', 'noPho', 'realisasi_meter', 'keterangan'], 'safe'],
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
        $query = TblJembatan2023::find();

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
        ]);

        $query->andFilterWhere(['like', 'namaPekerjaan', $this->namaPekerjaan])
            ->andFilterWhere(['like', 'penyedia', $this->penyedia])
            ->andFilterWhere(['like', 'nilaiPagu', $this->nilaiPagu])
            ->andFilterWhere(['like', 'nilaiKontrak', $this->nilaiKontrak])
            ->andFilterWhere(['like', 'nilaiKontrakAdd', $this->nilaiKontrakAdd])
            ->andFilterWhere(['like', 'noSpmk', $this->noSpmk])
            ->andFilterWhere(['like', 'noKontrak', $this->noKontrak])
            ->andFilterWhere(['like', 'noKontrakAdd', $this->noKontrakAdd])
            ->andFilterWhere(['like', 'noPho', $this->noPho])
            ->andFilterWhere(['like', 'realisasi_meter', $this->realisasi_meter])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
