<div class="wrapper">            
    <div class="row">
        <div class="col-lg-12">
            <section class="panel panel-info">
                <header class="panel-heading">Pengaturan
                	<span class="pull-right">
                    <form action="<?=base_url().$this->uri->segment(1).'/pengaturan_simpan'?>" id="form-simpan" method="post" role="form" accept-charset="utf-8" enctype="multipart/form-data">
                        <button type="submit" class="btn btn-success simpan" style="margin-top: -6px"><i class="fa fa-save"></i> Simpan</a>
                     </span>
                </header>
                <div class="panel-body">
                    <?=$this->session->flashdata('notif')?>
                    <div class="cmxform form-horizontal adminex-form">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Nama / Logo</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" minlength="2" name="nama_website" placeholder="Nama website" value="<?=$data[0]['nama_website']?>" >
                            </div>
                            <div class="col-lg-5">
                                <span class="label label-danger ">Ukuran foto: ≤ 1MB</span>
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 100px; height: 100px; float:left">
                                        <?php 
                                        $logo = $data[0]['logo'];
                                        $ada = file_exists(realpath(APPPATH . '../assets/images/'.$logo));
                                        if(!empty($logo) and $ada) {
                                            $images = base_url().'assets/images/'.$logo;
                                        }else{
                                            $images = base_url().'assets/images/no-image.jpg';                                        
                                        }?>
                                        <img src="<?=$images ?>" alt="" />
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="width: 100px; height: 100px; float:left"></div>
                                    <div style="float:left; margin-left:10px">
                                        <span class="btn btn-default btn-file">
                                        <span><i class="fa fa-paper-clip"></i>&nbsp;Ganti Logo</span>
                                        <input type="file" onchange="cek_file('1MB','image','inputImage')" id="inputImage" class="default" name="inputImage"/>
                                        </span>
                                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i>&nbsp;Batal&nbsp;</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Nomor Handphone / Email</label>
                            <div class="col-lg-5">
                                <input type="text" name="hape" class="form-control" placeholder="No Handphone" value="<?=$data[0]['hape']?>">
                            </div>
                            <div class="col-lg-5">
                                <input type="text" name="email" class="form-control" placeholder="Email Aktif" value="<?=$data[0]['email']?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Deskripsi</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" name="deskripsi" placeholder="Deskripsi website" rows="5"><?=$data[0]['deskripsi']?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Alamat</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" rows="5" name="alamat" placeholder="Alamat kantor"><?=$data[0]['alamat']?></textarea>
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label class="control-label col-lg-2">Media Sosial</label>
                            <div class="col-lg-2">
                                <label>Facebook</label>
                                <input type="text" name="facebook" class="form-control"
                                 placeholder="Link Facebook" value="<?=$data[0]['facebook']?>">
                            </div>
                            <div class="col-lg-2">
                                <label>Twitter</label>
                                <input type="text" name="twitter" class="form-control"
                                 placeholder="Link Twitter" value="<?=$data[0]['twitter']?>">
                            </div>
                            <div class="col-lg-2">
                                <label>Instagram</label>
                                <input type="text" name="instagram" class="form-control"
                                 placeholder="Link Instagram" value="<?=$data[0]['instagram']?>">
                            </div>
                            <div class="col-lg-2">
                                <label>Youtube</label>
                                <input type="text" name="youtube" class="form-control"
                                 placeholder="Chanel Youtube" value="<?=$data[0]['youtube']?>">
                            </div>
                        </div>                        
                    </div>
                    <button type="submit" class="btn btn-success btn-block simpan"><i class="fa fa-save"></i> Simpan</button>
                    </form>                    
                </div>
            </section>
        </div>
    </div>
</div>