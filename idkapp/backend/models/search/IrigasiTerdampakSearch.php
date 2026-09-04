<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\IrigasiTerdampak;

/**
 * IrigasiTerdampakSearch represents the model behind the search form of `backend\models\IrigasiTerdampak`.
 */
class IrigasiTerdampakSearch extends IrigasiTerdampak
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'luasIrigasi', 'kodeTahun'], 'integer'],
            [['nomeklatur', 'kodeDesa', 'arealBaik', 'arealRusakRingan', 'arealRusakSedang', 'arealRusakBerat', 'total'], 'safe'],
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
        $query = IrigasiTerdampak::find();

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
            'kodeDesa' => $this->kodeDesa,
            'luasIrigasi' => $this->luasIrigasi,
            'kodeTahun' => $this->kodeTahun,
        ]);

        $query->andFilterWhere(['like', 'nomeklatur', $this->nomeklatur])
            ->andFilterWhere(['like', 'arealBaik', $this->arealBaik])
            ->andFilterWhere(['like', 'arealRusakRingan', $this->arealRusakRingan])
            ->andFilterWhere(['like', 'arealRusakSedang', $this->arealRusakSedang])
            ->andFilterWhere(['like', 'arealRusakBerat', $this->arealRusakBerat])
            ->andFilterWhere(['like', 'total', $this->total]);

        return $dataProvider;
    }
}
