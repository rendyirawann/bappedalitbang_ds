<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DataKpspams;

/**
 * DataKpspamsSearch represents the model behind the search form of `backend\models\DataKpspams`.
 */
class DataKpspamsSearch extends DataKpspams
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'noKades', 'noKpspams', 'kodeTahun'], 'integer'],
            [['provinsi', 'kabupaten', 'kodeKecamatan', 'kodeDesa', 'namaKades', 'namaKpspams'], 'safe'],
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
        $query = DataKpspams::find();

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
            'noKades' => $this->noKades,
            'noKpspams' => $this->noKpspams,
            'kodeTahun' => $this->kodeTahun,
        ]);

        $query->andFilterWhere(['like', 'provinsi', $this->provinsi])
            ->andFilterWhere(['like', 'kabupaten', $this->kabupaten])
            ->andFilterWhere(['like', 'kodeKecamatan', $this->kodeKecamatan])
            ->andFilterWhere(['like', 'kodeDesa', $this->kodeDesa])
            ->andFilterWhere(['like', 'namaKades', $this->namaKades])
            ->andFilterWhere(['like', 'namaKpspams', $this->namaKpspams]);

        return $dataProvider;
    }
}
