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

tr.bold > td{
    font-weight: bolder;
}

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
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
        <?php

            if(!isset($_GET['id'])){
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2>Data PA/PPA yang dinilai</h2> <a class="float-right" title="Rubrik Penilaian" href="assets/file/rubrik.pdf"><i class="fa fa-file-pdf-o fa-2x"></i></a>
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>NIP</td>
                        <td>Nama</td>
                        <td>Aksi</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i=0;
                        $nip_s = $_SESSION[md5('user')];
                        $sql = "SELECT a.id_penilai, a.nip, c.nama_ppa, b.id_penilai_detail FROM penilai a JOIN penilai_detail b  ON a.id_penilai = b.id_penilai
                                JOIN user c ON a.nip = c.nip WHERE b.nip = '$nip_s' ";
                                /*AND b.id_penilai_detail NOT IN(SELECT id_penilai_detail FROM penilaian)*/
                        //echo $sql;
                        $q = mysql_query($sql);
                        //if(mysql_num_rows($q)>0)
                        while($row = mysql_fetch_array($q)){
                    ?>
                    <tr class="<?= sudah($row['id_penilai_detail']); ?>">
                        <td><?= ++$i; ?></td>
                        <td><?= $row['nip']; ?></td>
                        <td><?= $row['nama_ppa']; ?></td>
                        <td>
                            <?php
                            $sql2 = "SELECT * FROM penilai a JOIN penilai_detail b ON a.id_penilai = b.id_penilai JOIN penilaian c ON b.id_penilai_detail = c.id_penilai_detail WHERE b.id_penilai_detail = ".$row['id_penilai_detail'];
                            $q2 = mysql_query($sql2);
                            if(mysql_num_rows($q2)==0){ ?>
                            <a href="index.php?p=melakukanpen&id=<?= $row['id_penilai']; ?>" class="btn btn-success btn-sm">
                                <span class="fa fa-pencil fa-2x"></span> 
                            </a>
                            <?php } else { ?>
                            <button class="btn btn-secondary btn-sm" disabled>
                                <span class="fa fa-pencil fa-2x"></span> 
                            </button> 
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php }else{ ?>
        <?php
            $nip_s = $_SESSION[md5('user')];
            $ssql = "SELECT * FROM user c JOIN jenis_user d ON c.id_jenis_user = d.id_jenis_user WHERE c.nip = '$nip_s'";
            $q = mysql_query($ssql);
            $rw = mysql_fetch_array($q);
            $sebagai = $rw['level']==3?'0':($rw['level']==1?'1':($nip_s==$rw['nip']?'2':''));

            $id_penilai = isset($_GET['id'])?mysql_real_escape_string(htmlspecialchars($_GET['id'])):"";
            $sql = "SELECT a.id_penilai, a.nip, b.nama_ppa, b.golongan, b.unit_organisasi, b.jabatan FROM penilai a JOIN user b ON a.nip = b.nip JOIN jenis_user c ON b.id_jenis_user = c.id_jenis_user WHERE a.id_penilai = '$id_penilai'";
            $q = mysql_query($sql);
            $row  = mysql_fetch_array($q);
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-12">
                    <h2>Penilaian Kinerja (DP3)</h2>
                    <br>
                    <table class="table">
                        <tr>
                            <td><strong>Nama</strong></td>
                            <td>:</td>
                            <td> <?= $row['nama_ppa']; ?></td>
                        </tr>
                        <tr>
                            <td width="40%"><strong>NIP</strong></td>
                            <td width="1%">:</td>
                            <td> <?= $row['nip']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Pangkat, Golongan / ruang</strong></td>
                            <td>:</td>
                            <td> <?= $row['golongan']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Jabatan / Pekerjaan</strong></td>
                            <td>:</td>
                            <td> <?= $row['jabatan']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Unit Organisasi</strong></td>
                            <td>:</td>
                            <td> <?= $row['unit_organisasi']; ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 offset-md-1 offset-lg-1 align-self-end">
                    <h2 class="text-center">KETERANGAN</h2>
                    <p>Nilai rata-rata adalah jumlah dibagi dengan jumlah unsur yang dinilai.</p>
                </div>
            </div>
            <form class="form-horizontal" method="post" action="modal/p_nilai.php">
            <div class="row mt-4">
                <div class="col-lg-7 col-sm-7">
                    <h2>UNSUR YANG DINILAI</h2>
                    <br>
                        <input type="hidden" name="nip_dinilai" value="<?= $row['nip']; ?>" >
                        <input type="hidden" name="nip_penilai" value="<?= $_SESSION[md5('user')]; ?>" >
                        <nav class="">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <!-- <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Kompetensi Pedagogik</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Kompetensi Kepribadian</a>
                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Kompetensi Sosial</a>
                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contacti" role="tab" aria-controls="nav-contacti" aria-selected="false">Kompetensi Profesional</a>
                        --><?php 
                            $sql = "SELECT * FROM kelompok_penilaian";
                            $q = mysql_query($sql);
                            $i = 0;
                            $data_kompetensi = [];
                            while($row = mysql_fetch_array($q)){
                                $data_kompetensi[$i]['id_kelpenilaian'] = $row['id_kelpenilaian'];
                                $data_kompetensi[$i]['nama_kelpenilaian'] = $row['nama_kelpenilaian'];
                                $data_kompetensi[$i]['bobot_kelpenilaian'] = $row['bobot_kelpenilaian'];
                                if($i==0){
                        ?>
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-<?= $row['id_kelpenilaian']; ?>" role="tab" aria-controls="nav-home" aria-selected="true"><?= $row['nama_kelpenilaian']; ?></a>
                        <?php
                                }else{
                        ?>
                            <a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab" href="#nav-<?= $row['id_kelpenilaian']; ?>" role="tab" aria-controls="nav-home" aria-selected="true"><?= $row['nama_kelpenilaian']; ?></a>
                        <?php 
                                }
                                $i++;
                            }
                        ?>
                        </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                        <?php
                        foreach ($data_kompetensi as $k => $v) {
                            if($k==0){
                                $ext = "show active";
                            }else{
                                $ext = "";
                            }
                        ?>
                            <div class="tab-pane fade <?= $ext;?>" id="nav-<?= $v['id_kelpenilaian']; ?>" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <table class="table table-striped mt-3">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="30%">isi penilaian</th>
                                            <th width="10%">Angka</th>
                                            <th width="10%">Sebutan</th>
                                            <!-- <th >1</th>
                                            <th >2</th>
                                            <th >3</th>
                                            <th >4</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i=0;
                                            $sq = "SELECT * FROM isi_penilaian WHERE id_kelpenilaian = $v[id_kelpenilaian] AND ket LIKE '%$sebagai%' ";
                                            $qs = mysql_query($sq);
                                            while($row = mysql_fetch_array($qs)){
                                        ?>
                                        <tr>
                                            <td ><?= ++$i; ?></td>
                                            <td ><?= $row['isi_penilaian']; ?></td>
                                            <td><input type="number" name="nilai_kompetensi_<?= $row['id_isi']; ?>" id="nilai_kompetensi_<?= $row['id_isi']; ?>" style="width:50px;" class="angka"/></td>
                                            <td id="kompetensi_<?= $row['id_isi']; ?>"></td>
                                            <!-- <td class="form-group">
                                                <input class="form-control form-control-lg" type="radio" name="kompetensi_<?= $row['id_isi']; ?>" id="kompetensi_<?= $row['id_isi']; ?>_1" title="Tidak Mampu" value="1" required>
                                            </td>
                                            <td class="form-group">
                                                <input class="form-control form-control-lg" type="radio" name="kompetensi_<?= $row['id_isi']; ?>" id="kompetensi_<?= $row['id_isi']; ?>_2" title="Kurang Mampu" value="2" required>
                                            </td>
                                            <td class="form-group">
                                                <input class="form-control form-control-lg" type="radio" name="kompetensi_<?= $row['id_isi']; ?>" id="kompetensi_<?= $row['id_isi']; ?>_3" title="Mampu" value="3" required>
                                            </td>
                                            <td class="form-group">
                                                <input class="form-control form-control-lg" type="radio" name="kompetensi_<?= $row['id_isi']; ?>" id="kompetensi_<?= $row['id_isi']; ?>_4" title="Sangat Mampu" value="4" required>
                                            </td> -->
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php
                        }
                    ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 offset-lg-1 offset-sm-1">
                    <?php
                        $nip_s = $_SESSION[md5('user')];
                        $sql = "SELECT * FROM penilai a JOIN penilai_detail b ON a.id_penilai = b.id_penilai JOIN penilaian c ON b.id_penilai_detail = c.id_penilai_detail WHERE a.id_penilai = '$id_penilai' AND b.nip = '$nip_s'";
                        $q = mysql_query($sql);
                        if(mysql_num_rows($q)>0){
                            echo '<script>';
                            while($row = mysql_fetch_array($q)){
                                echo '$("#kompetensi_'.$row['id_isi'].'_'.$row['hasil_nilai'].'").attr("checked",true);';
                            }
                            echo '</script>';
                        }
                    ?>
                    <h2 class="text-center">NILAI SEBUTAN</h2>
                    <table cellspacing="0" class="no-spacing">
                        <tr>
                            <td width="25%" class="p-0">91 - 100</td>
                            <td width="5%" class="p-0">:</td>
                            <td class="p-0">Amat Baik</td>
                        </tr>
                        <tr>
                            <td class="p-0">76 - 90</td>
                            <td class="p-0">:</td>
                            <td class="p-0">Baik</td>
                        </tr>
                        <tr>
                            <td class="p-0">61 - 75</td>
                            <td class="p-0">:</td>
                            <td class="p-0">Cukup Baik</td>
                        </tr>
                        <tr>
                            <td class="p-0">51 - 60</td>
                            <td class="p-0">:</td>
                            <td class="p-0">Sedang</td>
                        </tr>
                        <tr>
                            <td class="p-0">< 50</td>
                            <td class="p-0">:</td>
                            <td class="p-0">Kurang</td>
                        </tr>
                    </table>
                </div>
                <div class="container">
                    <div class="float-right">
                        <br>
                        <button type="submit" class="btn btn-primary btn-md">Simpan</button>
                    </div>
                </div>
                <?php } ?>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
$(".angka").keyup(function () {
        let that = this,
        value = $(this).val();
        let id = $(this).attr('id');
        let result = id.substring(6);

        let sebutan;

        if(value >= 91 && value <= 100) {
            sebutan = 'Amat Baik';
        } else if (value >= 76 && value <= 90) {
            sebutan = 'Baik';
        } else if (value >= 61 && value <= 75) {
            sebutan = 'Cukup Baik';
        } else if (value >= 51 && value <= 60) {
            sebutan = 'Sedang';
        } else if (value <= 50) {
            sebutan = 'Kurang';
        } else {
            $(this).val('0');
            sebutan = '';
        }
        

        if(value) {
            $('#'+result).html(sebutan);
        } else {
            $('#'+result).html('');
        }
    });
</script>


<?php

    function sudah($idpdt=''){
        $sql = "SELECT * FROM penilai a JOIN penilai_detail b ON a.id_penilai = b.id_penilai JOIN penilaian c ON b.id_penilai_detail = c.id_penilai_detail WHERE b.id_penilai_detail = $idpdt";
        //echo $sql; 
        $q = mysql_query($sql);
        if(mysql_num_rows($q)>0){
            return 'bold';
        }else{
            return '';
        }
    }
?>