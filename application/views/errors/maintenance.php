<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="Error 404">
  <meta name="author" content="Rumah AiTi">

  <title><?php echo $title; ?></title>
  <style type="text/css">
  	a{-webkit-transition: all .35s;-moz-transition: all .35s;transition: all .35s;}
  	body{background:#fff;font-family: sans-serif;margin: 0}
    .container{width: 100%; margin: 100px auto}
    h2{text-align: center;margin:30px auto 10px;color: #555;}
    .credit{padding: 10px;position: fixed;bottom: 0;right: 0;}
    .credit a{color: #037AA8; text-decoration: none;}
    .credit a:hover{color: #000}
    .text{width: 100%;background: #f6f6f6; padding: 5px 0 25px}
    .gambar{width: 400px;margin: auto;text-align: center;margin-bottom: 30px;}
    small{color: #777; text-align: center;}
    @media(max-width:500px) {
        img{width: 100%;}
        .container{width: 100%;text-align: center;}
    }
  </style>
</head>

<body>
    <div class="container ">
        <section class="error-wrapper text-center">
            <div class="gambar">
                <img alt="" src="<?php echo base_url('assets/front/images/logo.png'); ?>" style="width:200px">
            </div>
            <div class="text">
                <h2>MAINTENANCE MODE</h2>
                <small>
                    <p>Mohon Untuk Menunggu, Kami Akan Kembali Secepatnya...</p>
                </small>
            </div>
            <div class="credit">
            	<small style="color:#777">&copy; Copyright 2016. Powered by <a href="http://www.rumah-aiti.com">Rumah AITI</a></small>
            </div>
        </section>
    </div>
</body>
</html>