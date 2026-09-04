<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TargetIndikatorSasaran;

/**
 * TargetIndikatorSasaranSearch represents the model behind the search form of `backend\models\TargetIndikatorSasaran`.
 */
class TargetIndikatorSasaranSearch extends TargetIndikatorSasaran
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['indikator_id', 'cascadingrenstrasasaran_id', 'refsasaranrenstra_id', 'tahun_id'], 'integer'],
            [['refskpd_id', 'target', 'target_rkt_p', 'sebab_rkt_p', 'target_pk', 'sebab_pk', 'target_pk_p', 'sebab_pk_p', 'realisasi', 'capaian', 'keterangan', 'analisis', 'analisis_date', 'analisis_usr'], 'safe'],
            [['test'], 'number'],
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
        $query = TargetIndikatorSasaran::find();

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
            'indikator_id' => $this->indikator_id,
            'cascadingrenstrasasaran_id' => $this->cascadingrenstrasasaran_id,
            'refsasaranrenstra_id' => $this->refsasaranrenstra_id,
            'tahun_id' => $this->tahun_id,
            'analisis_date' => $this->analisis_date,
            'test' => $this->test,
        ]);

        $query->andFilterWhere(['like', 'refskpd_id', $this->refskpd_id])
            ->andFilterWhere(['like', 'target', $this->target])
            ->andFilterWhere(['like', 'target_rkt_p', $this->target_rkt_p])
            ->andFilterWhere(['like', 'sebab_rkt_p', $this->sebab_rkt_p])
            ->andFilterWhere(['like', 'target_pk', $this->target_pk])
            ->andFilterWhere(['like', 'sebab_pk', $this->sebab_pk])
            ->andFilterWhere(['like', 'target_pk_p', $this->target_pk_p])
            ->andFilterWhere(['like', 'sebab_pk_p', $this->sebab_pk_p])
            ->andFilterWhere(['like', 'realisasi', $this->realisasi])
            ->andFilterWhere(['like', 'capaian', $this->capaian])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'analisis', $this->analisis])
            ->andFilterWhere(['like', 'analisis_usr', $this->analisis_usr]);

        return $dataProvider;
    }
}
