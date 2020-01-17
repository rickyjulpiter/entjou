<?php 
$CI =& get_instance();
if (!empty($data)) {
    $judul      = $data[0]['judul'];
    $deskripsi  = $data[0]['deskripsi'];    
    $foto       = $data[0]['foto'];    
    $publish    = $data[0]['publish'];
}else{
    $judul = $deskripsi = $foto = $publish = "";
}?>
<?=form_open(uri_string(), array('class' =>'form-horizontal', 'id'=>'form-simpan', 'enctype' => 'multipart/form-data' ,'role' => 'form'));?>
<section class="panel panel-info">
    <header class="panel-heading">
        <?=$title?> 
        <span class="tools pull-right">
            <button type="button" class="btn btn-warning" onclick="window.location.href='<?=base_url().$this->uri->segment(1)?>'"><i class="fa fa-chevron-left"></i> Kembali</button>&nbsp
            <button class="btn btn-info simpan" type="submit"><i class="fa fa-check"></i> Simpan </button>
        </span>
    </header>
    <div class="panel-body">
        <?=validation_errors()?>
        <div class="col-md-12">            
            <div class="form-group">
                <div class="col-md-6">
                    <label>Judul</label>
                    <input type="hidden" name="id" value="<?=$this->uri->segment(3)?>">
                    <input type="text" class="form-control" name="judul" value="<?=$CI->input('judul',$judul)?>" placeholder="Tulis judul postingan" autofocus="on">
                </div>
                <div class="col-md-6">                    
                    <label>Tampilkan ke Publik</label>
                    <select class="form-control" name="publish">
                        <option value="Y" <?php if($this->input->post('publish')=="Y"){echo "selected";}elseif (!empty($publish) AND $publish=="Y"){echo "selected";} ?>>Ya</option>
                        <option value="N" <?php if($this->input->post('publish')=="N"){echo "selected";}elseif (!empty($publish) AND $publish=="N"){echo "selected";} ?>>Tidak</option>
                    </select> 
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <textarea class="summernote" name="deskripsi"><?=$CI->input('deskripsi',$deskripsi)?></textarea>
                </div>
            </div>
            
            <label>Foto Slider</label>
            <div class="form-group">
                <div class="col-md-9">
                    <div class="img-container">
                        <img id="image" src="<?php if(!empty($foto)){echo base_url().'assets/images/slider/'.$foto;}else{echo "";}?>" alt="Browse Gambarmu">
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
                                <input name="covers" type="hidden" value="<?php if (!empty($foto)) {echo $foto;}?>"></input>
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
    </div>
</section>

<script type="text/javascript" src="<?=base_url('assets/backend/js/cropper.min.js');?>"></script>

<script type="text/javascript">
    $(document).ready(function(){        
        cropper(1,2.44);        
        $('.summernote').summernote({
            height:"200px",
            placeholder:"Tulis Deskripsi Slider Disini..."
        });
        $('.note-insert').css('display','none');
    });
</script>