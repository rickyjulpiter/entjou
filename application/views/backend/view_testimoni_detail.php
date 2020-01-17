<?php 
$CI =& get_instance();
if (!empty($data)) {
    $nama_siswa     = $data[0]['nama_siswa'];
    $nama_kelas     = $data[0]['nama_kelas'];
    $isi            = $data[0]['isi'];
}else{
    $nama_siswa = $nama_kelas = $isi = "";
}?>
<?=form_open(uri_string(), array('class' =>'form-horizontal', 'id'=>'form-simpan', 'enctype' => 'multipart/form-data' ,'role' => 'form'));?>
<section class="panel panel-info">
    <header class="panel-heading">
        <?=$title?> 
        <span class="tools pull-right">
            <button type="button" class="btn btn-warning" onclick="window.location.href='<?=base_url().$this->uri->segment(1)?>'"><i class="fa fa-chevron-left"></i> Kembali</button>&nbsp
            <button class="btn btn-info simpan" type="submit"><i class="fa fa-check"></i> Simpan </button>
        </span>
    </header>
    <div class="panel-body">
        <?=validation_errors()?>
        <?=$this->session->flashdata('notif');?>
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-6">                    
                    <label>Nama Siswa</label>
                    <input type="hidden" name="id" value="<?=$this->uri->segment(3)?>">
                    <input type="text" class="form-control" name="nama_siswa" value="<?=$CI->input('nama_siswa',$nama_siswa)?>" placeholder="Nama Siswa" autofocus>
                </div>
                <div class="col-md-6">                    
                    <label>Nama Kelas</label>
                    <input type="text" class="form-control" name="nama_kelas" value="<?=$CI->input('nama_kelas',$nama_kelas)?>" placeholder="Nama Kelas" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label>Isi Testimoni</label>                    
                    <textarea name="isi" class="form-control" rows="5"><?=$CI->input('isi',$isi)?></textarea>
                </div>
            </div>            
        </div>
        <?=form_close(); ?>
               
    </div>
</section>

