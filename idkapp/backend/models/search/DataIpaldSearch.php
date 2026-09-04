<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DataIpald;

/**
 * DataIpaldSearch represents the model behind the search form of `backend\models\DataIpald`.
 */
class DataIpaldSearch extends DataIpald
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tahunPembangunan', 'tahunRehabilitasi', 'kapasitasDesain', 'kapasitasPakai', 'jumlahAnggota'], 'integer'],
            [['enumerator', 'fasilitas', 'kodeKecamatan', 'kodeDesa', 'alamat', 'sistem', 'kondisi', 'kodePengelola', 'cekEffluent', 'namaLembaga', 'bentukLembaga', 'kodeBidang', 'kodeDana', 'kodeAset', 'kodeStatus', 'latitude', 'longitude'], 'safe'],
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
        $query = DataIpald::find();

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
            'tahunPembangunan' => $this->tahunPembangunan,
            'tahunRehabilitasi' => $this->tahunRehabilitasi,
            'kapasitasDesain' => $this->kapasitasDesain,
            'kapasitasPakai' => $this->kapasitasPakai,
            'jumlahAnggota' => $this->jumlahAnggota,
        ]);

        $query->andFilterWhere(['like', 'enumerator', $this->enumerator])
            ->andFilterWhere(['like', 'fasilitas', $this->fasilitas])
            ->andFilterWhere(['like', 'kodeKecamatan', $this->kodeKecamatan])
            ->andFilterWhere(['like', 'kodeDesa', $this->kodeDesa])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'sistem', $this->sistem])
            ->andFilterWhere(['like', 'kondisi', $this->kondisi])
            ->andFilterWhere(['like', 'kodePengelola', $this->kodePengelola])
            ->andFilterWhere(['like', 'cekEffluent', $this->cekEffluent])
            ->andFilterWhere(['like', 'namaLembaga', $this->namaLembaga])
            ->andFilterWhere(['like', 'bentukLembaga', $this->bentukLembaga])
            ->andFilterWhere(['like', 'kodeBidang', $this->kodeBidang])
            ->andFilterWhere(['like', 'kodeDana', $this->kodeDana])
            ->andFilterWhere(['like', 'kodeAset', $this->kodeAset])
            ->andFilterWhere(['like', 'kodeStatus', $this->kodeStatus])
            ->andFilterWhere(['like', 'latitude', $this->latitude])
            ->andFilterWhere(['like', 'longitude', $this->longitude]);

        return $dataProvider;
    }
}
