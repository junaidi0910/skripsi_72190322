<style >

.container table {
  width: 100%;
  font-size: 1rem;
}

.container td, .container th {
  padding: 10px;
}

.container td:first-child, .container th:first-child {
  padding-left: 20px;
}

.container td:last-child, .container th:last-child {
  padding-right: 20px;
}

.container th {
  border-bottom: 1px solid #ddd;
  position: relative;
}

</style>
<link rel="stylesheet" href="assets/plugins/bootstrap-select/bootstrap-select.css">

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
			<h3>Data Master isi penilaian</h3>
		</div>
	</div>
	<hr class="bg-primary" width="100%">
	<div class="container">
		<div class="col-xs-12">
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
			  	<span data-feather="user-plus"></span>
			</button>

			<?php 
				$btn = "Tambah"; 
				if(isset($_GET['ubah'])){
					$id_isi = isset($_GET['id_isi'])?mysql_real_escape_string(htmlspecialchars($_GET['id_isi'])):"";
					$sql = "SELECT * FROM isi_penilaian WHERE id_isi = $id_isi";
					$q = mysql_query($sql);
					$data = [];
					while ($row = mysql_fetch_assoc($q)) {
						$id_isi = $row['id_isi']; 
						$id_kelpenilaian = $row['id_kelpenilaian']; 
						// $$row['id_kelpenilaian'] = $row['id_kelpenilaian']; 
						$isi_penilaian = $row['isi_penilaian'];
						$btn = "Ubah"; 
					}

			?>
			<script type="text/javascript">
			    $(document).ready(function(){
					$('#exampleModal').modal('show');
					
					$('#exampleModal').on('hidden.bs.modal', function(e){
						document.location = 'index.php?p=misikom';
					});
			    });
			</script>
			<?php
				}
			?>
			<!-- Modal -->
			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  	<div class="modal-dialog modal-lg" role="document">
				    <div class="modal-content">
				      	<div class="modal-header">
				        	<h5 class="modal-title" id="exampleModalLabel">Data User</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          	<span aria-hidden="true">&times;</span>
					        </button>
				      	</div>
				     	<div class="modal-body">
				      	<!-- form -->
					       	<form class="form-horizontal" method="post" action="modal/p_isi_penilaian.php">
					       		<input type="hidden" id="id_isi" name="id_isi" value="<?= isset($id_isi)?$id_isi:""; ?>" >
					       	 	<div class="form-group row">
								   	<label for="id_kelpenilaian" class="col-sm-3 col-form-label col-form-label-sm">Kelompok Penilaian</label>
								    <div class="col-sm-9">
							          	<select class="form-control form-control-sm" id="id_kelpenilaian" name="id_kelpenilaian">
							          		<?php
							          			$jb = mysql_query("SELECT * FROM kelompok_penilaian");
							          			while($rj = mysql_fetch_array($jb)){
							          		?>
									      	<option value="<?= $rj['id_kelpenilaian']?>" <?= $rj['id_kelpenilaian'] == $id_kelpenilaian ?"selected":''?> ><?= $rj['nama_kelpenilaian']; ?></option>
									   		<?php } ?>
									   	</select>
							    	</div>
							  	</div>
								

								<div class="form-group row">
									<label for="isi_penilaian" class="col-sm-3 control-form-label col-form-label-sm">isi penilaian</label>
									<div class="col-sm-9">
										<textarea class="form-control form-control-sm" id="isi_penilaian" name="isi_penilaian" placeholder="isi penilaian" rows="10"><?= isset($isi_penilaian)?$isi_penilaian:""; ?></textarea>
									</div>
								</div>
								<div class="form-group row">
									<label for="ket" class="col-sm-3 control-form-label col-form-label-sm">Penilai</label>
									<div class="col-sm-9">
										<select class="form-control form-control-sm sel-penilai" multiple id="ket" name="ket">
							          		<option value="0">Atasan</option>
							          		<option value="1">Rekan Kerja</option>
							          		<option value="2">Diri Sendiri</option>
									   	</select>
									</div>
								</div>
								<input type="hidden" name="penilai" id="penilai">
				      	</div>
				      	<div class="modal-footer">
				        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				        	<input type="submit" class="btn btn-primary" value="<?= $btn; ?>" name="btnSimpan">
							</form>
				      	</div>
				    </div>
			  	</div>
			</div>
		</div>
	</div>
	<br>
	
	<div class="container">
		<div class="row">
			<div class="col">
			<input type="search" class="form-control" data-table="order-table" placeholder="Cari Data Isi Penilaian" />
			<hr>
				<table class="order-table dataTable" width="100%">
					<thead>
						<tr>
							<th width="10%">No</th>
							<th width="20%">Kelompok Penilaian</th>
							<th width="25%">isi penilaian</th>
							<th>Penilai</th>
							<th width="25%">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$sql = "SELECT * FROM isi_penilaian a JOIN kelompok_penilaian b ON a.id_kelpenilaian = b.id_kelpenilaian ORDER BY b.id_kelpenilaian ASC";
							$q = mysql_query($sql);
							$i=0;
							while($row = mysql_fetch_array($q)){
						?>
						<tr>
							<td><?= ++$i; ?></td>
							<td><?= $row['nama_kelpenilaian']; ?></td>
							<td><?= $row['isi_penilaian']; ?></td>
							<td><?php 
								$a = ['Atasan', 'Rekan Kerja', 'Diri Sendiri'];
								$ret = '';
								if($row['ket']!=''){
									$ket = explode(",", $row['ket']);
									$b = [];
									foreach ($ket as $k => $v) {
										array_push($b, $a[$v]);
									}
									$ret = join(", ", $b);
								}
								echo $ret;
							?></td>
							<td>
								<button class="btn btn-outline-info btn-sm btn_info" id="<?= $row['id_isi'];?>"><span data-feather="info"></span></button>
								<a href="index.php?p=misikom&ubah=true&id_isi=<?= $row['id_isi'];?>" class="btn btn-outline-warning btn-sm" id="<?= $row['id_isi'];?>"><span data-feather="edit"></span></a>
								<button href="#" class="btn btn-outline-danger btn-sm btn_hapus" id="<?= $row['id_isi'];?>"><span data-feather="trash-2"></span></button>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade infolengkap" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  	<div class="modal-dialog modal-lg">
    	<div class="modal-content">
	      	<div class="modal-header">
		   	 	<h5 class="modal-title" id="exampleModalLabel">Data isi penilaian</h5>
		      	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		        	<span aria-hidden="true">&times;</span>
		      	</button>
		    </div>
		    <div class="modal-body">
		     	<table class="table">
		     		<tr>
		     			<th width="30%">Kelompok Penilaian</th>
		     			<td width="5%"> : </td>
		     			<td id="td_kelompok_penilaian">  Sekolah </td>
		     		</tr>
		     		<tr>
		     			<th>isi penilaian</th>
		     			<td> : </td>
		     			<td  id="td_isi_penilaian">  </td>
		     		</tr>
		     	</table>
			</div>
    	</div>
  	</div>
</div>

<div class="modal fade hapusdata" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  	<div class="modal-dialog modal-md">
    	<div class="modal-content">
      		<div class="modal-header">
		   	 	<h5 class="modal-title" id="exampleModalLabel">Hapus Data isi penilaian</h5>
		      	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		        	<span aria-hidden="true">&times;</span>
		        	<form method="post" action="modal/p_isi_penilaian.php">
		        		
		        	<input type="hidden" name="id_delete" id="id_delete">
		      	</button>
		    </div>
		    <div class="modal-body">
		    	<input type="submit" class="btn btn-danger btn_delete" name="btnDelete" value="Hapus">
		        </form>
		    	<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
		    </div>
		</div>
  	</div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
		$(".btn_info").click(function(){
			var id = $(this).attr("id");
			var _url = "modal/p_isi_penilaian.php?id_isi="+id;
			$.ajax({
				url: _url, 
				success: function(result){
			  		var res = JSON.parse(result);
			  		$("#td_kelompok_penilaian").html(res.nama_kelpenilaian);
			  		$("#td_isi_penilaian").html(res.isi_penilaian);
			  	}
			});
			$('.infolengkap').modal('show');
		});
		$(".btn_hapus").click(function(){
			var id = $(this).attr("id");
			$("#id_delete").val(id);
			$('.hapusdata').modal('show');
		});
		$('.sel-penilai').selectpicker();
		$(".sel-penilai").change(function(){
			var a = $(this).val();
			var b = a.join();
			$("#penilai").val(b);
		});
    });
</script>