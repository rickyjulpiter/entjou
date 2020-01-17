<!DOCTYPE html>
<html>
<head>
	<title>Coba PDF</title>
	<script src="<?=base_url('assets/backend/js/jquery.min.js')?>"></script>
</head>
<?php 
/*$myfile = fopen("./assets/materi/test.txt", "r") or die("Unable to open file!");
$file = fgets($myfile);
fclose($myfile);
$berkas = "data:application/pdf;base64,".$file."#toolbar=0";*/
?>
<body>
	<embed type="application/pdf" width="100%" height="800"></embed>
	
<script>
	var base_url = "<?=base_url('materi/coba')?>";
		$.ajax({
	    url: base_url,
	    success: function(databerkas) {
	        $('embed').attr('src',databerkas);
	    }
	});
</script>
</body>
</html>






