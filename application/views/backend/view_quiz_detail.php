<?php 
$CI =& get_instance();
$id_kelas   = $this->encrypt->decode($this->input->get('id_kelas'));
$nama_kelas = $this->input->get('nama_kelas');
$id_stage   = $this->encrypt->decode($this->input->get('id_stage'));
$nama_stage = $this->input->get('nama_stage');
$id_materi  = $this->encrypt->decode($this->input->get('id_materi'));
if (!empty($data)) {
    $id_quiz        = $data[0]['id_quiz'];
    $pertanyaan_pg  = $data[0]['pertanyaan_pg'];
    $pg1            = $data[0]['pg1'];
    $pg2            = $data[0]['pg2'];
    $pg3            = $data[0]['pg3'];
    $pg4            = $data[0]['pg4'];
    $jawaban_pg     = $data[0]['jawaban_pg'];
    $pertanyaan_isian= $data[0]['pertanyaan_isian'];
    $jawaban_isian  = $data[0]['jawaban_isian'];
}else{
    $id_quiz = $pertanyaan_pg = $pg1 = $pg2 = $pg3 = $pg4 = $jawaban_pg = $pertanyaan_isian = $jawaban_isian = "";
}?>
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/backend/css/cropper.min.css');?>" />
<?=form_open(uri_string(), array('class' =>'form-horizontal', 'id'=>'form-simpan', 'enctype' => 'multipart/form-data' ,'role' => 'form'));?>
<input type="hidden" name="id_materi" value="<?=$CI->input('id_materi',$id_materi)?>">
<input type="hidden" name="id_kelas" value="<?=$CI->input('id_kelas',$id_kelas)?>">
<input type="hidden" name="id_stage" value="<?=$CI->input('id_stage',$id_stage)?>">
<section class="panel panel-info">
    <header class="panel-heading">
        <?=$title?> 
        <span class="tools pull-right">
            <button type="button" class="btn btn-warning" onclick="window.history.go(-1)"><i class="fa fa-chevron-left"></i> Kembali</button>&nbsp
            <button class="btn btn-info simpan" type="submit"><i class="fa fa-check"></i> Simpan </button>
        </span>
    </header>
    <div class="panel-body">
        <?=validation_errors()?>        
        <!-- --------------- start quiz ---------------- -->
        <div class="col-md-12">
            <div class="hr-sect">Quiz</div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Nama Kelas</label>                                    
                    <input type="text" class="form-control" name="nama_kelas" value="<?=$CI->input('nama_kelas',$nama_kelas)?>" readonly>
                </div>
                <div class="col-md-6">
                    <label>Nama Stage</label>                                    
                    <input type="text" class="form-control" name="nama_stage" value="<?=$CI->input('nama_stage',$nama_stage)?>" readonly>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <input type="hidden" name="id_quiz" value="<?=$CI->input('id_quiz',$id_quiz)?>">
                    <label>Pertanyaan Pilihan Ganda</label>
                    <textarea class="form-control" rows="7" name="pertanyaan_pg" placeholder="Buat lah soal pilihan ganda"><?=$CI->input('pertanyaan_pg',$pertanyaan_pg)?></textarea>
                </div>
                <div class="col-md-6">
                    <label>Pilihan Jawaban</label>
                    <div class="input-group">
                        <span class="input-group-addon"><input type="radio" name="jawaban_pg" value="A" <?php if ($jawaban_pg=="A") {echo "checked";}?> > A</span>
                        <input type="text" name="pg1" placeholder="Pilihan A" class="form-control" value="<?=$CI->input('pg1',$pg1)?>">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><input type="radio" name="jawaban_pg" value="B" <?php if ($jawaban_pg=="B") {echo "checked";}?>> B</span>
                        <input type="text" name="pg2" placeholder="Pilihan B" class="form-control" value="<?=$CI->input('pg2',$pg2)?>">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><input type="radio" name="jawaban_pg" value="C" <?php if ($jawaban_pg=="C") {echo "checked";}?>> C</span>
                        <input type="text" name="pg3" placeholder="Pilihan C" class="form-control" value="<?=$CI->input('pg3',$pg3)?>">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><input type="radio" name="jawaban_pg" value="D" <?php if ($jawaban_pg=="D") {echo "checked";}?>> D</span>
                        <input type="text" name="pg4" placeholder="Pilihan D" class="form-control" value="<?=$CI->input('pg4',$pg4)?>">
                    </div>
                    <small>Silahkan centang jawabawan yang benar</small>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Pertanyaan Isian Singkat</label>
                    <textarea class="form-control" rows="7" name="pertanyaan_isian" placeholder="Buat lah soal isian singkat"><?=$CI->input('pertanyaan_isian',$pertanyaan_isian)?></textarea>
                </div>
                <div class="col-md-6">
                    <label>Jawaban Isian Singkat</label>
                    <textarea class="form-control" rows="7" name="jawaban_isian" placeholder="Jawaban pertanyaan isian singkat"><?=$CI->input('jawaban_isian',$jawaban_isian)?></textarea>
                </div>
            </div>
        </div>
        <center><button class="btn btn-info simpan" type="submit"><i class="fa fa-save"></i> Simpan </button></center>
        <!-- --------------- end quiz ---------------- -->
    </div>
</section>
<?=form_close();?>

<script type="text/javascript" src="<?php echo base_url('assets/backend/js/cropper.min.js');?>"></script>

<script type="text/javascript">
    $(document).ready(function(){

    });
</script>