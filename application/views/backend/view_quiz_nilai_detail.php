<?php 
$CI =& get_instance();
if (!empty($hasil_quiz) && !empty($quiz)) {
    $nama_kelas         = $hasil_quiz[0]['nama_kelas'];
    $nama_siswa         = $hasil_quiz[0]['nama_siswa'];
    $nama_stage         = $hasil_quiz[0]['nama_stage'];
    $judul_materi       = $hasil_quiz[0]['judul_materi'];
    $nilai              = $hasil_quiz[0]['nilai'];
    $jawaban_pg_siswa   = $hasil_quiz[0]['jawaban_pg'];
    $jawaban_isian_siswa= $hasil_quiz[0]['jawaban_isian'];
    $upload_tugas       = $hasil_quiz[0]['upload_tugas'];
    $waktu_submit       = $hasil_quiz[0]['waktu_post'];

    $pertanyaan_pg      = $quiz[0]['pertanyaan_pg'];
    $pg1                = $quiz[0]['pg1'];
    $pg2                = $quiz[0]['pg2'];
    $pg3                = $quiz[0]['pg3'];
    $pg4                = $quiz[0]['pg4'];
    $jawaban_pg         = $quiz[0]['jawaban_pg'];
    $pertanyaan_isian   = $quiz[0]['pertanyaan_isian'];
    $jawaban_isian      = $quiz[0]['jawaban_isian'];

}else{
    $nama_kelas = $nama_siswa = $nama_stage = $judul_materi = $nilai = $jawaban_pg_siswa = $jawaban_isian_siswa = $upload_tugas = $waktu_submit       = $pertanyaan_pg = $pg1 = $pg2 = $pg3 = $pg4 = $jawaban_pg = $pertanyaan_isian = $jawaban_isian = "";
}?>

<?=form_open(uri_string(), array('class' =>'form-horizontal', 'id'=>'form-simpan', 'enctype' => 'multipart/form-data' ,'role' => 'form'));?>
<input type="hidden" name="id_siswa" value="<?=$this->input->get('id_siswa')?>">
<input type="hidden" name="id_quiz" value="<?=$this->input->get('id_quiz')?>">
<input type="hidden" name="nama_siswa" value="<?=$nama_siswa?>">

<section class="panel panel-info">
    <header class="panel-heading">
        <?=$title?> - <?=$nama_siswa?>
        <span class="tools pull-right">
            <button type="button" class="btn btn-warning" onclick="window.history.go(-1)"><i class="fa fa-chevron-left"></i> Kembali</button>&nbsp
            <button class="btn btn-info simpan" type="submit"><i class="fa fa-save"></i> Simpan </button>
        </span>
    </header>
    <div class="panel-body">
        <?=validation_errors()?>        
        <!-- --------------- start quiz ---------------- -->
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-12" style="text-align: center;font-size: 20px;">
                    <b>Materi : <?=$judul_materi?><b>
                </div>
            </div>
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
                    <label><?=$pertanyaan_pg?></label>
                    <div class="input-group">
                        <span class="input-group-addon"><input type="radio" name="jawaban_pg" value="A" <?php if ($jawaban_pg_siswa=="A") {echo "checked";}?> > A</span>
                        <input type="text" name="pg1" placeholder="Pilihan A" class="form-control" value="<?=$CI->input('pg1',$pg1)?>">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><input type="radio" name="jawaban_pg" value="B" <?php if ($jawaban_pg_siswa=="B") {echo "checked";}?>> B</span>
                        <input type="text" name="pg2" placeholder="Pilihan B" class="form-control" value="<?=$CI->input('pg2',$pg2)?>">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><input type="radio" name="jawaban_pg" value="C" <?php if ($jawaban_pg_siswa=="C") {echo "checked";}?>> C</span>
                        <input type="text" name="pg3" placeholder="Pilihan C" class="form-control" value="<?=$CI->input('pg3',$pg3)?>">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><input type="radio" name="jawaban_pg" value="D" <?php if ($jawaban_pg_siswa=="D") {echo "checked";}?>> D</span>
                        <input type="text" name="pg4" placeholder="Pilihan D" class="form-control" value="<?=$CI->input('pg4',$pg4)?>">
                    </div>
                    <span>
                        <?php 
                        if ($jawaban_pg==$jawaban_pg_siswa) {
                            $ket = "<b style='color:green'>Benar</b>";
                        }else{
                            $ket = "<b style='color:red'>Salah</b>";
                        }
                        echo "<b style='color:green'>Jawaban : $jawaban_pg </b> <br>";
                        echo "Jawaban Siswa $ket";
                        ?>  
                    </span>
                </div>
                <div class="col-md-6">
                    <label><?=$pertanyaan_isian?></label>
                    <textarea class="form-control"><?=$jawaban_isian_siswa?></textarea>
                    <b style='color:green'>Jawaban : <?=$jawaban_isian?></b>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-8">
                    <label>Nilai</label>
                    <input type="number" class="form-control" name="nilai" value="<?=$CI->input('nilai',$nilai)?>" placeholder="Berikan nilai" required>
                </div>
                <div class="col-md-4">
                    <label>File Tugas Siswa</label><br>
                    <?php 
                    $appath = realpath(APPPATH . '../assets/tugas_siswa/'.$upload_tugas);
                    if(!empty($upload_tugas) and file_exists($appath)){
                        $file = base_url().'assets/tugas_siswa/'.$upload_tugas;
                        echo "<a href=\"$file\" class=\"btn btn-success\" target=\"_blank\"><i class=\"fa fa-download\"></i> Download Tugas</a>";
                    }else{
                        echo "<p style='color: red'>Tidak Ada File Tugas</p>";
                    } ?>
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
