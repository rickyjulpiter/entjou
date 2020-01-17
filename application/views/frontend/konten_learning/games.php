<?php 
$CI =& get_instance();
$id_materi = $this->encrypt->decode($this->input->get('id_materi'));
$materi = $CI->get('_materi',$id_materi);
$games = $CI->get('_games',$id_materi);
?>

    <?php 
    if (!empty($games)) {?>
    <hr>
    <center><b><?=$games[0]['judul_games']?></b></center>
    <?php 
    $file_games = $games[0]['file_games'];
    $ada = file_exists(realpath(APPPATH . '../assets/games/'.$file_games));
    if(!empty($file_games) and $ada) {
        $berkas = base_url().'assets/games/'.$file_games;
    }else{
        $berkas = base_url().'assets/materi/no-image.jpg';                                        
    }?>
    <img src="<?=$berkas?>" width="100%" class="img-responsive">
    <hr>
    <div style="text-align: justify;"><?=$games[0]['detail_games']?></div>
    <?php }else{ 
        echo "<div align=\"center\" class=\"alert-notif alert-danger\" role=\"alert\" style=\"border:solid 1px;\">Belum ada games</div>";
    } ?>
