<?php 
$CI =& get_instance();
if (!empty($pesanan)) {
    $pesanan_status = $pesanan[0]['status'];
}else{
    $pesanan_status = "";
}
$tersisa = $kelas[0]['batas_peserta']-$ambil_kelas;
?>
<style type="text/css">
    .fasilitator img{width: 200px;border-radius: 100px;text-align: center;}
    .fasilitator{border-bottom: 2px solid #fbd131;;padding: 18px;margin-bottom: 28px;}
    .fasilitator h4{margin-bottom: 0px !important;}
    .leave-comments select {font-family: 'FontAwesome', 'sans-serif';color: #fdc800 !important;}
    .media img{width: 80px;}
    .table-stage a{font-weight: bold;color: black}
</style>
<div class="courses-page-area5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="course-details-inner">
                    <h2 class="title-default-left title-bar-high">Kelas
                        <div align="right" style="margin-top: -45px;">
                            <button type="button" class="btn btn-menu"><i class="fa fa-money"></i> 
                                <?php
                                    if ($kelas[0]['harga']==0) {
                                        echo "Gratis";
                                    }else{
                                        echo Tools::rupiah('Rp ',$kelas[0]['harga']);
                                    }
                                ?>
                            </button>
                        </div>
                    </h2>
                    <div class="row">
                        <div class="col-md-4">
                            <img src="<?=base_url().'assets/images/kelas/'.$kelas[0]['foto']?>" class="img-responsive" alt="course">
                        </div>
                        <div class="col-md-8">
                            <h3><?=$kelas[0]['nama_kelas']?></h3>
                            <p style="text-align: justify;">Deskripsi : <?=Tools::limit_words($kelas[0]['overview'],200)?>...</p>
                            <p><i class="fa fa-users"></i> 
                                Batas Peserta : <?=Tools::rupiah('',$kelas[0]['batas_peserta'])?> Orang || 
                                Tersisa : <?=Tools::rupiah('',$tersisa)?> Orang || 
                                <i class="fa fa-tag"></i> Kategori : <?=$kelas[0]['kategori']?></p>
                            <?php 
                            if (empty($pesanan)) {
                                if (!empty($this->session->userdata('nama')) AND $this->encrypt->decode($this->session->userdata('tipe_user'))=='siswa') {
                                    if ($tersisa==0) {
                                        echo "<button type=\"button\" class=\"btn btn-menu habis\">Masuk Kelas</button>";
                                    }else{
                                        if ($kelas[0]['harga']!=0) {
                                            echo "<a href=\"#masuk_kelas\" data-toggle=\"modal\" class=\"btn btn-menu\">Masuk Kelas</a>";
                                        }
                                    }
                                }else{
                                    echo "<button type=\"button\" class=\"btn btn-menu nologin\">Masuk Kelas</button>";
                                } 
                            }else{ 
                                if ($pesanan_status=='menunggu_bayar') {
                                    $url = base_url('siswa/pesanan');
                                    echo "<div align=\"center\" class=\"alert-notif alert-info\" role=\"alert\" style=\"border:solid 1px;\">Silahkan Lakukan Pembayaran. Klik <a href=\"$url\">Disini</a> </div>";
                                }elseif($pesanan_status=='proses'){
                                    echo "<div align=\"center\" class=\"alert-notif alert-info\" role=\"alert\" style=\"border:solid 1px;\">Harap tunggu konfirmasi dari admin</a> </div>";
                                }
                            } ?>

                            
                        </div>
                    </div>
                    <?=$this->session->flashdata('notif')?>
                    <div class="course-details-tab-area">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <ul class="course-details-tab-btn">
                                    <li class="active"><a href="#deskripsi" data-toggle="tab" aria-expanded="false">Deskripsi</a></li>
                                    <li><a href="#kurikulum" data-toggle="tab" aria-expanded="false">Kurikulum</a></li>
                                    <li><a href="#pengumuman" data-toggle="tab" aria-expanded="false">Pengumuman</a></li>
                                    <li><a href="#reviews" data-toggle="tab" aria-expanded="false">Review</a></li>
                                    <li><a href="#fasilitator" data-toggle="tab" aria-expanded="false">Fasilitator</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="tab-content">
                                    <div class="tab-pane fade active in" id="deskripsi">
                                        <h3 class="sidebar-title">Deskripsi Kelas</h3>
                                        <p style="font-style: italic;">Waktu Update : <?=Tools::tgl_indo($kelas[0]['waktu_edit'])?></p>
                                        <p style="text-align: justify;"><?=$kelas[0]['overview']?></p>
                                        
                                    </div>
                                    <div class="tab-pane fade" id="kurikulum">
                                        <h3 class="sidebar-title">Materi Pembelajaran</h3>
                                        <div class="panel-group curriculum-wrapper" id="accordion">

                                        <?php 
                                        if (!empty($materi)) {
                                        foreach ($materi as $key => $value) {
                                            $games = $CI->get('_games',$value['id_materi']);
                                            $quiz  = $CI->get('_quiz',$value['id_materi']);
                                            $project= $CI->get('agenda',$value['id_materi']);
                                            ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        <a aria-expanded="false" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=($key+1)?>">
                                                            <ul>
                                                                <li><i class="fa fa-book" aria-hidden="true"></i></li>
                                                                <li></li>
                                                                <li><?=$value['nama_stage'].' - '.$value['judul_materi']?></li>
                                                                <li>(1/4)</li>
                                                            </ul>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div aria-expanded="false" id="collapse<?=($key+1)?>" role="tabpanel" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <table class="table table-stage">
                                                            <tr>
                                                                <td width="50"><i class="fa fa-laptop"></i></td>
                                                                <?php 
                                                                if (!empty($this->session->userdata('id_user')) AND $this->encrypt->decode($this->session->userdata('tipe_user'))=='siswa') {
                                                                    if($pesanan_status=='dibayar' OR $kelas[0]['harga']==0){?>
                                                                    <td><a href="<?=base_url().'home/materi_detail/'.$this->encrypt->encode($value['id_kelas']).'?stage='.$value['id_stage'].'&tipe=materi&fm='.$this->encrypt->encode($value['file_materi']).'&id_materi='.$this->encrypt->encode($value['id_materi'])?>">Materi</a></td>
                                                                    <?php }else{
                                                                        if ($kelas[0]['harga']!=0) {
                                                                            echo "<td><a href='javascript:;' class='nobayar'>Materi</a></td>";
                                                                        }
                                                                }}else{
                                                                    echo "<td><a href='javascript:;' class='nologin'>Materi</a></td>";
                                                                } ?>
                                                            </tr>
                                                            <?php 
                                                            if (!empty($games)) {?>
                                                            <tr>
                                                                <td><i class="fa fa-puzzle-piece"></i></td>
                                                                <?php
                                                                if (!empty($this->session->userdata('id_user')) AND $this->encrypt->decode($this->session->userdata('tipe_user'))=='siswa') {
                                                                    if($pesanan_status=='dibayar' OR $kelas[0]['harga']==0){?>
                                                                    <td><a href="<?=base_url().'home/materi_detail/'.$this->encrypt->encode($value['id_kelas']).'?stage='.$value['id_stage'].'&tipe=games&fg='.$this->encrypt->encode($games[0]['file_games']).'&id_materi='.$this->encrypt->encode($value['id_materi'])?>">Games</a></td>
                                                                    <?php }else{
                                                                        if ($kelas[0]['harga']!=0) {
                                                                            echo "<td><a href='javascript:;' class='nobayar'>Games</a></td>";
                                                                        }
                                                                }}else{
                                                                    echo "<td><a href='javascript:;' class='nologin'>Games</a></td>";
                                                                } ?>
                                                            </tr>
                                                            <?php } ?>

                                                            <?php if (!empty($quiz)) {?>
                                                            <tr>
                                                                <td><i class="fa fa-bullhorn"></i></td>
                                                                <?php 
                                                                if (!empty($this->session->userdata('id_user')) AND $this->encrypt->decode($this->session->userdata('tipe_user'))=='siswa') {
                                                                    if($pesanan_status=='dibayar' OR $kelas[0]['harga']==0){?>
                                                                    <td><a href="<?=base_url().'home/materi_detail/'.$this->encrypt->encode($value['id_kelas']).'?stage='.$value['id_stage'].'&tipe=quiz&id_materi='.$this->encrypt->encode($value['id_materi'])?>">Quiz</a></td>
                                                                    <?php }else{
                                                                        if ($kelas[0]['harga']!=0) {
                                                                            echo "<td><a href='javascript:;' class='nobayar'>Quiz</a></td>";
                                                                        }
                                                                }}else{
                                                                    echo "<td><a href='javascript:;' class='nologin'>Quiz</a></td>";
                                                                } ?>
                                                            </tr>
                                                            <?php } ?>

                                                            <tr>
                                                                <td><i class="fa fa-rocket"></i></td>
                                                                <?php 
                                                                if (!empty($this->session->userdata('id_user')) AND $this->encrypt->decode($this->session->userdata('tipe_user'))=='siswa') {
                                                                    if($pesanan_status=='dibayar' OR $kelas[0]['harga']==0){?>
                                                                    <td><a href="<?=base_url().'home/materi_detail/'.$this->encrypt->encode($value['id_kelas']).'?stage='.$value['id_stage'].'&tipe=project&id_materi='.$this->encrypt->encode($value['id_materi'])?>">Project</a></td>
                                                                    <?php }else{
                                                                        if ($kelas[0]['harga']!=0) {
                                                                            echo "<td><a href='javascript:;' class='nobayar'>Project</a></td>";
                                                                        }
                                                                }}else{
                                                                    echo "<td><a href='javascript:;' class='nologin'>Project</a></td>";
                                                                } ?>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }}else{ 
                                            echo "<div align=\"center\" class=\"alert-notif alert-danger\" role=\"alert\" style=\"border:solid 1px;\">Belum ada materi</div>";
                                        }?>

                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="pengumuman">
                                        <h3 class="sidebar-title">Pengumuman</h3>
                                        <?php 
                                        if (!empty($pengumuman)) {?>
                                        <table class="table table-bordered table-striped table-siswa">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Pengirim</th>
                                                    <th>Isi Pengumuman</th>
                                                    <th>Lihat</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                foreach ($pengumuman as $key => $value) {?>
                                                <tr>
                                                    <td align="center"><?=($key+1)?></td>
                                                    <td align="center"><?=$value['waktu_post']?></td>
                                                    <td><?=$value['nama_user_post']?></td>
                                                    <td><?php
                                                    if (strlen($value['isi'])>=90) {
                                                        echo Tools::limit_words($value['isi'],90).' ...';
                                                    }else{
                                                        echo Tools::limit_words($value['isi'],90);
                                                    }
                                                    ?></td>
                                                    <td align="center">
                                                        <a href="<?=base_url().$value['slug']?>" class="btn btn-primary btn-xs" target="_blank"><i class="fa fa-eye"></i> Lihat</a>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php }else{ ?>
                                        <div align="center" class="alert-notif alert-danger" role="alert" style="border:solid 1px;">Belum ada pengumuman</div>
                                        <?php } ?>                                        

                                    </div>

                                    <div class="tab-pane fade" id="reviews">
                                        <div class="course-details-comments">
                                            <h3 class="sidebar-title">Review Siswa</h3>
                                            <?php 
                                            if (!empty($review)) {
                                            foreach ($review as $key => $value) {
                                            $appath = realpath(APPPATH . '../assets/images/user/'.$value['foto']);
                                            if(!empty($value['foto']) and file_exists($appath)){
                                                $image = base_url().'assets/images/user/'.$value['foto'];
                                            }else{
                                                $image = base_url().'assets/images/avatar/avatar5.png';
                                            }?>
                                            <div class="media">
                                                <a href="#" class="pull-left">
                                                    <img alt="Review" src="<?=$image?>" class="media-object">
                                                </a>
                                                <div class="media-body">
                                                    <h3><a href="#"><?=$value['nama_siswa']?></a></h3>
                                                    <h4><?=$value['judul']?></h4>
                                                    <p><?=strip_tags($value['isi'])?></p>
                                                    <div class="replay-area">
                                                        <ul>
                                                            <?php 
                                                            for ($i=1; $i<=$value['rating']; $i++) { 
                                                                echo '<li><i class="fa fa-star" aria-hidden="true"></i></li>';
                                                            }?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } }else{ 
                                                echo "<div align=\"center\" class=\"alert-notif alert-danger\" role=\"alert\" style=\"border:solid 1px;\">Belum ada review</div>";
                                            }?>


                                        </div>
                                        <?php 
                                        if (!empty($this->session->userdata('id_user')) AND $pesanan_status=='dibayar') {?>
                                        <div class="leave-comments">
                                            <h3 class="sidebar-title">Buat Review</h3>
                                            <div class="row">
                                                <div class="contact-form" id="review-form">
                                                    <form method="POST" action="<?=base_url().'home/review_add'?>">
                                                        <input type="hidden" name="id_kelas" value="<?=$kelas[0]['id_kelas']?>">
                                                        <input type="hidden" name="nama_kelas" value="<?=$kelas[0]['nama_kelas']?>">
                                                        <input type="hidden" name="slug" value="<?=$kelas[0]['slug']?>">
                                                        <fieldset>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <input type="text" name="judul" class="form-control" placeholder="Judul Review">
                                                                </div>
                                                                <div class="form-group">
                                                                    <textarea placeholder="Review kamu" class="textarea form-control" name="isi" rows="8" cols="20"></textarea>
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <div class="rate-wrapper">
                                                                        <div class="rate-label">Berikan Rating:</div>
                                                                        <div class="rate">
                                                                            <select name="rating" class="form-control">
                                                                            <option value="5">&#xf005; &#xf005; &#xf005; &#xf005; &#xf005;</option>
                                                                            <option value="4">&#xf005; &#xf005; &#xf005; &#xf005;</option>
                                                                            <option value="3">&#xf005; &#xf005; &#xf005;</option>
                                                                            <option value="2">&#xf005; &#xf005;</option>
                                                                            <option value="1">&#xf005;</option>
                                                                        </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <button type="submit" class="view-all-accent-btn">Submit</button>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>

                                    <div class="tab-pane fade" id="fasilitator">
                                        <h3 class="sidebar-title">Fasilitator</h3>
                                        <div class="course-details-skilled-lecturers">
                                            <?php 
                                            if (!empty($guru)) {
                                            foreach ($guru as $key => $value) {
                                            $foto = $value['foto'];
                                            $ada = file_exists(realpath(APPPATH . '../assets/images/user/'.$foto));
                                            if(!empty($foto) and $ada) {
                                                $images = base_url().'assets/images/user/thumbnail/'.$foto;
                                            }else{
                                                if ($value['jk']=="L") {
                                                    $images = base_url().'assets/images/avatar/male.jpg';
                                                }else{$images = base_url().'assets/images/avatar/female.jpg';

                                                }
                                            }
                                            ?>
                                            <div class="row fasilitator">
                                                <div class="col-md-2">
                                                    <img src="<?=$images?>" class="img-responsive" alt="fasilitator" width="50">
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="skilled-lecturers-content">
                                                        <h4><?=$value['nama_lengkap']?></h4>
                                                        <p><?=$value['posisi']?></p>
                                                        <p><?=$value['tentang']?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php }}else{
                                                echo "<div align=\"center\" class=\"alert-notif alert-danger\" role=\"alert\" style=\"border:solid 1px;\">Belum ada fasilitator</div>";
                                            } ?>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal tagihan -->
<div id="masuk_kelas" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header">
                <b>Checkout</b>
                <button type="button" class="close" data-dismiss="modal"><b style="color: red">x</b></button>
            </div>
            <form class="form-horizontal" method="post" action="<?=base_url().'home/kelas_order'?>">
                <input type="hidden" name="id_kelas" value="<?=$kelas[0]['id_kelas']?>">
                <input type="hidden" name="nama_kelas" value="<?=$kelas[0]['nama_kelas']?>">
                <input type="hidden" name="total" value="<?=$kelas[0]['harga']?>">
                <input type="hidden" name="slug" value="<?=$kelas[0]['slug']?>">
                <div class="modal-body">
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <td>Nama Siswa</td>
                                <td>:</td>
                                <td><?=$this->encrypt->decode($this->session->userdata('nama'))?></td>
                            </tr>
                            <tr>
                                <td>Nama Kelas</td>
                                <td>:</td>
                                <td><?=$kelas[0]['nama_kelas']?></td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>:</td>
                                <td><?="Rp ".number_format($kelas[0]['harga'],0,',','.')?></td>
                            </tr>
                        </table>
                        <small>Catatan : <br></small>
                        <small>- Lakukan pembayaran melalui transfer bank<br></small>
                        <small>- Bank BNI Syariah a.n. Novrian Carniege || No. Rekening xxxx.xxxxx.xxx<br></small>
                        <small>- Jika sudah melakukan pembayaran unggah bukti pembayaran di menu <b>Pesanan</b> pada halaman profil </small>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Ambil Kelas</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal tagihan -->