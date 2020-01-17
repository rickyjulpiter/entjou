<style type="text/css">
    .logo{font-size: 18px;font-weight: bold;}
</style>
<!-- Login Area Start Here -->
<div class="registration-page-area bg-secondary">
    <div class="container">
        <div id="daftar">
            <h2 align="center">Pendaftaran</h2>
            <center><small>Sudah punya akun? <a href="javascript:;#login" id="btn-login">Silahkan masuk</a></small></center>
            <div class="registration-details-area inner-page-padding">
                <div class="hr-sect">Informasi Umum</div>
                <form id="form-daftar" action="<?=base_url('home/daftar_proses')?>" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama lengkap" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Agama</label>
                                <?php 
                                $ar_agama = array('Islam', 'Katolik', 'Kristen Protestan', 'Hindu', 'Buddha', 'Kong Hu Cu', 'Lainnya');
                                ?>
                                <select name="agama" class="form-control select2" required>
                                    <option value="">-Pilih Agama-</option>
                                    <?php 
                                    foreach ($ar_agama as $key => $value) {?>
                                    <option><?=$value?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Panggilan</label>
                                <input type="text" name="nama_panggilan" class="form-control" placeholder="Nama Panggilan">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Alamat email aktif" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="text" name="tanggal_lahir tanggal" class="form-control tanggal" placeholder="dd-mm-yyyy" readonly required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor WA</label>
                                <input type="text" name="wa" class="form-control" placeholder="Nomor Whatsapp aktif" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat lahir" required>
                                
                                <?php 
                                $ar_jk = array('L'=>'Laki-Laki','P'=>'Perempuan');
                                ?>
                                <label>Jenis Kelamin</label>
                                <select name="jk" class="form-control select2">
                                    <option value="">-Pilih Jenis Kelamin-</option>
                                    <?php 
                                    foreach ($ar_jk as $key => $value) {?>
                                    <option value="<?=$key?>"><?=$value?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Alamat Rumah</label>
                                <textarea name="alamat" class="form-control" style="height: 123px" placeholder="Alamat rumah lengkap"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="hr-sect">Informasi Akun & Tentang Saya</div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Pengguna</label>
                                <input type="text" name="username" class="form-control" id="username" placeholder="Nama Pengguna" required>
                                <div id="pesan"></div>

                                <label>Kata Sandi</label>
                                <input type="password" name="password1" id="passBr" class="form-control" placeholder="Kata Sandi" required>

                                <label>Ulangi Kata Sandi</label>
                                <input type="password" name="password2" id="passUl" class="form-control" placeholder="Ulangi Kata Sandi" required>
                                <div id="pesan2"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Pertanyaan Keamanan</label>
                                    <select class="form-control" name="secret_quest" required>
                                        <?php
                                        $quest = array(
                                            'Siapa Nama Ayahmu?',
                                            'Siapa Nama Ibumu?',
                                            'Dimana Tempat Favoritmu?',
                                            'Siapa Yang Kamu Idolakan?',
                                            'Apa Nama Peliharaan Kesayangan Kamu?',
                                            'Apa Film Favoritmu?',
                                        );?>
                                        <option value="">-Pilih-</option>
                                        <?php foreach ($quest as $key => $value): ?>
                                            <option><?=$value?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Jawaban</label>
                                    <input type="text" name="secret_ans" class="form-control" placeholder="Ketikan Jawaban Pertanyaan Keamanan" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tentang Saya</label>
                                <textarea class="form-control" name="tentang" style="height: 125px" placeholder="Ceritakan secara singkat tentang diri anda"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <span><input type="checkbox" name="agree" id="agree">Saya menyatakan telah mengisi data dengan benar dan lengkap</span>
                            <button type="submit" class="view-all-accent-btn btn-block simpan">Daftar</button>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                </form>
            </div>
        </div>
        <div id="login">
            <center class="logo">
                <img src="<?=base_url('assets/images/logo.png')?>">
                <br><br>
                <p>Silakan masuk ke dalam akun kamu</p>
            </center>
            <div class="registration-details-area inner-page-padding">
                <form action="<?=base_url('login/cek_login')?>" method="POST">
                    <div class="row">
                        <?=$this->session->flashdata('notif')?>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Nama Pengguna</label>
                                <input type="text" class="form-control" name="username" placeholder="Masukan nama pengguna" autofocus="on" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Kata Sandi</label>
                                <input type="password" class="form-control" name="password" placeholder="Masukan kata sandi" required>
                            </div>
                            <div class="form-group">
                                <button class="view-all-accent-btn btn-block" type="submit">Masuk</button>
                            </div>
                            <div class="col-md-6" align="left">
                                <small>Belum punya akun? <a href="javascript:;#daftar" id="btn-daftar">Daftar disini</a></small>
                            </div>
                            <div class="col-md-6" align="right">
                                <small><a href='#pass_forget' data-toggle='modal' >Lupa kata sandi?</a></small>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Login Area End Here -->

<!-- Modal Password Forget -->
<div id="pass_forget" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <span>Lupa Kata Sandi</span>
                <button type="button" class="close" data-dismiss="modal"><b style="color: red"></b></button>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <small>* Hanya digunakan untuk siswa</small>
                    <div class="form-group">
                        <label>Nama Pengguna</label>
                        <div class="input-group">
                            <input type="text" name="username1" class="form-control" placeholder="Ketikan Nama Pengguna Kamu" autofocus="on">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default" id="cek_username"><i class="fa fa-check"></i> OK</button>
                            </span>
                        </div>
                    </div>
                    <div id="secret" style="display: none;">
                        <div class="form-group">
                            <label>Pertanyaan Keamanan</label>
                            <input type="text" class="form-control" name="secret_quest" disabled>
                        </div>
                        <div class="form-group">
                            <label>Jawaban</label>
                            <div class = "input-group">
                                <input type="text" name="secret_ans1" class="form-control" placeholder="Ketikan Jawaban Kamu Disini">
                                <span class = "input-group-btn">
                                    <button type="button" class="btn btn-default" id="cek_jawaban"><i class="fa fa-check"></i> OK</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <form action="<?=base_url().'home/pass_update/'?>" method="POST">
                        <div id="kata_sandi" style="display: none;">
                            <div class="hr-sect">Kata Sandi Baru</div>
                            <input type="hidden" name="username2">
                            <div class="form-group">
                                <input type="password" name="passBr" class="form-control" placeholder="Ketikan Kata Sandi Baru Kamu">
                            </div>
                            <div class="form-group">
                                <input type="password" name="passUl" class="form-control" placeholder="Ketik Ulang Kata Sandi Kamu">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Password Forget -->

<script type="text/javascript">
    $(document).ready(function(){
        $('#form-daftar').on('submit',function(){
            var agree = $('#agree').is(':checked');
            if (agree==false) {
                swal('Peringatan',' Anda belum menyetujui pernyataan', 'error');
                return false;
            }
        });
        $('#cek_username').on('click', function(){
            var username = $('[name="username1"]').val();
            $.ajax({
                url:"<?=base_url();?>"+'home/cek_username1/'+username,
                success: function(data){
                    if (data!="kosong") {
                        swal('Informasi!','Silahkan jawab pernyataan keamanan untuk dapat mengubah kata sandi yang baru','success');
                        $('[name="username1"]').attr("readonly","readonly");
                        $('#secret').show();
                        $('[name="secret_quest"]').val(data);
                    }else{
                        swal('Peringatan!','Maaf, nama pengguna tidak terdaftar','error');
                        $('[name="username1"]').val("");
                        $('#secret').hide();
                        $('[name="secret_quest"]').val("");
                    }
                }
            });
        });
        $('#cek_jawaban').on('click', function(){
            var username = $('[name="username1"]').val();
            var ans      = $('[name="secret_ans1"]').val();
            $.ajax({
                url : "<?=base_url();?>"+'home/cek_ans/'+username+'/'+ans,
                success: function(data){
                    if (data==1) {
                        swal('Informasi','Silahkan ubah kata sandi kamu yang baru','success');
                        $('#kata_sandi').show();
                        $('[name="username2"]').val(username);
                        $('[name="passBr"]').focus();
                    }else{
                        swal('Peringatan!','Maaf jawaban kamu salah','error');
                        $('#kata_sandi').hide();
                        $('[name="secret_ans1"]').val("");
                    }
                }
            });
        });
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
        $('#username').keyup(function(){
            $('#pesan').html("<label class='control-label col-md-12' style='text-align: left!important'>Sedang Mengecek..</label>");
            var username = $('#username').val();
            $.ajax({
                type:"POST", 
                url:"<?=base_url();?>"+'home/cek_username/'+$('#username').val(),
                data:"username="+username,
                success: function(data){                    
                    if(data == 1){                        
                        $('#pesan').html("<label class='control-label col-md-12' style='color: red;text-align: left!important'><i class='fa fa-times'></i> Username sudah digunakan</label>");
                        if ($('#username').val()=="") {
                            ketik('Silahkan Ketikan Username Kamu','#pesan');
                        }
                        $('.simpan').attr('disabled','disabled');
                    } else {
                        $('#pesan').html("<label class='control-label col-md-12' style='color: #6bc31d;text-align: left!important'><i class='fa fa-check'></i> Username Tersedia</label>");
                        $('.simpan').removeAttr('disabled');
                    }                    
                }
            });
        });
    });
</script>