<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DataJembatan;

/**
 * DataJembatanSearch represents the model behind the search form of `backend\models\DataJembatan`.
 */
class DataJembatanSearch extends DataJembatan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nilaiPagu', 'nilaiKontrak', 'nilaiAddendum', 'realisasiPanjang', 'realisasiLebar', 'tahun'], 'integer'],
            [['namaPekerjaan', 'kodeDesa', 'kodeKecamatan', 'alamat', 'penyedia', 'nomorSpmk', 'nomorKontrak', 'nomorAddendum', 'nomorPho', 'keterangan'], 'safe'],
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
        $query = DataJembatan::find();

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
            'nilaiPagu' => $this->nilaiPagu,
            'nilaiKontrak' => $this->nilaiKontrak,
            'nilaiAddendum' => $this->nilaiAddendum,
            'realisasiPanjang' => $this->realisasiPanjang,
            'realisasiLebar' => $this->realisasiLebar,
            'tahun' => $this->tahun,
        ]);

        $query->andFilterWhere(['like', 'namaPekerjaan', $this->namaPekerjaan])
            ->andFilterWhere(['like', 'kodeDesa', $this->kodeDesa])
            ->andFilterWhere(['like', 'kodeKecamatan', $this->kodeKecamatan])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'penyedia', $this->penyedia])
            ->andFilterWhere(['like', 'nomorSpmk', $this->nomorSpmk])
            ->andFilterWhere(['like', 'nomorKontrak', $this->nomorKontrak])
            ->andFilterWhere(['like', 'nomorAddendum', $this->nomorAddendum])
            ->andFilterWhere(['like', 'nomorPho', $this->nomorPho])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
