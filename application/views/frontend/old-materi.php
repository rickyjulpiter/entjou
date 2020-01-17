<!DOCTYPE html>
<html>
<head>
	<title>Coba PDF</title>
	<link rel="stylesheet" href="<?=base_url('assets/frontend/css/bootstrap.min.css')?>">
	<link href="<?=base_url('assets/backend/fonts/css/font-awesome.min.css')?>" rel="stylesheet">
	 <link rel="stylesheet" href="<?=base_url('assets/frontend/css/select2.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/frontend/css/style.css')?>">
	<script src="<?=base_url('assets/backend/js/jquery.min.js')?>"></script>
    <script src="<?=base_url('assets/backend/js/pdfobject.js')?>"></script>
	<script src="<?=base_url('assets/frontend/js/bootstrap.min.js')?>" type="text/javascript"></script>
	<script src="<?=base_url('assets/frontend/js/select2.min.js')?>" type="text/javascript"></script>
	<script src="<?=base_url('assets/frontend/js/main.js')?>" type="text/javascript"></script>
    <script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
	<style type="text/css">
		html, body {max-width: 100%;overflow-y: hidden;overflow-x: hidden;}
		body{width:100%;height:100%;margin: 0;}
		.header{background:black;color:#fff;}
		.left-panel{overflow-y: scroll;float:left;width:30%;height:calc(106vh - 40px);}
		.right-panel{overflow-y: scroll;height:calc(106vh - 40px);float:right;width:70%;padding-bottom: 50px;}
		.footer{background:white;position:fixed;bottom:0;width:70%;height: 8%;text-align: center;padding: 15px;font-weight: bold;border-top: 1px solid;font-size: 14px;}
		.content > div{display:inline-block;vertical-align:top;}
		.content{clear:both;height: 100%}
		.judul{padding: 20px 25px 20px 25px;background: #fdc800;}
		.judul h2{line-height: 35px}
		.button{text-align: right;}
		.curriculum-wrapper{border: 1px solid;}
        .table-stage a{font-weight: 500;color: #212121;}
        
        #canvas_container {width: 100%;height: 800px;overflow: auto;background: #333;text-align: center;border: solid 3px;}
        #canvas_container::-webkit-scrollbar {background-color:#fff;width:16px}
        #canvas_container::-webkit-scrollbar-track {background-color:#fff}
        #canvas_container::-webkit-scrollbar-track:hover {background-color:#f4f4f4}
        #canvas_container::-webkit-scrollbar-thumb {background-color:#babac0;border-radius:16px;border:5px solid #fff;}
        #canvas_container::-webkit-scrollbar-thumb:hover {background-color:#a0a0a5;border:4px solid #f4f4f4;}
        #canvas_container::-webkit-scrollbar-button {display:none}
        #navigation_controls{padding: 10px;text-align: center;}
	</style>
	<script type="text/javascript">
		$(document).ready(function(){
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
<body>
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
				<h2>Nama Kelas</h2>
				<div class="button">
					<a href="<?=base_url()?>" class="btn btn-info"><i class="fa fa-home"></i></a>&nbsp
					<button type="button" class="btn btn-success">Kembali ke Lobi</button>&nbsp
					<button type="button" class="btn btn-primary">Ulas Kelas</button>
				</div>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<select class="form-control select2" name="stage" onchange="this.form.submit()">
                        <option value="">-Pilih-</option>
                        <option>dfer</option>
                        <option>fer</option>
                    </select>
				</div>
                <!-- Judul Materi -->
				<div class="panel-group curriculum-wrapper" id="accordion">
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a aria-expanded="false" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                    <ul>
                                        <li><i class="fa fa-play" aria-hidden="true"></i></li>
                                        <li title="abcd">Judul saja <i class="fa fa-eye"></i></li>
                                    </ul>
                                </a>
                            </div>
                        </div>
                        <div aria-expanded="false" id="collapse1" role="tabpanel" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table class="table table-stage">
                                    <tr>
                                        <td width="50"><i class="fa fa-laptop"></i></td>
                                        <td><a href="#">Materi</a></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-puzzle-piece"></i></td>
                                        <td><a href="#">Games</a></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-bullhorn"></i></td>
                                        <td><a href="#">Quiz</a></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-rocket"></i></td>
                                        <td><a href="#">Project</a></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>	
				</div>
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
  					<h2>1. Judul Materi</h2>
  					<div class="row">
                        <div class="col-md-6" align="left"><i class="fa fa-tag"></i> Kategori : Kewirausahaan</div>
                        <div class="col-md-6" align="right"><i class="fa fa-user"></i> Fasilitator: Edo Afriando</div>             
                    </div>
                    <!-- File Materi -->                    
                    <div id="navigation_controls">
                        <button id="prevbutton" class="btn btn-default btn-sm">Prev</button>&nbsp
                        <button id="nextbutton" class="btn btn-default btn-sm">Next</button>&nbsp
                        <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
                        &nbsp
                        <button id="zoominbutton" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></button>&nbsp
                        <button id="zoomoutbutton" class="btn btn-default btn-sm"><i class="fa fa-minus"></i></button>
                    </div>
                    <div id="canvas_container">
                        <canvas id="pdf_renderer"></canvas>
                    </div>
                    <!-- File Materi -->
	  				<hr>
	  				<p>
	  					Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. At elementum eu facilisis sed odio morbi quis commodo. Eu lobortis elementum nibh tellus molestie. Ipsum dolor sit amet consectetur adipiscing elit ut aliquam. Suspendisse ultrices gravida dictum fusce ut placerat orci nulla. Enim facilisis gravida neque convallis a. Purus sit amet luctus venenatis lectus magna fringilla. Duis ultricies lacus sed turpis. Amet venenatis urna cursus eget. Etiam dignissim diam quis enim lobortis. Sit amet risus nullam eget felis eget. Ornare aenean euismod elementum nisi quis eleifend quam adipiscing.
	    			</p>
  				</div>
  				
  			</div>
    		<div class="footer">
    			<div class="col-md-4"><a href="#">SESI SEBELUMNYA</a></div>
    			<div class="col-md-4"><a href="#">MATERI TERSELESAIKAN</a></div>
    			<div class="col-md-4"><a href="#">SESI BERIKUTNYA</a></div>
    		</div>
  		</div>
	</div>
</body>

<script type="text/javascript">
    var url = 'https://raw.githubusercontent.com/mozilla/pdf.js/ba2edeae/web/compressed.tracemonkey-pldi-09.pdf';
    var pdfjsLib = window['pdfjs-dist/build/pdf'];
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://mozilla.github.io/pdf.js/build/pdf.worker.js';

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
    pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
        pdfDoc = pdfDoc_;
        document.getElementById('page_count').textContent = pdfDoc.numPages;
        // Initial/first page rendering
        renderPage(pageNum);
    });
  </script>
</html>






