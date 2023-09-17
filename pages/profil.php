<?php
	$nip_user = $_SESSION[md5('user')];//'2012091200113504';
			
	$sql = "SELECT * FROM user a JOIN jenis_user b ON a.id_jenis_user = b.id_jenis_user WHERE a.nip = '$nip_user'";
	$q = mysql_query($sql);
	$row = mysql_fetch_array($q);

?>

<div class="container">
	<div class="row">
		<div class="col">
			<h2>Profil Pengguna</h2>
			<hr>
			<table width="100%">
				<tr>
					<th width="25%">Nip</th>
					<td width="5%">:</td>
					<td id="td_nip"><?= $row['nip']; ?></td>
				</tr>
				<tr>
					<th>Jabatan</th>
					<td>:</td>
					<td id="td_jabatan"><?= $row['jabatan']; ?></td>
				</tr>

				<tr>
					<th>Password</th>
					<td>:</td>
					<td id="td_password"><?= $row['password']; ?></td>
				</tr>

				<tr>
					<th>Nama PA/PPA</th>
					<td>:</td>
					<td id="td_nama_ppa"><?= $row['nama_ppa']; ?></td>
				</tr>

				<tr>
					<th>Status PA/PPA</th>
					<td>:</td>
					<td id="td_status_ppa"><?= $row['status_ppa']; ?></td>
				</tr>

				<tr>
					<th>Alamat</th>
					<td>:</td>
					<td id="td_alamat"><?= $row['alamat']; ?></td>
				</tr>

				<tr>
					<th>Tempat</th>
					<td>:</td>
					<td id="td_ttl"><?= $row['tempat_lahir']; ?></td>
				</tr>

				<tr>
					<th>Tanggal Lahir</th>
					<td>:</td>
					<td id="td_ttl"><?= $row['tgl_lahir']; ?></td>
				</tr>

				<tr>
					<th>Jenis Kelamin</th>
					<td>:</td>
					<td id="td_jk"><?= $row['jenis_kelamin']; ?></td>
				</tr>

				<tr>
					<th>Status Nikah</th>
					<td>:</td>
					<td id="td_status_nikah"><?= $row['status_nikah']; ?></td>
				</tr>

				<tr>
					<th>No Telp</th>
					<td>:</td>
					<td id="td_notelp"><?= $row['no_telp']; ?></td>
				</tr>
		     	
			</table>
		</div>
	</div>
</div>


<script type="text/javascript">
			var id = $(this).attr("id");
			var _url = "admin/modal/p_user.php?nip="+id;
			$.ajax({
				url: _url, 
				success: function(result){
			  		var res = JSON.parse(result);
			  		console.log(res);
			  		$("#td_nip").html(res.nip);
			  		$("#td_jabatan").html(res.jabatan);
			  		$("#td_password").html(res.password);
			  		$("#td_nama_ppa").html(res.nama_ppa);
			  		$("#td_status_ppa").html(res.status_ppa);
			  		$("#td_alamat").html(res.alamat);
			  		$("#td_ttl").html(res.tempat_lahir+", "+res.tgl_lahir);
			  		$("#td_jk").html(res.jenis_kelamin=="L"?"Laki-laki":"Perempuan");
			  		$("#td_status_nikah").html(res.status_nikah=="B"?"Belum Nikah":"Sudah Nikah");
			  		$("#td_notelp").html(res.no_telp);
			  	}
			})
</script>