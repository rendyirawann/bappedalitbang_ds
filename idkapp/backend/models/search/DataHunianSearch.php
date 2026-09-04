<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DataHunian;

/**
 * DataHunianSearch represents the model behind the search form of `backend\models\DataHunian`.
 */
class DataHunianSearch extends DataHunian
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'jlhUnit', 'retribusi', 'kodeTahun'], 'integer'],
            [['namaPemohon', 'kodeDesa', 'kodeKecamatan', 'lokasiBangunan', 'noRegPbg', 'jenisBangunan', 'tanggal'], 'safe'],
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
        $query = DataHunian::find();

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
            'jlhUnit' => $this->jlhUnit,
            'retribusi' => $this->retribusi,
            'tanggal' => $this->tanggal,
            'kodeTahun' => $this->kodeTahun,
        ]);

        $query->andFilterWhere(['like', 'namaPemohon', $this->namaPemohon])
            ->andFilterWhere(['like', 'kodeDesa', $this->kodeDesa])
            ->andFilterWhere(['like', 'kodeKecamatan', $this->kodeKecamatan])
            ->andFilterWhere(['like', 'lokasiBangunan', $this->lokasiBangunan])
            ->andFilterWhere(['like', 'noRegPbg', $this->noRegPbg])
            ->andFilterWhere(['like', 'jenisBangunan', $this->jenisBangunan]);

        return $dataProvider;
    }
}
