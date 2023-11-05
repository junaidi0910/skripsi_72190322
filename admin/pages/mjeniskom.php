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
			<h3>Data Master Kelompok Penilaian</h3>
		</div>
	</div>
	<hr class="bg-primary" width="100%">
	<div class="container" >
		<div class="col-xs-12">
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
			  	<span data-feather="file-plus"></span>
			</button>
			<?php 
				$btn = "Tambah"; 
				if(isset($_GET['ubah'])){
					$id_kelpenilaian = isset($_GET['id_kelpenilaian'])?mysql_real_escape_string(htmlspecialchars($_GET['id_kelpenilaian'])):"";
					$sql = "SELECT * FROM kelompok_penilaian WHERE id_kelpenilaian = $id_kelpenilaian";
					$q = mysql_query($sql);
					$data = [];
					while ($row = mysql_fetch_assoc($q)) {
						$id_kelpenilaian = $row['id_kelpenilaian']; 
						$nama_kelpenilaian = $row['nama_kelpenilaian']; 
						$btn = "Ubah"; 
					}

			?>
			<script type="text/javascript">
			    $(document).ready(function(){
					$('#exampleModal').modal('show');
					
					$('#exampleModal').on('hidden.bs.modal', function(e){
						document.location = 'index.php?p=mjeniskom';
					});
			    });
			</script>
			<?php
				}
			?>
			<!-- Modal -->
			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  	<div class="modal-dialog" role="document">
				    <div class="modal-content">
				     	<div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Data Kelompok Penilaian</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          	<span aria-hidden="true">&times;</span>
					        </button>
				      	</div>
				      	<div class="modal-body">
			       			<!-- form -->
					       	<form class="form-horizontal" method="post" action="modal/p_kelompok_penilaian.php">
			       			<input type="hidden" id="id_kelpenilaian" name="id_kelpenilaian" <?= isset($id_kelpenilaian)?'value="'.$id_kelpenilaian.'" readonly':""; ?> >
						  	<div class="form-group row">
								<label for="nama_kelpenilaian" class="col-sm-4 col-form-label col-form-label-sm">Kelompok Penilaian</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="nama_kelpenilaian" name="nama_kelpenilaian" value="<?= isset($nama_kelpenilaian)?$nama_kelpenilaian:""; ?>" placeholder="Nama Kelompok Penilaian">
								</div>
							</div>
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
				<input type="search" class="form-control" data-table="order-table" placeholder="Cari Data Kelompok Penilaian" />
				<hr>
				<table class="order-table">
					<thead>
						<tr>
							<th width="10%">No</th>
							<th width="60%">Kelompok Penilaian</th>
							<th width="30%">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$sql = "SELECT * FROM kelompok_penilaian";
							$q = mysql_query($sql);
							$i=0;
							while($row = mysql_fetch_array($q)){
						?>
						<tr>
							<td><?= ++$i; ?></td>
							<td><?= $row['nama_kelpenilaian']; ?></td>
							<td>
								<button class="btn btn-outline-info btn-sm btn_info" id="<?= $row['id_kelpenilaian'];?>"><span data-feather="info"></span></button>
								<a href="index.php?p=mjeniskom&ubah=true&id_kelpenilaian=<?= $row['id_kelpenilaian'];?>" class="btn btn-outline-warning btn-sm" id="<?= $row['id_kelpenilaian'];?>"><span data-feather="edit"></span></a>
								<button href="#" class="btn btn-outline-danger btn-sm btn_hapus" id="<?= $row['id_kelpenilaian'];?>"><span data-feather="trash-2"></span></button>
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
  	<div class="modal-dialog modal-md">
    	<div class="modal-content">
	      	<div class="modal-header">
		   	 	<h5 class="modal-title" id="exampleModalLabel">Data Kelompok Penilaian</h5>
		      	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		        	<span aria-hidden="true">&times;</span>
		      	</button>
		    </div>
		    <div class="modal-body">
		     	<table class="table">
		     		<tr>
		     			<th width="30%">Kelompok Penilaian</th>
		     			<td width="5%"> : </td>
		     			<td id="td_kelompok_penilaian">  </td>
		     		</tr>
		     		<tr>
		     			<th>Bobot</th>
		     			<td> : </td>
		     			<td  id="td_bobot"> 0 </td>
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
		   	 	<h5 class="modal-title" id="exampleModalLabel">Hapus Data Kelompok Penilaian</h5>
		      	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		        	<span aria-hidden="true">&times;</span>
		        	<form method="post" action="modal/p_kelompok_penilaian.php">
		        		
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
			var _url = "modal/p_kelompok_penilaian.php?id_kelpenilaian="+id;
			$.ajax({
				url: _url, 
				success: function(result){
			  		var res = JSON.parse(result);
			  		console.log(res);
			  		$("#td_kelompok_penilaian").html(res.nama_kelpenilaian);
			  		$("#td_bobot").html(res.bobot_kelpenilaian);
			  	}
			});
			$('.infolengkap').modal('show');
		});

		$(".btn_hapus").click(function(){
			var id = $(this).attr("id");
			$("#id_delete").val(id);
			$('.hapusdata').modal('show');
		});

		$('#exampleModal').on('shown.bs.modal', function () {
			var _url = "modal/p_kelompok_penilaian.php?sum";
			$.ajax({
				url: _url, 
				success: function(result){
					var sum = result;
					var max = 100-sum;
					console.log(max);
					$("#bobot_kelpenilaian").attr("max", max);
			  	}
			});
		});
    });
</script>