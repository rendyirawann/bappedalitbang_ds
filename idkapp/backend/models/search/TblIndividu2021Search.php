<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TblIndividu2021;

/**
 * TblIndividu2021Search represents the model behind the search form of `backend\models\TblIndividu2021`.
 */
class TblIndividu2021Search extends TblIndividu2021
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'no'], 'integer'],
            [['namaKegiatan', 'desa', 'keterangan', 'uraian', 'target', 'capaian'], 'safe'],
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
        $query = TblIndividu2021::find();

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

        $query->andFilterWhere(['like', 'namaKegiatan', $this->namaKegiatan])
            ->andFilterWhere(['like', 'desa', $this->desa])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'uraian', $this->uraian])
            ->andFilterWhere(['like', 'target', $this->target])
            ->andFilterWhere(['like', 'capaian', $this->capaian]);

        return $dataProvider;
    }
}
