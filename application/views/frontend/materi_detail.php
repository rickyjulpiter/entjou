<!DOCTYPE html>
<html>
<head>
	<title><?=$title?> | Enterpreneur Journey</title>
    <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.png');?>" type="image/png">
	<link rel="stylesheet" href="<?=base_url('assets/frontend/css/bootstrap.min.css')?>">
	<link href="<?=base_url('assets/backend/fonts/css/font-awesome.min.css')?>" rel="stylesheet">
	 <link rel="stylesheet" href="<?=base_url('assets/frontend/css/select2.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/frontend/css/style.css')?>">
    <link href="<?=base_url('assets/backend/css/bootstrap-fileupload.min.css')?>" rel="stylesheet">
    <link href="<?=base_url('assets/backend/css/style-materi.css')?>" rel="stylesheet">
    <link href="<?=base_url('assets/backend/css/sweetalert2.min.css') ?>" rel="stylesheet" type="text/css" >
	<script src="<?=base_url('assets/backend/js/jquery.min.js')?>"></script>
    <script src="<?=base_url('assets/backend/js/jquery-ui-1.9.2.custom.min.js')?>"></script>
    <script src="<?=base_url('assets/backend/js/pdfobject.js')?>"></script>
	<script src="<?=base_url('assets/frontend/js/bootstrap.min.js')?>" type="text/javascript"></script>
	<script src="<?=base_url('assets/frontend/js/select2.min.js')?>" type="text/javascript"></script>
    <script type="text/javascript" src="<?=base_url('assets/backend/js/sweetalert2.min.js'); ?>" async></script>
    <script src="<?=base_url('assets/backend/js/bootstrap-fileupload.min.js')?>"></script>
    <!-- <script src="<?=base_url('assets/frontend/js/pdf.js')?>"></script> -->
    <script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
	
	<script type="text/javascript">
		$(document).ready(function(){
            $('.tanggal').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy',
                reverseYearRange: false,
                yearRange: '-70:+0'
            });
			$('#kontrol-kiri').on('click', function(){
				$('.left-panel').fadeOut('1500');
				$('.right-panel').css('width','100%');
				$('.footer').css('width','100%');
				$('#kontrol-kanan').show();
				$('#kontrol-kiri').hide();
                /*$('#topdiv').fadeIn();*/
                $('#topdiv').css('left','27px');
			});
			$('#kontrol-kanan').on('click', function(){
				$('.left-panel').fadeIn('1500');
				$('.right-panel').css('width','70%');
				$('.footer').css('width','70%');
				$('#kontrol-kanan').hide();
				$('#kontrol-kiri').show();
                $('#topdiv').css('left','420px');
			});
			$("#fullscreen").on('click', function(){
				var elem = document.documentElement;
				if (elem.requestFullscreen) {
					elem.requestFullscreen();
				} else if (elem.mozRequestFullScreen) { /* Firefox */
					elem.mozRequestFullScreen();
				} else if (elem.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
					elem.webkitRequestFullscreen();
				} else if (elem.msRequestFullscreen) { /* IE/Edge */
					elem.msRequestFullscreen();
				}
			});
			if ($('.select2').length) {
		        $('.select2').select2({
		            dropdownAutoWidth: true,
		            width: '100%'
		        });
		    }
		});
	</script>
</head>
<?php 
$CI =& get_instance();
$materi1 = $materi2 = $materi;
$kelas  = $this->model_admin->select_data('_kelas',null,array('id_kelas'=>$this->encrypt->decode($this->uri->segment(3))));
?>
<body>
    <div id="preloader"></div>
    <noscript class="noscript">
        <style>
             body { width:100%; height: 100%; overflow:hidden; }
         </style>
      <div id="javascript-notice">
        <i class="fa fa-warning fa-5x"></i>
        <h3>Silahkan untuk mengaktifkan javascript pada browser anda<br>Terima Kasih</h3>
      </div>
    </noscript>
	<div class="content">
		<div class="left-panel">
			<div class="judul">
				<h2><?=$stage[0]['nama_kelas']?></h2>
				<div class="button">
					<a href="<?=base_url()?>" class="btn btn-info"><i class="fa fa-home"></i></a>&nbsp
                    <a href="<?=base_url().$kelas[0]['slug']?>" class="btn btn-success">Kembali ke Lobi</a>
				</div>
			</div>
			<div class="panel-body">
				<div class="form-group">
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
				</div>
                <!-- Judul Materi -->
                <?php 
                if (!empty($materi1)) {
                foreach ($materi1 as $key => $value) {
                    if ($value['id_materi']==$this->encrypt->decode($this->input->get('id_materi'))) {
                        $aktif = "background:#fdc800";
                        $expand = "true";
                        $collapsed = "";
                        $in = "in";
                        if ($this->input->get('tipe')=="materi") {
                            $aktif_materi = "background:#5bc0de";
                            $aktif_games = $aktif_quiz = $aktif_project = "";
                        }elseif ($this->input->get('tipe')=="games") {
                            $aktif_games = "background:#5bc0de";
                            $aktif_materi = $aktif_quiz = $aktif_project = "";
                        }elseif ($this->input->get('tipe')=="quiz") {
                            $aktif_quiz = "background:#5bc0de";
                            $aktif_materi = $aktif_games = $aktif_project = "";
                        }elseif ($this->input->get('tipe')=="project") {
                            $aktif_project = "background:#5bc0de";
                            $aktif_materi = $aktif_quiz = $aktif_games = "";
                        }
                        
                    }else{
                        $aktif = "";
                        $expand = "false";
                        $collapsed = "collapsed";
                        $in = "";
                        $aktif_project = $aktif_materi = $aktif_quiz = $aktif_games = "";
                    }
                    $games = $CI->get('_games',$value['id_materi']);
                    $quiz  = $CI->get('_quiz',$value['id_materi']);
                    $project= $CI->get('agenda',$value['id_materi']);
                    ?>
				<div class="panel-group curriculum-wrapper" id="accordion">
                    <div class="panel panel-default" style="<?=$aktif?>">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a aria-expanded="<?=$expand?>" class="accordion-toggle <?=$collapsed?>" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=($key+1)?>">
                                    <ul>
                                        <li><i class="fa fa-book" aria-hidden="true"></i></li>
                                        <li title="<?=$value['judul_materi']?>"><?php
                                        if (strlen($value['judul_materi'])>=30) {
                                            echo Tools::limit_words(ucwords(strtolower($value['judul_materi'])),30).'....';
                                        }else{
                                            echo ucwords(strtolower($value['judul_materi']));
                                        }
                                        ?></li>
                                        <?php
                                        if ($value['selesai']=='Y') {
                                            echo "<li><i class='fa fa-eye'></i></li>";
                                        }?>
                                    </ul>
                                </a>
                            </div>
                        </div>
                        <div aria-expanded="<?=$expand?>" id="collapse<?=($key+1)?>" role="tabpanel" class="panel-collapse collapse <?=$in?>">
                            <div class="panel-body">
                                <table class="table table-stage">
                                    <tr style="<?=$aktif_materi?>">
                                        <td width="50"><i class="fa fa-laptop"></i></td>
                                        <td><a href="<?='?stage='.$value['id_stage'].'&tipe=materi&fm='.$this->encrypt->encode($value['file_materi']).'&id_materi='.$this->encrypt->encode($value['id_materi'])?>">Materi</a></td>
                                        
                                    </tr>

                                    <?php 
                                    if (!empty($games)) {?>
                                    <tr style="<?=$aktif_games?>">
                                        <td><i class="fa fa-puzzle-piece"></i></td>
                                        <td><a href="<?='?stage='.$value['id_stage'].'&tipe=games&fg='.$this->encrypt->encode($games[0]['file_games']).'&id_materi='.$this->encrypt->encode($value['id_materi'])?>">Games</a></td>
                                    </tr>
                                    <?php } ?>

                                    <?php if (!empty($quiz)) {?>
                                    <tr style="<?=$aktif_quiz?>">
                                        <td><i class="fa fa-bullhorn"></i></td>
                                        <td><a href="<?='?stage='.$value['id_stage'].'&tipe=quiz&id_materi='.$this->encrypt->encode($value['id_materi'])?>">Quiz</a></td>
                                    </tr>
                                    <?php } ?>

                                    <tr style="<?=$aktif_project?>">
                                        <td><i class="fa fa-rocket"></i></td>
                                        <td><a href="<?='?stage='.$value['id_stage'].'&tipe=project&id_materi='.$this->encrypt->encode($value['id_materi'])?>">Project</a></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }}else{ 
                    echo "<div align=\"center\" class=\"alert-notif alert-danger\" role=\"alert\" style=\"border:solid 1px;\">Belum ada materi</div>";
                }?>
                
                <!-- Judul Materi -->
			</div>
  		</div>
  		<div class="right-panel">
  			<div class="panel-body">
  				<div class="col-md-1">
                    <div id="">
      					<button type="button" class="btn btn-default" id="kontrol-kiri"><i class="fa fa-arrow-left"></i></button>
      					<button type="button" class="btn btn-default" id="kontrol-kanan" style="display: none;"><i class="fa fa-arrow-right"></i></button>&nbsp
      					<button type="button" id="fullscreen" class="btn btn-default"><i class="fa fa-arrows-alt"></i></button>
                    </div>
  				</div>
  				<div class="col-md-ofset-1 col-md-10">
                    <?php
                    $selesai = "";
                    if (!empty($materi)) {
                    $id_materi = $this->encrypt->decode($this->input->get('id_materi'));
                    $materi = $CI->get('_materi',$id_materi);
                    $selesai = $materi[0]['selesai'];
                    ?>
                    <h2><?=$materi[0]['judul_materi']?></h2>
                    <div class="row">
                        <div class="col-md-6" align="left"><i class="fa fa-tag"></i> Kategori : <?=$kelas[0]['kategori']?></div>
                        <div class="col-md-6" align="right"><i class="fa fa-user"></i> Oleh: <?=$materi[0]['nama_user']?></div>             
                    </div>
                    <?php } ?>
                    <!-- Konten materi, games, quiz, project -->
                    <?php $this->load->view($konten); ?>
                    <?php 
                    $id_materi = array_column($materi1, 'id_materi');
                    $index = array_search($this->encrypt->decode($this->input->get('id_materi')), $id_materi);
                    $end   = (sizeof($id_materi)-1);
                    ?>
  				</div>
  				
  			</div>
    		<div class="footer">
                <?php 
                if ($index!=0) {?>
        			<div class="col-md-4"><a href="<?=base_url().'home/materi_detail/'.$this->uri->segment(3).'?stage='.$this->input->get('stage').'&tipe='.$this->input->get('tipe').'&fm='.$this->input->get('fm').'&id_materi='.$this->encrypt->encode($id_materi[$index-1])?>">SESI SEBELUMNYA</a></div>
                <?php }else{ ?>
                    <div class="col-md-4">-</div>
                <?php } ?>


                <?php 
                if ($selesai!='Y') {
                    echo '<div class="col-md-4"><a href="#" id="materi_selesai">MATERI TERSELESAIKAN</a></div>';
                }else{
                    echo '<div class="col-md-4"><i class="fa fa-eye"></i></div>';
                }?>

    			<?php 
                if ($index<$end) {?>
                    <div class="col-md-4"><a href="<?=base_url().'home/materi_detail/'.$this->uri->segment(3).'?stage='.$this->input->get('stage').'&tipe='.$this->input->get('tipe').'&fm='.$this->input->get('fm').'&id_materi='.$this->encrypt->encode($id_materi[$index+1])?>">SESI BERIKUTNYA</a></div>
                <?php }else{ ?>
                    <div class="col-md-4">-</div>
                <?php } ?>
    		</div>
  		</div>
	</div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#preloader').fadeOut('slow', function() {
                $(this).remove();
            });
            $('#materi_selesai').on('click', function(){
                $.ajax({
                    url: '<?=site_url().'home/materi_selesai/'.$this->input->get('id_materi')?>',
                    success: function(data) {
                        swal('Berhasil','Materi Berhasil Diselesaikan','success');
                        location.reload();
                    }
                });
            });
        });
        document.addEventListener("contextmenu", function(e){
            e.preventDefault();
            swal('Peringatan!','Maaf konten dilindungi','error');
        }, false);
        document.onkeydown = function(e) {
            if(event.keyCode == 123) {
                swal('Peringatan!','Maaf konten dilindungi','error');
                return false;
            }if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
                swal('Peringatan!','Maaf konten dilindungi','error');
                return false;
            }if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
                swal('Peringatan!','Maaf konten dilindungi','error');
                return false;
            }
            if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
                swal('Peringatan!','Maaf konten dilindungi','error');
                return false;
            }
        }
    </script>
</body>
</html>






