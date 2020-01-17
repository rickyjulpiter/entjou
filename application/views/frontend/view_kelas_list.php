<?php 
$CI =& get_instance();
?>
<!-- News Page Area Start Here -->
<div class="news-page-area">
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h2 class="title-default-left title-bar-high" align="center">Semua Kelas</h2>
                    </div>
                </div>
                <div class="row">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- Listed product show -->
                        <div role="tabpanel" class="tab-pane active" id="list-view">
                            <?php 
                            foreach ($kelas as $key => $value) {?>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="courses-box3">
                                    <div class="single-item-wrapper">
                                        <div class="courses-img-wrapper hvr-bounce-to-right">
                                            <?php 
                                            $appath = realpath(APPPATH . '../assets/images/kelas/'.$value['foto']);
                                            if(!empty($value['foto']) and file_exists($appath)){
                                                $image = base_url().'assets/images/kelas/'.$value['foto'];
                                            }else{
                                                $image = base_url().'assets/images/logo.jpg';
                                            }?>
                                            <img class="img-responsive" src="<?=$image?>" alt="courses">
                                            <a href="<?=base_url().$value['slug']?>"><i class="fa fa-link" aria-hidden="true"></i></a>
                                        </div>
                                        <div class="courses-content-wrapper">
                                            <h3 class="item-title"><a href="<?=base_url().$value['slug']?>"><?=$value['nama_kelas']?></a></h3>
                                            <p class="item-content"><?=Tools::limit_words($value['overview'],30)?></p>
                                            <ul class="courses-info">
                                                <li>Batas Peserta
                                                    <br><span> <?=$value['batas_peserta']?> Orang</span></li>
                                                <li>Jumlah Fasilitator
                                                    <br><span><?=count(explode(",", $value['id_guru']))?> Orang</span></li>
                                            </ul>
                                            <div class="courses-fee"><?php
                                                if ($value['harga']==0) {
                                                    echo "Gratis";
                                                }else{
                                                    echo Tools::rupiah('Rp ',$value['harga']);
                                                }
                                            ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div align="center">
                            <?php print $halaman?>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- News Page Area End Here -->