<?php 
$CI =& get_instance();
if (!empty($data)) {
    $judul      = $data[0]['judul'];
    $id_kelas   = $data[0]['id_kelas'];
    $isi        = $data[0]['isi'];
    $kategori   = $data[0]['kategori'];
    $foto       = $data[0]['foto'];    
    $publish    = $data[0]['publish'];
}else{
    $id_kelas = $judul = $isi = $kategori = $foto = $publish = "";
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
                <div class="col-md-6" id="judul">
                    <label>Judul</label>
                    <input type="hidden" name="id" value="<?=$this->uri->segment(3)?>">
                    <input type="text" class="form-control" id="judul" name="judul" value="<?=$CI->input('judul',$judul)?>" placeholder="Tulis judul postingan" autofocus="on">
                </div>
                <div class="col-md-6" id="kelas">
                    <label>Kelas <?=$id_kelas?> </label>
                    <select class="form-control select2" name="kelas">
                        <option value="">-Pilih-</option>
                        <?php 
                        foreach ($kelas as $key => $value) {
                            if ($value['id_kelas']==$id_kelas) {
                                $selected = "selected";
                            }else{
                                $selected = "";
                            }
                            echo "<option value='".$value['id_kelas']."' $selected>".$value['nama_kelas']."</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">                    
                    <label>Kategori</label>                    
                    <select class="form-control" name="kategori">
                        <option value="kelas" <?php if($this->input->post('kategori')=="kelas"){echo "selected";}elseif (!empty($kategori) AND $kategori=="kelas"){echo "selected";} ?>>Kelas</option>
                        <option value="umum" <?php if($this->input->post('kategori')=="umum"){echo "selected";}elseif (!empty($kategori) AND $kategori=="umum"){echo "selected";} ?>>Umum</option>
                    </select> 
                    
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
                        <img id="image" src="<?php if(!empty($foto)){echo base_url().'assets/images/pengumuman/'.$foto;}else{echo "";}?>" alt="Browse Gambarmu">
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
        $('#judul').keyup(function(){
            this.value = this.value.ucwords();
        });
        $('.summernote').summernote({
            height:"500px",
            placeholder:"Tulis Pengumuman Disini..."
        });
        $('.note-insert').css('display','none');
        $('[name="kategori"]').on('change', function(){
            var kat = this.value;
            if (kat=='kelas') {
                $('#judul').removeClass('col-md-12');
                $('#judul').addClass('col-md-6');
                $('#kelas').show();
            }else{
                $('#judul').removeClass('col-md-6');
                $('#judul').addClass('col-md-12');
                $('#kelas').hide();
                
            }
        });
    });
</script>