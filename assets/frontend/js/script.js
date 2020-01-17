$(document).ready(function(){
    $(".dropdown-user").on("click", function(e){
        e.preventDefault();
        if($(this).hasClass("open")) {
            $(this).removeClass("open");
            $(this).children("ul").slideUp("fast");
        } else {
            $(this).addClass("open");
            $(this).children("ul").slideDown("fast");
        }
    });
    $(".dropdown-user li").click(function(){
        location.href = $(this).find("a").attr("href");
    });
    $('.nologin').on('click', function(){
        swal('Peringatan!', 'Silahkan masuk ke akun kamu terlebih dahulu', 'error');
    });
    $('.nobayar').on('click', function(){
        swal('Peringatan!', 'Silahkan lakukan pembayaran terlebih dahulu. Jika kamu sudah membayar, harap tunggu verifikasi dari admin. Terima kasih', 'error');
    });
    $('.habis').on('click', function(){
        swal('Peringatan!', 'Maaf peserta kelas melampaui batas', 'error');
    });
    $('body').tooltip({
        selector: '[data-toggle=tooltip]'
    });
    $('#daftar').hide();
    $('#btn-daftar').on('click',function(){
        $('#login').hide();
        $('#daftar').show();
    });
    $('#btn-login').on('click',function(){
        $('#daftar').hide();
        $('#login').show();
    });
    $('.tanggal').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
        reverseYearRange: false,
        yearRange: '-70:+0'
    });
    if ($('.select2').length) {
        $('.select2').select2({
            theme: 'classic',
            dropdownAutoWidth: true,
            width: '100%'
        });
    }
    var timeout = 4000; // in miliseconds (3*1000)
    $('.alert').delay(timeout).fadeOut(600);
    $("#form-simpan").on("submit",(function(e){
        $(".simpan").attr("disabled","disabled");
        $(".simpan").html("<i class='fa fa-cog fa-spin'></i> Sedang Proses...");
    }));
});

function cek_file(mb="",type="",id=""){
    var ukuran = '';
    if (mb=='1MB') {
        var ukuran = '1242880';
    }else if(mb=='2MB'){
        var ukuran = '2242880';
    }else if(mb=='3MB'){
        var ukuran = '3242880';
    }else if(mb=='10MB'){
        var ukuran = '10242880';
    }else if(mb=='2GB'){
        var ukuran = '2000242880';
    }
    var x = document.getElementById(id);
    if ('files' in x) {
        if (x.files.length > 0) {
            var file = x.files[0];
            if ('size' in file) {
                if (file.size >= ukuran) {
                    swal("Maaf!", "Ukuran file > "+mb+", silahkan ubah file dengan ukuran lebih kecil!", "error");
                    document.getElementById(id).value="";
                };
            };
        };
    };
    if (type=="image") {
        var ext  = /\.(jpe?g|png|jpg|bmp|ico)$/i;
        if (ext.test(x.files[0].name) === false) { 
            swal("Maaf!", "File yang anda masukan bukan gambar. Silahkan masukan file dengan ekstensi *.jpeg, *.png, *.jpg, *.bmp ", "error"); 
            document.getElementById(id).value = "";
        }   
    }
    if(type=="doc"){
        var ext  = /\.(doc|docx|pdf|xls|xlsx)$/i;
        if (ext.test(x.files[0].name) === false) { 
            swal("Maaf!", "File yang anda masukan bukan dokumen. Silahkan masukan file dengan ekstensi *.doc, *.docx, *.pdf, *.xls, *xlsx ", "error"); 
            document.getElementById(id).value = "";
        }
    }
    if(type=="pdf"){
        var ext  = /\.(pdf)$/i;
        if (ext.test(x.files[0].name) === false) { 
            swal("Maaf!", "File yang anda masukan bukan tipe PDF. Silahkan masukan file PDF ", "error"); 
            document.getElementById(id).value = "";
        }
    }
    if (type=="all") {
        var ext  = /\.(doc|docx|pdf|xls|xlsx|jpe?g|png|jpg|bmp|rar|zip)$/i;
        if (ext.test(x.files[0].name) === false) { 
            swal("Maaf!", "File yang anda masukan salah. Silahkan masukan file dengan ekstensi *.doc, *.docx, *.pdf, *.xls, *xlsx, *.jpeg, *.png, *.jpg, *.bmp, *.rar,. *zip ", "error");
            document.getElementById(id).value = ""; 
        }   
    }
    if (type=="video") {
        var ext  = /\.(mp4|flv|wmv|ogg|webm|mpeg|mpg)$/i;
        if (ext.test(x.files[0].name) === false) { 
            swal("Maaf!", "File yang anda masukan salah. Silahkan masukan file dengan ekstensi *.mp4, *.flv, *.wmv, *.ogg, *.webm, *.mpeg, *.mpg ", "error");
            document.getElementById(id).value = ""; 
        }   
    }
}

function cropper(vm,ar) {
    var $image = $('#image');var uploadedImageURL;var URL = window.URL || window.webkitURL;var $inputImage = $('#inputImage');
    var options = {
        viewMode: vm, // 0, 1, 2, 3  
        aspectRatio: ar, //16:9 = 1.7777777777777777 | 4:3 = 1.3333333333333333 | 1:1 = 1 | 2:3 = 0.6666666666666666 | free = NaN
        preview: '.img-preview',
        crop: function (e) {$('#dataX').val(Math.round(e.x));$('#dataY').val(Math.round(e.y));$('#dataHeight').val(Math.round(e.height));$('#dataWidth').val(Math.round(e.width));$('#dataRotate').val(e.rotate);$('#dataScaleX').val(e.scaleX);$('#dataScaleY').val(e.scaleY);}
    };$image.cropper(options);
    if (URL) {$inputImage.change(function () {var files = this.files;var file;if (!$image.data('cropper')) {return;}if (files && files.length) {file = files[0];if (/^image\/\w+$/.test(file.type)) {if (uploadedImageURL) {URL.revokeObjectURL(uploadedImageURL);}uploadedImageURL = URL.createObjectURL(file);$image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);}else{window.alert('Please choose an image file.');}}});}else{$inputImage.prop('disabled', true).parent().addClass('disabled');}

    $("#reset").click(function() {$image.cropper("reset");});
    $("#zoomIn").click(function() {$image.cropper("zoom", 0.1);});
    $("#zoomOut").click(function() {$image.cropper("zoom", -0.1);});
    $("#rotateLeft").click(function() {$image.cropper("rotate", 90);});
    $("#rotateRight").click(function() {$image.cropper("rotate", -90);});
    $("#fliphorizontal").click(function() {if ($('#dataScaleX').val() == 1) {var x = -1;}else{var x = 1;}$image.cropper("scaleX", x);});
    $("#flipvertical").click(function() {if ($('#dataScaleY').val() == 1) {var y = -1;}else{var y = 1;}$image.cropper("scaleY", y);});
}

function tersedia(pesan="",nama_id=""){
    $(nama_id).html("<label class='control-label col-md-12' style='color: #6bc31d;text-align: left!important'><i class='fa fa-check'></i> "+pesan+"</label>");    
    $('.simpan').removeAttr('disabled');        
}

function ketik(pesan="",nama_id=""){
    $(nama_id).html("<label class='control-label col-md-12' style='color:#00d2ff;text-align: left!important'><i class='fa fa-question-circle'></i> "+pesan+"</label>");
    $('.simpan').attr('disabled','disabled');
}

function sudah_tersedia(pesan="",nama_id=""){
    $(nama_id).html("<label class='control-label col-md-12' style='color: red;text-align: left!important'><i class='fa fa-times'></i> "+pesan+"</label>");
    $('.simpan').attr('disabled','disabled');
}

function kurang(pesan="",nama_id=""){
    $(nama_id).html("<label class='control-label col-md-12' style='color: red;text-align: left!important'><i class='fa fa-times'></i> "+pesan+"</label>");
    $('.simpan').attr('disabled','disabled');
}

function tidak_berubah(pesan="",nama_id=""){
    $(nama_id).html("<label class='control-label col-md-12' style='color:#00d2ff;text-align: left!important'><i class='fa fa-question-circle'></i> "+pesan+"</label>");
    $('.simpan').removeAttr('disabled');
}

document.addEventListener("contextmenu", function(e){
    e.preventDefault();
}, false);
document.onkeydown = function(e) {
    if(event.keyCode == 123) {
        return false;
    }if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
        return false;
    }if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
        return false;
    }
    if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
        return false;
    }
}