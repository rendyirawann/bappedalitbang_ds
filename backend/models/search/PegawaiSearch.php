<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Pegawai;

/**
 * PegawaiSearch represents the model behind the search form of `backend\models\Pegawai`.
 */
class PegawaiSearch extends Pegawai
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'statusAparatur', 'eselon', 'kodeBidang', 'kodeTitle'], 'integer'],
            [['namaLengkap', 'nip', 'no_hp'], 'safe'],
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
        $query = Pegawai::find();

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
            'statusAparatur' => $this->statusAparatur,
            'eselon' => $this->eselon,
            'kodeBidang' => $this->kodeBidang,
            'kodeTitle' => $this->kodeTitle,
        ]);

        $query->andFilterWhere(['like', 'namaLengkap', $this->namaLengkap])
            ->andFilterWhere(['like', 'nip', $this->nip])
            ->andFilterWhere(['like', 'no_hp', $this->no_hp]);

        return $dataProvider;
    }
}
