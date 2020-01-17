<?php 
$CI =& get_instance();
if (!empty($data)) {    
    $username       = $data[0]['username'];
    $pass           = "1234567890";    
    $tipe_user      = $data[0]['tipe_user'];
    $nama_lengkap   = $data[0]['nama_lengkap'];
    $nama_panggilan = $data[0]['nama_panggilan'];
    $tanggal_lahir  = $data[0]['tanggal_lahir'];
    $tempat_lahir   = $data[0]['tempat_lahir'];
    $jk             = $data[0]['jk'];    
    $foto           = $data[0]['foto'];
    $agama          = $data[0]['agama'];
    $alamat         = $data[0]['alamat'];
    $wa             = $data[0]['wa'];
    $email          = $data[0]['email'];
    $facebook       = $data[0]['facebook'];
    $instagram      = $data[0]['instagram'];
    $twitter        = $data[0]['twitter'];
    $youtube        = $data[0]['youtube'];
    $tentang        = $data[0]['tentang'];
    $posisi         = $data[0]['posisi'];
    $nama_usaha     = $data[0]['nama_usaha'];
    $misi_usaha     = $data[0]['misi_usaha'];
    $publish        = $data[0]['publish'];  
    $allow_login    = $data[0]['allow_login'];
    $disabled       = "disabled";
    
}else{
    $username = $pass = $tipe_user = $nama_lengkap = $nama_panggilan = $tanggal_lahir  = $tempat_lahir = $jk = $foto = $agama = $alamat = $wa = $email = $facebook = $instagram = $twitter = $youtube = $tentang = $posisi = $nama_usaha = $misi_usaha = $publish = $allow_login = $disabled = "";
}?>
<?=form_open(uri_string(), array('class' =>'form-horizontal', 'id'=>'form-simpan', 'enctype' => 'multipart/form-data' ,'role' => 'form'));?>

<section class="panel panel-info">
    <header class="panel-heading">
        <?=$title?> <?php if (!empty($id_user)) {echo ' - '.$id_user;}?>
        <span class="tools pull-right">
            <button type="button" class="btn btn-warning" onclick="window.history.go(-1)"><i class="fa fa-chevron-left"></i> Kembali</button>&nbsp
            <button class="btn btn-info simpan" type="submit"><i class="fa fa-check"></i> Simpan </button>
        </span>
    </header>
    <div class="panel-body">
        <?=validation_errors()?>
        <div class="col-md-12">            
            <div class="form-group">
                <div class="col-md-6">
                    <div class="hr-sect">Informasi Umum</div>
                    <label>Nama Lengkap*</label>
                    <input type="hidden" name="id" value="<?=$this->uri->segment(3)?>">
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?=$CI->input('nama_lengkap',$nama_lengkap)?>" placeholder="Nama Lengkap" autofocus>
                    
                </div>
                <div class="col-md-6">
                    <div class="hr-sect">Sosial Media</div>
                    <label>Whatsapp</label>
                     <input type="text" class="form-control" name="wa" placeholder="Nomor Whatsapp Aktif" value="<?=$CI->input('wa',$wa)?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">                    
                    <label>Nama Panggilan</label>
                    <input type="text" class="form-control" id="nama_panggilan" name="nama_panggilan" value="<?=$CI->input('nama_panggilan',$nama_panggilan)?>" placeholder="Nama Panggilan">
                    
                </div>
                <div class="col-md-6">                    
                    <label>Email</label>
                     <input type="text" class="form-control" name="email" placeholder="Alamat Email Aktif" value="<?=$CI->input('email',$email)?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Jenis Kelamin*</label>
                    <select class="form-control" name="jk">
                        <option value="">-Pilih-</option>
                        <option value="L" <?php if($this->input->post('jk')=="L"){echo "selected";}elseif (!empty($jk) AND $jk=="L"){echo "selected";} ?>>Laki-Laki</option>
                        <option value="P" <?php if($this->input->post('jk')=="P"){echo "selected";}elseif (!empty($jk) AND $jk=="P"){echo "selected";} ?>>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-6">                    
                    <label>Facebook</label>
                     <input type="text" class="form-control" name="facebook" placeholder="Nama Facebook" value="<?=$CI->input('facebook',$facebook)?>">
                </div>
            </div>            
            <div class="form-group">
                <div class="col-md-6">               
                     <?php 
                    $tgl_lhr = date("d-m-Y",strtotime($tanggal_lahir));
                    ?>
                    <label>Tanggal Lahir</label>
                    <input type="text" name="tanggal_lahir" class="form-control tanggal" value="<?=$CI->input('tanggal_lahir',$tanggal_lahir)?>" placeholder="Tanggal Lahir" readonly>
                </div>
                <div class="col-md-6">
                    <label>Instagram</label>
                     <input type="text" class="form-control" name="instagram" placeholder="Nama Instagram" value="<?=$CI->input('instagram',$instagram)?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">               
                    <label>Tempat Lahir</label>
                     <input type="text" class="form-control" name="tempat_lahir" placeholder="Tempat Lahir" value="<?=$CI->input('tempat_lahir',$tempat_lahir)?>">
                </div>
                <div class="col-md-6">
                    <label>Twitter</label>
                     <input type="text" class="form-control" name="twitter" placeholder="Nama Twitter" value="<?=$CI->input('twitter',$twitter)?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">               
                    <?php
                    $ar_agama = array('Islam','Katolik','Kristen Protestan','Hindu', 'Buddha', 'Kong Hu Cu', 'Lainnya');
                    ?>
                    <label>Agama</label>
                    <select name="agama" class="form-control">
                        <option value="">-Pilih-</option>
                        <?php 
                        foreach ($ar_agama as $key => $value) {?>
                        <option <?php if($this->input->post('agama')==$value){echo 'selected';}elseif (!empty($data[0]['agama']) AND $data[0]['agama']==$value){echo 'selected';}?>><?=$value?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Youtube</label>
                     <input type="text" class="form-control" name="youtube" placeholder="Chanel Youtube" value="<?=$CI->input('youtube',$youtube)?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">               
                    <label>Alamat</label>
                    <textarea class="form-control" name="alamat" rows="3" placeholder="Alamat Lengkap"><?=$CI->input('alamat',$alamat)?></textarea>
                    <br>
                    <label>Posisi</label>
                    <input type="text" name="posisi" class="form-control" placeholder="Isi jika pengguna seorang fasilitator" value="<?=$CI->input('posisi',$posisi)?>">
                </div>
                <div class="col-md-6">
                    <div class="hr-sect">Tentang Diri & Usaha</div>
                    <label>Deksripsi Diri</label>
                    <textarea class="form-control" rows="5" name="tentang" placeholder="Deskripsikan secara singkat tentang diri"><?=$CI->input('tentang',$tentang)?></textarea>                    
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <div class="hr-sect">Informasi Akun</div>
                    <label>Username*</label>
                    <input type="hidden" id="username_dt" value="<?=$CI->input('username',$username)?>">
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?=$CI->input('username',$username)?>">
                    <div id="pesan"></div>
                </div>
                <div class="col-md-6">
                    <label>Nama Usaha</label>
                     <input type="text" class="form-control" name="nama_usaha" placeholder="Nama Usaha" value="<?=$CI->input('nama_usaha',$nama_usaha)?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Password*</label>
                    <input type="password" name="password1" id="password1" class="form-control" placeholder="Ketikan Password" value="<?=$pass?>" <?=$disabled?>>
                </div>
                <div class="col-md-6">
                    <label>Misi Usaha</label>
                     <input type="text" class="form-control" name="misi_usaha" placeholder="Nama Usaha" value="<?=$CI->input('misi_usaha',$misi_usaha)?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Ulangi Password*</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Ketik Ulang Password" value="<?=$pass?>" <?=$disabled?>>
                    <div id="pesan2"></div>
                </div>
                <div class="col-md-6">
                    <label>Tampilkan ke Publik</label>
                    <select class="form-control" name="publish">                        
                        <option value="Y" <?php if($this->input->post('publish')=="Y"){echo "selected";}elseif (!empty($publish) AND $publish=="Y"){echo "selected";} ?>>Ya</option>
                        <option value="N" <?php if($this->input->post('publish')=="N"){echo "selected";}elseif (!empty($publish) AND $publish=="N"){echo "selected";} ?>>Tidak</option>
                    </select>      
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <?php 
                    $user_tipe = $this->encrypt->decode($this->session->userdata(
                        'tipe_user'));
                    if ($user_tipe=='admin') {
                        $ar_tipe = array('admin','guru','siswa');
                    }else{
                        $ar_tipe = array('guru');
                    }
                    ?>
                    <label>Tipe User*</label>
                    <select name="tipe_user" class="form-control">
                        <option value="">-Pilih-</option>
                        <?php 
                        foreach ($ar_tipe as $key => $value) {?>
                        <option <?php if($this->input->post('tipe_user')==$value){echo 'selected';}elseif (!empty($data[0]['tipe_user']) AND $data[0]['tipe_user']==$value){echo 'selected';}?>><?=$value?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Blokir</label>
                    <select class="form-control" name="allow_login">
                        <option value="Y" <?php if($this->input->post('allow_login')=="Y"){echo "selected";}elseif (!empty($allow_login) AND $allow_login=="Y"){echo "selected";} ?>>Tidak</option>
                        <option value="N" <?php if($this->input->post('allow_login')=="N"){echo "selected";}elseif (!empty($allow_login) AND $allow_login=="N"){echo "selected";} ?>>Ya</option>
                    </select> 
                </div>
            </div>
            
            <label>Foto Pengguna</label>
            <div class="form-group">
                <div class="col-md-9">
                    <div class="img-container">
                        <img id="image" src="<?php if(!empty($foto)){echo base_url().'assets/images/user/'.$foto;}else{echo "";}?>" alt="Browse Gambarmu">
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
                                <input name="covers" type="hidden" value="<?php if (!empty($foto)) {echo $foto;}?>"></input>
                                <input name="cover" onchange="cek_file('2MB','image','inputImage')" type="file" class="sr-only" id="inputImage" accept=".jpg,.jpeg,.png,.bmp">
                                <span class="fa fa-upload"></span> Browse
                            </span>
                        </label>
                        <button class="btn btn-danger tooltips" data-original-title="Reset" data-toggle="tooltip" data-placement="top" title="" id="reset" type="button"><i class="fa fa-refresh"></i> Reset</button>
                    </div>
                    <div style="margin-top: 20px">
                        <button class="btn btn-success simpan" type="submit"><i class="fa fa-save"></i> Simpan </button>
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
    </div>
</section>
<?=form_close()?>
<script type="text/javascript">
    $(document).ready(function(){        
        cropper(1,1);
        $('#nama_lengkap').keyup(function(){
            this.value = this.value.ucwords();         
        });
        $('#nama_panggilan').keyup(function(){
            this.value = this.value.ucwords();         
        });
        $('#password').keyup(function(){
            if ($('#password').val() != $('#password1').val()) {
                $('#pesan2').html("<label class='control-label col-md-12' style='color: red;text-align: left!important'><i class='fa fa-times'></i> Password Tidak Sama</label>");
                $('.simpan').attr('disabled','disabled');
            }else{
                $('#pesan2').html("<label class='control-label col-md-12' style='color: #6bc31d;text-align: left!important'><i class='fa fa-check'></i> Password Sama</label>");    
                $('.simpan').removeAttr('disabled');
            }
        });
        $('#username').keyup(function(){
            $('#pesan').html("<label class='control-label col-md-12' style='text-align: left!important'>Sedang Mengecek..</label>");
            var username = $('#username').val();                              
            $.ajax({
                type:"POST", 
                url:"<?=base_url();?>user/cek_username/"+username,
                data:"username="+username,
                success: function(data){                    
                    if(data == 0){                        
                        tersedia('Username Tersedia','#pesan');                     
                        if ($('#username').val()=="") {
                            ketik('Silahkan Ketikan Username','#pesan');
                        }
                    } else {
                        sudah_tersedia('Username Sudah Tersedia. Silahkan Ketikan Username Lain','#pesan');
                        if ($('#username').val()==$('#username_dt').val()) {
                            tidak_berubah('Tidak Ada Perubahan','#pesan');
                        }
                    }
                }
            });
        });
    });
</script>