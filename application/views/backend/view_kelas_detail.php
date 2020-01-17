<script type="text/javascript">
    $(document).ready(function(){
        <?php 
        for ($i=0; $i<sizeof($id_guru); $i++) { 
            $ar_id_guru[] = "'".$id_guru[$i]."'";
        }
        $ars_id_guru = '["'.implode('","', $ar_id_guru).'"]';
        ?>
        var guru = <?=$ars_id_guru?>;
        $("#guru").val(guru).trigger("change");
    });
</script>

<?php 
$CI =& get_instance();
$tipe_user    = $this->encrypt->decode($this->session->userdata('tipe_user'));
if (!empty($data)) {
    $nama_kelas     = $data[0]['nama_kelas'];
    $kategori       = $data[0]['kategori'];      
    $harga          = 'Rp. '.number_format($data[0]['harga'],0,',','.');
    $harga1         = $data[0]['harga'];
    $foto           = $data[0]['foto'];
    $overview       = $data[0]['overview'];
    $jumlah_stage   = $data[0]['jumlah_stage'];
    $batas_peserta  = $data[0]['batas_peserta'];
}else{
    $nama_kelas = $kategori = $foto = $harga = $harga1 = $overview = $jumlah_stage = $batas_peserta = "";
}?>

<?php 
if ($tipe_user=="admin") {
    echo form_open(uri_string(), array('class' =>'form-horizontal', 'id'=>'form-simpan', 'enctype' => 'multipart/form-data' ,'role' => 'form'));
}?>
<section class="panel panel-info">
    <header class="panel-heading">
        <?=$title?> 
        <span class="tools pull-right">
            <button type="button" class="btn btn-warning" onclick="window.history.go(-1)"><i class="fa fa-chevron-left"></i> Kembali</button>&nbsp
            <button class="btn btn-info simpan" type="submit"><i class="fa fa-save"></i> Simpan </button>
        </span>
    </header>
    <div class="panel-body">
        <?=validation_errors()?>
        <?=$this->session->flashdata('notif');?>
        <div class="col-md-12">
            <label>Foto Sampul</label>
            <div class="form-group">
                <div class="col-md-9">
                    <div class="img-container">
                        <img id="image" src="<?php if(!empty($foto)){echo base_url().'assets/images/kelas/'.$foto;}else{echo "";}?>" alt="Browse Gambarmu">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="img-preview preview-lg"></div>
                    </div>
                    <div class="form-group text-center">
                        <div class="btn-group">
                            <button class="btn btn-primary tooltips" data-original-title="Zoom In" data-toggle="tooltip" data-placement="top" title="" id="zoomIn" type="button"><i class="fa fa-search-plus"></i></button>
                            <button class="btn btn-primary tooltips" data-original-title="Zoom Out" data-toggle="tooltip" data-placement="top" title="" id="zoomOut" type="button"><i class="fa fa-search-minus"></i></button>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-primary tooltips" data-original-title="Rotate Left" data-toggle="tooltip" data-placement="top" title="" id="rotateLeft" type="button"><i class="fa fa-rotate-left"></i></button>
                            <button class="btn btn-primary tooltips" data-original-title="Rotate Right" data-toggle="tooltip" data-placement="top" title="" id="rotateRight" type="button"><i class="fa fa-rotate-right"></i></button>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-primary tooltips" data-original-title="Flip Horizontal" data-toggle="tooltip" data-placement="top" title="" id="fliphorizontal" type="button"><i class="fa fa-arrows-h"></i></button>
                            <button class="btn btn-primary tooltips" data-original-title="Flip Vertical" data-toggle="tooltip" data-placement="top" title="" id="flipvertical" type="button"><i class="fa fa-arrows-v"></i></button>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <div class="btn-group">
                        <label class="btn btn-danger" for="inputImage" title="Upload image file">
                            <span data-toggle="tooltip" data-animation="false" title="Pilih Gambar">
                                <input name="covers" type="hidden" value="<?php if (!empty($foto)) {echo $foto;}?>"></input>
                                <input name="cover" onchange="cek_file('2MB','image','inputImage')" type="file" class="sr-only" id="inputImage" accept=".jpg,.jpeg,.png,.bmp">
                                <span class="fa fa-upload"></span> Browse
                            </span>
                        </label>
                        <button class="btn btn-danger tooltips" data-original-title="Reset" data-toggle="tooltip" data-placement="top" title="" id="reset" type="button"><i class="fa fa-refresh"></i> Reset</button>
                    </div>
                    <div style="margin-top: 20px">
                        <button class="btn btn-success simpan" type="submit"><i class="fa fa-save"></i> Simpan </button>
                    </div>
                </div>
                <input type="hidden" id="dataX" name="x">
                <input type="hidden" id="dataY" name="y">
                <input type="hidden" id="dataWidth" name="width">
                <input type="hidden" id="dataHeight" name="height">
                <input type="hidden" id="dataRotate" name="rotate">
                <input type="hidden" id="dataScaleX" name="flipx">
                <input type="hidden" id="dataScaleY" name="flipy">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">                    
                <label>Nama Kelas</label>
                <input type="hidden" name="id" value="<?=$this->uri->segment(3)?>">
                <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" value="<?=$CI->input('nama_kelas',$nama_kelas)?>" placeholder="Nama Kelas">
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <label>Jenis</label>
                        <select class="form-control" id="fee" name="fee">
                            <option value="">-Pilih-</option>
                            <option value="0">Gratis</option>
                            <option value="1">Berbayar</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Harga</label>
                        <input type="text" id="harga" name="harga" class="form-control" value="<?=$CI->input('harga', $harga)?>" placeholder="Masukan harga kursus kelas">
                    </div>
                </div>
            </div>
            <div class="col-md-6">                    
                <label>Overview</label>
                <textarea class="form-control" rows="6" placeholder="Tuliskan overview" name="overview"><?=$CI->input('overview',$overview)?></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <label>Jumlah Stage</label>                    
                        <input type="number" class="form-control" name="jumlah_stage" min="1" value="<?=$CI->input('jumlah_stage',$jumlah_stage)?>" placeholder="Jumlah Stage">
                    </div>
                    <div class="col-md-6">
                        <label>Batas Peserta</label>
                        <input type="number" class="form-control" name="batas_peserta" min="<?=$min_kelas?>" value="<?=$CI->input('batas_peserta',$batas_peserta)?>" placeholder="Batas Peserta">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <label>Kategori</label>
                        <select class="form-control select2" id="kategori" name="kategori" required>
                            <option value="">-Pilih-</option>
                            <option value="lainnya">Kategori Lainnya</option>
                            <?php 
                            foreach ($kat as $key => $value) {
                                if ($value['kat']==$kategori) {
                                    $selected = 'selected';
                                }else{
                                    $selected = '';
                                }
                                echo "<option $selected>".$value['kat']."</option>";
                            }?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>-</label>
                        <input type="text" id="kategori1" name="kategori1" class="form-control" placeholder="Masukan nama kategori">
                    </div>
                </div>
            </div>
        </div>
<?=form_close(); ?>

        <?php 
        if (!empty($data)) {?>
        <div class="row">
            <div class="col-md-12">
            <?=$this->session->flashdata('notif')?>
            <div class="hr-sect"><b>Data Stage</b></div>
                <?php 
                if ($tipe_user=="admin") {?>
                <form action="<?=base_url().'kelas/tambah_stage'?>" method="POST">
                    <input type="hidden" name="id_kelas1" value="<?=$this->uri->segment(3);?>">
                    <input type="hidden" name="nama_kelas1" value="<?=$nama_kelas?>">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <b>Tambah Stage</b></button>
                </form>
                <?php } ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped tableku">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Oleh</th>
                                <th>Waktu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no=0;
                            foreach ($stage as $stage) {?>
                            <tr>
                                <td><?=++$no?></td>
                                <td><?=$stage['nama_stage']?></td>
                                <td><?=$stage['nama_guru']?></td>
                                <td><?=$stage['waktu_edit']?></td>
                                <td>
                                    <a href="<?=base_url().'materi?id_kelas='.$this->uri->segment(3).'&nama_kelas='.$nama_kelas.'&id_stage='.$this->encrypt->encode($stage['id_stage']).'&nama_stage='.$stage['nama_stage']?>" class="btn btn-warning btn-sm" target="_blank" title="Lihat Materi"><i class="fa fa-eye"></i> Materi</a> || 
                                    <a href="#" class="btn btn-danger btn-sm"><i class="fa fa-close" title="Hapus Data"></i> Hapus</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="hr-sect"><b>Data Fasilitator</b></div>
        <form action="<?=base_url().'kelas/tambah_fasilitator'?>" method="POST">
            <?php 
            if ($tipe_user=="admin") {?>
            <div class="form-group">
                <div class="col-md-10">
                    <label>Tambah Fasilitator | 
                    <small><i>Catatan : Klik tombol OK jika sudah menambah / mengurang data fasilitator</i></small></label>
                    <input type="hidden" name="id2" value="<?=$this->uri->segment(3)?>">                    
                    <select class="form-control select2" id="guru" name="guru[]" multiple>
                        <?php 
                        foreach ($guru as $guru) {?>
                        <option value="'<?=$guru['id_user']?>'"><?=$guru['nama_lengkap']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>-</label>
                    <button type="submit" class="btn btn-info btn-block"><i class="fa fa-check"></i> Ok</button>
                </div>
            </div>
            <?php } ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped tableku">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>Posisi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no=0;
                        foreach ($guru_kelas as $gk) {?>
                        <tr>
                            <td><?=++$no?></td>
                            <td><?=$gk['nama_lengkap']?></td>
                            <td><?=$gk['tempat_lahir']?></td>
                            <td><?=$gk['tanggal_lahir']?></td>
                            <td><?=$gk['posisi']?></td>
                            <td><a href="<?=base_url().'user/user_detail/'.$this->encrypt->encode($gk['id_user'])?>" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> Lihat Profil</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </form>
        <?php } ?>
               
    </div>
</section>

<div id="stage" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><b style="color:red">x</b></button>
      </div>
      <div class="modal-body">
        <form action="<?=base_url().'kelas/tambah_stage'?>">
            <div class="table-responsive">
                <table class="table table-striped table-bordered tableku" style="font-size: 12px">
                    <input type="hidden" name="id_kelas1" value="<?=$this->uri->segment(3);?>">
                    <input type="hidden" name="nama_kelas1" value="<?=$nama_kelas?>">
                    <thead>
                        <tr>
                            <th colspan="2" style="padding: 12px"><b style="font-size: 15px">Data Stage</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td align="right">Nama Stage</td>
                            <td>
                                <input name="nama_stage" class="form-control" required="" placeholder="Nama Stage">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button class="btn btn-primary btn-block simpan"><i class="fa fa-floppy"></i> Simpan</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-tutup btn-default" data-dismiss="modal">Tutup</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        cropper(1,1);
        var fee1 = "<?=$harga1?>";
        if (fee1==0) {
            $('#fee option[value=0]').attr('selected','selected');
            $('#harga').attr('disabled','disabled');
        }else if(fee1>0){
            $('#fee option[value=1]').attr('selected','selected');
            $('#harga').removeAttr('disabled');
        }
        $('#fee').on('change', function(){
            var fee = this.value;
            if (fee==0) {
                $('#harga').val(0);
                $('#harga').attr('disabled','disabled');
            }else if (fee>0){
                $('#harga').val("");
                $('#harga').removeAttr('disabled');
                $('#harga').focus();
            }
        });
        $('#nama_kelas').keyup(function(){
            this.value = this.value.ucwords();
        });
        $('#harga').keyup(function(){
            this.value = formatRupiah(this.value, 'Rp. ');
        });
        $('#kategori1').attr('disabled','disabled');
        $('#kategori').on('change', function(){
            var kat = $('#kategori').val();
            if (kat=='lainnya') {
                $('#kategori1').removeAttr('disabled');
                swal('Informasi!','Silahkan masukan nama kategori lainnya','success');
            }else{
                $('#kategori1').attr('disabled','disabled');
            }
        });
    });    
</script>