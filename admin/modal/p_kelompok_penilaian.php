<?php
	include '../../config/koneksi.php';
	if(isset($_POST['btnSimpan'])){
		$btn = $_POST['btnSimpan'];
		
		$id_kelpenilaian = isset($_POST['id_kelpenilaian'])?mysql_real_escape_string(htmlspecialchars($_POST['id_kelpenilaian'])):"";
		$nama_kelpenilaian = isset($_POST['nama_kelpenilaian'])?mysql_real_escape_string(htmlspecialchars($_POST['nama_kelpenilaian'])):"";
		$bobot_kelpenilaian = isset($_POST['bobot_kelpenilaian'])?mysql_real_escape_string(htmlspecialchars($_POST['bobot_kelpenilaian'])):"";
		
		if($btn=="Tambah"){
			$sql = "INSERT INTO kelompok_penilaian ( nama_kelpenilaian, bobot_kelpenilaian) VALUES( '$nama_kelpenilaian', '$bobot_kelpenilaian') ";
		}else{
			$sql = "UPDATE kelompok_penilaian SET nama_kelpenilaian = '$nama_kelpenilaian', bobot_kelpenilaian = '$bobot_kelpenilaian' WHERE id_kelpenilaian = '$id_kelpenilaian'";
		}

		$query = mysql_query($sql);
		if($query){
			$_SESSION["flash"]["type"] = "success";
			$_SESSION["flash"]["head"] = "Sukses";
			$_SESSION["flash"]["msg"] = "Data berhasil disimpan!";
		}else{
			$_SESSION["flash"]["type"] = "danger";
			$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
			$_SESSION["flash"]["msg"] = "Data gagal disimpan! ".mysql_error();
		}
		header("location:../index.php?p=mjeniskom");
	}

	if(isset($_POST['btnDelete'])){
		$id_kelpenilaian = isset($_POST['id_delete'])?mysql_real_escape_string(htmlspecialchars($_POST['id_delete'])):"";
		$sql = "DELETE  FROM kelompok_penilaian WHERE id_kelpenilaian = $id_kelpenilaian";
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
		header("location:../index.php?p=mjeniskom");
	}

	if(isset($_GET['id_kelpenilaian'])){
		$id_kelpenilaian = isset($_GET['id_kelpenilaian'])?mysql_real_escape_string(htmlspecialchars($_GET['id_kelpenilaian'])):"";
		$sql = "SELECT * FROM kelompok_penilaian WHERE id_kelpenilaian = $id_kelpenilaian";
		$q = mysql_query($sql);
		$data = [];
		while ($row = mysql_fetch_assoc($q)) {
			$data = $row; 
		}
		echo json_encode($data);
	}


	if(isset($_GET['sum'])){
		$sql = "SELECT SUM(bobot_kelpenilaian) as bobot FROM kelompok_penilaian";
		$q = mysql_query($sql);
		/*$data = [];
		while ($row = mysql_fetch_assoc($q)) {
			$data = $row[]; 
		}
		*/
		$row = mysql_fetch_assoc($q);
		echo $row['bobot']; 
		//print_r($data);
	}
?>