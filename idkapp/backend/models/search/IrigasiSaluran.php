<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\IrigasiSaluran as IrigasiSaluranModel;

/**
 * IrigasiSaluran represents the model behind the search form of `backend\models\IrigasiSaluran`.
 */
class IrigasiSaluran extends IrigasiSaluranModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'luasIrigasi', 'kodeTahun'], 'integer'],
            [['nomeklatur', 'kodeDesa', 'primerKondisiBaik', 'primerSaluranStatus', 'primerPjgSaluran', 'primerSaluranBaik', 'sekunderKondisiBaik', 'sekunderSaluranStatus', 'sekunderPjgSaluran', 'sekunderSaluranBaik', 'pembuangKondisiBaik', 'pembuangSaluranStatus', 'bangunanBagiKondisiBaik', 'bangunanBagiStatus', 'bangunanBagiSadapKondisiBaik', 'bangunanBagiSadapStatus', 'bangunanSadapKondisiBaik', 'bangunanSadapStatus', 'bangunanPintuAirKondisiBaik', 'bangunanPintuAirStatus', 'bangunanTalangKondisiBaik', 'bangunanTalangStatus', 'bangunanSiponKondisiBaik', 'bangunanSiponStatus', 'bangunanGorongKondisiBaik', 'bangunanGorongStatus', 'bangunanTerjunKondisiBaik', 'bangunanTerjunStatus', 'bangunanTanggulKondisiBaik', 'bangunanTanggulStatus', 'rataJaringanKondisiBaik', 'rataJaringanStatus', 'arealBaik', 'arealRusakRingan', 'arealRusakSedang', 'arealRusakBerat', 'arealTotal', 'indeksPrasaranaFisik', 'indeksProduktivitas', 'indeksSaranaPenunjang', 'indeksOrganisasiPersonalia', 'indeksDokumentasi', 'indeksPpa', 'indeksJumlah', 'indeksKategori', 'keterangan'], 'safe'],
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
        $query = IrigasiSaluranModel::find();

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
            'luasIrigasi' => $this->luasIrigasi,
            'kodeTahun' => $this->kodeTahun,
        ]);

        $query->andFilterWhere(['like', 'nomeklatur', $this->nomeklatur])
            ->andFilterWhere(['like', 'kodeDesa', $this->kodeDesa])
            ->andFilterWhere(['like', 'primerKondisiBaik', $this->primerKondisiBaik])
            ->andFilterWhere(['like', 'primerSaluranStatus', $this->primerSaluranStatus])
            ->andFilterWhere(['like', 'primerPjgSaluran', $this->primerPjgSaluran])
            ->andFilterWhere(['like', 'primerSaluranBaik', $this->primerSaluranBaik])
            ->andFilterWhere(['like', 'sekunderKondisiBaik', $this->sekunderKondisiBaik])
            ->andFilterWhere(['like', 'sekunderSaluranStatus', $this->sekunderSaluranStatus])
            ->andFilterWhere(['like', 'sekunderPjgSaluran', $this->sekunderPjgSaluran])
            ->andFilterWhere(['like', 'sekunderSaluranBaik', $this->sekunderSaluranBaik])
            ->andFilterWhere(['like', 'pembuangKondisiBaik', $this->pembuangKondisiBaik])
            ->andFilterWhere(['like', 'pembuangSaluranStatus', $this->pembuangSaluranStatus])
            ->andFilterWhere(['like', 'bangunanBagiKondisiBaik', $this->bangunanBagiKondisiBaik])
            ->andFilterWhere(['like', 'bangunanBagiStatus', $this->bangunanBagiStatus])
            ->andFilterWhere(['like', 'bangunanBagiSadapKondisiBaik', $this->bangunanBagiSadapKondisiBaik])
            ->andFilterWhere(['like', 'bangunanBagiSadapStatus', $this->bangunanBagiSadapStatus])
            ->andFilterWhere(['like', 'bangunanSadapKondisiBaik', $this->bangunanSadapKondisiBaik])
            ->andFilterWhere(['like', 'bangunanSadapStatus', $this->bangunanSadapStatus])
            ->andFilterWhere(['like', 'bangunanPintuAirKondisiBaik', $this->bangunanPintuAirKondisiBaik])
            ->andFilterWhere(['like', 'bangunanPintuAirStatus', $this->bangunanPintuAirStatus])
            ->andFilterWhere(['like', 'bangunanTalangKondisiBaik', $this->bangunanTalangKondisiBaik])
            ->andFilterWhere(['like', 'bangunanTalangStatus', $this->bangunanTalangStatus])
            ->andFilterWhere(['like', 'bangunanSiponKondisiBaik', $this->bangunanSiponKondisiBaik])
            ->andFilterWhere(['like', 'bangunanSiponStatus', $this->bangunanSiponStatus])
            ->andFilterWhere(['like', 'bangunanGorongKondisiBaik', $this->bangunanGorongKondisiBaik])
            ->andFilterWhere(['like', 'bangunanGorongStatus', $this->bangunanGorongStatus])
            ->andFilterWhere(['like', 'bangunanTerjunKondisiBaik', $this->bangunanTerjunKondisiBaik])
            ->andFilterWhere(['like', 'bangunanTerjunStatus', $this->bangunanTerjunStatus])
            ->andFilterWhere(['like', 'bangunanTanggulKondisiBaik', $this->bangunanTanggulKondisiBaik])
            ->andFilterWhere(['like', 'bangunanTanggulStatus', $this->bangunanTanggulStatus])
            ->andFilterWhere(['like', 'rataJaringanKondisiBaik', $this->rataJaringanKondisiBaik])
            ->andFilterWhere(['like', 'rataJaringanStatus', $this->rataJaringanStatus])
            ->andFilterWhere(['like', 'arealBaik', $this->arealBaik])
            ->andFilterWhere(['like', 'arealRusakRingan', $this->arealRusakRingan])
            ->andFilterWhere(['like', 'arealRusakSedang', $this->arealRusakSedang])
            ->andFilterWhere(['like', 'arealRusakBerat', $this->arealRusakBerat])
            ->andFilterWhere(['like', 'arealTotal', $this->arealTotal])
            ->andFilterWhere(['like', 'indeksPrasaranaFisik', $this->indeksPrasaranaFisik])
            ->andFilterWhere(['like', 'indeksProduktivitas', $this->indeksProduktivitas])
            ->andFilterWhere(['like', 'indeksSaranaPenunjang', $this->indeksSaranaPenunjang])
            ->andFilterWhere(['like', 'indeksOrganisasiPersonalia', $this->indeksOrganisasiPersonalia])
            ->andFilterWhere(['like', 'indeksDokumentasi', $this->indeksDokumentasi])
            ->andFilterWhere(['like', 'indeksPpa', $this->indeksPpa])
            ->andFilterWhere(['like', 'indeksJumlah', $this->indeksJumlah])
            ->andFilterWhere(['like', 'indeksKategori', $this->indeksKategori])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
