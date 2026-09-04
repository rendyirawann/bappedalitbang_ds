<style>
	.form-info {
		border-color: #20e8fa;
		background: #e0feff;

	}

	.form-warning {
		border-color: #ed9a15;
		background: #fff3e0;


	}

	.is-invalid {
		border-color: #FA7575;
		outline: 0;
		-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(250, 117, 117, .6);
		box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(250, 117, 117, .6);
	}

	.is-invalid:focus {
		border-color: #f54242;
		outline: 0;
		-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(245, 66, 66, .6);
		box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(245, 66, 66, .6);
	}
</style>
<form class="form-horizontal" role="form" id="frmkebijakan" action="" method="POST">
	<?php
	$loop = 0;
	$loop2 = 0;
	$loop3 = 0;
	$loop4 = 0;
	$loop5 = 0;
	$periode_aktif = $this->menu->get_periode_aktif();
	$jlh = 0;

	$count = 0;
	foreach ($misi as $misi) {
		$row = (object)$misi['detail'];
		$loop++;
	?>

		<div class="form-group">
			<div class="col-sm-12">
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="tblMisi-<?= $loop ?>" style='background: white;'>
							<tr>
								<td class='col-sm-1 bg-primary' colspan='14' style='vertical-align:middle;'>Misi <?= $loop ?> - <?= $row->refmisi_uraian ?></td>
							</tr>
							<?php

							$loop2 = 0;
							foreach ($misi['tujuan'] as $tujuan) {
								$row2 = (object)$tujuan['detail'];
								$loop2++;
								echo "
									<tr>
									<td class='col-sm-1 bg-danger' style='vertical-align:middle;' colspan='14'>Tujuan " . $loop . "." . $loop2 . " - " . $row2->reftujuan_uraian . "</td>
									</tr>";



								$sID = 0;
								$indikatorSasaran = "";
								$loop3 = 0;
								foreach ($tujuan['renstra'] as $renstra) {
									$row3 = (object) $renstra['detail'];
									$loop3++;
									echo "
										<tr>
										<td class='col-sm-1 bg-info' style='vertical-align:middle;'  colspan='14'>Sasaran " . $loop . "." . $loop2 . "." . $loop3 . " - " . $row3->refsasaranrenstra_uraian . "</td>
										</tr>
";


									$iterat = 0;
									$loop4 = 0;
									$prID = "";



									foreach ($renstra['program'] as $program) {
										$row4 = (object) $program['detail'];

										$thn = "";
										$iterat++;
										$loop4++;
										$target = "";
										echo "
											<tr>
											<td class='col-sm-1 bg-warning' style='vertical-align:middle;' colspan='14'>Program " . $loop . "." . $loop2 . "." . $loop3 . "." . $loop4 . " - [" . $row4->permen90refprogram_id . "] " . $row4->refprogram_nama . "</td>
											</tr>
";

										$iterat = 0;
										$loop5 = 0;
										$kgID = "";

										foreach ($program['kegiatan'] as $kegiatan) {

											$row5 = (object) $kegiatan['detail'];

											$thn = "";
											$iterat++;
											$loop5++;
											$target = "";
											echo "
												<tr>
												<td class='col-sm-1 bg-primary' style='vertical-align:middle;' colspan='14'>Kegiatan " . $loop . "." . $loop2 . "." . $loop3 . "." . $loop4 . "." . $loop5 . " - [" . $row5->permen90refkegiatan_id . "] " . $row5->refkegiatan_nama . "</td>
												</tr>";

											$iterat = 0;
											$loop6 = 0;
											$kgID = "";
											$trSasaranRenstra = "";





											foreach ($kegiatan['subkegiatan'] as $row6) {


												$thn = "";
												$iterat++;

												$target = "";
												$anggaran = "";



												$count++;
												if ($kgID != $row6->refsubkegiatan_id) {
													$kegiatan2 = (array) $xkegiatan;
													$kegiatan2['where'] = array(
														"permen90cascadingrenstrakegiatan.refskpd_id" => $this->session->userdata("refskpd_id"),
														"permen90cascadingrenstrakegiatan.permen90refprogram_id" => $row4->permen90refprogram_id,
														"permen90cascadingrenstrakegiatan.permen90refkegiatan_id" => $row5->permen90refkegiatan_id,
														"permen90cascadingrenstrasubkegiatan.permen90refsubkegiatan_id" => $row6->permen90refsubkegiatan_id,
														"permen90cascadingrenstraprogram.refsasaranrenstra_id" => $row3->refsasaranrenstra_id
													);
													//$kegiatan2['sum']= 'refkegiatan.refkegiatan_id, sum(kegiatan_anggaran_th1) as a_th1, sum(kegiatan_anggaran_th2) as a_th2, sum(kegiatan_anggaran_th3) as a_th3, sum(kegiatan_anggaran_th4) as a_th4, sum(kegiatan_anggaran_th5) as a_th5';
													$kegiatan2['sum'] = 'permen90refkegiatan.refkegiatan_id, subkegiatan_anggaran_th1 as a_th1, subkegiatan_anggaran_th2 as a_th2, subkegiatan_anggaran_th3 as a_th3, subkegiatan_anggaran_th4 as a_th4, subkegiatan_anggaran_th5 as a_th5';
													$kegiatan2['group'] = "permen90cascadingrenstrakegiatan.permen90refkegiatan_id";


													$kegiatan2 = (object) $kegiatan2;

													$loop6++;



													$txttarget = "subkegiatan_target_th";
													$txtsatuan = "subkegiatan_satuan_th";
													$txtanggaran = "subkegiatan_anggaran_th";
													$totalsub = "<td colspan='4'></td>";
													for ($i = 1; $i <= 2; $i++) {

														$thn .= "<td class='text-center' colspan='2' style='vertical-align:middle; width:5%;'><i class='fa fa-flag'></i> " . (2023 + $i) . " </td>";
														$an = "a_th" . $i;

														$find = (object)array(
															"from"		=> "permen90cascadingrenstrasubkegiatan",
															"sum"		=> "SUM(" . ($txtanggaran . $i) . ") as anggaran ",
															"where"		=> (object) array(
																"permen90refsubkegiatan_id" => $row6->permen90refsubkegiatan_id,
																"permen90refkegiatan_id" => $row5->permen90refkegiatan_id,
																"permen90refprogram_id" => $row4->permen90refprogram_id,
																"refsasaranrenstra_id" => $row3->refsasaranrenstra_id,
															),
															"group"		=> "permen90refsubkegiatan_id",
														);

														$ang = get_anggaran($find);
														//$arr["a_thn".$i] = $arr["a_thn".$i]+$ang;
														$totalsub .= "<td class='text-right' style='vertical-align:middle; ' colspan='2'>" . number_format($ang->anggaran, 2, ',', '.') . "</td>";

														$anggaran .= "<td class='text-center' style='vertical-align:middle; '>Target</td> <td class='text-center' style='vertical-align:middle; '>Pagu</td>";
													}
													$sub[$loop6] = $totalsub;

													if ($loop6 > 1) {
														$trSasaranRenstra .= "
														<tr class='' style=' border:none;'>" .
															$sub[$loop6 - 1] . "
														</tr>
														<tr class='' style=' border:none;'>
														<td class='text-center ' colspan='14' style='vertical-align:middle; border:none; border'></td>
														</tr>
														";
													}
													$trSasaranRenstra .= "
													<tr class='bg-success'>
													<td rowspan='2' colspan='2' style='vertical-align:middle;  width:6%;'>Sub Kegiatan " . $loop . "." . $loop2 . "." . $loop3 . "." . $loop4 . "." . $loop5 . "." . $loop6 . "</td>
													<td rowspan='2' style='vertical-align:middle; width: 20%;'> [" . $row6->permen90refsubkegiatan_id . "] " . $row6->refsubkegiatan_nama . "</td>
													<td rowspan='2' class='text-center' style='vertical-align:middle; width:5%;'>Satuan</td>
													" . $thn . "
													</tr>
													<tr class='bg-info'>
													" . $anggaran . "
													</tr>
													";
												}
												$data_target = "";
												$data_satuan = "";
												$data_anggaran = "";
												for ($i = 1; $i <= 2; $i++) {
													$set = "subkegiatan_target_th" . $i;
													$target .= "<td class='text-center' style='vertical-align:middle; cursor:pointer;' title=''><span >" . $row6->{$set} . "</td>";
													//$target.="<td class='text-right' style='vertical-align:middle; cursor:pointer;' title=''><span >".number_format($row6->{$txtanggaran.$i},2,',','.')."</td>";
													$target .= "<td class='text-right' style='vertical-align:middle; cursor:pointer;' title=''><span >" . number_format(floatval($row6->{$txtanggaran . $i}), 2, ',', '.') . "</td>";

													$data_target .= $row6->{$txttarget . $i} . "-";
													$data_satuan .= $row6->{$txtsatuan . $i} . "-";
													$data_anggaran .= $row6->{$txtanggaran . $i} . "-";
												}

												//<td class='text-center' style='vertical-align:middle;'>".$row5->cascadingrenstrakegiatan_id."</td>
												$trSasaranRenstra .= "
												<tr class='' style='background:#eee;'>
												<td style='vertical-align:middle; width:100px !important;'>
												<a href='javascript:void(0)' 
												data-casid='" . $row6->cascadingrenstrasubkegiatan_id . "'
												data-kegiatan='" . $row6->permen90refkegiatan_id . "'
												data-caskegiatan='" . $row6->cascadingrenstrakegiatan_id . "'
												data-subkegiatan='" . $row6->permen90refsubkegiatan_id . "'
												data-indikator='" . $row6->permen90refsubkegiatan_indikator . "'
												data-sasaran='" . $row6->permen90refsubkegiatan_sasaran . "'
												data-target='" . $data_target . "'
												data-satuan='" . $data_satuan . "'
												data-anggaran='" . $data_anggaran . "'
												title='Edit' 
												class='btn foredit btn-success btn-xxs'>
												<span class='fa fa-edit'></span>
												</a>

												<a href='javascript:void(0)' onclick='deleteNow(\"" . $row6->cascadingrenstrasubkegiatan_id . "\",\"deleteindikatorsubkegiatanrenstra\")' title='Delete' class='btn btn-danger btn-xxs'> <span class='fa fa-trash-o'></span></a>
												</td>
												<td class='text-center' style='vertical-align:middle;'>Sasaran / Indikator </td>
												<td style='vertical-align:middle;'>" . $row6->permen90refsubkegiatan_sasaran . ' / ' . $row6->permen90refsubkegiatan_indikator . " </td>
												<td class='text-center' style='vertical-align:middle;'>" . $row6->subkegiatan_satuan_th1 . "</td>
												" . $target . "
												</tr>
												";



												$kgID = $row6->refsubkegiatan_id;

												/*
																											
																											<tr>
																										<td colspan='2' class='col-sm-1 text-center bg-success' style='vertical-align:middle;'>Program ".$row4->refprogram_kode."</td>
																										<td class='bg-success' style='vertical-align:middle;' colspan='2'>".$row4->refprogram_nama."</td>
																										</tr>
																										<tr>
																										<td colspan='2' class='col-sm-1 text-center' style='vertical-align:middle;'>Indikator ".$loop.".".$loop2.".".$loop3.".".$loop4."</td>
																										<td class='' style='vertical-align:middle;' colspan='2'>".$row4->refprogram_indikator."</td>
																										</tr>
																										</thead>
																										<tbody>";
																										//$kebijakan = $this->renstra_model->get_data_kebijakan($row["idmisi"],$row2["idtujuan"],$row3["idsasaran"],$row4["idstrategi"]);
																										$kebijakan['where']=array(
																												"refstrategi_renstra.refskpd_id"=>$this->session->userdata("refskpd_id"),
																												"refstrategi_renstra.refstrategi_id"=>$row4->refstrategi_id,
																												
																												);
																										$kebijakan=(object) $kebijakan;
																										
																										$refkebijakan = $this->crud->onView($kebijakan);
																										$iterat = 0;
																										
																										foreach($refkebijakan->data as $row5){
																											if ($row5->reason_delete==""){
																											$iterat++;
																											$loop5++;
																											echo "<tr id='row$loop5'>
																													<td class='text-center' style='vertical-align:top;'>
																													<a class='deleterow' id='deleterow$loop5' onclick='deleteRow(this.id,".$loop.",".$loop2.",".$loop3.",".$loop4.");' href='javascript:void(0);'><img src='".base_url()."images/delete.png'></a>
																													</td>
																													<td class='col-sm-1 text-center btn-default' style='vertical-align:middle;font-size:8px;'>";
																													$iteratthn=0;
																													for($c=$periode_aktif["tahunmulai"];$c<=$periode_aktif["tahunakhir"];$c++){
																														$iteratthn++;
																														$status="status_tahun".$iteratthn;
																														if($row5->{$status}==1)$checked = "checked"; else $checked = "";
																														echo "<div class='col-sm-6' style='padding:0px;'>
																														<input type='hidden' name='update[".$jlh."][status_tahun".$iteratthn."]' value='0'>
																														<input name='update[".$jlh."][status_tahun".$iteratthn."]' id='status_tahun".$iteratthn."-".$loop5."' type='checkbox' value='1' autocomplete='off' $checked>&nbsp;$c&nbsp;</div>";
																													}
																											echo "  </td>
																													<td class='text-center' style='vertical-align:top;'>".$loop.".".$loop2.".".$loop3.".".$loop4.".".$iterat."</td>
																													<td><input type='hidden' name='update[".$jlh."][refmisi_id]' id='idmisi$loop5' value='".$row->refmisi_id."' readonly>
																														 <input type='hidden' name='update[".$jlh."][reftujuan_id]' id='idtujuan$loop5' value='".$row2->reftujuan_id."' readonly>
																														 <input type='hidden' name='update[".$jlh."][refsasaran_id]' id='idsasaran$loop5' value='".$row3->refsasaran_id."' readonly>
																														 <input type='hidden' name='update[".$jlh."][refsasaranrenstra_id]' id='idsasaranrenstra$loop5' value='".$row3->refsasaranrenstra_id."' readonly>
																														 <input type='hidden' name='update[".$jlh."][refstrategi_id]' id='idstra$loop5' value='".$row4->refstrategi_id."' readonly>
																														
																														 <input type='hidden' name='update[".$jlh."][refkebijakan_id]' id='idkeb$loop5' value='".$row5->refkebijakan_id."' readonly>
																														 <textarea class='form-control input-sm' id='kebijakanawal$loop5' rows='2' readonly style='display:none;'>".$row5->refkebijakan_uraian."</textarea>
																														 <textarea class='form-control input-sm' id='kebijakan$loop5' name='update[".$jlh."][refkebijakan_uraian]' rows='2' onkeyup='checkPerubahan($loop5);'>".$row5->refkebijakan_uraian."</textarea>
																														 <textarea class='form-control input-sm form-info reason' data-numb='".$jlh."' id='sebab$loop5' name='update[".$jlh."][reason_delete]' rows='2' placeholder='Sebab Dirubah ?' style='display:none;'></textarea>
																													</td>
																												</tr>";
																												$jlh++;
																											}
																										}
																											*/
											}
											$trSasaranRenstra .= "
																										<tr class='' style=' border:none;'>" .
												$sub[$loop6] . "
																										</tr>
																										<tr class='' style=' border:none;'>
																										<td class='text-center ' colspan='14' style='vertical-align:middle; border:none;'></td>
																										</tr>
																										";
											echo $trSasaranRenstra;
										}
									}
								}
							}

							?>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
	?>
</form>

<script>
	window.jlh = <?= $loop5 ?>;

	function jvSave() {

		if (parseInt($("#jmlStrategi").val()) == 0) {
			msgGagal("Simpan Gagal! minimal harus ada satu strategi!");
			return;
		}

		if (confirm("Apakah anda yakin untuk menyimpan data?")) {
			$("#frmkebijakan").submit();
		}
	}


	$("#frmkebijakan").submit(function(e) {
		var ur = 0;
		var reas = 0;
		e.preventDefault();
		$(".uraian").each(function() {
			uraian = $(this).val();
			if (uraian == "") {
				$(this).addClass("is-invalid");
				ur++;

			}

		});

		$(".reason").each(function() {
			reason = $(this).val();
			if ($(this).css('display') != "none") {
				if (reason == "") {
					$(this).addClass("is-invalid");
					reas++;
				}
			}


		});

		if (ur < 1 && reas < 1) {
			var data = $("#frmkebijakan").serializeArray();
			$.post("<?= base_url() ?>renstra/savekebijakan/", data, function(result) {
				result = $.trim(result);
				var obj = jQuery.parseJSON(result);
				new PNotify(obj)
				loadKebijakan();

			});

		}
	});


	$(".reason").on("keyup", function() {
		var rea = $(this);
		val = rea.val();
		val = val.trim();

		if (val != "") {
			rea.removeClass("is-invalid");
		}
	});

	$(".uraian").on("keyup", function() {
		var ur = $(this);
		val = ur.val();
		val = val.trim();

		if (val != "") {
			ur.removeClass("is-invalid");
		}
	});

	function deleteNow(id, direct) {
		fordelete = id;
		fordirect = direct;
		$("#delData").modal("show");
	}

	function deleteThis() {
		$.post("<?= base_url() ?>renstra/" + fordirect, {
			id: fordelete
		}, function(result) {
			result = $.trim(result);
			var obj = jQuery.parseJSON(result);
			if (obj.type == "success") {
				loadSubKegiatan();
			}
			new PNotify(obj);
			$("#delData").modal("hide");
		});
	}
</script>