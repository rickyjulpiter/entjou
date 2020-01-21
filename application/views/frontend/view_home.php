<?php
$slider1 = $slider2 = $slider;
?>
<style type="text/css">
    .item-content {
        text-align: justify;
        height: 160px;
        border-radius: 10px;
    }
</style>
<!-- Slider 1 Area Start Here -->
<div class="slider1-area overlay-default index1">
    <div class="bend niceties preview-1">
        <div id="ensign-nivoslider-3" class="slides">
            <?php
            if (empty($slider1)) {
                $image = base_url() . 'assets/images/slider_logo.jpg';
                echo "<img src='" . $image . "' alt='slider' title='#slider-direction-1'/>";
            } else {
                foreach ($slider1 as $key => $value) {
                    $appath = realpath(APPPATH . '../assets/images/slider/' . $value['foto']);
                    if (!empty($value['foto']) and file_exists($appath)) {
                        $image = base_url() . 'assets/images/slider/' . $value['foto'];
                    } else {
                        $image = base_url() . 'assets/images/slider_logo.jpg';
                    }
            ?>
                    <img src="<?= $image ?>" alt="slider" title="#slider-direction-<?= ($key + 1) ?>" />
            <?php }
            } ?>
        </div>
        <?php
        foreach ($slider2 as $key => $value) { ?>
            <div id="slider-direction-<?= ($key + 1) ?>" class="t-cn slider-direction">
                <div class="slider-content s-tb slide-<?= ($key + 1) ?>">
                    <div class="title-container s-tb-c">
                        <div class="title1"><?= $value['judul'] ?></div>
                        <?= $value['deskripsi'] ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<!-- Slider 1 Area End Here -->

<div class="container mt-10" style="margin-top: 40px; margin-bottom:40px">
    <img src="<?= base_url() . 'assets/images/curhat.png' ?>" alt="">
    <!-- <h2 class="title-default-left" style="text-align: center">Kamu Enterpreneur UMKM ?</h2>
    <h2 class="title-default-left" style="text-align: center">Punya masalah bisnis yang belum terpecahkan ?</h2>
    <h2 class="title-default-left" style="text-align: center">Mari Curhat Bisnis Gratis Bersama Kami.</h2> -->
    <button type="button" class="btn btn-lg btn-danger btn-block" data-toggle="modal" data-target="#myModal" style="border-radius:0px 0px 10px 10px">Mulai Curhat Bisnis</button>
</div>

<div class="container">
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Form Curhat Bisnis</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="<?= base_url() . 'home/curhat_tambah' ?>" method="POST">
                        <div class="form-group">
                            <label class="control-label col-md-4" for="email" style="text-align:left">Nama:</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="email" placeholder="" name="nama">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="email" style="text-align:left">No. WA:</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="email" placeholder="" name="nowa">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="email" style="text-align:left">Email:</label>
                            <div class="col-md-8">
                                <input type="email" class="form-control" id="email" placeholder="" name="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="email" style="text-align:left">Nama Usaha:</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="email" placeholder="" name="namausaha">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="email" style="text-align:left">Deskripsi Singkat Usaha:</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="email" placeholder="" name="deskripsi">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="email" style="text-align:left" for="comment">Curhatan Kamu:</label>
                            <div class="col-md-8">
                                <textarea class="form-control" rows="5" id="comment" placeholder="Apa yang ingin kamu curhatkan" name="curhatan"></textarea>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-info btn-block">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div> -->
            </div>
        </div>
    </div>
</div>

<!-- Courses 1 Area Start Here -->
<!-- <div class="courses1-area">
    <div class="container">
        <h2 class="title-default-left">Kelas</h2>
    </div>
    <div id="shadow-carousel" class="container">
        <div class="rc-carousel" data-loop="true" data-items="4" data-margin="20" data-autoplay="false" data-autoplay-timeout="10000" data-smart-speed="2000" data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="true" data-r-x-small-dots="false" data-r-x-medium="2" data-r-x-medium-nav="true" data-r-x-medium-dots="false" data-r-small="2" data-r-small-nav="true" data-r-small-dots="false" data-r-medium="3" data-r-medium-nav="true" data-r-medium-dots="false" data-r-large="4" data-r-large-nav="true" data-r-large-dots="false">
            <?php
            // foreach ($kelas as $key => $value) {
            //     if ($key == 13) {
            //         $key == 0;
            //     }
            //     $appath = realpath(APPPATH . '../assets/images/kelas/' . $value['foto']);
            //     if (!empty($value['foto']) and file_exists($appath)) {
            //         $image = base_url() . 'assets/images/kelas/' . $value['foto'];
            //     } else {
            //         $image = base_url() . 'assets/images/no-image.jpg';
            //     }
            ?>
                <div class="courses-box1">
                    <div class="single-item-wrapper">
                        <div class="courses-img-wrapper hvr-bounce-to-bottom">
                            <img class="img-responsive" src="<?= $image ?>" alt="courses">
                            <a href="javascript;" onClick="window.open('<?= $value['slug'] ?>');" target="_blank"><i class="fa fa-link" aria-hidden="true"></i></a>
                        </div>
                        <div class="courses-content-wrapper">
                            <h3 class="item-title" align="center"><a href="#"><?= $value['nama_kelas'] ?></a></h3>
                            <p class="item-content"><?= Tools::limit_words($value['overview'], 110) ?>...</p>
                            <a href="javascript;" onClick="window.open('<?= $value['slug'] ?>');" class="btn btn-menu btn-block" target="_blank"><i class="fa fa-money"></i>
                                <?php
                                // if ($value['harga'] == 0) {
                                //     echo "Gratis";
                                // } else {
                                //     echo Tools::rupiah('Rp ', $value['harga']);
                                // }
                                ?></a>
                        </div>
                    </div>
                </div>
            <?php //} 
            ?>
        </div>
    </div>
</div> -->
<!-- Courses 1 Area End Here -->

<!-- Lecturers Area Start Here -->
<!-- <div class="lecturers-area">
    <div class="container">
        <h2 class="title-default-left">Fasilitator & Kawan Sharing (Kasha)</h2>
    </div>
    <div class="container">
        <div class="rc-carousel" data-loop="true" data-items="4" data-margin="30" data-autoplay="false" data-autoplay-timeout="10000" data-smart-speed="2000" data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="true" data-r-x-small-dots="false" data-r-x-medium="2" data-r-x-medium-nav="true" data-r-x-medium-dots="false" data-r-small="3" data-r-small-nav="true" data-r-small-dots="false" data-r-medium="4" data-r-medium-nav="true" data-r-medium-dots="false" data-r-large="4" data-r-large-nav="true" data-r-large-dots="false">
            <?php
            // foreach ($fasilitator as $key => $value) {
            //     $foto = $value['foto'];
            //     $ada = file_exists(realpath(APPPATH . '../assets/images/user/' . $foto));
            //     if (!empty($foto) and $ada) {
            //         $images = base_url() . 'assets/images/user/' . $foto;
            //     } else {
            //         if ($value['jk'] == "L") {
            //             $images = base_url() . 'assets/images/avatar/male.jpg';
            //         } else {
            //             $images = base_url() . 'assets/images/avatar/female.jpg';
            //         }
            //     }
            ?>
                <div class="single-item">
                    <div class="lecturers1-item-wrapper">
                        <div class="lecturers-img-wrapper">
                            <a href="#"><img class="img-responsive" src="<?= $images ?>" alt="team"></a>
                        </div>
                        <div class="lecturers-content-wrapper">
                            <h3 class="item-title"><a href="#"><?= $value['nama_lengkap'] ?></a></h3>
                            <span class="item-designation"><?php
                                                            // if (!empty($value['posisi'])) {
                                                            //     echo $value['posisi'];
                                                            // } else {
                                                            //     echo '-';
                                                            // }
                                                            ?></span>
                            <ul class="lecturers-social">
                                <li><a href="#"><i class="fa fa-envelope-o" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php //} 
            ?>
        </div>
    </div>
</div> -->
<!-- Lecturers Area End Here -->
<!-- News and Event Area Start Here -->
<!-- <div class="news-event-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 news-inner-area">
                <h2 class="title-default-left">Blog</h2>
                <?php
                // if (!empty($blog)) { 
                ?>
                    <ul class="news-wrapper wow bounceInUp" data-wow-duration="2s" data-wow-delay=".1s">
                        <?php
                        // foreach ($blog as $key => $value) {
                        //     $appath = realpath(APPPATH . '../assets/images/blog/thumbnail/' . $value['foto']);
                        //     if (!empty($value['foto']) and file_exists($appath)) {
                        //         $image = base_url() . 'assets/images/blog/thumbnail/' . $value['foto'];
                        //     } else {
                        //         $image = base_url() . 'assets/images/no-image-bp.jpg';
                        //     } 
                        ?>
                            <li>
                                <div class="news-img-holder">
                                    <a href="<?= $value['slug'] ?>"><img src="<?= $image ?>" class="img-responsive" style="padding-right: 15px;width: 100%" alt="blog"></a>
                                </div>
                                <div class="news-content-holder">
                                    <h3><a href="<?= $value['slug'] ?>" target="_blank" title="<?= $value['judul'] ?>"><?php
                                                                                                                        if (strlen($value['judul']) <= 35) {
                                                                                                                            echo Tools::limit_words($value['judul'], 35);
                                                                                                                        } else {
                                                                                                                            echo Tools::limit_words($value['judul'], 35) . ' ...';
                                                                                                                        }
                                                                                                                        ?></a></h3>
                                    <div class="post-date"><?= Tools::tgl_indo($value['waktu_post'], 'l, d F Y H:i') ?> WIB</div>
                                    <span style="text-align: justify;">
                                        <?php
                                        // if (strlen($value['isi']) <= 100) {
                                        //     echo Tools::limit_words(strip_tags($value['isi']), 100);
                                        // } else {
                                        //     echo Tools::limit_words(strip_tags($value['isi']), 100) . ' ...';
                                        // }
                                        ?>
                                    </span>
                                </div>
                            </li>
                        <?php //} 
                        ?>
                    </ul>
                    <div class="news-btn-holder">
                        <a href="<?= base_url('home/blog') ?>" class="view-all-accent-btn">Lihat Semua</a>
                    </div>
                <?php //} else { 
                ?>
                    <div align="center">
                        <b>Tidak Ada Postingan Blog</b>
                    </div>
                <?php //} 
                ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 event-inner-area">
                <h2 class="title-default-left">Pengumuman</h2>
                <?php
                if (!empty($pengumuman)) { ?>
                    <ul class="event-wrapper">
                        <?php
                        foreach ($pengumuman as $key => $value) { ?>
                            <li class="wow bounceInUp" data-wow-duration="2s" data-wow-delay=".1s">
                                <div class="event-calender-wrapper">
                                    <div class="event-calender-holder">
                                        <h3><?= Tools::tgl_indo($value['waktu_post'], 'd') ?></h3>
                                        <p><?= Tools::tgl_indo($value['waktu_post'], 'm') ?></p>
                                        <span><?= Tools::tgl_indo($value['waktu_post'], 'Y') ?></span>
                                    </div>
                                </div>
                                <div class="event-content-holder">
                                    <h3><a href="<?= $value['slug'] ?>" title="<?= $value['judul'] ?>"><?php
                                                                                                        if (strlen($value['judul']) <= 38) {
                                                                                                            echo Tools::limit_words($value['judul'], 38);
                                                                                                        } else {
                                                                                                            echo Tools::limit_words($value['judul'], 38) . ' ...';
                                                                                                        }
                                                                                                        ?></a></h3>
                                    <span style="text-align: justify !important;">
                                        <?php
                                        if (strlen($value['isi']) <= 160) {
                                            echo Tools::limit_words(strip_tags($value['isi']), 160);
                                        } else {
                                            echo Tools::limit_words(strip_tags($value['isi']), 160) . ' ...';
                                        }
                                        ?>
                                    </span>
                                </div>
                            </li>
                        <?php } ?>

                    </ul>
                    <div class="event-btn-holder">
                        <a href="<?= base_url('home/pengumuman') ?>" class="view-all-primary-btn">Lihat Semua</a>
                    </div>
                <?php } else { ?>
                    <div align="center"><b>Tidak Ada Pengumuman</b></div>
                <?php } ?>
            </div>
        </div>
    </div>
</div> -->
<!-- News and Event Area End Here -->

<!-- Program Area Start Here -->
<div class="brand-area">
    <h2 class="title-default-center">Program</h2>
    <div class="container">
        <div class="rc-carousel" data-loop="true" data-items="4" data-margin="30" data-autoplay="true" data-autoplay-timeout="5000" data-smart-speed="2000" data-dots="false" data-nav="false" data-nav-speed="false" data-r-x-small="2" data-r-x-small-nav="false" data-r-x-small-dots="false" data-r-x-medium="3" data-r-x-medium-nav="false" data-r-x-medium-dots="false" data-r-small="4" data-r-small-nav="false" data-r-small-dots="false" data-r-medium="4" data-r-medium-nav="false" data-r-medium-dots="false" data-r-large="4" data-r-large-nav="false" data-r-large-dots="false">
            <?php
            foreach ($program as $key => $value) {
                $appath = realpath(APPPATH . '../assets/images/program/' . $value['foto']);
                if (!empty($value['foto']) and file_exists($appath)) {
                    $image = base_url() . 'assets/images/program/' . $value['foto'];
                } else {
                    $image = base_url() . 'assets/images/slider_logo.jpg';
                }
                if (!empty($value['link'])) {
                    $link   = $value['link'];
                    $target = "target='_blank'";
                } else {
                    $link = "#";
                    $target = "";
                }
            ?>
                <div class="brand-area-box">
                    <a href="<?= $link ?>" <?= $target ?>><img src="<?= $image ?>" alt="brand"></a>
                </div>
            <?php }
            ?>

        </div>
    </div>
</div>
<!-- Program Area End Here -->

<!-- Students Say Area Start Here -->
<div class="students-say-area">
    <h2 class="title-default-center">Testimoni</h2>
    <div class="container">
        <div class="rc-carousel" data-loop="true" data-items="2" data-margin="30" data-autoplay="false" data-autoplay-timeout="10000" data-smart-speed="2000" data-dots="true" data-nav="false" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="false" data-r-x-small-dots="true" data-r-x-medium="2" data-r-x-medium-nav="false" data-r-x-medium-dots="true" data-r-small="2" data-r-small-nav="false" data-r-small-dots="true" data-r-medium="2" data-r-medium-nav="false" data-r-medium-dots="true" data-r-large="2" data-r-large-nav="false" data-r-large-dots="true">
            <?php
            foreach ($testimoni as $key => $value) {
                if ($key == 5) {
                    $key == 0;
                }
            ?>
                <div class="single-item">
                    <div class="single-item-wrapper">
                        <div class="profile-img-wrapper">
                            <a href="#" class="profile-img"><img style="width: 112px;" class="profile-img-responsive img-circle" src="<?= base_url() . 'assets/images/avatar/avatar' . ($key + 1) . '.png' ?>" alt="Testimonial"></a>
                        </div>
                        <div class="tlp-tm-content-wrapper" style="padding-top: 15px">
                            <h3 class="item-title"><a href="#"><?= $value['nama_siswa'] ?></a></h3>
                            <span class="item-designation"><?= $value['nama_kelas'] ?></span>
                            <ul class="rating-wrapper">
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                            </ul>
                            <div class="item-content"><?= $value['isi'] ?></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- Students Say Area End Here -->

<!-- Brand Area Start Here -->
<!-- <div class="brand-area">
    <h2 class="title-default-center">Partner</h2>
    <div class="container">
        <div class="rc-carousel" data-loop="true" data-items="4" data-margin="30" data-autoplay="true" data-autoplay-timeout="5000" data-smart-speed="2000" data-dots="false" data-nav="false" data-nav-speed="false" data-r-x-small="2" data-r-x-small-nav="false" data-r-x-small-dots="false" data-r-x-medium="3" data-r-x-medium-nav="false" data-r-x-medium-dots="false" data-r-small="4" data-r-small-nav="false" data-r-small-dots="false" data-r-medium="4" data-r-medium-nav="false" data-r-medium-dots="false" data-r-large="4" data-r-large-nav="false" data-r-large-dots="false">
            <?php
            // foreach ($partner as $key => $value) {
            //     $appath = realpath(APPPATH . '../assets/images/program/' . $value['foto']);
            //     if (!empty($value['foto']) and file_exists($appath)) {
            //         $image = base_url() . 'assets/images/program/' . $value['foto'];
            //     } else {
            //         $image = base_url() . 'assets/images/slider_logo.jpg';
            //     }
            //     if (!empty($value['link'])) {
            //         $link   = $value['link'];
            //         $target = "target='_blank'";
            //     } else {
            //         $link = "#";
            //         $target = "";
            //     }
            ?>
                <div class="brand-area-box">
                    <a href="<?= $link ?>" <?= $target ?>><img src="<?= $image ?>" alt="brand"></a>
                </div>
            <?php //} 
            ?>
        </div>
    </div>
</div> -->
<!-- Brand Area End Here -->