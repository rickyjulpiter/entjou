<?php 
$CI =& get_instance();
?>
<!-- News Details Page Area Start Here -->
<div class="news-details-page-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-1 col-md-1 col-sm-2"></div>
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-12">
                <div class="row news-details-page-inner">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="news-img-holder">
                            <?php 
                            $dt_foto = $pengumuman[0]['foto'];
                            $ada = file_exists(realpath(APPPATH . '../assets/images/pengumuman/thumbnail/'.$dt_foto));
                            if(!empty($dt_foto) and $ada){
                                $foto = base_url().'assets/images/pengumuman/thumbnail/'.$dt_foto;
                            }else{
                                $foto = base_url().'assets/images/no-image-bp.jpg';
                            }
                            ?>
                            <img src="<?=$foto?>" class="img-responsive" alt="research" width="100%">
                            <ul class="news-date1">
                                <li><?=Tools::tgl_indo($pengumuman[0]['waktu_post'],'d F')?></li>
                                <li><?=Tools::tgl_indo($pengumuman[0]['waktu_post'],'Y')?></li>
                            </ul>
                        </div>
                        <h2 class="title-default-left-bold-lowhight"><a href="#"><?=$pengumuman[0]['judul']?></a></h2>
                        <ul class="title-bar-high news-comments">
                            <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i><span>Oleh</span> <?=$pengumuman[0]['nama_user_post']?></a></li>
                            <li><a href="#"><i class="fa fa-calendar"></i> <?=Tools::tgl_indo($pengumuman[0]['waktu_post'],'l, d F Y H:i')?> WIB</a></li>
                        </ul>
                        <div style="text-align: justify !important;">
                            <?=$pengumuman[0]['isi']?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-2"></div>
        </div>
    </div>
</div>
<!-- News Page Area End Here -->
      