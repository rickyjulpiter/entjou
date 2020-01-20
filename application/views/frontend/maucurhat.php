<!DOCTYPE html>
<html lang="en">
<?php
$this->load->model('model_admin');
$set = $this->model_admin->select_data('pengaturan', null, array('id_pengaturan' => 1));
$fitur_link = $this->model_admin->select_data('blog', null, array('kategori' => 'link', 'publish' => 'Y'));
$this->nama         = $this->encrypt->decode($this->session->userdata('nama'));
$this->tipe_user    = $this->encrypt->decode($this->session->userdata('tipe_user'));
$this->foto         = $this->session->userdata('foto');
$this->jk           = $this->session->userdata('jk');
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= $title ?> | <?= $set[0]['nama_website'] ?></title>
    <meta name="description" content="<?= $set[0]['deskripsi'] ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/images/favicon.png') ?>">
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/normalize.css') ?>">
    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/main.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/backend/css/datepicker/jquery-ui.css') ?>">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/bootstrap.min.css') ?>">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/animate.min.css') ?>">
    <!-- Font-awesome CSS-->
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/font-awesome.min.css') ?>">
    <!-- Owl Caousel CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/frontend/vendor/OwlCarousel/owl.carousel.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/vendor/OwlCarousel/owl.theme.default.min.css') ?>">
    <!-- Main Menu CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/meanmenu.min.css') ?>">
    <!-- nivo slider CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/frontend/vendor/slider/css/nivo-slider.css') ?>" type="text/css" />
    <link rel="stylesheet" href="<?= base_url('assets/frontend/vendor/slider/css/preview.css') ?>" type="text/css" media="screen" />
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/select2.min.css') ?>">
    <!-- Magic popup CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/magnific-popup.css') ?>">
    <!-- Switch Style CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/hover-min.css') ?>">
    <!-- ReImageGrid CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/reImageGrid.css') ?>">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/style.css') ?>">
    <link href="<?= base_url('assets/backend/css/sweetalert2.min.css') ?>" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/backend/css/cropper.min.css'); ?>" />
    <link href="<?= base_url('assets/backend/css/bootstrap-fileupload.min.css') ?>" rel="stylesheet">
    <!-- Modernizr Js -->
    <script src="<?= base_url('assets/frontend/js/modernizr-2.8.3.min.js') ?>"></script>
    <!-- jquery-->
    <script src="<?= base_url('assets/frontend/js/jquery-2.2.4.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/backend/js/jquery-ui-1.9.2.custom.min.js') ?>"></script>
    <!-- Select2 Js -->
    <script src="<?= base_url('assets/frontend/js/select2.min.js') ?>" type="text/javascript"></script>
    <script type="text/javascript" src="<?= base_url('assets/backend/js/sweetalert2.min.js'); ?>" async></script>
    <script type="text/javascript" src="<?php echo base_url('assets/backend/js/cropper.min.js'); ?>"></script>
    <script src="<?= base_url('assets/backend/js/bootstrap-fileupload.min.js') ?>"></script>
    <script src="<?= base_url('assets/frontend/js/script.js') ?>" type="text/javascript"></script>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- Add your site or application content here -->
    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->
    <!-- Main Body Area Start Here -->
    <noscript class="noscript">
        <style>
            body {
                width: 100%;
                height: 100%;
                overflow: hidden;
            }
        </style>
        <div id="javascript-notice">
            <i class="fa fa-warning fa-5x"></i>
            <h3>Silahkan untuk mengaktifkan javascript pada browser anda<br>Terima Kasih</h3>
        </div>
    </noscript>
    <div id="wrapper">
        <!-- Header Area Start Here -->
        <header>
            <div id="header1" class="header1-area">
                <div class="main-menu-area bg-primary" id="sticker">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-3">
                                <div class="logo-area">
                                    <a href="<?= base_url() ?>"><img class="img-responsive" src="<?= base_url() . 'assets/images/' . $set[0]['logo'] ?>" width="115" alt="logo"></a>
                                </div>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-9">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <nav id="desktop-nav">
                                            <ul>
                                                <li class=""><a href="<?= base_url() ?>">Beranda</a></li>
                                                <!-- <li><a href="<?php //base_url().'home/kelas'
                                                                    ?>">Kelas</a></li> -->
                                                <li><a href="<?= base_url() . 'home/blog' ?>">Blog</a></li>
                                                <li><a href="<?= base_url() . 'home/kontak' ?>">Kontak</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="apply-btn-area">
                                            <?php

                                            if (!empty($this->nama) and $this->tipe_user == "siswa") {
                                                $appath = realpath(APPPATH . '../assets/images/user/' . $this->foto);
                                                if (!empty($this->foto) and file_exists($appath)) {
                                                    $image = base_url() . 'assets/images/user/' . $this->foto;
                                                } else {
                                                    if ($this->jk == "L") {
                                                        $image = base_url() . 'assets/images/avatar/male.jpg';
                                                    } else {
                                                        $image = base_url() . 'assets/images/avatar/female.jpg';
                                                    }
                                                } ?>
                                                <div class="ddmenu dropdown-user">
                                                    <div style="display: block;">
                                                        <img src="<?= $image ?>" style="border-radius: 20px;width: 32px;position: absolute;top: 7px;left: 10px;">
                                                        <div style="margin-left: 40px;text-align: left;"><?= $this->nama ?></div>
                                                        <i class="fa fa-chevron-down" style="position: absolute;top: 13px;right: 15px;"></i>
                                                    </div>
                                                    <ul>
                                                        <li><a href="<?= base_url('siswa') ?>">Profil</a></li>
                                                        <li><a href="<?= base_url('siswa/misi') ?>">Misi</a></li>
                                                        <li><a href="<?= base_url('siswa/agenda') ?>">Agenda</a></li>
                                                        <li><a href="<?= base_url('siswa/pengumuman') ?>">Pengumuman</a></li>
                                                        <li><a href="<?= base_url('siswa/pesanan') ?>">Pesanan</a></li>
                                                        <li><a href="<?= base_url('login/logout') ?>">Keluar</a></li>
                                                    </ul>
                                                </div>
                                            <?php } else { ?>
                                                <a href="<?= base_url('login') ?>" class="apply-now-btn">Masuk</a>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- <div class="col-lg-2 col-md-2 hidden-sm">
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu Area Start -->
            <div class="mobile-menu-area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mobile-menu">
                                <nav id="dropdown">
                                    <style type="text/css">
                                        #menu-mobile {
                                            height: auto !important;
                                        }
                                    </style>
                                    <ul id="menu-mobile">
                                        <li><a href="<?= base_url() ?>">Beranda</a></li>
                                        <li><a href="<?php //base_url() . 'home/kelas' 
                                                        ?>">Kelas</a></li>
                                        <li><a href="<?= base_url() . 'home/blog' ?>">Blog</a></li>
                                        <li><a href="<?= base_url() . 'home/kontak' ?>">Kontak</a></li>
                                        <li>
                                            <div class="apply-btn-area">
                                                <?php

                                                if (!empty($this->nama) and $this->tipe_user == "siswa") {
                                                    $appath = realpath(APPPATH . '../assets/images/user/' . $this->foto);
                                                    if (!empty($this->foto) and file_exists($appath)) {
                                                        $image = base_url() . 'assets/images/user/' . $this->foto;
                                                    } else {
                                                        if ($this->jk == "L") {
                                                            $image = base_url() . 'assets/images/avatar/male.jpg';
                                                        } else {
                                                            $image = base_url() . 'assets/images/avatar/female.jpg';
                                                        }
                                                    } ?>
                                                    <div class="ddmenu dropdown-user" style="width: 96%">
                                                        <div style="display: block;padding: 1em 5%;">
                                                            <img src="<?= $image ?>" style="border-radius: 20px; width: 32px; position: absolute;top: 10px">
                                                            <div style="margin-left: 40px"><?= $this->nama ?></div>
                                                        </div>
                                                        <ul>
                                                            <li><a href="<?= base_url('siswa') ?>">Profil</a></li>
                                                            <li><a href="<?= base_url('siswa/misi') ?>">Misi</a></li>
                                                            <li><a href="<?= base_url('siswa/agenda') ?>">Agenda</a></li>
                                                            <li><a href="<?= base_url('siswa/pengumuman') ?>">Pengumuman</a></li>
                                                            <li><a href="<?= base_url('siswa/pesanan') ?>">Pesanan</a></li>
                                                            <li><a href="<?= base_url('login/logout') ?>">Keluar</a></li>
                                                        </ul>
                                                    </div>
                                                <?php } else { ?>
                                                    <a href="<?= base_url('login') ?>" class="apply-now-btn">Masuk</a>
                                                <?php } ?>

                                            </div>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu Area End -->
        </header>
        <!-- Header Area End Here -->
        <?php $this->load->view($isi); ?>
        <!-- Footer Area Start Here -->
        <footer>
            <div class="footer-area-top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="footer-box">
                                <a href="<?= base_url() ?>"><img class="img-responsive" src="<?= base_url() . 'assets/images/' . $set[0]['logo'] ?>" alt="logo"></a>
                                <div class="footer-about" style="text-align: justify;">
                                    <p><?= Tools::limit_words($set[0]['deskripsi'], 30) ?></p>
                                </div>
                                <ul class="footer-social">
                                    <li><a href="<?= $set[0]['facebook'] ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li><a href="<?= $set[0]['twitter'] ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                    <li><a href="<?= $set[0]['instagram'] ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                    <li><a href="<?= $set[0]['youtube'] ?>"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="footer-box">
                                <h3>Featured Links</h3>
                                <ul class="featured-links">
                                    <li>
                                        <ul>
                                            <?php
                                            foreach ($fitur_link as $key => $value) {
                                                echo "<li><a href='" . base_url() . $value['slug'] . "' target='_blank'>" . $value['judul'] . "</a></li>";
                                            } ?>

                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="footer-box">
                                <h3>Informasi</h3>
                                <ul class="corporate-address">
                                    <li><i class="fa fa-phone" aria-hidden="true"></i><a href="tel:<?= $set[0]['hape'] ?>"> <?= $set[0]['hape'] ?> </a></li>
                                    <li><i class="fa fa-envelope-o" aria-hidden="true"></i><?= $set[0]['email'] ?></li>
                                    <li><i class="fa fa-map-marker" aria-hidden="true"></i><?= $set[0]['alamat'] ?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="footer-box">
                                <h3>Lokasi</h3>
                                <div id="googleMap-footer" style="width:100%; height:250px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-area-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <p>Entjou &copy; <?= date('Y') ?> </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer Area End Here -->
    </div>
    <!-- Main Body Area End Here -->
    <script type="text/javascript">
        $(function() {
            var url = "<?= base_url(); ?>assets/images/logo.png";
            $('nav#dropdown').meanmenu({
                siteLogo: "<a href='" + "<?= base_url() ?>" + "' class='logo-mobile-menu'><img style='width: 120px;padding: 2px;' src='" + url + "' /></a>"
            });
        });
    </script>
    <!-- Plugins js -->
    <script src="<?= base_url('assets/frontend/js/plugins.js') ?>" type="text/javascript"></script>
    <!-- Bootstrap js -->
    <script src="<?= base_url('assets/frontend/js/bootstrap.min.js') ?>" type="text/javascript"></script>
    <!-- WOW JS -->
    <script src="<?= base_url('assets/frontend/js/wow.min.js') ?>"></script>
    <!-- Nivo slider js -->
    <script src="<?= base_url('assets/frontend/vendor/slider/js/jquery.nivo.slider.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/frontend/vendor/slider/home.js') ?>" type="text/javascript"></script>
    <!-- Owl Cauosel JS -->
    <script src="<?= base_url('assets/frontend/vendor/OwlCarousel/owl.carousel.min.js') ?>" type="text/javascript"></script>
    <!-- Meanmenu Js -->
    <script src="<?= base_url('assets/frontend/js/jquery.meanmenu.min.js') ?>" type="text/javascript"></script>
    <!-- Srollup js -->
    <script src="<?= base_url('assets/frontend/js/jquery.scrollUp.min.js') ?>" type="text/javascript"></script>
    <!-- jquery.counterup js -->
    <script src="<?= base_url('assets/frontend/js/jquery.counterup.min.js') ?>"></script>
    <script src="<?= base_url('assets/frontend/js/waypoints.min.js') ?>"></script>
    <!-- Countdown js -->
    <script src="<?= base_url('assets/frontend/js/jquery.countdown.min.js') ?>" type="text/javascript"></script>

    <!-- Isotope js -->
    <script src="<?= base_url('assets/frontend/js/isotope.pkgd.min.js') ?>" type="text/javascript"></script>
    <!-- Google Map -->
    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCRGdwGm9y0rWgRnp3Ri_dwlCdmyjubbJU"></script>

    <!-- Magic Popup js -->
    <script src="<?= base_url('assets/frontend/js/jquery.magnific-popup.min.js') ?>" type="text/javascript"></script>
    <!-- Gridrotator js -->
    <script src="<?= base_url('assets/frontend/js/jquery.gridrotator.js') ?>" type="text/javascript"></script>
    <!-- Custom Js -->
    <script src="<?= base_url('assets/frontend/js/main.js') ?>" type="text/javascript"></script>
</body>

</html>