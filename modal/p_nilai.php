<?php
	
	include '../config/koneksi.php';
	
	if(isset($_POST['nip_dinilai'])){

		$nip_dinilai = $_POST['nip_dinilai'];
		$nip_penilai = $_POST['nip_penilai'];

		$sql = "SELECT * FROM penilai a JOIN penilai_detail b  ON a.id_penilai = b.id_penilai WHERE a.nip = '$nip_dinilai' AND b.nip = '$nip_penilai' ";
		$q = mysql_query($sql);
		$row = mysql_fetch_array($q);

		$id_penilaian_detail = $row['id_penilai_detail'];
		$sql = "SELECT * FROM penilaian WHERE id_penilai_detail = $id_penilaian_detail ";
		$q = mysql_query($sql);
		if(mysql_num_rows($q)>0){
			if(!mysql_query("DELETE FROM penilaian WHERE id_penilai_detail = $id_penilaian_detail")){
				$_SESSION["flash"]["type"] = "danger";
				$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
				$_SESSION["flash"]["msg"] = "Data gagal disimpan! ";
				
				header("location:../index.php?p=melakukanpen");
			}
		}
		$sql = "INSERT INTO penilaian (id_penilai_detail, id_isi, hasil_nilai) VALUES ";
		$i = 0;
		
		foreach ($_POST as $k => $v) {
			if(substr($k, 0, 16)=='nilai_kompetensi'){
				//echo "$k = $v <br>";
				$id_isi = explode("nilai_kompetensi_", $k)[1];
				if($i==0){
					$sql .= "($id_penilaian_detail, $id_isi, $v)";
				}else{
					$sql .= ", ($id_penilaian_detail, $id_isi, $v)";
				}
				$i++;
			}
		}
		$insert = mysql_query($sql);
		$sql = "UPDATE penilai_detail SET status = 0, pesan = NULL WHERE id_penilai_detail = $id_penilaian_detail";
		$update = mysql_query($sql);
		if($insert){
			$_SESSION["flash"]["type"] = "success";
			$_SESSION["flash"]["head"] = "Sukses";
			$_SESSION["flash"]["msg"] = "Data berhasil disimpan!";
		}else{
			// echo $sql;
			// die(mysql_error());
			$_SESSION["flash"]["type"] = "danger";
			$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
			$_SESSION["flash"]["msg"] = "Data gagal disimpan! ";
		}

		header("location:../index.php?p=melakukanpen");
	} else if($_POST['keberatan']){
		$sql = "SELECT * FROM penilai_detail WHERE id_penilai_detail = '". $_POST["nip_penilai"] . "'";
		$q = mysql_query($sql);
		$row = mysql_fetch_array($q);
		// die($sql);
		// echo mysql_num_rows($q);
		if(mysql_num_rows($q)>0){
			if(isset($_POST['setuju'])){
				$sql = "UPDATE penilai_detail SET status = 2 WHERE id_penilai_detail = '". $_POST["nip_penilai"] . "'";
			} else {
				$sql = "UPDATE penilai_detail SET status = 1, pesan =  '". $_POST["pesan"] . "'  WHERE id_penilai_detail = '". $_POST["nip_penilai"] . "'";
			}
			$query = mysql_query($sql);
			if($query){
				$_SESSION["flash"]["type"] = "success";
				$_SESSION["flash"]["head"] = "Sukses";
				$_SESSION["flash"]["msg"] = "Berhasil mengajukan keberatan!";
			}else{
				$_SESSION["flash"]["type"] = "danger";
				$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
				$_SESSION["flash"]["msg"] = "Gagal mengajukan keberatan! ".mysql_error();
			}
			header("location:../index.php?p=home");
		}
	}
?>