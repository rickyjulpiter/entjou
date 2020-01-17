<?php 
$CI =& get_instance();
$id_materi = $this->encrypt->decode($this->input->get('id_materi'));
$quiz = $CI->get('_quiz',$id_materi);
$id_siswa = $this->encrypt->decode($this->session->userdata('id_user'));
if ($id_siswa=="") {
    $hasil_quiz = "";
}else{
    $hasil_quiz = $CI->get('_quiz_hasil',$id_materi,$id_siswa);
}

if (!empty($hasil_quiz)) {
    $jawaban_pg     = $hasil_quiz[0]['jawaban_pg'];
    $jawaban_isian  = $hasil_quiz[0]['jawaban_isian'];
    $upload_tugas   = $hasil_quiz[0]['upload_tugas'];
    $nilai          = $hasil_quiz[0]['nilai'];
    $nama_guru      = $hasil_quiz[0]['nama_guru'];
    $ket            = "Telah dikerjakan pada ".$hasil_quiz[0]['waktu_post']." WIB";
}else{
    $jawaban_pg = $jawaban_isian = $upload_tugas = $nilai = $nama_guru = $ket = "";
}

?>
<?php 
if (!empty($quiz)) {?>
<hr>
<b>Jawablah quiz di bawah ini dengan benar dan tepat!</b>
<?=form_open(base_url().'home/quiz_add', array('class' =>'form-horizontal', 'id'=>'form-simpan', 'enctype' => 'multipart/form-data' ,'role' => 'form'));?>
<div class="panel-body">
    <?=$this->session->flashdata('notif')?>
    <input type="hidden" name="id_quiz" value="<?=$quiz[0]['id_quiz']?>">
    <input type="hidden" name="id_stage" value="<?=$quiz[0]['id_stage']?>">
    <input type="hidden" name="id_materi" value="<?=$quiz[0]['id_materi']?>">
    <input type="hidden" name="id_kelas" value="<?=$quiz[0]['id_kelas']?>">
    <input type="hidden" name="url" value="<?=uri_string().'?stage='.$this->input->get('stage').'&tipe=quiz&id_materi='.$this->input->get('id_materi')?>">
    <?php
    if (!empty($ket)) {?>
    <div class="row">
        <div class="form-group">
            <div class="col-md-6">
                <small><?=$ket?></small>
            </div>
            <div class="col-md-6 autosized" align="right">
                <?php
                if (!empty($nilai) and $nilai!=0) {
                    echo "<label class=\"label label-success\" title=\"Dinilai oleh : $nama_guru\">Nilai : $nilai</label>";
                }else{
                    echo "<label class=\"label label-danger\">Belum Dinilai</label>";
                }?>
                
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="form-group">
        <label>1. <?=$quiz[0]['pertanyaan_pg']?></label>
        <div class="input-group">
            <span class="input-group-addon"><input type="radio" name="jawaban_pg" value="A" <?php if ($jawaban_pg=="A") {echo "checked";}?> > A</span>
            <input type="text" class="form-control" value="<?=$quiz[0]['pg1']?>" readonly>
        </div>
        <div class="input-group">
            <span class="input-group-addon"><input type="radio" name="jawaban_pg" value="B" <?php if ($jawaban_pg=="B") {echo "checked";}?>> B</span>
            <input type="text" class="form-control" value="<?=$quiz[0]['pg2']?>" readonly>
        </div>
        <div class="input-group">
            <span class="input-group-addon"><input type="radio" name="jawaban_pg" value="C" <?php if ($jawaban_pg=="C") {echo "checked";}?>> C</span>
            <input type="text" class="form-control" value="<?=$quiz[0]['pg3']?>" readonly>
        </div>
        <div class="input-group">
            <span class="input-group-addon"><input type="radio" name="jawaban_pg" value="D" <?php if ($jawaban_pg=="D") {echo "checked";}?>> D</span>
            <input type="text" class="form-control" value="<?=$quiz[0]['pg4']?>" readonly>
        </div>
    </div>
    <div class="form-group">
        <label>2. <?=$quiz[0]['pertanyaan_isian']?></label>
        <textarea name="jawaban_isian" id="jawaban_isian" class="form-control" placeholder="Tuliskan jawaban kamu disini" rows="5"><?=$jawaban_isian?></textarea>
    </div>

    <div class="form-group">
        <label>3. Upload Tugas (optional)</label><br>
        <?php 
        if (empty($hasil_quiz)) {?>
        <span class="label label-danger">Besar file ≤ 3MB</span>
        <div class="fileupload fileupload-new" data-provides="fileupload">
            <div class="fileupload-new thumbnail" style="width:100%; padding:3px;color:red;font-style:italic">
                <?php if (!empty($upload_tugas)) {
                    echo $upload_tugas;
                }else{echo "Tidak ada file terpilih";} ?>
            </div>
            <div class="fileupload-preview fileupload-exists thumbnail" style="width:100%;padding: 6px;" ></div>

            <div></div>
            <span class="btn btn-default btn-file" style="left: 5px;">
                <span class="fileupload-new"><i class="fa fa-paper-clip"></i>Pilih File PDF</span>
                <span class="fileupload-exists">Ubah</span>
                <input type="file" id="inputPdf" onchange="cek_file('3MB','pdf','inputPdf')" class="default" name="inputPdf" accept=".pdf">
                </span>
            <span>
                <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i>&nbsp;Hapus&nbsp;</a>
            </span>
        </div>
        <?php }else{ 
        $appath = realpath(APPPATH . '../assets/tugas_siswa/'.$upload_tugas);
        if(!empty($upload_tugas) and file_exists($appath)){
            $file = base_url().'assets/tugas_siswa/'.$upload_tugas;
            echo "<a href=\"$file\" class=\"btn btn-success\" target=\"_blank\"><i class=\"fa fa-download\"></i> Download Tugas</a>";
        }else{?>
        <p style="color: red">Tidak Ada File</p>
        <?php }} ?>
    </div>
    <?php
    if (empty($hasil_quiz)) {
        echo "<div class=\"form-group\">
            <button type=\"submit\" class=\"btn btn-menu simpan\"><i class=\"fa fa-save\"></i> Submit</button>
        </div>";
    }?>
    
<?=form_close();?>

<?php }else{ 
    echo "<div align=\"center\" class=\"alert-notif alert-danger\" role=\"alert\" style=\"border:solid 1px;\">Belum ada Quiz</div>";
} ?>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $('#form-simpan').on('submit',  function(){
            if($('input[name=jawaban_pg]').is(':checked')==false || $('#jawaban_isian').val()==""){
                swal('Peringatan!', 'Silahkan jawab pertanyaan terlebih dahulu', 'error');
                $('.simpan').removeAttr("disabled");
                $(".simpan").html("<i class='fa fa-save'></i> Simpan");
                 return false;
            }
        });
    });
    
</script>