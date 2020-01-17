$(document).ready(function(){
    $('.dataTable').DataTable();
    var timeout = 4000; // in miliseconds (3*1000)
    $('.alert').delay(timeout).fadeOut(600);
    $('.tanggal').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
        reverseYearRange: false,
        yearRange: '-70:+0'
    });
    $(".bulan").datepicker({
        dateFormat: 'yy-mm',
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,

        onClose: function(dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).val($.datepicker.formatDate('yy-mm', new Date(year, month, 1)));
        }
    });
    $(".bulan").focus(function () {
        $(".ui-datepicker-calendar").hide();
        $("#ui-datepicker-div").position({
            my: "center top",
            at: "center bottom",
            of: $(this)
        });
    });
    $('.select2').select2();
    $("#form-simpan").on("submit",(function(e){
        $(".simpan").attr("disabled","disabled");
        $(".simpan").html("<i class='fa fa-cog fa-spin'></i> Sedang Proses...");
    }));
    $('#id_client').keyup(function(){        
        this.value = this.value.toUpperCase();
        var size = this.value.length;
        if (size>3) {
            swal("Peringatan!", "Maaf Hanya dibatasi 3 karakter", "error");
            this.value = this.value.substr(0,3);
        }            
    });        
    $('#email').blur(function(){
        var email = validateEmail(this.value);        
        if (email==false) {            
            this.value = "";
            $('#email').focus();
            swal("Peringatan!", "Maaf format email yang anda masukan salah", "error");
        }            
    });    
    String.prototype.ucwords = function () {
        return this.replace(/\w+/g, function(a){
            return a.charAt(0).toUpperCase() + a.slice(1).toLowerCase()
        })
    }    
}); 

/*fungsi saja*/
function validateEmail(email){
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function hanyaAngka(evt) {
    this.val(convertToRupiah(12321));
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))

    return false;
    return true;
}

function formatRupiah(angka, prefix){
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split           = number_string.split(','),
    sisa            = split[0].length % 3,
    rupiah          = split[0].substr(0, sisa),
    ribuan          = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

function convertToRupiah(angka){
    var rupiah = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
}

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

/*document.addEventListener("contextmenu", function(e){
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
}*/
