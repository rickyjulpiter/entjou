<?php 
$CI =& get_instance();
if (!empty($checkup)) {
    $ans = array();
    for ($i=1; $i<=32 ; $i++) { 
        $ans []= $checkup[0]['p'.$i];
    }
    
    for ($i=0; $i<sizeof($ans); $i++) { 
        $no=$i+1;
        ${"p$no"} = $ans[$i];
    }
}else{
    for ($i=1; $i<=32; $i++) { 
        ${"p$i"} = "";
    }
}
?>
<style type="text/css">
    h2.sidebar-title a:hover {
         color: black !important; 
    }
</style>

<!-- Registration Page Area Start Here -->
<div class="registration-page-area bg-secondary" style="padding: 25px 0 70px;">
    <div class="container">
        <h2 class="sidebar-title">Misi
            <a href="#checkup" class="btn btn-menu" data-toggle="modal" style="float: right;width: 160px;">Check Up</a>
            <?php 
            if (!empty($hasil_checkup)) {?>
            <a href="#hasil_checkup" class="btn btn-menu" data-toggle="modal" style="float: right;width: 160px;">Hasil Check Up</a>
            <?php } ?>
        </h2>
        
        <?=$this->session->flashdata('notif')?>
        <div class="row">
        <?php 
        if (empty($checkup)) {?>
            <div align="center" class="alert-notif alert-danger" role="alert" style="border:solid 1px;">Anda Belum Check-Up. Silahkan checkup terlebih dahulu.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
        <?php }?>
            <div class="col-md-4">
                <div class="courses-box1">
                    <div class="single-item-wrapper">
                        <img class="img-responsive" src="<?=base_url().'assets/images/logo.jpg';?>">
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <table class="table tabel-diri">
                    <tr>
                        <td>Nama Usaha</td>
                        <td>:</td>
                        <td><?php 
                        if (!empty($p13)) {
                            echo $p13;
                        }else{
                            echo "Belum ada nama usaha";
                        }
                        ?></td>
                    </tr>
                    <tr>
                        <td>Misi Usaha</td>
                        <td>:</td>
                        <td><?php
                        if (!empty($p14)) {
                            echo $p14;
                        }else{
                            echo "Belum ada misi usaha";
                        }
                        ?></td>
                    </tr>                    
                </table>
                <?php 
                if (empty($hasil_checkup) and !empty($checkup)) { ?>
                    <div align="center" class="alert-notif alert-info" role="alert" style="border:solid 1px;">Jawaban Checkup kamu sedang dipelajari dan akan diberikan rekomendasi terbaik untuk kamu menjadi seorang Enterpreneur<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                <?php } ?>
            </div>
        </div>
        <!-- Start Menu Siswa -->
        <div class="row menu-siswa">
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <a href="<?=base_url('siswa')?>" class="btn btn-block btn-menu">Profil</a>
            </div>
            <div class="col-md-2">
                <a href="<?=base_url('siswa/misi')?>" class="btn btn-block btn-menu aktif">Misi</a>
            </div>
            <div class="col-md-2">
                <a href="<?=base_url('siswa/agenda')?>" class="btn btn-block btn-menu">Agenda</a>
            </div>
            <div class="col-md-2">
                <a href="<?=base_url('siswa/pengumuman')?>" class="btn btn-block btn-menu">Pengumuman</a>
            </div>
            <div class="col-md-2">
                <a href="<?=base_url('siswa/pesanan')?>" class="btn btn-block btn-menu">Pesanan</a>
            </div>
            <div class="col-md-1"></div>
        </div>
        <!-- End Menu Siswa -->
        <!-- Start Form Biodata -->
        <form action="<?=base_url('siswa/profil_update')?>" method="POST">
        <div class="registration-details-area inner-page-padding" style="margin-top: 15px">
            <?php
            if (!empty($pesanan)) {?>
            <table class="table table-bordered table-striped table-siswa">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kelas</th>
                        <th>Materi</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($materi as $key => $value) {?>
                    <tr>
                        <td align="center"><?=($key+1)?></td>
                        <td><?=$value['nama_kelas']?></td>
                        <td><?=$value['judul_materi']?></td>
                        <td align="center"><?=$value['waktu_post']?></td>
                        <td align="center"><a target="_blank" class="btn btn-primary" href="<?=base_url().'home/materi_detail/'.$this->encrypt->encode($value['id_kelas']).'?stage='.$value['id_stage'].'&tipe=materi&fm='.$this->encrypt->encode($value['file_materi']).'&id_materi='.$this->encrypt->encode($value['id_materi'])?>"><i class="fa fa-eye"></i> Lihat</a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php }else{?>
                <div align="center" class="alert-notif alert-danger" role="alert" style="border:solid 1px;">Anda belum memilih kelas. Silahkan pilih kelas pada menu "Kelas". Pemilihan kelas lihat juga rekomendasi dari Kasha. Materi akan muncul jika kamu sudah mengambil kelas dan melakukan pembayaran<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
            <?php } ?>
        </div>
        </form>
        <!-- End Form Biodata -->

    </div>
</div>
<!-- Registration Page Area End Here -->
<!-- Modal checkup -->
<div id="checkup" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span>Checkup Entrepreneur</span>
                <button type="button" class="close" data-dismiss="modal"><b style="color: red">x</b></button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?=base_url('siswa/checkup_insert')?>">
                    <div class="panel-body">
                        <?php 
                        for ($i=0; $i<=10; $i++) { $no=$i+1;?>
                        <div class="form-group">
                            <label><?=ucwords($form_checkup[$i]['pertanyaan'])?></label>
                            <textarea class="form-control" name="<?=$form_checkup[$i]['kode']?>" placeholder="Tuliskan jawaban kamu"><?=${"p$no"}?></textarea>
                        </div>
                        <?php } ?>
                        <div class="form-group">
                            <label><?=ucwords($form_checkup[11]['pertanyaan'])?>
                            </label>
                            <?php 
                            $ar = array('Ya','Tidak');
                            ?>
                            <select class="form-control" id="bisnis" name="<?=$form_checkup[11]['kode']?>">
                                <option value="">-Pilih-</option>
                                <?php
                                foreach ($ar as $key => $value) {
                                    if ($value==$p12) {
                                        $select = "selected";
                                    }else{
                                        $select = "";
                                    }
                                    echo "<option $select>$value</option>";
                                }?>
                            </select>
                        </div>

                        <div id="ada_bisnis">
                            <div class="hr-sect">Tentang Bisnis Kamu</div>
                            <?php
                            for ($i=12; $i<=27; $i++) { $no=$i+1;?>
                            <div class="form-group">
                                <label><?=ucwords($form_checkup[$i]['pertanyaan'])?></label>
                                <textarea class="form-control" name="<?=$form_checkup[$i]['kode']?>" placeholder="Tuliskan jawaban kamu"><?=${"p$no"}?></textarea>
                            </div>
                            <?php } ?>
                        </div>

                        <?php 
                        for ($i=28; $i<=31; $i++) { $no=$i+1;?>
                        <div class="form-group">
                            <label><?=ucwords($form_checkup[$i]['pertanyaan'])?></label>
                            <textarea class="form-control" name="<?=$form_checkup[$i]['kode']?>" placeholder="Tuliskan jawaban kamu"><?=${"p$no"}?></textarea>
                        </div>
                        <?php } ?>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary simpan btn-block"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div>                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal checkup -->
<!-- Modal checkup -->
<div id="hasil_checkup" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span>Hasil Checkup Entrepreneur</span>
                <button type="button" class="close" data-dismiss="modal"><b style="color: red">x</b></button>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <div class="form-group">
                        <label>Dimana posisimu sekarang</label>
                        <textarea class="form-control"><?=$hasil_checkup[0]['j1']?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Hal-hal yang harus kamu pelajari</label>
                        <textarea class="form-control"><?=$hasil_checkup[0]['j2']?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Rekomendasi kelas yang dapat kamu ikuti</label>
                        <textarea class="form-control"><?=$hasil_checkup[0]['j3']?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Cerita tentang Entrepreneur Terkenal yang sama dengan posisi kamu sekarang</label>
                        <textarea class="form-control"><?=$hasil_checkup[0]['j4']?></textarea>
                    </div>
                    <small><i>Diperiksa dan dijawab oleh <b><?=$hasil_checkup[0]['nama_guru']?></b></i></small>
                    <small><i>Waktu : <?=$hasil_checkup[0]['waktu_post']?></i></small>
                </div>                    
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal checkup -->

<script type="text/javascript">
    $(document).ready(function(){        
        $('#ada_bisnis').hide();
        var x = "<?=$p12?>";
        if (x=="Ya") {
            $('#ada_bisnis').show();
        }
        if (x=="Ya" || x=="Tidak") {
            $('.simpan').attr('disabled','disabled');
        }
        $('#bisnis').on('change', function(){
            if ($(this).val()=="Ya") {
                $('#ada_bisnis').show();
            }else{
                $('#ada_bisnis').hide();
            }
        });
    });
</script>
