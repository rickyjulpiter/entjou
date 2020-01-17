<!-- News Page Area Start Here -->
<div class="news-page-area">
    <div class="container">
        <h2 class="title-default-left title-bar-high" align="center">Blog</h2>
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                <div class="row">
                    <?php 
                    foreach ($data as $key => $value) {
                        $ada = file_exists(realpath(APPPATH . '../assets/images/blog/thumbnail/'.$value['foto']));
                        if(!empty($value['foto']) and $ada){
                            $foto = base_url().'assets/images/blog/thumbnail/'.$value['foto'];
                        }else{
                            $foto = base_url().'assets/images/no-image-bp.jpg';
                        }
                    ?>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="news-box">
                            <div class="news-img-holder">
                                <img src="<?=$foto?>" class="img-responsive" width="100%" alt="research">
                                <ul class="news-date2">
                                    <li><?=Tools::tgl_indo($value['waktu_post'],'d F')?></li>
                                    <li><?=Tools::tgl_indo($value['waktu_post'],'Y')?></li>
                                </ul>
                            </div>
                            <div class="konten">
                                <h3 class="title-news-left-bold"><a href="<?=base_url().$value['slug']?>" target="_blank" title="<?=$value['judul']?>"><?php
                                if (strlen($value['judul'])>=30) {
                                    echo Tools::limit_words($value['judul'],30).'...';
                                }else{
                                    echo $value['judul'];
                                }?>
                                </a></h3>
                                <ul class="title-bar-high news-comments">
                                    <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i><span>Oleh</span> <?=$value['nama_user_post']?></a></li>
                                    <li><a href="#"><i class="fa fa-tags" aria-hidden="true"></i><?php if (!empty($value['tags'])) { echo $value['tags'];}else{echo "Tidak Ada";}?></a></li>
                                </ul>
                                <p style="text-align: justify;">
                                <?php 
                                    if (strlen($value['isi'])>=50) {
                                        echo Tools::limit_words(strip_tags($value['isi']),48).' ...';
                                    }else{
                                        echo Tools::limit_words(strip_tags($value['isi']),48);
                                    }
                                ?>
                                </p>
                            </div>
                        </div>

                    </div>
                    <?php } ?>
                    <div align="center">
                        <?php print $halaman?>

                    </div>
                   <!--  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        
                    </div>   -->                 

                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                <div class="sidebar">
                    <!-- <div class="sidebar-box">
                        <div class="sidebar-box-inner">
                            <h3 class="sidebar-title">Search</h3>
                            <div class="sidebar-find-course">
                                <form id="checkout-form">
                                    <div class="form-group course-name">
                                        <input id="first-name" placeholder="Type Here . . .." class="form-control" type="text" />
                                    </div>
                                    <div class="form-group">
                                        <button class="sidebar-search-btn-full disabled" type="submit" value="Login">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> -->
                    <div class="sidebar-box">
                        <div class="sidebar-box-inner">
                            <h3 class="sidebar-title">Post Terakhir</h3>
                            <div class="sidebar-latest-research-area">
                                <ul>
                                    <?php 
                                    foreach ($data2 as $key => $value) {
                                        $ada = file_exists(realpath(APPPATH . '../assets/images/blog/thumbnail/'.$value['foto']));
                                    if(!empty($value['foto']) and $ada){
                                        $foto = base_url().'assets/images/blog/thumbnail/'.$value['foto'];
                                    }else{
                                        $foto = base_url().'assets/images/no-image-bp.jpg';
                                    }
                                    ?>
                                    <li>
                                        <div class="latest-research-img">
                                            <a href="<?=base_url().$value['slug']?>" a><img src="<?=$foto?>" class="img-responsive" alt="skilled" width="100%"></a>
                                        </div>
                                        <div class="latest-research-content">
                                            <h4><?=Tools::tgl_indo($value['waktu_post'],'d F Y')?></h4>
                                            <p style="text-align: justify;" title="<?=$value['judul']?>"> <?=Tools::limit_words(strip_tags($value['judul']),10)?> ....</p>
                                        </div>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- News Page Area End Here