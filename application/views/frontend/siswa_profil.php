<?php 
$CI =& get_instance();
?>
<!-- Registration Page Area Start Here -->
<div class="registration-page-area bg-secondary" style="padding: 25px 0 70px;">
    <div class="container">
        <h2 class="sidebar-title">Profil</h2>
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
                            <a href="#unggah_foto" data-toggle="modal" title="Unggah Foto"><i class="fa fa-eye" aria-hidden="true"></i></a>
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
                <a href="<?=base_url('siswa')?>" class="btn btn-block btn-menu aktif">Profil</a>
            </div>
            <div class="col-md-2">
                <a href="<?=base_url('siswa/misi')?>" class="btn btn-block btn-menu">Misi</a>
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
            <div class="row">
                <?=$this->session->flashdata('notif')?>
                <div class="col-md-6">
                    <div class="hr-sect">Informasi Umum</div>
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" value="<?=$profil[0]['nama_lengkap']?>" placeholder="Nama Lengkap">
                    </div>
                    <div class="form-group">
                        <label>Nama Panggilan</label>
                        <input type="text" name="nama_panggilan" class="form-control" value="<?=$profil[0]['nama_panggilan']?>" placeholder="Nama Panggilan">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="text" name="tanggal_lahir" class="form-control tanggal" value="<?=Tools::tgl_indo($profil[0]['tanggal_lahir'],'d-m-Y')?>" readonly placeholder="dd-mm-yyyy">
                    </div>
                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" value="<?=$profil[0]['tempat_lahir']?>" placeholder="Tempat Lahir">
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <?php 
                        $ar_jk = array(
                            'L' => 'Laki-Laki',
                            'P' => 'Perempuan'
                        );?>
                        <select name="jk" class="form-control select2">
                            <option value="">-Pilih Jenis Kelamin-</option>
                            <?php 
                            foreach ($ar_jk as $key => $value) {
                                if ($key==$profil[0]['jk']) {
                                    $select = 'selected';
                                }else{
                                    $select = '';
                                }
                                echo "<option value='$key' $select>$value</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Agama</label>
                        <?php 
                        $ar_agama = array('Islam', 'Katolik', 'Kristen Protestan', 'Hindu', 'Buddha', 'Kong Hu Cu', 'Lainnya');
                        ?>
                        <select name="agama" class="form-control select2" required>
                            <option value="">-Pilih Agama-</option>
                            <?php 
                            foreach ($ar_agama as $key => $value) {
                                if ($key==$profil[0]['agama']) {
                                    $select = 'selected';
                                }else{
                                    $select = '';
                                }
                                echo "<option $select>$value</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control" rows="6"><?=$profil[0]['alamat']?></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="hr-sect">Sosial Media</div>
                    <div class="form-group">
                        <label>No. Whatsapp</label>
                        <input type="text" name="wa" class="form-control" placeholder="Nomor Whatsapp aktif" value="<?=$profil[0]['wa']?>">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email Aktif" value="<?=$profil[0]['email']?>">
                    </div>
                    <div class="form-group">
                        <label>Facebook</label>
                        <input type="text" name="facebook" class="form-control" placeholder="https://www.facebook.com/nama_pengguna" value="<?=$profil[0]['facebook']?>">
                    </div>
                    <div class="form-group">
                        <label>Instagram</label>
                        <input type="text" name="instagram" class="form-control" placeholder="https://www.instagram.com/nama_pengguna" value="<?=$profil[0]['instagram']?>">
                    </div>
                    <div class="form-group">
                        <label>Twitter</label>
                        <input type="text" name="twitter" class="form-control" placeholder="https://twitter.com/nama_pengguna" value="<?=$profil[0]['twitter']?>">
                    </div>
                    <div class="form-group">
                        <label>Youtube</label>
                        <input type="text" name="youtube" class="form-control" placeholder="https://www.youtube.com/channel/aBCdEFGHijKLMnOP" value="<?=$profil[0]['youtube']?>">
                    </div>
                    <div class="hr-sect">Informasi Akun</div>
                    <div class="form-group">
                        <label>Nama Pengguna</label>
                        <input type="text" name="username" class="form-control" value="<?=$profil[0]['username']?>" placeholder="Nama Pengguna" readonly>
                    </div>
                    <div class="form-group">
                        <a href='#pass_reset' data-toggle='modal' class="btn btn-success btn-block">Ubah Kata Sandi</a>
                    </div>
                </div>
                
            </div>
            <div class="row">
                <div class="hr-sect">Tentang Diri & Usaha</div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tentang Saya</label>
                        <textarea class="form-control" name="tentang" rows="6"><?=$profil[0]['tentang']?></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Usaha</label>
                        <input type="text" name="nama_usaha" class="form-control" placeholder="Nama Usaha" value="<?=$profil[0]['nama_usaha']?>">
                    </div>
                    <div class="form-group">
                        <label>Misi Usaha</label>
                        <input type="text" class="form-control" name="misi_usaha" placeholder="Misi Usaha" value="<?=$profil[0]['misi_usaha']?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <button type="submit" class="btn view-all-accent-btn btn-block"><i class="fa fa-save"></i> Simpan</button>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
        </form>
        <!-- End Form Biodata -->

    </div>
</div>
<!-- Registration Page Area End Here -->
<!-- Modal Password Reset -->
<div id="pass_reset" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <span>Ubah Kata Sandi</span>
                <button type="button" class="close" data-dismiss="modal"><b style="color: red"></b></button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?=base_url('siswa/pass_update')?>">
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Kata Sandi Lama</label>
                            <input type="password" class="form-control" id="passLm" placeholder="Ketikan kata sandi lama">
                            <span id="pesan"></span>
                        </div>
                        <div class="form-group">
                            <label>Kata Sandi Baru</label>
                            <input type="password" class="form-control" id="passBr" placeholder="Ketikan kata sandi baru">
                        </div>
                        <div class="form-group">
                            <label>Ulangi kata sandi baru</label>
                            <input type="password" class="form-control" id="passUl" name="passUl" placeholder="Ketik ulang kata sandi baru">
                            <span id="pesan2"></span>
                        </div>
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
<!-- Modal Password Reset -->

<!-- Modal Unggah Foto -->
<div id="unggah_foto" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span>Unggah Foto</span>
                <button type="button" class="close" data-dismiss="modal"><b style="color:red">x</b></button>
            </div>
            <div class="modal-body">
                <?=form_open(base_url('siswa/unggah_foto'), array('class' =>'form-horizontal', 'enctype' => 'multipart/form-data' ,'role' => 'form', 'id'=>'form-simpan'));?>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-9">
                            <div class="img-container">
                                <img id="image" width="100%" src="<?php if(!empty($profil[0]['foto'])){echo base_url().'assets/images/user/'.$profil[0]['foto'];}else{echo "";}?>" alt="Browse Gambarmu">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="img-preview preview-lg"></div>
                            </div>
                            <div class="form-group text-center">
                                <div class="btn-group">
                                    <button class="btn btn-primary tooltips" data-original-title="Zoom In" data-toggle="tooltip" data-placement="top" title="" id="zoomIn" type="button"><i class="fa fa-search-plus"></i></button>
                                    <button class="btn btn-primary tooltips" data-original-title="Zoom Out" data-toggle="tooltip" data-placement="top" title="" id="zoomOut" type="button"><i class="fa fa-search-minus"></i></button>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-primary tooltips" data-original-title="Rotate Left" data-toggle="tooltip" data-placement="top" title="" id="rotateLeft" type="button"><i class="fa fa-rotate-left"></i></button>
                                    <button class="btn btn-primary tooltips" data-original-title="Rotate Right" data-toggle="tooltip" data-placement="top" title="" id="rotateRight" type="button"><i class="fa fa-rotate-right"></i></button>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-primary tooltips" data-original-title="Flip Horizontal" data-toggle="tooltip" data-placement="top" title="" id="fliphorizontal" type="button"><i class="fa fa-arrows-h"></i></button>
                                    <button class="btn btn-primary tooltips" data-original-title="Flip Vertical" data-toggle="tooltip" data-placement="top" title="" id="flipvertical" type="button"><i class="fa fa-arrows-v"></i></button>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <div class="btn-group">
                                    <label class="btn btn-danger" for="inputImage" title="Upload image file">
                                        <span data-toggle="tooltip" data-animation="false" title="Pilih Gambar">
                                            <input name="covers" type="hidden" value="<?php if (!empty($profil[0]['foto'])) {echo $profil[0]['foto'];}?>"></input>
                                            <input name="cover" onchange="cek_file('2MB','image','inputImage')" type="file" class="sr-only" id="inputImage" accept=".jpg,.jpeg,.png,.bmp">
                                            <span class="fa fa-search"></span> Browse
                                        </span>
                                    </label>
                                    <button class="btn btn-danger tooltips" data-original-title="Reset" data-toggle="tooltip" data-placement="top" title="" id="reset" type="button"><i class="fa fa-refresh"></i> Reset</button>
                                </div>
                            </div>
                            <div style="margin-top: 20px;text-align: center;">
                                <button class="btn btn-success btn-block simpan" type="submit"><i class="fa fa-upload"></i> Unggah </button>
                            </div>
                        </div>
                        <input type="hidden" id="dataX" name="x">
                        <input type="hidden" id="dataY" name="y">
                        <input type="hidden" id="dataWidth" name="width">
                        <input type="hidden" id="dataHeight" name="height">
                        <input type="hidden" id="dataRotate" name="rotate">
                        <input type="hidden" id="dataScaleX" name="flipx">
                        <input type="hidden" id="dataScaleY" name="flipy">
                    </div>
                </div>
                <?=form_close();?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Unggah Foto -->

<script type="text/javascript">
    $(document).ready(function(){        
        cropper(1,1); 
        $('#passUl').keyup(function(){            
            if ($('#passBr').val() != $('#passUl').val()) {
                if ($('#passUl').val()=="") {
                    $('#pesan2').html("<label class='control-label col-md-12' style='color:#00d2ff;text-align: left!important'><i class='fa fa-question-circle'></i>Silahkan Ketikan Ulang Password Baru</label>");
                }else{
                    $('#pesan2').html("<label class='control-label col-md-12' style='color: red;text-align: left!important'><i class='fa fa-times'></i> Password Tidak Sama</label>");
                }
                $('.simpan').attr('disabled','disabled');
            }else{
                $('#pesan2').html("<label class='control-label col-md-12' style='color: #6bc31d;text-align: left!important'><i class='fa fa-check'></i> Password Sama</label>");    
                $('.simpan').removeAttr('disabled');
            }
        });
        $('#passUl').blur(function(){            
            $('#pesan2').html("");
        });
        $('#passLm').keyup(function(){
            $('#pesan').html("<label class='control-label col-md-12' style='text-align: left!important'>Sedang Mengecek..</label>");
            var passLm = $('#passLm').val();                             
            $.ajax({
                type:"POST", 
                url:"<?=base_url().'siswa/cek_password/'.$this->session->userdata('id_user')?>",
                data:"passLm="+passLm,
                success: function(data){                    
                    if(data == 0){                        
                        sudah_tersedia('Password Lama Salah','#pesan');
                        if ($('#passLm').val()=="") {
                            ketik('Silahkan Ketikan Password Lama','#pesan');
                        }
                    } else {
                        tersedia('Password Lama Benar','#pesan');
                    }                    
                }
            });
        });

        
    });
</script>