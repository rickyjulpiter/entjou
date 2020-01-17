<?php 
$CI =& get_instance();
$id_materi = $this->encrypt->decode($this->input->get('id_materi'));
$materi = $CI->get('_materi',$id_materi);
?>

<?php 
if (!empty($materi)) {?>
<?php 
$file_materi = $materi[0]['file_materi'];
$jenis       = $materi[0]['jenis'];
$ada         = file_exists(realpath(APPPATH . '../assets/materi/'.$file_materi));
if(!empty($file_materi) and $ada) {
    if ($jenis=="pdf") {
        echo "<div id='navigation_controls'>
            <button id='prevbutton' class='btn btn-default btn-sm'>Prev</button>&nbsp
            <button id='nextbutton' class='btn btn-default btn-sm'>Next</button>&nbsp
            <span>Page: <span id='page_num'></span> / <span id='page_count'></span></span>
            &nbsp
            <button id='zoominbutton' class='btn btn-default btn-sm'><i class='fa fa-plus'></i></button>&nbsp
            <button id='zoomoutbutton' class='btn btn-default btn-sm'><i class='fa fa-minus'></i></button>
        </div>
        <div id='canvas_container'>
            <canvas id='pdf_renderer'></canvas>
        </div>";
    }elseif ($jenis=="video") {
        $berkas = base_url().'assets/materi/'.$file_materi;
        echo "<video width=\"100%\" height=\"300\" controlslist=\"nodownload\" loop video controls ><source src=\"$berkas\" type=\"video/mp4\"></video>";
    }
}else{
    $berkas = base_url().'assets/materi/no-image.jpg';
    echo "<div align=\"center\" class=\"alert-notif alert-info\" role=\"alert\" style=\"border:solid 1px;\">File materi tidak ditemukan</div>";
                                            
}?>
<hr>
<div style="text-align: justify !important;"><?=$materi[0]['detail_materi']?></div>
<?php }else{ 
    echo "<div align=\"center\" class=\"alert-notif alert-danger\" role=\"alert\" style=\"border:solid 1px;\">Belum ada materi</div>";
} ?>

<?php
if ($jenis=="pdf") {
    $data = file_get_contents("./assets/materi/$file_materi");
}
?>
<textarea style="display: none;" id="base64-pdf"><?=base64_encode($data)?></textarea>
<script type="text/javascript">
    var pdfData = atob($('#base64-pdf').val());
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://mozilla.github.io/pdf.js/build/pdf.worker.js';
    /*pdfjsLib.GlobalWorkerOptions.workerSrc = '<?=base_url('assets/frontend/js/pdf.worker.js')?>';*/

    var pdfDoc         = null;
    var pdfScale       = 1; 
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
</html>






