<?php 
$CI =& get_instance();
?>
<?=form_open(uri_string(), array('class' =>'form-horizontal', 'id'=>'form-simpan', 'enctype' => 'multipart/form-data' ,'role' => 'form'));?>
<input type="hidden" id="id_user" name="id_user" value="<?=$this->uri->segment(3)?>">
<section class="panel panel-info">
    <header class="panel-heading">
        <?=$title.' - '.ucwords($data[0]['nama_lengkap'].' ['.$data[0]['tipe_user'].']')?>
        <span class="tools pull-right">
            <button type="button" class="btn btn-warning" onclick="window.history.go(-1)"><i class="fa fa-chevron-left"></i> Kembali</button>&nbsp
        </span>
    </header>
    <div class="panel-body">
        <?=validation_errors()?>
        <div class="col-md-12">
            <center>
                <h2>Silahkan Ubah Password</h2>
            </center>
            <div class="col-md-4"></div>                        
            <div class="col-md-4">                
                <div class="form-group">
                    <input type="password" class="form-control" name="passLm" id="passLm" placeholder="Password Lama" autofocus>
                    <div id="pesan"></div>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="passBr" id="passBr" placeholder="Password Baru">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="passUl" name="passUl" placeholder="Ketik Ulang Password Baru">
                    <div id="pesan2"></div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?=base_url().'user/pass_reset/'.$this->uri->segment(3)?>" class="btn btn-primary"><i class="fa fa-refresh"></i> Reset</a>     
                        </div>                        
                        <div class="col-md-6" align="right">
                            <button class="btn btn-info simpan" type="submit"><i class="fa fa-save"></i> Simpan </button>
                        </div>
                    </div>
                </div>                
            </div>            
            <div class="col-md-4"></div>            
        </div>
        <center><p>Catatan: Tekan tombol <b>Reset</b>. Password baru akan otomatis digenerate.</p></center>
    </div>
</section>
<?=form_close()?>

<script type="text/javascript">
    $(document).ready(function(){        
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
                url:"<?=base_url();?>user/cek_password/"+$('#id_user').val(),
                data:"passLm="+passLm,
                success: function(data){                    
                    if(data == 0){                        
                        sudah_tersedia('Password Lama Salah','#pesan');
                        if ($('#passLm').val()=="") {
                            ketik('Silahkan Ketikan Password Lama','#pesan');
                        }
                    } else {
                        tersedia('Password Lama Benar','#pesan');
                        $('.simpan').removeAttr('disabled');
                    }                    
                }
            });
        });
    });
</script>