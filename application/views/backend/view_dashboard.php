<style type="text/css">
	.flot-chart{display: block;height: 200px}
	.flot-chart-pie-content {width: 200px;height: 200px;margin: auto;}
    #lineChart{width: 100%!important;}
    .huge{font-size: 40px;font-weight: bold;}
    .text-right{font-weight: 20 !important}
    .panel-primary{border: 1px solid #337ab7; color: white}
    .panel-warning{border: 1px solid #8a6d3b;}
    .panel-danger{border: 1px solid #a94442}
</style>
<!-- <div class="alert alert-info alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    Selamat datang <strong><?=$this->encrypt->decode($this->session->userdata('nama'))?></strong> di halaman Dashboard <b>Aplikasi POS (Point Of Sale)</b>
	<?=$id_client?>
	<?=$id_unit?>
</div> -->
<section class="panel panel-info">
	<header class="panel-heading">Dashboard
		<span class="tools pull-right">
			<a class="fa fa-chevron-down" href="javascript:;"></a>
            <a class="fa fa-times" href="javascript:;"></a>
		</span>
	</header>
	<div class="panel-body">
		<div class="row">
	        <div class="col-lg-4 col-md-6">
	            <div class="panel panel-warning">
	                <div class="panel-heading">
	                    <div class="row">
	                        <div class="col-xs-3">
	                            <i class="fa fa-users fa-5x"></i>
	                        </div>
	                        <div class="col-xs-9 text-right">
	                            <div class="huge"><?=$peserta?></div>
	                            <div>Peserta Kelas</div>
	                        </div>
	                    </div>
	                </div>	                
	            </div>
	        </div>
	        <div class="col-lg-4 col-md-6">
	            <div class="panel panel-primary">
	                <div class="panel-heading">
	                    <div class="row">
	                        <div class="col-xs-3">
	                            <i class="fa fa-user fa-5x"></i>
	                        </div>
	                        <div class="col-xs-9 text-right">
	                            <div class="huge"><?=$guru?></div>
	                            <div>Fasilitator</div>
	                        </div>
	                    </div>
	                </div>	                
	            </div>
	        </div>
	        <div class="col-lg-4 col-md-6">
	            <div class="panel panel-warning">
	                <div class="panel-heading">
	                    <div class="row">
	                        <div class="col-xs-3">
	                            <i class="fa fa-book fa-5x"></i>
	                        </div>
	                        <div class="col-xs-9 text-right">
	                            <div class="huge"><?=$materi?></div>
	                            <div>Materi</div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
    	<div class="row">
	        <div class="col-lg-4 col-md-6">
	            <div class="panel panel-primary">
	                <div class="panel-heading">
	                    <div class="row">
	                        <div class="col-xs-3">
	                            <i class="fa fa-check fa-5x"></i>
	                        </div>
	                        <div class="col-xs-9 text-right">
	                            <div class="huge"><?=$checkup?></div>
	                            <div>Checkup</div>
	                        </div>
	                    </div>
	                </div>	                
	            </div>
	        </div>
	        <div class="col-lg-4 col-md-6">
	            <div class="panel panel-warning">
	                <div class="panel-heading">
	                    <div class="row">
	                        <div class="col-xs-3">
	                            <i class="fa fa-newspaper-o fa-5x"></i>
	                        </div>
	                        <div class="col-xs-9 text-right">
	                            <div class="huge"><?=$blog?></div>
	                            <div>Blog</div>
	                        </div>
	                    </div>
	                </div>	                
	            </div>
	        </div>
	        <div class="col-lg-4 col-md-6">
	            <div class="panel panel-primary">
	                <div class="panel-heading">
	                    <div class="row">
	                        <div class="col-xs-3">
	                            <i class="fa fa-shopping-cart fa-5x"></i>
	                        </div>
	                        <div class="col-xs-9 text-right">
	                            <div class="huge"><?=$pesanan?></div>
	                            <div>Pesanan</div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
    	</div>
    	<?php 
    	$tipe_user = $this->encrypt->decode($this->session->userdata('tipe_user'));
    	if ($tipe_user=='admin') {?>
    	<div class="row">
    		<div class="col-md-12" align="center">
    			<label>Pengingat Admin<br>Biaya Sewa Hosting</label>
    			<img src="<?=base_url('assets/images/tagihan.png')?>" class="img-responsive">
    		</div>
    	</div>
    	<?php } ?>
	</div>	
</section>