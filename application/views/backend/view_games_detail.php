<?php 
$CI =& get_instance();
$id_kelas   = $this->encrypt->decode($this->input->get('id_kelas'));
$nama_kelas = $this->input->get('nama_kelas');
$id_stage   = $this->encrypt->decode($this->input->get('id_stage'));
$nama_stage = $this->input->get('nama_stage');
$id_materi  = $this->encrypt->decode($this->input->get('id_materi'));
if (!empty($data)) {
    $id_games       = $data[0]['id_games'];
    $judul_games    = $data[0]['judul_games'];
    $file_games     = $data[0]['file_games'];
    $detail_games   = $data[0]['detail_games'];
}else{    
    $id_games = $judul_games = $file_games = $detail_games = "";
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
            <button class="btn btn-info simpan" type="submit"><i class="fa fa-save"></i> Simpan </button>
        </span>
    </header>
    <div class="panel-body">
        <?=validation_errors()?>
        <!-- --------------- start games ---------------- -->
        <div class="col-md-12">
            <div class="hr-sect">Games</div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Nama Kelas</label>                                    
                    <input type="text" class="form-control" name="nama_kelas" value="<?=$CI->input('nama_kelas',$nama_kelas)?>" readonly>
                    <br>
                    <label>Nama Stage</label>                                    
                    <input type="text" class="form-control" name="nama_stage" value="<?=$CI->input('nama_stage',$nama_stage)?>" readonly>
                    <br>
                    <input type="hidden" name="id_games" value="<?=$CI->input('id_games',$id_games)?>">
                    <label>Judul Game</label>
                    <input type="text" id="judul_games" name="judul_games" class="form-control" placeholder="Judul Games" value="<?=$CI->input('judul_games',$judul_games)?>" required>
                </div>
                <div class="col-md-6">
                    <label>Detail game</label>
                    <textarea class="summernote" name="detail_games"><?=$CI->input('detail_games',$detail_games)?></textarea>
                </div>
            </div>
            <label>Foto Games</label>
            <div class="form-group">
                <div class="col-md-9">
                    <div class="img-container">
                        <img id="image" src="<?php if(!empty($file_games)){echo base_url().'assets/games/'.$file_games;}else{echo "";}?>" alt="Browse Gambarmu">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="img-preview preview-lg"></div>
                    </div>
                    <div class="form-group text-center">
                        <div class="btn-group">
                            <button class="btn btn-primary tooltips" data-original-title="Zoom In" data-toggle="tooltip" data-placement="top" title="" id="zoomIn" type="button"><i class="fa fa-search-plus"></i></button>
                            <button class="btn btn-primary tooltips" data-original-title="Zoom Out" data-toggle="tooltip" data-placement="top" title="" id="zoomOut" type="button"><i class="fa fa-search-minus"></i></button>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-primary tooltips" data-original-title="Rotate Left" data-toggle="tooltip" data-placement="top" title="" id="rotateLeft" type="button"><i class="fa fa-rotate-left"></i></button>
                            <button class="btn btn-primary tooltips" data-original-title="Rotate Right" data-toggle="tooltip" data-placement="top" title="" id="rotateRight" type="button"><i class="fa fa-rotate-right"></i></button>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-primary tooltips" data-original-title="Flip Horizontal" data-toggle="tooltip" data-placement="top" title="" id="fliphorizontal" type="button"><i class="fa fa-arrows-h"></i></button>
                            <button class="btn btn-primary tooltips" data-original-title="Flip Vertical" data-toggle="tooltip" data-placement="top" title="" id="flipvertical" type="button"><i class="fa fa-arrows-v"></i></button>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <div class="btn-group">
                        <label class="btn btn-danger" for="inputImage" title="Upload image file">
                            <span data-toggle="tooltip" data-animation="false" title="Pilih Gambar">
                                <input name="covers" type="hidden" value="<?php if (!empty($file_games)) {echo $file_games;}?>"></input>
                                <input name="cover" onchange="cek_file('2MB','image','inputImage')" type="file" class="sr-only" id="inputImage" accept=".jpg,.jpeg,.png,.bmp">
                                <span class="fa fa-upload"></span> Browse
                            </span>
                        </label>
                        <button class="btn btn-danger tooltips" data-original-title="Reset" data-toggle="tooltip" data-placement="top" title="" id="reset" type="button"><i class="fa fa-refresh"></i> Reset</button>
                    </div>
                    <div style="margin-top: 20px">
                        <button class="btn btn-success simpan" type="submit"><i class="fa fa-save"></i> Simpan </button>
                    </div>
                </div>
                <input type="hidden" id="dataX" name="x">
                <input type="hidden" id="dataY" name="y">
                <input type="hidden" id="dataWidth" name="width">
                <input type="hidden" id="dataHeight" name="height">
                <input type="hidden" id="dataRotate" name="rotate">
                <input type="hidden" id="dataScaleX" name="flipx">
                <input type="hidden" id="dataScaleY" name="flipy">
            </div>
        </div>
        <!-- --------------- end games ---------------- -->
        <!-- --------------- start quiz ---------------- -->
    </div>
</section>
<?=form_close();?>

<script type="text/javascript" src="<?php echo base_url('assets/backend/js/cropper.min.js');?>"></script>

<script type="text/javascript">
    $(document).ready(function(){        
        cropper(1,1);
        $('#judul_games').on('keyup', function(){
            this.value = this.value.ucwords();
        });
        <?php 
        if (empty($data)) {?>
        $('#form-simpan').on('submit', function(){
            if ($('#inputImage').val()=="") {
                swal('Peringatan !','Silahkan masukan file games', 'error');
                $('.simpan').removeAttr("disabled");
                $(".simpan").html("<i class='fa fa-save'></i> Simpan");
                return false;
            }
        });        
        <?php } ?>
        $('.summernote').summernote({
            height:"200px",
            placeholder:"Tulis Detail Disini..."
        });
        $('.note-insert').css('display','none');
    });
</script>