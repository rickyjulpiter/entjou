<?php 
$CI =& get_instance();
$materi1 = $materi2 = $materi;
?>
<style type="text/css">
    #detail{margin-top: 15px;font-size: 18px;}
    #the-canvas{border: 3px solid #fdc800;width: 100%;padding: 5px;border-radius: 10px;}
</style>
<script src="<?=base_url().'assets/frontend/js/pdf.js'?>"></script>
<!-- <script src="<?=base_url().'assets/frontend/js/pdf-script.js'?>"></script> -->
<div class="courses-page-area5">
    <div class="container">
        <h2 class="sidebar-title"><?=$stage[0]['nama_kelas']?></h2>
        <div class="row">
            <div class="col-md-4">
                <form>
                    <div class="form-group">
                        <select class="form-control select2" name="stage" onchange="this.form.submit()">
                            <option value="">-Pilih-</option>
                            <?php 
                            foreach ($stage as $key => $value) {
                                if ($value['id_stage']==$this->input->get('stage')) {
                                    $selected = "selected";
                                }else{
                                    $selected = "";
                                }?>
                                <option value='<?=$value['id_stage']?>' <?=$selected?> > <?=$value['nama_stage']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </form>

                <div class="panel-group curriculum-wrapper" id="accordion">
                <?php 
                if (!empty($materi1)) {
                foreach ($materi1 as $key => $value) {
                    $games = $CI->get('_games',$value['id_materi']);
                    $quiz  = $CI->get('_quiz',$value['id_materi']);
                    $project= $CI->get('agenda',$value['id_materi']);
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a aria-expanded="false" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=($key+1)?>">
                                    <ul>
                                        <li><i class="fa fa-book" aria-hidden="true"></i></li>
                                        <li></li>
                                        <li title="<?=$value['judul_materi']?>"><?=Tools::limit_words(ucwords(strtolower($value['judul_materi'])),25)?>...</li>
                                        
                                    </ul>
                                </a>
                            </div>
                        </div>
                        <div aria-expanded="false" id="collapse<?=($key+1)?>" role="tabpanel" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table class="table table-stage">
                                    <tr>
                                        <td width="50"><i class="fa fa-laptop"></i></td>
                                        <td><a href="<?='?stage='.$value['id_stage'].'&tipe=materi&fm='.$this->encrypt->encode($value['file_materi']).'&id_materi='.$this->encrypt->encode($value['id_materi'])?>">Materi</a></td>
                                        
                                    </tr>

                                    <?php 
                                    if (!empty($games)) {?>
                                    <tr>
                                        <td><i class="fa fa-puzzle-piece"></i></td>
                                        <td><a href="<?='?stage='.$value['id_stage'].'&tipe=games&fg='.$this->encrypt->encode($games[0]['file_games']).'&id_materi='.$this->encrypt->encode($value['id_materi'])?>">Games</a></td>
                                    </tr>
                                    <?php } ?>

                                    <?php if (!empty($quiz)) {?>
                                    <tr>
                                        <td><i class="fa fa-bullhorn"></i></td>
                                        <td><a href="<?='?stage='.$value['id_stage'].'&tipe=quiz&id_materi='.$this->encrypt->encode($value['id_materi'])?>">Quiz</a></td>
                                    </tr>
                                    <?php } ?>

                                    <tr>
                                        <td><i class="fa fa-rocket"></i></td>
                                        <td><a href="<?='?stage='.$value['id_stage'].'&tipe=project&id_materi='.$this->encrypt->encode($value['id_materi'])?>">Project</a></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php }}else{ 
                    echo "<div align=\"center\" class=\"alert-notif alert-danger\" role=\"alert\" style=\"border:solid 1px;\">Belum ada materi</div>";
                }?>
                </div>
            </div>
            <!-- Konten materi, games, quiz, project -->
            <?php $this->load->view($konten); ?>
        </div>
    </div>
</div>
