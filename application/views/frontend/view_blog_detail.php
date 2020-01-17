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
                            $dt_foto = $blog[0]['foto'];
                            $ada = file_exists(realpath(APPPATH . '../assets/images/blog/'.$dt_foto));
                            if(!empty($dt_foto) and $ada){
                                $foto = base_url().'assets/images/blog/'.$dt_foto;
                            }else{
                                $foto = base_url().'assets/images/no-image-bp.jpg';
                            }
                            ?>
                            <img src="<?=$foto?>" class="img-responsive" alt="research" width="100%">
                            <ul class="news-date1">
                                <li><?=Tools::tgl_indo($blog[0]['waktu_post'],'d F')?></li>
                                <li><?=Tools::tgl_indo($blog[0]['waktu_post'],'Y')?></li>
                            </ul>
                        </div>
                        <h2 class="title-default-left-bold-lowhight"><a href="#"><?=$blog[0]['judul']?></a></h2>
                        <ul class="title-bar-high news-comments">
                            <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i><span>Oleh</span> <?=$blog[0]['nama_user_post']?></a></li>
                            <li><a href="#"><i class="fa fa-tags" aria-hidden="true"></i><?=$blog[0]['tags']?></a></li>
                            <li><a href="#"><i class="fa fa-comments-o" aria-hidden="true"></i><span>(<?=count($komentar)?>)</span> Komentar</a></li>
                            <li><a href="#"><i class="fa fa-calendar"></i> <?=Tools::tgl_indo($blog[0]['waktu_post'],'l, d F Y H:i')?> WIB</a></li>
                        </ul>
                        <div>
                            <?=$blog[0]['isi']?>
                        </div>
                        <ul class="news-social">
                            <li><a href="https://www.facebook.com/sharer.php?u=<?=base_url().uri_string()?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                            target="_blank" title="Bagikan ke Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="https://twitter.com/intent/tweet?url=<?=base_url().uri_string()?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                            target="_blank" title="Bagikan ke Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?=base_url().uri_string()?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                            target="_blank" title="Bagikan ke LinkedId"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            <li><a href="https://plus.google.com/share?url=<?=base_url().uri_string()?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                            target="_blank" title="Bagikan ke Google Plus"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                        </ul>
                        <div class="course-details-comments" id="komentar">
                            <h3 class="sidebar-title">(<?=count($komentar)?>) Komentar</h3>
                            <?=$this->session->flashdata('notif')?>
                            <?php 
                            if (!empty($komentar)) {
                            $av = array('avatar1.png', 'avatar2.png', 'avatar3.png', 'avatar4.png', 'avatar5.png');
                            $no=0;
                            foreach ($komentar as $key => $value) {
                                if ($no==4) {$no==0;}?>
                            <div class="media">
                                <a href="#" class="pull-left">
                                    <img alt="Comments" class="img-responsive" width="50" src="<?=base_url().'assets/images/avatar/'.$av[++$no]?>" class="media-object">
                                </a>
                                <div class="media-body">
                                    <h3><a href="#"><?=$value['nama_user']?></a></h3>
                                    <small><?=Tools::tgl_indo($value['waktu_post'],'l, d F Y H:i')?> WIB</small>
                                    <p><?=$value['komentar']?></p>
                                </div>
                            </div>
                            <?php }}else{ ?>
                            <div align="center">
                                <p>Belum Ada Komentar</p>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="leave-comments">
                            <h3 class="sidebar-title">Komentar</h3>
                            <div class="row">
                                <div class="contact-form">
                                    <form action="<?=base_url().'home/komentar_tambah'?>" method="post">
                                        <input type="hidden" name="slug" value="<?=uri_string()?>">
                                        <input type="hidden" name="id_post" value="<?=$blog[0]['id_post']?>">
                                        <fieldset>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <input type="text" placeholder="Nama" class="form-control" name="nama" oninvalid="this.setCustomValidity('Silahkan Masukan Nama Anda')" oninput="this.setCustomValidity('')" required>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <input type="email" placeholder="Email" class="form-control" name="email" oninvalid="this.setCustomValidity('Silahkan Masukan Email Anda')" oninput="this.setCustomValidity('')" required>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <input type="text" placeholder="Website" class="form-control" name="website">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <textarea placeholder="Komentar" name="komentar" class="textarea form-control" id="form-message" rows="8" cols="20" oninvalid="this.setCustomValidity('Silahkan Masukan Komentar Anda')" oninput="this.setCustomValidity('')" required></textarea>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group margin-bottom-none">
                                                    <button type="submit" class="view-all-accent-btn"> Kirim</button>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-2"></div>
        </div>
    </div>
</div>
<!-- News Page Area End Here -->
      