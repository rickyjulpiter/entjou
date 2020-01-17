<?php 
$CI =& get_instance();
$id_materi = $this->encrypt->decode($this->input->get('id_materi'));
$materi    = $CI->get('_materi',$id_materi);
$id_siswa = $this->encrypt->decode($this->session->userdata('id_user'));
if ($id_siswa=="") {
    $project = "";
}else{
    $project = $CI->get('agenda',$id_materi,$id_siswa);
}
if (!empty($project)) {
    $title      = $project[0]['title'];
    $deskripsi  = $project[0]['deskripsi'];
    $tanggal    = Tools::tgl_indo($project[0]['start'],'d-m-Y');
}else{
    $title = $deskripsi = $tanggal = "";
}
?>

<?=form_open(base_url().'home/project_add', array('class' =>'form-horizontal', 'id'=>'form-simpan', 'enctype' => 'multipart/form-data' ,'role' => 'form'));?>

    <input type="hidden" name="url" value="<?=uri_string().'?stage='.$this->input->get('stage').'&tipe=project&id_materi='.$this->input->get('id_materi')?>">
    <input type="hidden" name="id_materi" value="<?=$materi[0]['id_materi']?>">
    <input type="hidden" name="judul_materi" value="<?=$materi[0]['judul_materi']?>">
    <?=$this->session->flashdata('notif')?>
    <hr>
    <b>Project</b>
    <div class="form-group">
        <label>Kegiatan yang akan dilakukan</label>
        <textarea class="form-control" name="title" placeholder="Tuliskan kegiatan yang akan kamu lakukan"><?=$title?></textarea>
    </div>
    <div class="form-group">
        <label>Deskripsi kegiatan</label>
        <textarea class="form-control" name="deskripsi" rows="5" placeholder="Deskripsikan kegiatan kamu disini"><?=$deskripsi?></textarea>
    </div>
    <div class="form-group">
        <label>Deadline</label>
        <input type="text" name="start" class="form-control tanggal" placeholder="dd-mm-yyyy" value="<?=$tanggal?>" readonly>
    </div>
    <div class="form-group">
        <i>Kegiatan yang dibuat akan muncul di agenda kamu</i>
    </div>
    <div class="form-group">
        <?php 
        if (empty($project)) {
            echo "<button class=\"btn btn-menu\"><i class=\"fa fa-save\"></i> Submit</button>";
        }else{
            $url = base_url().'siswa/agenda';
            echo "<a href=\"$url\" class=\"btn btn-menu\" target=\"_blank\"><i class=\"fa fa-eye\"></i> Lihat Agenda</a>";
        }?>
        
    </div>

<?=form_close()?>