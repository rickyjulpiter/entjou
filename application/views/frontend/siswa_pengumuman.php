<?php 
$CI =& get_instance();
?>
<!-- Registration Page Area Start Here -->
<div class="registration-page-area bg-secondary" style="padding: 25px 0 70px;">
    <div class="container">
        <h2 class="sidebar-title">Pengumuman</h2>
        <?=$this->session->flashdata('notif')?>
        <div class="row">
            <div class="col-md-4">
                <div class="courses-box1">
                    <div class="single-item-wrapper">
                        <div class="courses-img-wrapper hvr-bounce-to-bottom" style="width: 100%">
                            <?php 
                            $appath = realpath(APPPATH . '../assets/images/user/'.$profil[0]['foto']);
                            if(!empty($profil[0]['foto']) and file_exists($appath)){
                                $image = base_url().'assets/images/user/'.$profil[0]['foto'];
                            }else{
                                if ($profil[0]['jk']=="L") {
                                    $image = base_url().'assets/images/avatar/male.jpg';
                                }else{
                                    $image = base_url().'assets/images/avatar/female.jpg';
                                }
                            }?>
                            <img class="img-responsive" src="<?=$image?>">
                        </div>
                        
                        <div class="panel-body sosial-media" align="center">
                            <div class="col-xs-3">
                                <a href="<?=$profil[0]['facebook']?>" target="_blank" title="Facebook" class="btn btn-warning btn-block"><i class="fa fa-facebook fa-2x" aria-hidden="true"></i></a>
                            </div>
                            <div class="col-xs-3">
                                <a href="<?=$profil[0]['twitter']?>" target="_blank" title="Twitter" class="btn btn-warning btn-block"><i class="fa fa-twitter fa-2x" aria-hidden="true"></i></a>
                            </div>
                            <div class="col-xs-3">
                                <a href="<?=$profil[0]['instagram']?>" target="_blank" title="Instagram" class="btn btn-warning btn-block"><i class="fa fa-instagram fa-2x" aria-hidden="true"></i></a>
                            </div>
                            <div class="col-xs-3">
                                <a href="<?=$profil[0]['youtube']?>" target="_blank" title="Youtube" class="btn btn-warning btn-block"><i class="fa fa-youtube fa-2x" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <table class="table tabel-diri">
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td><?=ucwords($profil[0]['nama_lengkap'])?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td><?=$profil[0]['email']?></td>
                    </tr>
                    <tr>
                        <td>Whatsapp</td>
                        <td>:</td>
                        <td><?=$profil[0]['wa']?></td>
                    </tr>
                    <tr>
                        <td width="200">Tentang Saya</td>
                        <td>:</td>
                        <td><?=$profil[0]['tentang']?></td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- Start Menu Siswa -->
        <div class="row menu-siswa">
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <a href="<?=base_url('siswa')?>" class="btn btn-block btn-menu">Profil</a>
            </div>
            <div class="col-md-2">
                <a href="<?=base_url('siswa/misi')?>" class="btn btn-block btn-menu">Misi</a>
            </div>
            <div class="col-md-2">
                <a href="<?=base_url('siswa/agenda')?>" class="btn btn-block btn-menu">Agenda</a>
            </div>
            <div class="col-md-2">
                <a href="<?=base_url('siswa/pengumuman')?>" class="btn btn-block btn-menu aktif">Pengumuman</a>
            </div>
            <div class="col-md-2">
                <a href="<?=base_url('siswa/pesanan')?>" class="btn btn-block btn-menu">Pesanan</a>
            </div>
            <div class="col-md-1"></div>
        </div>
        <!-- End Menu Siswa -->
        <!-- Start pengumuman -->
        <div class="panel-body">
            <?php 
            if (!empty($pengumuman)) {?>
            <table class="table table-bordered table-striped table-siswa">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Pengirim</th>
                        <th>Isi Pengumuman</th>
                        <th>Kategori</th>
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
                        <td><?=Tools::limit_words($value['isi'],90)?></td>
                        <td align="center"><?=$value['kategori']?></td>
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
        <!-- End pengumuman -->

    </div>
</div>
<!-- Registration Page Area End Here -->