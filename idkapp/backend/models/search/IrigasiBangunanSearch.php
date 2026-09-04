<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\IrigasiBangunan;

/**
 * IrigasiBangunanSearch represents the model behind the search form of `backend\models\IrigasiBangunan`.
 */
class IrigasiBangunanSearch extends IrigasiBangunan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'kodeTahun'], 'integer'],
            [['nomeklatur', 'kodeDesa', 'luasIrigasi', 'bgnUtamaStatus', 'bgnUtamaKondisi', 'bgnPengaturPengukurStatus', 'bgnPengaturPengukurKondisi', 'bgnPembawaStatus', 'bgnPembawaKondisi', 'bgnLindungStatus', 'bgnLindungKondisi', 'bgnPelengkapStatus', 'bgnPelengkapKondisi', 'saranaStatus', 'saranaKondisi', 'rataStatus', 'rataKondisi', 'keterangan'], 'safe'],
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
        $query = IrigasiBangunan::find();

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
            'kodeTahun' => $this->kodeTahun,
        ]);

        $query->andFilterWhere(['like', 'nomeklatur', $this->nomeklatur])
            ->andFilterWhere(['like', 'kodeDesa', $this->kodeDesa])
            ->andFilterWhere(['like', 'luasIrigasi', $this->luasIrigasi])
            ->andFilterWhere(['like', 'bgnUtamaStatus', $this->bgnUtamaStatus])
            ->andFilterWhere(['like', 'bgnUtamaKondisi', $this->bgnUtamaKondisi])
            ->andFilterWhere(['like', 'bgnPengaturPengukurStatus', $this->bgnPengaturPengukurStatus])
            ->andFilterWhere(['like', 'bgnPengaturPengukurKondisi', $this->bgnPengaturPengukurKondisi])
            ->andFilterWhere(['like', 'bgnPembawaStatus', $this->bgnPembawaStatus])
            ->andFilterWhere(['like', 'bgnPembawaKondisi', $this->bgnPembawaKondisi])
            ->andFilterWhere(['like', 'bgnLindungStatus', $this->bgnLindungStatus])
            ->andFilterWhere(['like', 'bgnLindungKondisi', $this->bgnLindungKondisi])
            ->andFilterWhere(['like', 'bgnPelengkapStatus', $this->bgnPelengkapStatus])
            ->andFilterWhere(['like', 'bgnPelengkapKondisi', $this->bgnPelengkapKondisi])
            ->andFilterWhere(['like', 'saranaStatus', $this->saranaStatus])
            ->andFilterWhere(['like', 'saranaKondisi', $this->saranaKondisi])
            ->andFilterWhere(['like', 'rataStatus', $this->rataStatus])
            ->andFilterWhere(['like', 'rataKondisi', $this->rataKondisi])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
