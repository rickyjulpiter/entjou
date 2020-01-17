<style type="text/css">
    viewer-pdf-toolbar #buttons{display: none !important;}
</style>
<?php 
$CI =& get_instance();
$id_materi = $this->encrypt->decode($this->input->get('id_materi'));
$materi = $CI->get('_materi',$id_materi);
?>
<div class="col-md-8" oncontextmenu="return false;">
    <?php 
    if (!empty($materi)) {?>
    <h3><span id="judul_materi"><?=$materi[0]['judul_materi']?></span></h3>
    <?php 
    $file_materi = $materi[0]['file_materi'];
    $jenis       = $materi[0]['jenis'];
    $ada         = file_exists(realpath(APPPATH . '../assets/materi/'.$file_materi));
    
    if(!empty($file_materi) and $ada) {
        if ($jenis=="pdf") {
            $file = file_get_contents("./assets/materi/".$file_materi);
            $berkas = "data:application/pdf;base64,".$file;
            echo "<embed type=\"application/pdf\" id=\"file_pdf\" src=\"\" width=\"100%\" height=\"800\">";
        }elseif ($jenis=="video") {
            $berkas = base_url().'assets/materi/'.$file_materi;
            echo "<video width=\"100%\" height=\"300\" controlslist=\"nodownload\" loop video controls ><source src=\"$berkas\" type=\"video/mp4\"></video>";
        }
    }else{
        $berkas = base_url().'assets/materi/no-image.jpg';
        echo "<center><img src='$berkas></center>";
                                                
    }?>
    <div id="detail" style="text-align: justify;"><?=$materi[0]['detail_materi']?></div>
    <?php }else{ 
        echo "<div align=\"center\" class=\"alert-notif alert-danger\" role=\"alert\" style=\"border:solid 1px;\">Belum ada materi</div>";
    } ?>

</div>

<script type="text/javascript">
    $('#file_pdf').attr('src','<?=$berkas?>');
</script>