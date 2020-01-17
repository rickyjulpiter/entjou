<?php 
$CI =& get_instance();
if (!empty($data)) {
    $id_checkup = $data[0]['id_checkup'];
    $id_guru    = $data[0]['id_guru'];
    $nama_guru  = $data[0]['nama_guru'];
    $j1         = $data[0]['j1'];
    $j2         = $data[0]['j2'];
    $j3         = $data[0]['j3'];
    $j4         = $data[0]['j4'];
    $waktu_edit = $data[0]['waktu_edit'];
    $ket = "Telah diperiksa dan dijawab oleh <a href='".base_url().'user/user_detail/'.$this->encrypt->encode($id_guru)."' target='_blank'>".$nama_guru."</a> pada ".$waktu_edit." WIB";

}else{
    $id_checkup = $id_guru = $nama_guru = $j1 = $j2 = $j3 = $j4 = $waktu_edit = $ket = "";
}?>
<?=form_open(uri_string(), array('class' =>'form-horizontal', 'id'=>'form-simpan', 'enctype' => 'multipart/form-data' ,'role' => 'form'));?>
<section class="panel panel-info">
    <header class="panel-heading">
        <?=$title?> 
        <span class="tools pull-right">
            <button type="button" class="btn btn-warning" onclick="window.location.href='<?=base_url().$this->uri->segment(1)?>'"><i class="fa fa-chevron-left"></i> Kembali</button>&nbsp
            <button class="btn btn-info simpan" type="submit"><i class="fa fa-save"></i> Simpan </button>
        </span>
    </header>
    <div class="panel-body">
        <?=validation_errors()?>
        <div class="col-md-12">   
        <input type="hidden" name="id_checkup" value="<?=$id_checkup?>">
        <input type="hidden" name="id_siswa" value="<?=$checkup[0]['id_siswa']?>">
        <input type="hidden" name="nama_siswa" value="<?=$checkup[0]['nama_siswa']?>">  
            <label><?=$ket?></label>
            <div class="form-group">
                <div class="col-md-6">
                    <div class="hr-sect">Checkup Siswa</div>
                    <label>Nama Siswa : <?=$checkup[0]['nama_siswa']?> <a class="btn btn-info btn-xs" href="<?=base_url().'user/user_detail/'.$this->encrypt->encode($checkup[0]['id_siswa'])?>" target="_blank"><i class="fa fa-user"></i> Lihat Profil</a></label>
                    <br>
                    <?php 
                    foreach ($form_checkup as $key => $value) {?>
                        <label><?=ucwords($value['pertanyaan'])?></label>
                        <textarea class="form-control" rows="4" readonly><?=$checkup[0][$value['kode']]?></textarea>
                    <?php } ?>
                </div>
                <div class="col-md-6">
                    <div class="hr-sect">Hasil Checkup Siswa</div>
                    <label>Dimana posisi siswa sekarang?</label>
                    <textarea class="form-control" name="j1" placeholder="Silahkan berikan jawaban" rows="5" required><?=$CI->input('j1',$j1)?></textarea>
                    <br>
                    <label>Hal-hal yang harus siswa pelajari</label>
                    <textarea class="form-control" name="j2" placeholder="Silahkan berikan jawaban" rows="5" required><?=$CI->input('j2',$j2)?></textarea>
                    <br>
                    <label>Rekomendasi kelas yang dapat siswa ikuti</label>
                    <textarea class="form-control" name="j3" placeholder="Silahkan berikan jawaban" rows="5" required><?=$CI->input('j3',$j3)?></textarea>
                    <br>
                    <label>Cerita tentang Entrepreneur Terkenal yang sama dengan posisi siswa sekarang</label>
                    <textarea class="form-control" name="j4" placeholder="Silahkan berikan jawaban" rows="5" required><?=$CI->input('j4',$j4)?></textarea>
                </div>
            </div>

            
        </div>
    </div>
</section>
<?=form_close()?>

<script type="text/javascript">
    $(document).ready(function(){        
        cropper(1,2.2);        
        $('.summernote').summernote({
            height:"500px",
            placeholder:"Tulis Pengumuman Disini..."
        });
        $('.note-insert').css('display','none');
    });
</script>