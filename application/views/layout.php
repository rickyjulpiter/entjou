<!DOCTYPE html>
<html lang="en">
<?php
$nama       = $this->encrypt->decode($this->session->userdata('nama'));
$tipe_user  = $this->encrypt->decode($this->session->userdata('tipe_user'));
$foto       = $this->session->userdata('foto');
$jk         = $this->session->userdata('jk');
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="no-index">
    <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.png'); ?>" type="image/png">
    <title><?= $title ?> - Entjou </title>
    <link href="<?= base_url('assets/backend/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/backend/fonts/css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/backend/css/animate.min.css') ?>" rel="stylesheet">

    <link href="<?= base_url('assets/backend/css/nprogress.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/backend/css/style.css') ?>" rel="stylesheet">

    <link href="<?= base_url('assets/backend/css/dataTables.responsive.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/backend/css/sweetalert2.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/backend/css/select2.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/backend/css/bootstrap-fileupload.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/backend/css/summernote.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/backend/css/cropper.min.css'); ?>" />

    <script src="<?= base_url('assets/backend/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/backend/js/jquery-ui-1.9.2.custom.min.js') ?>"></script>
    <script src="<?= base_url('assets/backend/js/nprogress.js') ?>"></script>
    <script>
        $(document).ready(function() {
            NProgress.done()
        });
    </script>
    <script type="text/javascript" src="<?= base_url('assets/backend/js/bootstrap.min.js') ?>"></script>

    <script type="text/javascript" src="<?= base_url('assets/backend/js/bootstrap-select.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/backend/js/jquery.dataTables.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/backend/js/dataTables.responsive.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/backend/js/dataTables.bootstrap.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/backend/js/sweetalert2.min.js'); ?>" async></script>
    <script type="text/javascript" src="<?= base_url('assets/backend/js/select2.full.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/backend/js/script.js') ?>"></script>
    <script src="<?= base_url('assets/backend/js/bootstrap-fileupload.min.js') ?>"></script>
    <script src="<?= base_url('assets/backend/js/chart.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/backend/js/summernote.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/backend/js/cropper.min.js'); ?>"></script>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="nav-md">
    <noscript class="noscript">
        <style>
            body {
                width: 100%;
                height: 100%;
                overflow: hidden;
            }
        </style>
        <div id="javascript-notice">
            <img src="https://grafologiindonesia.com/wp-content/uploads/2014/08/warning-icon-png-2766-300x300.png" width="250" alt="JavaScript Disabled Notice" title="JavaScript Disabled" />
            <h3>Silahkan untuk mengaktifkan javascript pada browser anda<br>Terima Kasih</h3>
        </div>
    </noscript>

    <div id="wrapper">
        <!-- side nav -->
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title">
                    <a href="<?= base_url() ?>" class="site-title"><i class="fa fa-home"></i></a>
                </div>
                <div class="clearfix"></div>
                <div class="profile">
                    <div class="profile-pic">
                        <?php
                        $ada = $ada = file_exists(realpath(APPPATH . '../assets/images/user/thumbnail/' . $foto));
                        if (!empty($foto) and $ada) {
                            $foto_usr = base_url() . 'assets/images/user/thumbnail/' . $foto;
                        } else {
                            if ($jk == "L") {
                                $foto_usr = base_url('assets/images/avatar/male.jpg');
                            } elseif ($jk == "P") {
                                $foto_usr = base_url('assets/images/avatar/female.jpg');
                            }
                        }
                        ?>
                        <img src="<?= $foto_usr ?>" class="img-circle profile-img">
                    </div>
                    <div class="profile-info">
                        <span>
                            <?php
                            if ($tipe_user == "admin") {
                                echo "Administrator";
                            } elseif ($tipe_user == "guru") {
                                echo "Fasilitator";
                            }
                            ?>
                        </span>
                        <h2><?= $nama ?></h2>
                    </div>
                </div>
                <br />
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <?php
                        if ($tipe_user == "admin") { ?>
                            <ul class="nav side-menu">
                                <li><a href="<?= base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard </a></li>

                                <li><a><i class="fa fa-building"></i> Data Kelas <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?= base_url('kelas') ?>"> Kelas </a></li>
                                        <li><a href="<?= base_url('kelas/peserta_kelas') ?>"> Peserta Kelas </a></li>
                                        <li><a href="<?= base_url('materi') ?>"> Materi </a></li>
                                        <li><a href="<?= base_url('quiz/quiz_nilai') ?>"> Nilai Quiz </a></li>
                                        <li><a href="<?= base_url('agenda') ?>"> Agenda </a></li>
                                    </ul>
                                </li>

                                <li><a><i class="fa fa-newspaper-o"></i> Data Informasi <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?= base_url('blog') ?>"> Blog </a></li>
                                        <li><a href="<?= base_url('pengumuman') ?>"> Pengumuman </a></li>
                                    </ul>
                                </li>

                                <li><a><i class="fa fa-home"></i> Data Beranda <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?= base_url('slider') ?>"> Slider </a></li>
                                        <li><a href="<?= base_url('fitur_link') ?>"> Feature Link </a></li>
                                        <li><a href="<?= base_url('program_partner') ?>"> Program/Partner </a></li>
                                        <li><a href="<?= base_url('testimoni') ?>"> Testimoni </a></li>

                                    </ul>
                                </li>

                                <li><a href="<?= base_url('pesanan') ?>"><i class="fa fa-money"></i> Pesanan </a></li>

                                <li><a href="<?= base_url('user') ?>"><i class="fa fa-user"></i> Pengguna </a></li>

                                <li><a href="<?= base_url('user') ?>"><i class="fa fa-bell-o"></i> Curhat Bisnis </a></li>

                                <li><a href="<?= base_url('checkup') ?>"><i class="fa fa-compass"></i> Checkup </a></li>

                                <li><a href="<?= base_url('aktivitas_login') ?>"><i class="fa fa-clock-o"></i> Aktivitas Login </a></li>

                                <li><a href="<?= base_url('pengaturan') ?>"><i class="fa fa-gear"></i> Pengaturan</a></li>

                                <li><a href="<?= base_url('login/logout') ?>"><i class="fa fa-power-off"></i> Keluar </a></li>
                            </ul>
                        <?php } elseif ($tipe_user == "guru") { ?>
                            <ul class="nav side-menu">
                                <li><a href="<?= base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard </a></li>

                                <li><a href="<?= base_url('kelas') ?>"><i class="fa fa-building"></i> Kelas </a></li>

                                <li><a href="<?= base_url('kelas/peserta_kelas') ?>"><i class="fa fa-users"></i> Peserta Kelas </a></li>

                                <li><a href="<?= base_url('materi') ?>"><i class="fa fa-book"></i> Materi </a></li>

                                <li><a href="<?= base_url('quiz/quiz_nilai') ?>"><i class="fa fa-book"></i> Nilai Quiz </a></li>

                                <li><a href="<?= base_url('agenda') ?>"><i class="fa fa-calendar"></i> Agenda </a></li>

                                <li><a href="<?= base_url('checkup') ?>"><i class="fa fa-compass"></i> Checkup </a></li>

                                <li><a href="<?= base_url('blog') ?>"><i class="fa fa-newspaper-o"></i> Blog </a></li>

                                <li><a href="<?= base_url('login/logout') ?>"><i class="fa fa-power-off"></i> Keluar </a></li>
                            </ul>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /side nav -->
        <!-- top nav -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle" class="btn btn-info"><i class="fa fa-bars"></i></a>
                    </div>
                    <div class="welcome">
                        <span>Selamat datang <strong><?= $this->encrypt->decode($this->session->userdata('nama')) ?></strong></span>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <img src="<?= $foto_usr ?>" alt=""> <?= $this->encrypt->decode($this->session->userdata('nama')) ?> <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                <li><a href="<?= base_url() . 'user/user_detail/' . $this->session->userdata('id_user') ?>"><i class="fa fa-user pull-right"></i> Profil</a></li>
                                <li><a href="<?= base_url() ?>" target="_blank"><i class="fa fa-globe pull-right"></i> Website</a></li>

                                <li class="divider"></li>
                                <li><a href="<?= base_url('login/logout') ?>"><i class="fa fa-sign-out pull-right"></i> Keluar</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top nav -->
        <!-- content -->
        <div class="main" role="main">
            <div class="wrapper-content">
                <div class="row">
                    <div class="col-md-12">
                        <?php $this->load->view($isi); ?>
                    </div>
                </div>
            </div>
            <footer>
                <p class="pull-right">2018 © <a href="<?= base_url() ?>">entjou.com</a> </p>
            </footer>
        </div>
        <!-- /content -->
    </div>

    <script src="<?= base_url('assets/backend/js/custom.js') ?>"></script>
    <script>
        NProgress.done();
    </script>
</body>

</html>
<script type="text/javascript">
    function SwalDelete(hapus) {
        swal({
            title: 'Yakin mau di Hapus?',
            text: "Data akan terhapus permanen!",
            type: 'warning',
            showCancelButton: true,
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $.ajax({
                        url: "<?= base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(1) . '_hapus' ?>",
                        type: 'POST',
                        data: {
                            'hapus': hapus,
                            '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
                        },
                        dataType: 'json'
                    }).done(function(response) {
                        swal('Berhasil dihapus!', response.message, 'success');
                        datatb.fnDraw();
                    }).fail(function() {
                        swal('Oops...', 'Terjadi Kesalahan !', 'error');
                        datatb.fnDraw();
                    });
                });
            },
            allowOutsideClick: false
        });
    }
    $(document).ready(function() {
        $(document).on('click', '.hapus', function(e) {
            var hapus = $(this).data('hapus');
            SwalDelete(hapus);
            e.preventDefault();
        });
    });

    function SwalDelete1(nonaktif) {
        swal({
            title: 'Yakin mau di nonaktif?',
            text: "Kelas akan menjadi nonaktif. Jika ingin mengaktifkan kembali perbarui data kelas!",
            type: 'warning',
            showCancelButton: true,
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $.ajax({
                        url: "<?= base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(1) . '_nonaktif' ?>",
                        type: 'POST',
                        data: {
                            'nonaktif': nonaktif,
                            '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
                        },
                        dataType: 'json'
                    }).done(function(response) {
                        swal('Berhasil dinonaktif!', response.message, 'success');
                        datatb.fnDraw();
                    }).fail(function() {
                        swal('Oops...', 'Terjadi Kesalahan !', 'error');
                        datatb.fnDraw();
                    });
                });
            },
            allowOutsideClick: false
        });
    }
    $(document).ready(function() {
        $(document).on('click', '.nonaktif', function(e) {
            var nonaktif = $(this).data('nonaktif');
            SwalDelete1(nonaktif);
            e.preventDefault();
        });
    });

    function SwalDelete2(hapus) {
        swal({
            title: 'Yakin mau di Hapus?',
            text: "Data akan terhapus permanen!",
            type: 'warning',
            showCancelButton: true,
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $.ajax({
                        url: "<?= base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '_hapus' ?>",
                        type: 'POST',
                        data: {
                            'hapus': hapus,
                            '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
                        },
                        dataType: 'json'
                    }).done(function(response) {
                        swal('Berhasil dihapus!', response.message, 'success');
                        datatb.fnDraw();
                    }).fail(function() {
                        swal('Oops...', 'Terjadi Kesalahan !', 'error');
                        datatb.fnDraw();
                    });
                });
            },
            allowOutsideClick: false
        });
    }
    $(document).ready(function() {
        $(document).on('click', '.hapus2', function(e) {
            var hapus = $(this).data('hapus2');
            SwalDelete2(hapus);
            e.preventDefault();
        });
    });
</script>