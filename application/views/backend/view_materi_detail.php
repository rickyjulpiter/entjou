<?php 
$CI =& get_instance();
$id_kelas   = $this->input->get('id_kelas');
$nama_kelas = $this->input->get('nama_kelas');
$id_stage   = $this->input->get('id_stage');
$nama_stage = $this->input->get('nama_stage');

if (!empty($data)) {
    $id_materi      = $data[0]['id_materi'];
    $jenis          = $data[0]['jenis'];
    $judul_materi   = $data[0]['judul_materi'];
    $file_materi    = $data[0]['file_materi'];
    $detail_materi  = $data[0]['detail_materi'];

}else{
    $id_materi = $jenis = $judul_materi = $file_materi = $berkas = $detail_materi = "";
}?>

<style type="text/css">
    #progress{position: relative;width: 400px; border: 1px solid #ddd;padding: 1px;border-radius: 3px}
    #bar{background-color: #B4F5B4; width: 0%; height: 20px; border-radius: 3px;}
    #percent{text-align: center;font-weight: bold;}
    .hide{display: none;}
    .thumbnail{width:100%;color:red;font-style:italic}
    .fileupload-exists{width:100%;padding: 6px;}
    .btn-file{left: 5px;}
    .btn-hapus{float: left;width: 75px;}
    #proses{color:red;font-weight:bold}
    #selesai{color:green;font-weight:bold}
    #canvas_container {width: 100%;height: 650px;overflow: auto;background: #333;text-align: center;border: solid 3px;}
    #canvas_container::-webkit-scrollbar {background-color:#fff;width:16px}
    #canvas_container::-webkit-scrollbar-track {background-color:#fff}
    #canvas_container::-webkit-scrollbar-track:hover {background-color:#f4f4f4}
    #canvas_container::-webkit-scrollbar-thumb {background-color:#babac0;border-radius:16px;border:5px solid #fff;}
    #canvas_container::-webkit-scrollbar-thumb:hover {background-color:#a0a0a5;border:4px solid #f4f4f4;}
    #canvas_container::-webkit-scrollbar-button {display:none}
    #navigation_controls{padding: 10px;text-align: center;}
</style>
<script src="<?=base_url().'assets/backend/js/jquery.form.js'?>"></script> 
<?=form_open(uri_string(), array('class' =>'form-horizontal', 'id'=>'form-simpan', 'enctype' => 'multipart/form-data' ,'role' => 'form'));?>
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
        <div class="col-md-12">
            <div class="hr-sect"><b>Materi</b></div>
            <div class="form-group">
                <div class="col-md-6">
                    <label>Kelas</label>
                    <select class="form-control select2" name="kelas" id="kelas" required>
                        <option value="">-Pilih-</option>
                        <?php 
                        foreach ($kelas as $key => $value) {
                            if ($this->encrypt->decode($id_kelas)==$value['id_kelas']) {
                                $selected = "selected";
                            }else{
                                $selected = "";
                            }
                            echo "<option value='".$value['id_kelas']."#".$value['nama_kelas']."' $selected>".$value['nama_kelas']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Stage</label>
                    <select class="stage form-control" id="stage" name="stage" required>
                        <option value="<?=$this->encrypt->decode($id_stage).'#'.$nama_stage?>"><?=$nama_stage?></option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <!-- judul dan jenis file -->
                    <label>Judul</label>
                    <input type="hidden" name="id_materi" value="<?=$id_materi?>">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="judul_materi" id="judul_materi" value="<?=$CI->input('judul_materi',$judul_materi)?>" placeholder="Tulis judul materi" autofocus="on" required>
                        </div>
                        <div class="col-md-6">
                            <?php $ar_jenis = array('no_exist'=> 'Tidak Ada File', 'pdf'=> 'PDF','video'=>'Video'); ?>
                            <select class="form-control" id="jenis" name="jenis" required>
                                <option value="">-Pilih Jenis Materi-</option>
                                <?php 
                                foreach ($ar_jenis as $key => $value) {
                                    if ($jenis==$key) {
                                        $selected = "selected";
                                    }else{
                                        $selected = "";
                                    }
                                    echo "<option value='$key' $selected>".$value."</option>";
                                }?>
                            </select>
                        </div>
                    </div> <br>
                    <!-- Detail materi -->
                    <label>Detail Materi</label>
                    <textarea class="summernote" name="detail_materi"><?=$CI->input('detail_materi',$detail_materi)?></textarea>
                </div>
                <div class="col-md-6">
                    <!-- input file pdf -->
                    <div class="form-group" id="pdf">
                        <div class="col-md-12">
                            <span class="label label-danger ">Besar file ≤ 2MB</span>
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail">
                                    <?php if (!empty($data)) {
                                        echo $file_materi;
                                    }else{echo "Tidak ada file terpilih";} ?>
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail"></div>

                                <span class="btn btn-default btn-file">
                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i>Pilih File PDF</span>
                                    <span class="fileupload-exists"><i class="fa fa-pencil"></i> Ubah</span>
                                    <input type="file" id="inputPdf" onchange="cek_file('2MB','pdf','inputPdf')" class="default" name="inputPdf" accept=".pdf">
                                </span>
                                <span class="btn-hapus">
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i>&nbsp;Hapus&nbsp;</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- input file pdf -->
                    <!-- input file video -->
                    <div class="form-group" id="video">
                        <div class="col-md-12">
                            <span class="label label-danger ">Besar file ≤ 2GB</span>
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail">
                                    <?php if (!empty($data)) {
                                        echo $file_materi;
                                    }else{echo "Tidak ada file terpilih";} ?>
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail"></div>

                                <span class="btn btn-default btn-file">
                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i>Pilih File Video</span>
                                    <span class="fileupload-exists">Ubah</span>
                                    <input type="file" onchange="cek_file('2GB','video','inputVideo')" id="inputVideo" name="inputVideo" accept=".3gp,.mp4,.flv,.wmv,.ogg,.webm,.mpeg,.mpg">
                                    </span>
                                <span class="btn-hapus">
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i>&nbsp;Hapus&nbsp;</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- input file video -->
                    <div id="progress-bar">
                        <div id="percent">0%</div>
                        <div class="progress">
                            <progress value="0" max="100" id="progress" class="hide"></progress>
                            <div id="bar"></div>
                        </div>
                        <div id="pesan"></div>
                    </div>
                    <?php 
                    if (!empty($data)) {
                        if ($jenis=="pdf") {
                            echo "<div id='navigation_controls'>
                                <button type='button' id='prevbutton' class='btn btn-default btn-sm'>Prev</button>&nbsp
                                <button type='button' id='nextbutton' class='btn btn-default btn-sm'>Next</button>&nbsp
                                <span>Page: <span id='page_num'></span> / <span id='page_count'></span></span>
                                &nbsp
                                <button type='button' id='zoominbutton' class='btn btn-default btn-sm'><i class='fa fa-plus'></i></button>&nbsp
                                <button type='button' id='zoomoutbutton' class='btn btn-default btn-sm'><i class='fa fa-minus'></i></button>
                            </div>
                            <div id='canvas_container'>
                                <canvas id='pdf_renderer'></canvas>
                            </div>";
                        }elseif ($jenis=="video") {
                            $berkas = base_url().'assets/materi/'.$file_materi;
                            echo "<video width=\"100%\" height=\"300\" controlslist=\"nodownload\" loop video controls ><source src=\"$berkas\" type=\"video/mp4\"></video>";
                        }
                    }?>
                </div>
            </div>

        </div>
    </div>
</section>
<?php
$data = file_get_contents("./assets/materi/$file_materi");
?>
<textarea style="display: none;" id="base64-pdf"><?=base64_encode($data)?></textarea>
<?=form_close();?>

<script type="text/javascript">
    $(document).ready(function(){
        var upload_materi = {
            beforeSend: function(){
                $("#progress").show();
                $("#progress-bar").show();
                $("#bar").width("0%");
                $("#pesan").html("");
                $("#percent").html("0%");
            },
            uploadProgress: function(event, position, total, percentComplete){
                $("#bar").width(percentComplete+"%");
                $("#percent").html(percentComplete+"%");
                $("#pesan").html("<center id='proses'> <i class='fa fa-spinner fa-spin'></i> Sedang Proses Unggah <i class='fa fa-spinner fa-spin'></i></center>");
            },
            success: function(){
                $("#bar").width("100%");
                $("#percent").html("100%");
                $("#pesan").html("<center id='selesai'><i class='fa fa-check'></i> Proses Unggah berhasil. Harap Tunggu <i class='fa fa-check'></i></center>");
                window.location.assign("<?=base_url('materi')?>");
            }
        };
    });
</script>


<script type="text/javascript">
    $(document).ready(function(){        
        cropper(1,1);
        $('#judul_materi').on('keyup', function(){
            this.value = this.value.ucwords();
        });
        $('#progress-bar').hide();
        <?php 
        if (empty($data)) {?>
        $('#form-simpan').on('submit', function(){
            var jenis = $('#jenis').val();
            if (jenis!="tidak ada file") {
                if (jenis=="pdf") {
                    if ($('#inputPdf').val()=="") {
                        swal('Peringatan !','Silahkan masukan file materi', 'error');
                        $('.simpan').removeAttr("disabled");
                        $(".simpan").html("<i class='fa fa-save'></i> Simpan");
                        return false;
                    }else{
                        $("#form-simpan").ajaxForm(upload_materi);
                    }
                }else if(jenis=="video"){
                    if ($('#inputVideo').val()=="") {
                        swal('Peringatan !','Silahkan masukan file materi', 'error');
                        $('.simpan').removeAttr("disabled");
                        $(".simpan").html("<i class='fa fa-save'></i> Simpan");
                        return false;
                    }else{
                        $("#form-simpan").ajaxForm(upload_materi);
                    }
                }
            }
        });
        <?php } ?>
        if ($('#jenis').val()=="pdf") {
            $('#pdf').show();
            $('#video').hide();
            
        }else if($('#jenis').val()=="video"){
            $('#pdf').hide();
            $('#video').show();
        }else{
            $('#pdf').hide();
            $('#video').hide();
        }
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
                url: "<?=site_url('materi/upload_image')?>",
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
                url: "<?=site_url('materi/delete_image')?>",
                cache: false,
                success: function(response) {
                    console.log(response);
                }
            });
        }

        $('#jenis').on('change', function(){
            if ($(this).val()=="pdf") {
                $('#pdf').show();
                $('#video').hide();
            }else if($(this).val()=="video"){
                $('#pdf').hide();
                $('#video').show();
            }else{
                $('#pdf').hide();
                $('#video').hide();
            }
        });        
        $('#kelas').on('change', function(){
            var kelas       = $(this).val();
            var id_kelas    = kelas.split("#")[0];
            $.ajax({
                url: "<?=base_url();?>materi/get_stage",
                method: "POST",
                data: {id_kelas:id_kelas},
                async: false,
                dataType: 'json',
                success: function(data){
                    var html = '';
                    var i;
                    if (data.length==0) {
                        swal("Peringatan !","Silahkan isi Stage pada kelas ini","error");
                        $('.stage option').remove();
                    }else{
                        for(i=0; i<data.length; i++){
                            html += '<option value="'+data[i].id_stage+'#'+data[i].nama_stage+'">'+data[i].nama_stage+'</option>';
                        }
                        $('.stage').html(html);
                    }
                }
            });
        });
        
    });
</script>

<?php 
if ($jenis=="pdf") {?>
<script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
<script type="text/javascript">
    var pdfData = atob($('#base64-pdf').val());
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://mozilla.github.io/pdf.js/build/pdf.worker.js';
    var pdfDoc         = null;
    var pdfScale       = 0.8; 
    var pageNum        = 1;
    var pageRendering  = false;
    var pageNumPending = null;
    canvas = document.getElementById('pdf_renderer');
    ctx = canvas.getContext('2d'); 

    function renderPage(num) {
        pageRendering = true;
        // Using promise to fetch the page
        pdfDoc.getPage(num).then(function(page) {
            var viewport = page.getViewport({scale: pdfScale});
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            // Render PDF page into canvas context
            var renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };
            var renderTask = page.render(renderContext);
            // Wait for rendering to finish
            renderTask.promise.then(function() {
                pageRendering = false;
                if (pageNumPending !== null) {
                    // New page rendering is pending
                    renderPage(pageNumPending);
                    pageNumPending = null;
                }
            });
        });
        // Update page counters
        document.getElementById('page_num').textContent = num;
    }

    function queueRenderPage(num) {
        if (pageRendering) {
            pageNumPending = num;
        } else {
            renderPage(num);
        }
    }

    $(document).ready(function(){
        $('#nextbutton').on('click', function(){
            if (pageNum >= pdfDoc.numPages) {
               return;
            }
            pageNum++;
            queueRenderPage(pageNum);
        });
        $('#prevbutton').on('click', function(){
            if (pageNum <= 1) {
               return;
            }
            pageNum--;
            queueRenderPage(pageNum);
        });
        $('#zoominbutton').on('click', function(){
            pdfScale = pdfScale + 0.25;
            queueRenderPage(pageNum);
            $('#canvas_container').scrollLeft (($('#canvas_container').width()/2 + $('#canvas_container').width())/2);
        });
        $('#zoomoutbutton').on('click', function(){
            if (pdfScale <= 0.25) {
               return;
            }
            pdfScale = pdfScale - 0.25;
            queueRenderPage(pageNum);
            $('#canvas_container').scrollLeft (($('#canvas_container').width()/2 + $('#canvas_container').width())/2);
        });
    });
    pdfjsLib.getDocument({data:pdfData}).promise.then(function(pdfDoc_) {
        pdfDoc = pdfDoc_;
        document.getElementById('page_count').textContent = pdfDoc.numPages;
        // Initial/first page rendering
        renderPage(pageNum);
    });
</script>

<?php }?>

