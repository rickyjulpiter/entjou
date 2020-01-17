<?php 
$CI =& get_instance();
?>
<!-- Registration Page Area Start Here -->
<div class="registration-page-area bg-secondary" style="padding: 25px 0 70px;">
    <div class="container">
        <h2 class="sidebar-title">Pesanan</h2>
        <?=$this->session->flashdata('notif')?>
        <div class="row">
            <div class="col-md-4">
                <div class="courses-box1">
                    <div class="single-item-wrapper">
                        <div class="courses-img-wrapper hvr-bounce-to-bottom" style="width: 100%">
                            <?php 
                            $appath = realpath(APPPATH . '../assets/images/user/'.$profil[0]['foto']);
                            if(!empty($profil[0]['foto']) and file_exists($appath)){
                                $image = base_url().'assets/images/user/'.$profil[0]['foto'];
                            }else{
                                if ($profil[0]['jk']=="L") {
                                    $image = base_url().'assets/images/avatar/male.jpg';
                                }else{
                                    $image = base_url().'assets/images/avatar/female.jpg';
                                }
                            }?>
                            <img class="img-responsive" src="<?=$image?>">
                        </div>
                        
                        <div class="panel-body sosial-media" align="center">
                            <div class="col-xs-3">
                                <a href="#" target="_blank" title="Facebook" class="btn btn-warning btn-block"><i class="fa fa-facebook fa-2x" aria-hidden="true"></i></a>
                            </div>
                            <div class="col-xs-3">
                                <a href="#" target="_blank" title="Twitter" class="btn btn-warning btn-block"><i class="fa fa-twitter fa-2x" aria-hidden="true"></i></a>
                            </div>
                            <div class="col-xs-3">
                                <a href="#" target="_blank" title="Instagram" class="btn btn-warning btn-block"><i class="fa fa-instagram fa-2x" aria-hidden="true"></i></a>
                            </div>
                            <div class="col-xs-3">
                                <a href="#" target="_blank" title="Youtube" class="btn btn-warning btn-block"><i class="fa fa-youtube fa-2x" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <table class="table tabel-diri">
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td><?=ucwords($profil[0]['nama_lengkap'])?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td><?=$profil[0]['email']?></td>
                    </tr>
                    <tr>
                        <td>Whatsapp</td>
                        <td>:</td>
                        <td><?=$profil[0]['wa']?></td>
                    </tr>
                    <tr>
                        <td width="200">Tentang Saya</td>
                        <td>:</td>
                        <td><?=$profil[0]['tentang']?></td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- Start Menu Siswa -->
        <div class="row menu-siswa">
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <a href="<?=base_url('siswa')?>" class="btn btn-block btn-menu">Profil</a>
            </div>
            <div class="col-md-2">
                <a href="<?=base_url('siswa/misi')?>" class="btn btn-block btn-menu">Misi</a>
            </div>
            <div class="col-md-2">
                <a href="<?=base_url('siswa/agenda')?>" class="btn btn-block btn-menu">Agenda</a>
            </div>
            <div class="col-md-2">
                <a href="<?=base_url('siswa/pengumuman')?>" class="btn btn-block btn-menu">Pengumuman</a>
            </div>
            <div class="col-md-2">
                <a href="<?=base_url('siswa/pesanan')?>" class="btn btn-block btn-menu aktif">Pesanan</a>
            </div>
            <div class="col-md-1"></div>
        </div>
        <!-- End Menu Siswa -->
        <!-- Start pengumuman -->
        <div class="panel-body">
            <?php 
            if (!empty($pesanan)) {?>
            <table class="table table-bordered table-striped table-siswa">
                <thead>
                    <tr>
                        <th>No Pesanan</th>
                        <th>Nama Kelas</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($pesanan as $key => $value) {
                        if ($value['status']=="menunggu_bayar") {
                            $status = "<label class='label label-danger'>Menunggu Pembayaran</label>";
                        }elseif ($value['status']=="proses") {
                            $status = "<label class='label label-warning'>Menunggu Verifikasi Admin</label>";
                        }else{
                            $status = "<label class='label label-success'>Lunas</label>";
                        }
                        ?>
                    <tr>
                        <td align="center"><?=$value['id_pesanan']?></td>
                        <td><?=$value['nama_kelas']?></td>
                        <td align="center"><?=Tools::tgl_indo($value['waktu'])?></td>
                        <td align="center"><?="Rp ".number_format($value['total'],0,',','.')?></td>
                        <td align="center"><?=$status?></td>
                        <?php 
                        if ($value['status']!='menunggu_bayar') {
                            echo "<td align='center'>-</td>";
                        }else{?>
                        <td align="center">
                            <a href="#konfirmasi" 
                            data-id_pesanan="<?=$value['id_pesanan']?>" 
                            data-nama_kelas="<?=$value['nama_kelas']?>" 
                            data-total="<?="Rp ".number_format($value['total'],0,',','.')?>" 
                            data-waktu="<?=$value['waktu']?>"
                            data-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-money"></i> Konfirmasi Pembayaran</a>
                        </td>
                        <?php } ?>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php }else{ ?>
            <div align="center" class="alert-notif alert-danger" role="alert" style="border:solid 1px;">Belum ada pesanan. Silahkan ambil kelas <a href="<?=base_url('home/kelas')?>">Disini</a></div>
            <?php } ?>
        </div>
        <!-- End pengumuman -->

    </div>
</div>
<!-- Registration Page Area End Here -->
<!-- Modal Konfirmasi Pembayaran -->
<div id="konfirmasi" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <b>Konfirmasi Pembayaran</b>
                <button type="button" class="close" data-dismiss="modal"><b style="color:red">x</b></button>
            </div>
            <div class="modal-body">
                <?=form_open(base_url('siswa/unggah_bukti'), array('class' =>'form-horizontal', 'enctype' => 'multipart/form-data' ,'role' => 'form', 'id'=>'form-simpan'));?>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>No Pesanan</label>
                            <input type="text" class="form-control" name="id_pesanan" id="id_pesanan" readonly>
                        </div>
                        <div class="col-md-6">
                            <label>Nama Kelas</label>
                            <input type="text" class="form-control" id="nama_kelas" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Total Pembayaran</label>
                            <input type="text" class="form-control" id="total" readonly>
                        </div>
                        <div class="col-md-6">
                            <label>Waktu</label>
                            <input type="text" class="form-control" id="waktu" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Tanggal Transfer</label>
                            <input type="text" class="form-control tanggal" name="waktu_bayar" placeholder="Tanggal Transfer" readonly>
                        </div>
                        <div class="col-md-6">
                            <label>Jumlah Transfer</label>
                            <input type="text" class="form-control" onkeyup="rupiah(this)" id="nominal" name="nominal" placeholder="Jumlah yang ditransfer" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Nama Pengirim</label>
                            <input type="text" class="form-control" name="atas_nama" placeholder="Nama Pengirim (Rekening)" required>
                        </div>
                        <div class="col-md-6">
                            <label>Waktu Sekarang</label>
                            <input type="text" class="form-control" value="<?=date('d-m-Y H:i:s')?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Bank Pengirim</label>
                            <input type="text" class="form-control" name="bank_pengirim" placeholder="Bank Pengirim" required>
                        </div>
                        <div class="col-md-6">
                            <label>Bank Tujuan</label>
                            <input type="text" class="form-control" name="bank_tujuan" placeholder="Bank Tujuan" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-9">
                            <div class="img-container">
                                <img id="image" width="100%" src="" alt="Browse Gambarmu">
                            </div>
                        </div>
                        <label>Unggah Foto</label>
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
                                            <input name="cover" onchange="cek_file('2MB','image','inputImage')" type="file" class="sr-only" id="inputImage" accept=".jpg,.jpeg,.png,.bmp">
                                            <span class="fa fa-search"></span> Browse
                                        </span>
                                    </label>
                                    <button class="btn btn-danger tooltips" data-original-title="Reset" data-toggle="tooltip" data-placement="top" title="" id="reset" type="button"><i class="fa fa-refresh"></i> Reset</button>
                                </div>
                            </div>
                            <div style="margin-top: 20px;text-align: center;">
                                <button class="btn btn-success btn-block simpan" type="submit"><i class="fa fa-upload"></i> Unggah Bukti </button>
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
                <?=form_close();?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Konfirmasi Pembayaran -->

<script type="text/javascript">
    $(document).ready(function(){
        cropper(1,1);

        $('#form-simpan').on('submit', function(){
            if ($('#inputImage').val()=="") {
                swal('Peringatan !','Silahkan masukan file bukti pembayaran', 'error');
                $('.simpan').removeAttr("disabled");
                $(".simpan").html("<i class='fa fa-save'></i> Simpan");
                return false;
            }
        });
        $('#konfirmasi').on('show.bs.modal', function(e) {
            $(e.currentTarget).find('#id_pesanan').val($(e.relatedTarget).data('id_pesanan'));
            $(e.currentTarget).find('#nama_kelas').val($(e.relatedTarget).data('nama_kelas'));
            $(e.currentTarget).find('#total').val($(e.relatedTarget).data('total'));
            $(e.currentTarget).find("#waktu").val($(e.relatedTarget).data('waktu'));
        });
    });
    function rupiah(objek) { 
         separator = "."; 
         a = objek.value; 
         b = a.replace(/[^\d]/g,""); 
         c = ""; 
         panjang = b.length; 
         j = 0; for (i = panjang; i > 0; i--) { 
         j = j + 1; if (((j % 3) == 1) && (j != 1)) { 
         c = b.substr(i-1,1) + separator + c; } else { 
         c = b.substr(i-1,1) + c; } } objek.value = c;
    }
</script>