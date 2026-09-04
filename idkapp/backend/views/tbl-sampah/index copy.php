<?php

use backend\models\TblSampah;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\TblSampahSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tbl Sampahs';
$this->params['breadcrumbs'][] = $this->title;
?>
    <section class="pc-container">
      <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
          <div class="page-block">
            <div class="row align-items-center">
              <div class="col-md-12">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="../dashboard/index.html">Homee</a></li>
                  <li class="breadcrumb-item"><a href="javascript: void(0)">DataTable</a></li>
                  <li class="breadcrumb-item" aria-current="page">Responsive</li>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="page-header-title">
                  <h2 class="mb-0">Responsive</h2>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- [ breadcrumb ] end -->


        <!-- [ Main Content ] start -->
        <div class="row">
          <!-- Config table start -->
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
                <h5>Configuration Option</h5>
                <small
                  >The Responsive extension for DataTables can be applied to a DataTable in one of two ways; with a specific class name on
                  the table.</small
                >
              </div>
              <div class="card-body">
                <table id="res-config" class="display table table-striped table-hover dt-responsive nowrap" style="width: 100%">
                  <thead>
                    <tr>
                    <th>No</th>
                    <th>Enumerator</th>
                    <th>Fasilitas</th>
                    <th>Lokasi</th>
                    <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  <?php $no = 1; ?>
                    <?php foreach ($dataProvider->models as $model): ?>
                    <tr>
                      <td><?= Html::encode($no++) ?></td>
                      <td><?= Html::encode($model->enumerator) ?></td>
                      <td><?= Html::encode($model->fasilitas) ?></td>
                      <td style="width: 150px;">
                    <button type="button" class="btn btn-primary btn-sm" title="View" data-toggle="modal" data-target="#myModal<?= $model->id ?>">
                                <i class="fas fa-eye"></i>
                            </button>
                            <?= Html::a('<i class="fas fa-edit"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-success btn-sm', 'title' => 'Update']) ?>
                            <?= Html::a('<i class="fas fa-trash-alt"></i>', ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger btn-sm',
                                'title' => 'Delete',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </td>
                      <td><?= Html::encode($model->lokasi) ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- Config table end -->
          <!-- `New` Constructor table start -->
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
                <h5>New Constructor</h5>
                <small
                  >The third way of initialising Responsive is by manually creating a new instance using the $.fn.dataTable.Responsive
                  class, as shown in this example (the other two methods are provided using this constructor</small
                >
              </div>
              <div class="card-body">
                <div class="dt-responsive table-responsive">
                  <table id="new-cons" class="display table table-striped table-hover dt-responsive nowrap" style="width: 100%">
                    <thead>
                      <tr>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Position</th>
                        <th>Office</th>
                        <th>Age</th>
                        <th>Start date</th>
                        <th>Salary</th>
                        <th>Extn.</th>
                        <th>E-mail</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Tiger</td>
                        <td>Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>61</td>
                        <td>2011/04/25</td>
                        <td>$320,800</td>
                        <td>5421</td>
                        <td>t.nixon@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Garrett</td>
                        <td>Winters</td>
                        <td>Chief Executive Officer (CEO)</td>
                        <td>Tokyo</td>
                        <td>63</td>
                        <td>2011/07/25</td>
                        <td>$170,750</td>
                        <td>8422</td>
                        <td>g.winters@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Ashton</td>
                        <td>Cox</td>
                        <td>Junior Technical Author</td>
                        <td>San Francisco</td>
                        <td>66</td>
                        <td>2009/01/12</td>
                        <td>$86,000</td>
                        <td>1562</td>
                        <td>a.cox@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Cedric</td>
                        <td>Kelly</td>
                        <td>Senior Javascript Developer</td>
                        <td>Edinburgh</td>
                        <td>22</td>
                        <td>2012/03/29</td>
                        <td>$433,060</td>
                        <td>6224</td>
                        <td>c.kelly@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Airi</td>
                        <td>Satou</td>
                        <td>Accountant</td>
                        <td>Tokyo</td>
                        <td>33</td>
                        <td>2008/11/28</td>
                        <td>$162,700</td>
                        <td>5407</td>
                        <td>a.satou@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Brielle</td>
                        <td>Williamson</td>
                        <td>Integration Specialist</td>
                        <td>New York</td>
                        <td>61</td>
                        <td>2012/12/02</td>
                        <td>$372,000</td>
                        <td>4804</td>
                        <td>b.williamson@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Herrod</td>
                        <td>Chandler</td>
                        <td>Sales Assistant</td>
                        <td>San Francisco</td>
                        <td>59</td>
                        <td>2012/08/06</td>
                        <td>$137,500</td>
                        <td>9608</td>
                        <td>h.chandler@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Rhona</td>
                        <td>Davidson</td>
                        <td>Integration Specialist</td>
                        <td>Tokyo</td>
                        <td>55</td>
                        <td>2010/10/14</td>
                        <td>$327,900</td>
                        <td>6200</td>
                        <td>r.davidson@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Colleen</td>
                        <td>Hurst</td>
                        <td>Javascript Developer</td>
                        <td>San Francisco</td>
                        <td>39</td>
                        <td>2009/09/15</td>
                        <td>$205,500</td>
                        <td>2360</td>
                        <td>c.hurst@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Sonya</td>
                        <td>Frost</td>
                        <td>Software Engineer</td>
                        <td>Edinburgh</td>
                        <td>23</td>
                        <td>2008/12/13</td>
                        <td>$103,600</td>
                        <td>1667</td>
                        <td>s.frost@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Jena</td>
                        <td>Gaines</td>
                        <td>Office Manager</td>
                        <td>London</td>
                        <td>30</td>
                        <td>2008/12/19</td>
                        <td>$90,560</td>
                        <td>3814</td>
                        <td>j.gaines@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Quinn</td>
                        <td>Flynn</td>
                        <td>Support Lead</td>
                        <td>Edinburgh</td>
                        <td>22</td>
                        <td>2013/03/03</td>
                        <td>$342,000</td>
                        <td>9497</td>
                        <td>q.flynn@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Charde</td>
                        <td>Marshall</td>
                        <td>Regional Director</td>
                        <td>San Francisco</td>
                        <td>36</td>
                        <td>2008/10/16</td>
                        <td>$470,600</td>
                        <td>6741</td>
                        <td>c.marshall@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Haley</td>
                        <td>Kennedy</td>
                        <td>Senior Marketing Designer</td>
                        <td>London</td>
                        <td>43</td>
                        <td>2012/12/18</td>
                        <td>$313,500</td>
                        <td>3597</td>
                        <td>h.kennedy@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Tatyana</td>
                        <td>Fitzpatrick</td>
                        <td>Regional Director</td>
                        <td>London</td>
                        <td>19</td>
                        <td>2010/03/17</td>
                        <td>$385,750</td>
                        <td>1965</td>
                        <td>t.fitzpatrick@datatables.net</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- `New` Constructor table end -->
          <!-- Immediately Show Hidden Details table start -->
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
                <h5>Immediately Show Hidden Details</h5>
                <small
                  >Responsive has the ability to display the details that it has hidden in a variety of different ways. Its default is to
                  allow the end user to toggle the the display by clicking on a row and showing the information in a DataTables child
                  row</small
                >
              </div>
              <div class="card-body">
                <div class="dt-responsive table-responsive">
                  <table id="show-hide-res" class="display table table-striped table-hover dt-responsive nowrap" style="width: 100%">
                    <thead>
                      <tr>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Position</th>
                        <th>Office</th>
                        <th>Age</th>
                        <th>Start date</th>
                        <th>Salary</th>
                        <th>Extn.</th>
                        <th>E-mail</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Tiger</td>
                        <td>Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>61</td>
                        <td>2011/04/25</td>
                        <td>$320,800</td>
                        <td>5421</td>
                        <td>t.nixon@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Garrett</td>
                        <td>Winters</td>
                        <td>Chief Executive Officer (CEO)</td>
                        <td>Tokyo</td>
                        <td>63</td>
                        <td>2011/07/25</td>
                        <td>$170,750</td>
                        <td>8422</td>
                        <td>g.winters@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Ashton</td>
                        <td>Cox</td>
                        <td>Junior Technical Author</td>
                        <td>San Francisco</td>
                        <td>66</td>
                        <td>2009/01/12</td>
                        <td>$86,000</td>
                        <td>1562</td>
                        <td>a.cox@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Cedric</td>
                        <td>Kelly</td>
                        <td>Senior Javascript Developer</td>
                        <td>Edinburgh</td>
                        <td>22</td>
                        <td>2012/03/29</td>
                        <td>$433,060</td>
                        <td>6224</td>
                        <td>c.kelly@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Airi</td>
                        <td>Satou</td>
                        <td>Accountant</td>
                        <td>Tokyo</td>
                        <td>33</td>
                        <td>2008/11/28</td>
                        <td>$162,700</td>
                        <td>5407</td>
                        <td>a.satou@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Brielle</td>
                        <td>Williamson</td>
                        <td>Integration Specialist</td>
                        <td>New York</td>
                        <td>61</td>
                        <td>2012/12/02</td>
                        <td>$372,000</td>
                        <td>4804</td>
                        <td>b.williamson@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Herrod</td>
                        <td>Chandler</td>
                        <td>Sales Assistant</td>
                        <td>San Francisco</td>
                        <td>59</td>
                        <td>2012/08/06</td>
                        <td>$137,500</td>
                        <td>9608</td>
                        <td>h.chandler@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Rhona</td>
                        <td>Davidson</td>
                        <td>Integration Specialist</td>
                        <td>Tokyo</td>
                        <td>55</td>
                        <td>2010/10/14</td>
                        <td>$327,900</td>
                        <td>6200</td>
                        <td>r.davidson@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Colleen</td>
                        <td>Hurst</td>
                        <td>Javascript Developer</td>
                        <td>San Francisco</td>
                        <td>39</td>
                        <td>2009/09/15</td>
                        <td>$205,500</td>
                        <td>2360</td>
                        <td>c.hurst@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Sonya</td>
                        <td>Frost</td>
                        <td>Software Engineer</td>
                        <td>Edinburgh</td>
                        <td>23</td>
                        <td>2008/12/13</td>
                        <td>$103,600</td>
                        <td>1667</td>
                        <td>s.frost@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Jena</td>
                        <td>Gaines</td>
                        <td>Office Manager</td>
                        <td>London</td>
                        <td>30</td>
                        <td>2008/12/19</td>
                        <td>$90,560</td>
                        <td>3814</td>
                        <td>j.gaines@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Quinn</td>
                        <td>Flynn</td>
                        <td>Support Lead</td>
                        <td>Edinburgh</td>
                        <td>22</td>
                        <td>2013/03/03</td>
                        <td>$342,000</td>
                        <td>9497</td>
                        <td>q.flynn@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Charde</td>
                        <td>Marshall</td>
                        <td>Regional Director</td>
                        <td>San Francisco</td>
                        <td>36</td>
                        <td>2008/10/16</td>
                        <td>$470,600</td>
                        <td>6741</td>
                        <td>c.marshall@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Haley</td>
                        <td>Kennedy</td>
                        <td>Senior Marketing Designer</td>
                        <td>London</td>
                        <td>43</td>
                        <td>2012/12/18</td>
                        <td>$313,500</td>
                        <td>3597</td>
                        <td>h.kennedy@datatables.net</td>
                      </tr>
                      <tr>
                        <td>Tatyana</td>
                        <td>Fitzpatrick</td>
                        <td>Regional Director</td>
                        <td>London</td>
                        <td>19</td>
                        <td>2010/03/17</td>
                        <td>$385,750</td>
                        <td>1965</td>
                        <td>t.fitzpatrick@datatables.net</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- Immediately Show Hidden Details table end -->
        </div>
        <!-- [ Main Content ] end -->
      </div>
    </section>
<div class="tbl-sampah-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tbl Sampah', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Upload CSV to Database', ['upload'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Export to CSV', ['export-csv'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Export to XLSX', ['export-xlsx'], ['class' => 'btn btn-primary']) ?>

    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'no',
            'enumerator:ntext',
            'fasilitas:ntext',
            'lokasi:ntext',
            //'kondisi:ntext',
            //'thn_pembangunan',
            //'thn_optimalisasi',
            //'kegiatan_pengurangan:ntext',
            //'jlh_sampah_masuk',
            //'jlh_sampah_terolah',
            //'jlh_sampah_residu',
            //'pengelola:ntext',
            //'nama_lembaga:ntext',
            //'bentuk_lembaga:ntext',
            //'jlh_anggota:ntext',
            //'kel_bidang:ntext',
            //'wilayah:ntext',
            //'operasional:ntext',
            //'asset:ntext',
            //'status:ntext',
            //'latitude',
            //'longitude',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TblSampah $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
