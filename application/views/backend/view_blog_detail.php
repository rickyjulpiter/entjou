<?php 
$CI =& get_instance();
if (!empty($data)) {
    $judul      = $data[0]['judul'];
    $isi        = $data[0]['isi'];
    $tags       = $data[0]['tags'];
    $foto       = $data[0]['foto'];    
    $publish    = $data[0]['publish'];
}else{
    $judul = $isi = $tags = $foto = $publish = "";
}?>
<?=form_open(uri_string(), array('class' =>'form-horizontal', 'id'=>'form-simpan', 'enctype' => 'multipart/form-data' ,'role' => 'form'));?>
<section class="panel panel-info">
    <header class="panel-heading">
        <?=$title?> 
        <span class="tools pull-right">
            <button type="button" class="btn btn-warning" onclick="window.location.href='<?=base_url().$this->uri->segment(1)?>'"><i class="fa fa-chevron-left"></i> Kembali</button>&nbsp
            <button class="btn btn-info simpan" type="submit"><i class="fa fa-save"></i> Simpan </button>
        </span>
    </header>
    <div class="panel-body">
        <?=validation_errors()?>
        <div class="col-md-12">            
            <div class="form-group">
                <div class="col-md-12">
                    <label>Judul</label>
                    <input type="hidden" name="id" value="<?=$this->uri->segment(3)?>">
                    <input type="text" class="form-control" name="judul" id="judul" value="<?=$CI->input('judul',$judul)?>" placeholder="Tulis judul postingan" autofocus="on">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">                    
                    <label>Tags</label>
                    <input type="text" class="form-control" name="tags" value="<?=$CI->input('tags',$tags)?>" placeholder="Gunakan tanda koma (,) jika > 2 tags">
                    
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
                    <textarea class="summernote" name="isi"><?=$CI->input('isi',$isi)?></textarea>
                </div>
            </div>
            
            <label>Foto Sampul</label>
            <div class="form-group">
                <div class="col-md-9">
                    <div class="img-container">
                        <img id="image" src="<?php if(!empty($foto)){echo base_url().'assets/images/blog/'.$foto;}else{echo "";}?>" alt="Browse Gambarmu">
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

<script type="text/javascript">
    $(document).ready(function(){        
        cropper(1,2.2);

        $('#judul').on('keyup', function(){
            this.value = this.value.ucwords();
        });
        $('.summernote').summernote({
            height:"500px",
            placeholder:"Tulis Postigan Blog Disini...",
            toolbar: [
                // [groupName, [list of button]]
                ['para', ['style', 'ul', 'ol', 'paragraph', 'height',]],
                ['fontsize', ['fontsize']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript', 'fontname']],
                ['misc', ['undo', 'redo', 'print', 'help', 'fullscreen', 'codeview']],
                ['insert', ['picture', 'link', 'video', 'table', 'hr','lorem']]
              ],

            maximumImageFileSize: 2242880,
            callbacks: {
                onImageUpload: function(image) {
                    uploadImage(image[0]);
                },
                onMediaDelete : function(target) {
                    deleteImage(target[0].src);
                },
                onImageUploadError: function(msg){
                    swal('Peringatan','Ukuran file anda >2MB. Silahkan masukan ukuran yang lebih kecil','error');
                }

            }
        });


        function uploadImage(image) {
            var data = new FormData();
            data.append("image", image);
            $.ajax({
                url: "<?=site_url('blog/upload_image')?>",
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "POST",
                success: function(url) {
                    $('.summernote').summernote("insertImage", url);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function deleteImage(src) {
            $.ajax({
                data: {src : src},
                type: "POST",
                url: "<?=site_url('blog/delete_image')?>",
                cache: false,
                success: function(response) {
                    console.log(response);
                }
            });
        }
    });
</script>