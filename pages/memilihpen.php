
<style >

.container table {
  width: 100%;
  font-size: 1rem;
}

.container td, .container th {
  padding: 10px;
}
/* 
.container td:first-child, .container th:first-child {
  padding-left: 20px;
}
 */
.container td:last-child, .container th:last-child {
  padding-right: 20px;
}

.container th {
  border-bottom: 1px solid #ddd;
  position: relative;
}

.tr_odd{
	background-color: rgba(0,0,0,.05);
}
/*  */
</style>

<script >

(function(document) {
	'use strict';

	var LightTableFilter = (function(Arr) {

		var _input;

		function _onInputEvent(e) {
			_input = e.target;
			var tables = document.getElementsByClassName(_input.getAttribute('data-table'));
			Arr.forEach.call(tables, function(table) {
				Arr.forEach.call(table.tBodies, function(tbody) {
					Arr.forEach.call(tbody.rows, _filter);
				});
			});
		}

		function _filter(row) {
			var text = row.textContent.toLowerCase(), val = _input.value.toLowerCase();
			row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
		}

		return {
			init: function() {
				var inputs = document.getElementsByClassName('form-control');
				Arr.forEach.call(inputs, function(input) {
					input.oninput = _onInputEvent;
				});
			}
		};
	})(Array.prototype);

	document.addEventListener('readystatechange', function() {
		if (document.readyState === 'complete') {
			LightTableFilter.init();
		}
	});

	})(document);

</script>

<div class="container">
	<div class="row">
		<div class="col">
			<h1>Memilih Penilai</h1>
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
				Tambah Penilaian
			</button>
			<!-- Modal -->
			<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			  	<div class="modal-dialog modal-dialog-centered" role="document">
				    <div class="modal-content">
				      	<div class="modal-header">
					        <h5 class="modal-title" id="exampleModalCenterTitle">Data Penilai</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          	<span aria-hidden="true">&times;</span>
					        </button>
				      	</div>
				      	<?php
				      		echo '<script>';
				      		$i=0;
				      		$sql_guru = "SELECT * FROM user a JOIN jenis_user b ON a.id_jenis_user = b.id_jenis_user WHERE b.level = 1 AND (SELECT COUNT(*) FROM penilai c WHERE c.nip = a.nip ) = 0";
				      		$q = mysql_query($sql_guru);
				      		echo 'var data_dinilai = [';
				      		while($row = mysql_fetch_array($q)){
				      			if($i!=0){
				      				echo ",";
				      			}
				      			echo '{ nip : "'.$row['nip'].'", ';
				      			echo ' nama : "'.$row['nama_ppa'].'"}';
				      			
				      			$i++;
				      		}
				      		echo '];';

				      		$i=0;
				      		$sql_guru = "SELECT * FROM user a JOIN jenis_user b ON a.id_jenis_user = b.id_jenis_user WHERE b.LEVEL = 2 ";
				      		$q = mysql_query($sql_guru);
				      		echo 'var data_penilai_pejabat = [';
				      		while($row = mysql_fetch_array($q)){
				      			if($i!=0){
				      				echo ",";
				      			}
				      			echo '{ nip : "'.$row['nip'].'", ';
				      			echo ' nama : "'.$row['nama_ppa'].'"}';
				      			
				      			$i++;
				      		}
				      		echo '];';
				      		$i=0;
				      		$sql_guru = "SELECT * FROM user a JOIN jenis_user b ON a.id_jenis_user = b.id_jenis_user WHERE b.LEVEL = 1";
				      		$q = mysql_query($sql_guru);
				      		echo 'var data_penilai_pa = [';
				      		while($row = mysql_fetch_array($q)){
				      			if($i!=0){
				      				echo ",";
				      			}
				      			echo '{ nip : "'.$row['nip'].'", ';
				      			echo ' nama : "'.$row['nama_ppa'].'"}';
				      			
				      			$i++;
				      		}
				      		echo '];';
				      		echo '</script>';
				      	?>
				      	<div class="modal-body">
				      	<form action="modal/p_penilai.php" method="post">
				      		<input type="hidden" name="txt_id_penilai" id="txt_id_penilai" value="" />
				      		<input type="hidden" name="tahun_ajar" value="<?= get_tahun_ajar_id(); ?>" />
				      		<div class="form-group row">
			                	<span class="label-text col-md-6 col-form-label text-md-left">PA/PPA Dinilai</span>
			                    <div class="col-md-6">
			                        <select name="dinilai" id="select_dinilai" class="form-control" placeholderrequired>
			                            
			                        </select>
			                    </div>
			           	 	</div>
				      		<div class="form-group row" id="fg_pejabat">
			                	<span class="label-text col-md-6 col-form-label text-md-left">Pejabat Penilai</span>
			                    <div class="col-md-6">
			                        <select name="penilai_pejabat" id="select_penilai_pejabat" class="form-control" required>
			                            
			                        </select>
			                    </div>
			           	 	</div>
				      		<div class="form-group row" id="fg_penilai_1">
			                	<span class="label-text col-md-6 col-form-label text-md-left">PA/PPA Penilai 1</span>
			                    <div class="col-md-6">
			                        <select name="penilai_pa_1" id="select_penilai_pa_1" class="form-control" required>
			                            
			                        </select>
			                    </div>
			           	 	</div>
				      		<div class="form-group row" id="fg_penilai_2">
			                	<span class="label-text col-md-6 col-form-label text-md-left">PA/PPA Penilai 2</span>
			                    <div class="col-md-6">
			                        <select name="penilai_pa_2" id="select_penilai_pa_2" class="form-control" required>
			                            
			                        </select>
			                    </div>
			           	 	</div>
				      		<div class="form-group row" id="fg_penilai_3">
			                	<span class="label-text col-md-6 col-form-label text-md-left">PA/PPA Penilai 3</span>
			                    <div class="col-md-6">
			                        <select name="penilai_pa_3" id="select_penilai_pa_3" class="form-control" required>
			                            
			                        </select>
			                    </div>
			           	 	</div>
				      		<div class="form-group row" id="fg_penilai_4">
			                	<span class="label-text col-md-6 col-form-label text-md-left">PA/PPA Penilai 4</span>
			                    <div class="col-md-6">
			                        <select name="penilai_pa_4" id="select_penilai_pa_4" class="form-control" required>
			                            
			                        </select>
			                    </div>
			           	 	</div>
							
				            <!-- <div class="row">
				            					            <div class="col-md-4"><label><input type="checkbox" value=""> budi</label></div>
				            					            <div class="col-md-4"><label><input type="checkbox" value=""> budi</label></div>
				            					            <div class="col-md-4"><label><input type="checkbox" value=""> budi</label></div>
				            </div> -->
				      	</div>
				      	<div class="modal-footer">
				        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				        	<input type="submit" class="btn btn-primary btnSimpan" name="btnSimpan" value="Tambah">
				      	</form>
				      	</div>
				    </div>
			  	</div>
			</div>
			<hr>
			<div style="background: rgba(79,195,247 ,0.3); padding: 10px 10px 10px 10px; border-radius: 1rem;">
				<input type="search" class="form-control " data-table="order-table" placeholder="Cari Data Penilai" />
				<hr>
				<table class="order-table table">
					<thead>
						<tr>
							<th width="10%">No</th>
							<th width="30%">PA/PPA Dinilai</th>
							<th width="30%">Pejabat dan PA/PPA Penilai</th>
							<th width="30%">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$i=0;
							$fi = 0;
							$id_pen = "";
							$rowspan = 0;
							$nip_temp = "";
							$idper = get_tahun_ajar_id();
							$sql = "SELECT a.*, b.id_penilai_detail, b.nip as 'nip_dinilai', c.nama_ppa as 'penilai', d.nama_ppa as 'dinilai', e.jabatan FROM penilai a JOIN penilai_detail b ON a.id_penilai = b.id_penilai  JOIN user c ON a.nip = c.nip JOIN user d ON b.nip = d.nip JOIN jenis_user e ON d.id_jenis_user = e.id_jenis_user WHERE a.id_periode = $idper ORDER BY a.nip, e.level DESC";
							$q = mysql_query($sql);
							while($row = mysql_fetch_array($q)){
								if($row['nip']!=$row['nip_dinilai']){
									$ket = $row['jabatan'];
								}else{
									$ket = "Diri Sendiri";
								}
								if($nip_temp == "" || $nip_temp != $row['nip']) {
									$nip_temp = $row['nip'];
							$sql = "SELECT COUNT(*) as total FROM penilai a JOIN penilai_detail b ON a.id_penilai = b.id_penilai  JOIN user c ON a.nip = c.nip JOIN user d ON b.nip = d.nip JOIN jenis_user e ON d.id_jenis_user = e.id_jenis_user WHERE a.id_periode = $idper AND a.nip = $nip_temp ORDER BY a.nip, e.level DESC";
							$rowspan = mysql_query($sql);
							$rowspan = mysql_fetch_assoc($rowspan);
							$rowspan = $rowspan["total"];
							if($fi%2 != 0) {
								$odd='';
							} else {
								$odd = 'class="tr_odd"';
							}
							$fi++;
							$id_pen = $row['id_penilai'];
						?>

						<tr <?= $odd; ?>>
							<td rowspan="<?php echo $rowspan; ?>" style="vertical-align:middle"><?= ++$i; ?></td>
							<td rowspan="<?php echo $rowspan; ?>" style="vertical-align:middle"><?= $row['penilai'].'<br><small>NIP : '.$row['nip'].'</small>'; ?></td>
							<td><?= $row['dinilai'].' ('.$ket.') <br><small>NIP : '.$row['nip_dinilai'].'</small>'; ?></td>
							<td rowspan="<?php echo $rowspan; ?>" style="vertical-align:middle; text-align:center;">
								<button class="btn btn-dark btn-sm btn_ubah" data-id="<?= $row['id_penilai']; ?>" ><span data-feather="edit"></span> </button>
								<button class="btn btn-danger btn-sm  btn_hapus" data-id="<?= $row['id_penilai']; ?>" ><span data-feather="trash-2"></span> </button>
							</td>
						</tr>
						<?php }else{ ?>
						<tr <?= $odd; ?>>
							
							<td><?= $row['dinilai'].' ('.$ket.') <br><small>NIP : '.$row['nip_dinilai'].'</small>'; ?></td>
						</tr>
						<?php } 
							// if($fi>=6){
							// 	$fi=0;	
							// }
							}
							
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade hapusdata" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  	<div class="modal-dialog modal-md">
	    <div class="modal-content">
	      	<div class="modal-header">
		   	 	<h5 class="modal-title" id="exampleModalLabel">Hapus Penilai</h5>
		      	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		        	<span aria-hidden="true">&times;</span>
		      	</button>
		    </div>
		    <div class="modal-body">
		    	<form action="modal/p_penilai.php" method="post">
		    		<input type="hidden" name="id_delete" id="id_delete">
			    	<button type="submit" class="btn btn-danger">Hapus</button>
			    	<button type="button" class="btn btn-secondary">Batal</button>
		    	</form>
		    </div>
		</div>
  	</div>
</div>

<script type="text/javascript">
	var dinilai = '';
	var penilai_pejabat = '';
	var penilai_pa = '';
	var temp_data_penilai_pa = data_penilai_pa.slice(0);
    $(document).ready(function(){
    	$("#exampleModalCenter").on('hidden.bs.modal', function (event) {
    		document.location="index.php?p=memilihpen";
    	});
    	$("#exampleModalCenter").on('show.bs.modal', function (event) {
	    	dinilai = '';
	    	data_dinilai.forEach(isi_dinilai);
			$("#select_dinilai").html('');
			$("#select_dinilai").append('<option value="">[ Pilih PA/PPA Dinilai ]</value>');
			$("#select_dinilai").append(dinilai);

			$("#fg_pejabat").hide();
			$("#fg_penilai_1").hide();
			$("#fg_penilai_2").hide();
			$("#fg_penilai_3").hide();
			$("#fg_penilai_4").hide();
    	});

		$("#select_dinilai").change(function(){
	 		temp_data_penilai_pa = data_penilai_pa.slice(0);
			var v = $(this).val();
			console.log(temp_data_penilai_pa);
			var ind = get_id(v, temp_data_penilai_pa);
			temp_data_penilai_pa.splice(ind, 1);
			penilai_pa = '';
			temp_data_penilai_pa.forEach(isi_penilai_pa);
			penilai_pejabat = '';
			data_penilai_pejabat.forEach(isi_penilai_pejabat);
			$("#select_penilai_pejabat").html('');
			$("#select_penilai_pa_1").html('');
			$("#select_penilai_pa_2").html('');
			$("#select_penilai_pa_3").html('');
			$("#select_penilai_pa_4").html('');
			$("#fg_pejabat").show();
			$("#fg_penilai_1").hide();
			$("#fg_penilai_2").hide();
			$("#fg_penilai_3").hide();
			$("#fg_penilai_4").hide();
			$("#select_penilai_pejabat").append('<option value="">[ Pilih Pejabat Penilai ]</value>');
			$("#select_penilai_pejabat").append(penilai_pejabat);
			$("#select_penilai_pa_1").append('<option value="">[ Pilih PA/PPA Penilai 1 ]</value>');
			$("#select_penilai_pa_1").append(penilai_pa);
		});

		$("#select_penilai_pejabat").change(function(){
			$("#fg_penilai_1").show();
			$("#fg_penilai_2").hide();
			$("#fg_penilai_3").hide();
			$("#fg_penilai_4").hide();
		});

		$("#select_penilai_pa_1").change(function(){
			var v = $(this).val();
			var ind = get_id(v, temp_data_penilai_pa);
			temp_data_penilai_pa.splice(ind, 1);
			penilai_pa = '';
			temp_data_penilai_pa.forEach(isi_penilai_pa);
			$("#select_penilai_pa_2").html('');
			$("#select_penilai_pa_3").html('');
			$("#select_penilai_pa_4").html('');
			$("#fg_penilai_2").show();
			$("#fg_penilai_3").hide();
			$("#fg_penilai_4").hide();
			$("#select_penilai_pa_2").append('<option value="">[ Pilih PA/PPA Penilai 2 ]</value>');
			$("#select_penilai_pa_2").append(penilai_pa);
		});

		$("#select_penilai_pa_2").change(function(){
			var v = $(this).val();
			var ind = get_id(v, temp_data_penilai_pa);
			temp_data_penilai_pa.splice(ind, 1);
			penilai_pa = '';
			temp_data_penilai_pa.forEach(isi_penilai_pa);
			$("#select_penilai_pa_3").html('');
			$("#select_penilai_pa_4").html('');
			$("#fg_penilai_3").show();
			$("#fg_penilai_4").hide();
			$("#select_penilai_pa_3").append('<option value="">[ Pilih PA/PPA Penilai 3 ]</value>');
			$("#select_penilai_pa_3").append(penilai_pa);
		});

		$("#select_penilai_pa_3").change(function(){
			var v = $(this).val();
			var ind = get_id(v, temp_data_penilai_pa);
			temp_data_penilai_pa.splice(ind, 1);
			penilai_pa = '';
			temp_data_penilai_pa.forEach(isi_penilai_pa);
			if(temp_data_penilai_pa.length > 0) {
				$("#select_penilai_pa_4").html('');
				$("#fg_penilai_4").show();
				$("#select_penilai_pa_4").append('<option value="">[ Pilih PA/PPA Penilai 4 ]</value>');
				$("#select_penilai_pa_4").append(penilai_pa);
			}
		});

		$(".btn_hapus").click(function(){
			var daid = $(this).attr("data-id");
			$(".hapusdata").modal("show");
			$("#id_delete").val(daid);
		});


		$(".btn_ubah").click(function(){
			var daid = $(this).attr("data-id");
			var _url = "modal/p_penilai.php?id_penilai="+daid;
			$("#exampleModalCenter").modal("show");
			$(".btnSimpan").val("Ubah");
			$.ajax({
				url: _url, 
				success: function(result){
			  		var res = JSON.parse(result);
			  		$("#txt_id_penilai").val(res.id_penilai);
			  		$("#select_dinilai").append("<option value='"+res.nip+"'>"+res.nama_dinilai+"</option>");
					$('#select_dinilai option[value='+res.nip+']').prop('selected', true);
					$("#select_dinilai").attr("disabled", true);
					dinilai = '';
					$("#select_dinilai").trigger('change');
					$('#select_penilai_pejabat option[value='+res.pejabat+']').prop('selected', true);
					$('#select_penilai_pa_1 option[value='+res.penilai1+']').prop('selected', true);
					$("#select_penilai_pa_1").trigger('change');
					$('#select_penilai_pa_2 option[value='+res.penilai2+']').prop('selected', true);
					console.log(data_penilai_pa);
					$("#select_penilai_pa_2").trigger('change');
					$('#select_penilai_pa_3 option[value='+res.penilai3+']').prop('selected', true);
					$("#select_penilai_pa_3").trigger('change');
					$('#select_penilai_pa_4 option[value='+res.penilai4+']').prop('selected', true);
					$("#select_penilai_pa_4").trigger('change');
					$("#fg_pejabat").show();
					$("#fg_penilai_1").show();
					$("#fg_penilai_2").show();
					$("#fg_penilai_3").show();
					$("#fg_penilai_4").show();
			  	}
			});
		});


    });

    function isi_dinilai(value) {
  		dinilai = dinilai + "<option value='"+value.nip+"'>"+value.nama+"</option>" ; 
	}

    function isi_penilai_pa(value) {
		penilai_pa = penilai_pa + "<option value='"+value.nip+"'>"+value.nama+"</option>" ; 
	}

	function isi_penilai_pejabat(value) {
		penilai_pejabat = penilai_pejabat + "<option value='"+value.nip+"'>"+value.nama+"</option>" ; 
	}

	function get_index (nip) {
		for(var i = 0; i < data_penilai_pa.length; i++){
			if(data_penilai_pa[i].nip == nip){
				return i;
			}
		}
		return -1; 
	}

	function get_id (nip, arr) {
		for(var i = 0; i < arr.length; i++){
			if(arr[i].nip == nip){
				return i;
			}
		}
		return ""; 
	}

	function get_nama (nip, arr) {
		for(var i = 0; i < arr.length; i++){
			if(arr[i].nip == nip){
				return arr[i].nama;
			}
		}
		return ""; 
	}
</script>

