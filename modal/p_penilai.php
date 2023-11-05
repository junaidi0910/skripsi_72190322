<?php
	include '../config/koneksi.php';
	if(isset($_POST['btnSimpan'])){
		$btn = $_POST['btnSimpan'];
		
		$id_penilai = isset($_POST['txt_id_penilai'])?mysql_real_escape_string(htmlspecialchars($_POST['txt_id_penilai'])):"";
		$dinilai = isset($_POST['dinilai'])?mysql_real_escape_string(htmlspecialchars($_POST['dinilai'])):"";
		$tahun_ajar = isset($_POST['tahun_ajar'])?mysql_real_escape_string(htmlspecialchars($_POST['tahun_ajar'])):"";
		$penilai_pejabat = isset($_POST['penilai_pejabat'])?mysql_real_escape_string(htmlspecialchars($_POST['penilai_pejabat'])):"";
		$penilai_pa_1 = isset($_POST['penilai_pa_1'])?mysql_real_escape_string(htmlspecialchars($_POST['penilai_pa_1'])):"";
		$penilai_pa_2 = isset($_POST['penilai_pa_2'])?mysql_real_escape_string(htmlspecialchars($_POST['penilai_pa_2'])):"";
		$penilai_pa_3 = isset($_POST['penilai_pa_3'])?mysql_real_escape_string(htmlspecialchars($_POST['penilai_pa_3'])):"";
		$penilai_pa_4 = isset($_POST['penilai_pa_4'])?mysql_real_escape_string(htmlspecialchars($_POST['penilai_pa_4'])):"";
		
		$cek = false;
		mysqli_autocommit($con, FALSE);

		if($btn=="Tambah"){

			$sql = "INSERT INTO penilai ( nip, id_periode) VALUES('$dinilai', '$tahun_ajar') ";
			
			

			$qq = mysql_query("SELECT * FROM user a JOIN jenis_user b ON a.id_jenis_user = b.id_jenis_user WHERE b.level = 3 ");
			$row = mysql_fetch_array($qq);
			$nip_kepala = $row['nip'];

			$qq = mysql_query("SELECT * FROM user a JOIN jenis_user b ON a.id_jenis_user = b.id_jenis_user WHERE b.level = 2 ");
			$row = mysql_fetch_array($qq);
			$nip_wakil = $row['nip']; 

			

			$query = mysqli_query($con, $sql);



			if($query){
				$last_id = mysqli_insert_id($con);
				$sql2 = "INSERT INTO penilai_detail ( id_penilai, nip) VALUES ('$last_id', '$penilai_pejabat'), ('$last_id', '$penilai_pa_1'), ('$last_id', '$penilai_pa_2'), ('$last_id', '$penilai_pa_3'), ('$last_id', '$penilai_pa_4') ";
				$query2 = mysqli_query($con, $sql2);
				if($query2){
					$cek = true;
				}
			}
			
			
		}else{
			$qq = "SELECT b.id_penilai_detail FROM penilai a 
				JOIN penilai_detail b ON a.id_penilai = b.id_penilai
				JOIN user c ON b.nip = c.nip
				JOIN jenis_user d ON c.id_jenis_user = d.id_jenis_user
				WHERE a.id_penilai = $id_penilai AND a.nip <> b.nip AND d.level = 1";
			$co = mysql_query($qq);
			$o = 0;
			$id_pd = "";
			while ($rw = mysql_fetch_array($co)) {
				if($o==0){
					$id_pd .= $rw['id_penilai_detail'];
				}else{
					$id_pd .= ', '.$rw['id_penilai_detail'];
				}
				$o++;
			}
			$sqdel = "DELETE FROM penilai_detail WHERE id_penilai_detail IN($id_pd)  ";
			echo $sqdel;
			$query = mysqli_query($con, $sqdel);
			if($query){
				$last_id = $id_penilai;
				$sql2 = "INSERT INTO penilai_detail ( id_penilai, nip) VALUES ('$last_id', '$penilai_pejabat'), ('$last_id', '$penilai_pa_1'), ('$last_id', '$penilai_pa_2'), ('$last_id', '$penilai_pa_3'), ('$last_id', '$penilai_pa_4') ";
				$query2 = mysqli_query($con, $sql2);
				if($query2){
					$cek = true;
				}
			}

			//echo $qq."<br>".$sqdel."<br>".$sql2;

		}
 $err = mysqli_error($con);
		if($cek){
			mysqli_commit($con);

			$_SESSION["flash"]["type"] = "success";
			$_SESSION["flash"]["head"] = "Sukses";
			$_SESSION["flash"]["msg"] = "Data berhasil disimpan!";
		}else{
			mysqli_rollback($con);
			
			$_SESSION["flash"]["type"] = "danger";
			$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
			$_SESSION["flash"]["msg"] = $err;
		}

		header("location:../index.php?p=memilihpen");
		
	}

	if(isset($_POST['id_delete'])){
		$id_isi = isset($_POST['id_delete'])?mysql_real_escape_string(htmlspecialchars($_POST['id_delete'])):"";
		$sql = "DELETE  FROM penilai WHERE id_penilai = $id_isi";
		$query = mysql_query($sql);
		if($query){
			$_SESSION["flash"]["type"] = "success";
			$_SESSION["flash"]["head"] = "Sukses";
			$_SESSION["flash"]["msg"] = "Data berhasil dihapus!";
		}else{
			$_SESSION["flash"]["type"] = "danger";
			$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
			$_SESSION["flash"]["msg"] = "Data gagal dihapus! ".mysql_error();
		}
		header("location:../index.php?p=memilihpen");
	}

	if(isset($_GET['id_penilai'])){
		$id_penilai = isset($_GET['id_penilai'])?mysql_real_escape_string(htmlspecialchars($_GET['id_penilai'])):"";
		/*$sql = "SELECT 
					a.id_penilai, 
					a.nip, 
					(SELECT nip FROM penilai_detail WHERE id_penilai_detail = b.id_penilai_detail) as 'penilai',
					(SELECT nip FROM penilai_detail WHERE id_penilai_detail = b.id_penilai_detail+1) as 'penilai2',
					(SELECT nip FROM penilai_detail WHERE id_penilai_detail = b.id_penilai_detail+2) as 'penilai3',
					(SELECT nip FROM penilai_detail WHERE id_penilai_detail = b.id_penilai_detail+3) as 'penilai4',
					(SELECT nip FROM penilai_detail WHERE id_penilai_detail = b.id_penilai_detail+4) as 'penilai5',
					(SELECT nip FROM penilai_detail WHERE id_penilai_detail = b.id_penilai_detail+5) as 'penilai6'
				FROM penilai a 
				JOIN penilai_detail b ON a.id_penilai = b.id_penilai
				WHERE a.id_penilai = $id_penilai
				GROUP BY a.id_penilai";*/
		$i = 1;
		$sql = "SELECT a.id_penilai, a.nip, b.nip as 'penilai', c.nama_ppa, d.jabatan, d.level, (SELECT nama_ppa FROM user JOIN penilai ON penilai.nip = user.nip WHERE id_penilai = $id_penilai) as nama_dinilai
				FROM penilai a 
				JOIN penilai_detail b ON a.id_penilai = b.id_penilai
				JOIN user c ON b.nip = c.nip
				JOIN jenis_user d ON c.id_jenis_user = d.id_jenis_user
				WHERE a.id_penilai = $id_penilai ORDER BY d.level DESC";
		$q = mysql_query($sql);
		$data = [];
		while ($row = mysql_fetch_assoc($q)) {
			$d['id_penilai'] = $row['id_penilai'];	
			$d['nama_dinilai'] = $row['nama_dinilai'];		
			$d['nip'] = $row['nip'];		
			if($row['level'] != 2) {
				$d['nama_penilai'.$i] = $row['nama_ppa'];			
				$d['penilai'.$i] = $row['penilai'];			
				$i++;
			} else {
				$d['nama_pejabat'] = $row['nama_ppa'];			
				$d['pejabat'] = $row['penilai'];			
			}
		}
		$data = $d; 
		echo json_encode($data);
	}

?>