<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DataSampah;

/**
 * DataSampahSearch represents the model behind the search form of `backend\models\DataSampah`.
 */
class DataSampahSearch extends DataSampah
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tahunPembangunan', 'tahunOptimalisasi', 'jlhAnggota'], 'integer'],
            [['enumerator', 'fasilitas', 'kodeDesa', 'kodeKecamatan', 'alamat', 'kondisi', 'kegiatanPengurangan', 'kodePengelola', 'namaLembaga', 'bentukLembaga', 'kodeBidang', 'wilayah', 'kodeDana', 'kodeAset', 'status', 'latitude', 'longitude'], 'safe'],
            [['jlhSampahMasuk', 'jlhSampahKompos', 'jlhSampahResidu'], 'number'],
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
        $query = DataSampah::find();

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
            'tahunOptimalisasi' => $this->tahunOptimalisasi,
            'jlhSampahMasuk' => $this->jlhSampahMasuk,
            'jlhSampahKompos' => $this->jlhSampahKompos,
            'jlhSampahResidu' => $this->jlhSampahResidu,
            'jlhAnggota' => $this->jlhAnggota,
        ]);

        $query->andFilterWhere(['like', 'enumerator', $this->enumerator])
            ->andFilterWhere(['like', 'fasilitas', $this->fasilitas])
            ->andFilterWhere(['like', 'kodeDesa', $this->kodeDesa])
            ->andFilterWhere(['like', 'kodeKecamatan', $this->kodeKecamatan])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'kondisi', $this->kondisi])
            ->andFilterWhere(['like', 'kegiatanPengurangan', $this->kegiatanPengurangan])
            ->andFilterWhere(['like', 'kodePengelola', $this->kodePengelola])
            ->andFilterWhere(['like', 'namaLembaga', $this->namaLembaga])
            ->andFilterWhere(['like', 'bentukLembaga', $this->bentukLembaga])
            ->andFilterWhere(['like', 'kodeBidang', $this->kodeBidang])
            ->andFilterWhere(['like', 'wilayah', $this->wilayah])
            ->andFilterWhere(['like', 'kodeDana', $this->kodeDana])
            ->andFilterWhere(['like', 'kodeAset', $this->kodeAset])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'latitude', $this->latitude])
            ->andFilterWhere(['like', 'longitude', $this->longitude]);

        return $dataProvider;
    }
}
