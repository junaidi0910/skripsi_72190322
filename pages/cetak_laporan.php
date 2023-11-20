<?php
  require_once('../config/koneksi.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->
    <link href="<?= base_url("../assets/css/bootstrap.min.css") ?>" rel="stylesheet">
	<title>Laporan Penilaian Kinerja</title>
	<style>
		@page {
			size: a4 potrait; 
			font-size: 12px;
		} 
		table.main, table.main th, table.main td {
			border: 1px solid black !important;
		}
		table.inner, table.inner th, table.inner td {
			border: 0px solid black !important;
		}
		th, td {
			padding: 0 8px;
		}

	</style>
</head>
<body>
	<div class="">
		<table style="width: 100%;">
			<tr>
				<td style="width:10%">
					<img class="img-header" src="<?= base_url("../assets/img/LOGO UKDW WARNA PNG.png") ?>" style="height: 50px;" alt="Logo">
				</td>
				<td style="width:70%">
					<h4 style="margin-bottom: 0; font-weight: bold;">UNIVERSITAS KRISTEN DUTA WACANA</h4>
					<p style="padding: 0; margin: 0;">Jl. Dr. Wahidin Sudirohusodo No.5-25, Yogyakarta</p>
				</td>
				<td style="width: 25%; font-weight: bold; font-size: 14px;">
					( RAHASIA )
				</td>
			</tr>
		</table>
		<br>
		<br>
		<?php
			$sql = "SELECT c.nama_ppa, c.nip, c.golongan, c.jabatan, c.unit_organisasi, d.jabatan as level, ROUND(AVG(a.hasil_nilai),2) as rata2, b.status, b.id_penilai, b.id_penilai_detail, b.pesan FROM penilaian a JOIN penilai_detail b ON b.id_penilai_detail = a.id_penilai_detail JOIN user c ON c.nip = b.nip JOIN jenis_user d ON d.id_jenis_user = c.id_jenis_user JOIN penilai e ON e.id_penilai = b.id_penilai WHERE b.id_penilai_detail = '". $_GET["nip_penilai"]."' AND e.nip = '". $_GET["nip_dinilai"]."' GROUP BY a.id_penilai_detail";
			$q = mysql_query($sql);
			$row = mysql_fetch_assoc($q);

			// echo $sql;

			// echo $row["id_penilai_detail"];

			$sql2 = "SELECT * FROM user c JOIN jenis_user d ON c.id_jenis_user = d.id_jenis_user WHERE c.nip = '". $_GET["nip_dinilai"]."'";
			$q2 = mysql_query($sql2);
			$rw = mysql_fetch_array($q2);

			$sebagai = $rw['level']==3||$rw['level']==2?'0':($rw['level']==1?'1':($row["nip"]==$rw['nip']?'2':''));
		?>
		<div class="row mt-5">
			<div class="col">
				<div class="text-center">
					<h4 style="font-weight: bold;">
						DAFTAR PENILAIAN PELAKSANAAN PEKERJAAN <br>
						DP3 <br>
						KARYAWAN / PEGAWAI TETAP <br>
						JANGKA WAKTU PENILAIAN <br>
						<br>
						BULAN : <br>
						S.D.
					</h4>
				</div>
			</div>
		</div>
		<div class="row mt-5">
			<div class="col">
				<table style="table-layout: fixed; width: 100%;" class="main">
					<colgroup>
					<col style="width: 2.5%; text-align: center;">
					<col style="width: 15%">
					<col style="width: 25%">
					<col style="width: 15%">
					<col style="width: 15%">
					<col style="width: 27.5%">
					</colgroup>
					<tbody>
					<tr>
						<td rowspan="6" style="width: 7.5%; text-align: center;">1.</td>
						<td colspan="5" style="font-weight: bold;">YANG DINILAI</td>
					</tr>
					<tr>
						<td colspan="2">a. Nama</td>
						<td colspan="3"><?= $rw["nama_ppa"]; ?></td>
					</tr>
					<tr>
						<td colspan="2">b. N I K</td>
						<td colspan="3"><?= $rw["nip"]; ?></td>
					</tr>
					<tr>
						<td colspan="2">c. Pangkat, Golongan / ruang</td>
						<td colspan="3"><?= $rw["golongan"]; ?></td>
					</tr>
					<tr>
						<td colspan="2">d. Jabatan / pekerjaan</td>
						<td colspan="3"><?= $rw["jabatan"]; ?></td>
					</tr>
					<tr>
						<td colspan="2">e. Unit Organisasi</td>
						<td colspan="3"><?= $rw["unit_organisasi"]; ?></td>
					</tr>
					<tr>
						<td rowspan="6" style="width: 7.5%; text-align: center;">2.</td>
						<td colspan="5" style="font-weight: bold;">PEJABAT PENILAI</td>
					</tr>
					<tr>
						<td colspan="2">a. Nama</td>
						<td colspan="3"><?= $row["nama_ppa"]; ?></td>
					</tr>
					<tr>
						<td colspan="2">b. N I K</td>
						<td colspan="3"><?= $row["nip"]; ?></td>
					</tr>
					<tr>
						<td colspan="2">c. Pangkat, Golongan / ruang</td>
						<td colspan="3"><?= $row["golongan"]; ?></td>
					</tr>
					<tr>
						<td colspan="2">d. Jabatan / pekerjaan</td>
						<td colspan="3"><?= $row["jabatan"]; ?></td>
					</tr>
					<tr>
						<td colspan="2">e. Unit Organisasi</td>
						<td colspan="3"><?= $row["unit_organisasi"]; ?></td>
					</tr>
					<tr>
						<td rowspan="6" style="width: 7.5%; text-align: center;">3.</td>
						<td colspan="5" style="font-weight: bold;">ATASAN PEJABAT PENILAI</td>
					</tr>
					<tr>
						<td colspan="2">a. Nama</td>
						<td colspan="3"></td>
					</tr>
					<tr>
						<td colspan="2">b. N I K</td>
						<td colspan="3"></td>
					</tr>
					<tr>
						<td colspan="2">c. Pangkat, Golongan / ruang</td>
						<td colspan="3"></td>
					</tr>
					<tr>
						<td colspan="2">d. Jabatan / pekerjaan</td>
						<td colspan="3"></td>
					</tr>
					<tr>
						<td colspan="2">e. Unit Organisasi</td>
						<td colspan="3"></td>
					</tr>
					<tr>
						<td id="no4" style="width: 7.5%; text-align: center;">4.</td>
						<td colspan="5" style="font-weight: bold;">PENILAI</td>
					</tr>
					<tr>
						<td colspan="2" rowspan="2">UNSUR YANG DINILAI</td>
						<td colspan="2" style="text-align: center;">NILAI</td>
						<td id="keterangan" style="width: 22.5%">KETERANGAN
						<p>Nilai rata-rata adalah jumlah dibagi dengan jumlah unsur yang dinilai.</p>
						<br>
							<p style="padding: 0; margin: 0;">NILAI SEBUTAN</p>
							<p style="padding: 0; margin: 0;">91 - 100 : Amat Baik</p>
							<p style="padding: 0; margin: 0;">76 - 90 : Baik</p>
							<p style="padding: 0; margin: 0;">61 - 75 : Cukup Baik</p>
							<p style="padding: 0; margin: 0;">51 - 60 : Sedang</p>
							<p style="padding: 0; margin: 0;">< 50 : Kurang</p>
						</td>
					</tr>
					<tr>
						<td>ANGKA</td>
						<td>SEBUTAN</td>
					</tr>
					<?php
						$sql3 = "SELECT * FROM penilai a JOIN penilai_detail b  ON a.id_penilai = b.id_penilai WHERE a.nip = '".$rw["nip"]."' AND b.nip = '".$row["nip"]."' ";
						$q3 = mysql_query($sql3);
						$row3 = mysql_fetch_array($q3);
						// echo $sql3;

						// echo $sql3;
						
						$id_penilaian_detail = $row3['id_penilai_detail'];
						$sql4 = "SELECT * FROM penilaian WHERE id_penilai_detail = $id_penilaian_detail";
						$q4 = mysql_query($sql4);
						
						// echo $sql4;
						$sqlz = "SELECT * FROM kelompok_penilaian WHERE nama_kelpenilaian != 'Rekan Kerja'";
					$qz = mysql_query($sqlz);
					$i = 0;
					$data_kompetensi = [];
					$no4 = 0;
					while($rowz = mysql_fetch_array($qz)){
						$data_kompetensi[$i]['id_kelpenilaian'] = $rowz['id_kelpenilaian'];
						$data_kompetensi[$i]['nama_kelpenilaian'] = $rowz['nama_kelpenilaian'];
						$i++;	
					}
				?>
				<!-- <?php print_r($data_kompetensi); ?> -->
						<?php
							$tot = 0;
					foreach ($data_kompetensi as $k => $v) {
					?>
						<?php
							$sql5 = "SELECT * FROM isi_penilaian a JOIN penilaian b ON b.id_isi = a.id_isi WHERE a.id_kelpenilaian = $v[id_kelpenilaian] AND b.id_penilai_detail = '$id_penilaian_detail'";
							// echo $sq;
							$q5 = mysql_query($sql5);
							$banyak = mysqli_num_rows($q5);
							$j = 0;
							$no4 += $banyak;
							while($row5 = mysql_fetch_array($q5)){

								if($row5['hasil_nilai'] >= 91 && $row5['hasil_nilai'] <= 100) {
									$sebutan = 'Amat Baik';
								} else if ($row5['hasil_nilai'] >= 76 && $row5['hasil_nilai'] <= 90) {
									$sebutan = 'Baik';
								} else if ($row5['hasil_nilai'] >= 61 && $row5['hasil_nilai'] <= 75) {
								$sebutan = 'Cukup Baik';
							} else if ($row5['hasil_nilai'] >= 51 && $row5['hasil_nilai'] <= 60) {
								$sebutan = 'Sedang';
							} else if ($row5['hasil_nilai'] <= 50) {
								$sebutan = 'Kurang';
							} else {
								$sebutan = '';
							}    
							$tot += $row5['hasil_nilai'];
						?>
						<tr>
						<?php if($j == 0) { ?>
						<td rowspan="<?= $banyak; ?>" style="width: 15%; font-weight: bold;"><?= $v['nama_kelpenilaian']; ?></td>
						<?php } ?>
						<td style="width: 25%"><?= $row5['isi_penilaian']; ?></td>
						<td style="width: 15%"><?= $row5['hasil_nilai']; ?></td>
						<td style="width: 15%"><?= $sebutan; ?></td>
					</tr>
					<?php $j++; 
					if($j == $banyak) {
						$j = 0;
					}
					} ?>
					<?php
					}

					if($tot > 0) {
						$rata2 = $tot/$no4;
					} else {
						$rata2 = 0;
					}

					if($rata2 >= 91 && $rata2 <= 100) {
						$sebutan = 'Amat Baik';
					} else if ($rata2 >= 76 && $rata2 <= 90) {
						$sebutan = 'Baik';
					} else if ($rata2 >= 61 && $rata2 <= 75) {
						$sebutan = 'Cukup Baik';
					} else if ($rata2 >= 51 && $rata2 <= 60) {
						$sebutan = 'Sedang';
					} else if ($rata2 <= 50) {
						$sebutan = 'Kurang';
					}  
					?>
					
					<tr>
						<td colspan="2">JUMLAH</td>
						<td><?= $tot; ?></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="2">NILAI RATA-RATA</td>
						<td><?= number_format((float)$rata2, 2, ',', ''); ?></td>
						<td><?= $sebutan; ?></td>
					</tr>
					<tr>
						<td style="width: 7.5%; text-align: center;">5.</td>
						<td colspan="5">KEBERATAN DARI KARYAWAN / PEGAWAI YANG DINILAI (JIKA ADA)
							<table style="width: 100%;" class="inner">
								<tr>
									<td style="width: 50%;"><p style="text-align: center"><?= $row["pesan"]; ?></p></td>
									<td style="width: 50%;">
										YOGYAKARTA, <?php echo date('d-m-Y'); ?>
										<br>
										<br>
										<br>
										(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="width: 7.5%; text-align: center;">6.</td>
						<td colspan="5">TANGGAPAN PEJABAT PENILAI ATAS KEBERATAN
							<table style="width: 100%;" class="inner">
								<tr>
									<td style="width: 50%;"><p style="text-align: center"></p></td>
									<td style="width: 50%;">
										YOGYAKARTA, <?php echo date('d-m-Y'); ?>
										<br>
										<br>
										<br>
										(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="width: 7.5%; text-align: center;">7.</td>
						<td colspan="5">KEPUTUSAN ATASAN PENILAI PEJABAT ATAS KEBERATAN
							<table style="width: 100%;" class="inner">
								<tr>
									<td style="width: 50%;"><p style="text-align: center">Valid</p></td>
									<td style="width: 50%;">
										YOGYAKARTA, <?php echo date('d-m-Y'); ?>
										<br>
										<br>
										<br>
										(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="width: 7.5%; text-align: center;">8.</td>
						<td colspan="5">
							<table style="width: 100%;" class="inner">
								<tr>
									<td style="width: 50%;"><p style="text-align: center"></p></td>
									<td style="width: 50%;">
										DIBUAT TANGGAL <?php echo date('d-m-Y'); ?> <br>
										<?= $row["jabatan"]; ?>
										<br>
										<br>
										<br>
										NIP : <?= $row["nip"]; ?> <br>
										(&nbsp; <?= $row["nama_ppa"]; ?> &nbsp;)
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="width: 7.5%; text-align: center;">9.</td>
						<td colspan="2">DITERIMA TANGGAL <?php echo date('d-m-Y'); ?><br>KARYAWAN/PEGAWAI TETAP YANG DINILAI<br><br><br>(&nbsp; <?= $rw["nama_ppa"]; ?> &nbsp;)</td>
						<td style="width: 7.5%; text-align: center;">10.</td>
						<td colspan="2">DITERIMA TANGGAL <?php echo date('d-m-Y'); ?><br>ATASAN PEJABAT YANG MENILAI<br><br><br>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>