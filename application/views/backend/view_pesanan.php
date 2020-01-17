<style type="text/css">    
    .tableku tr td:nth-child(3) {text-align: left;}
    .tableku tr td:nth-child(5) {text-align: right;}
</style>
<section class="panel panel-info">
    <header class="panel-heading">
        <?=$title?>
        <span class="tools pull-right">
            <button type="button" class="btn btn-warning" onclick="window.history.go(-1)"><i class="fa fa-chevron-left"></i> Kembali</button>
         </span>
    </header>
    <div class="panel-body">
        <div class="col-md-12">
            <br/>
            <table class="table table-striped table-bordered tableku">
            <thead>
                <tr>
                    <th style="width:50px">No</th>
                    <th>No Pesanan</th>
                    <th>Nama Siswa</th>
                    <th>Nama Kelas</th>
                    <th>Total</th>
                    <th>Waktu</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            </table>
            <div style="text-align:center;"></div>
        </div>
    </div>
</section>
<!-- Modal Konfirmasi -->
<div id="konfirmasi" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <b>Konfirmasi Pembayaran</b>
                <button type="button" class="close" data-dismiss="modal"><b style="color: red"></b></button>
            </div>
            <div class="modal-body">
                <!-- <form method="post" action="<?=base_url('siswa/pass_konfirmasi')?>"> -->
                    <div class="panel-body">
                        <table class="table table-striped">
                            <tr>
                                <td>No Pesanan</td>
                                <td>:</td>
                                <td id="id_pesanan"></td>
                            </tr>
                            <tr>
                                <td>Waktu Pemesanan</td>
                                <td>:</td>
                                <td id="waktu"></td>
                            </tr>
                            <tr>
                                <td>Nama Siswa</td>
                                <td>:</td>
                                <td id="nama_siswa"></td>
                            </tr>
                            <tr>
                                <td>Nama Kelas</td>
                                <td>:</td>
                                <td id="nama_kelas"></td>
                            </tr>
                            <tr>
                                <td>Total Pembayaran</td>
                                <td>:</td>
                                <td id="total"></td>
                            </tr>
                            <tr>
                                <td>Tanggal Pembayaran</td>
                                <td>:</td>
                                <td id="waktu_bayar"></td>
                            </tr>
                            <tr>
                                <td>Jumlah Dibayar</td>
                                <td>:</td>
                                <td id="nominal"></td>
                            </tr>
                            <tr>
                                <td>Atas Nama</td>
                                <td>:</td>
                                <td id="atas_nama"></td>
                            </tr>
                            <tr>
                                <td>Bank Pengirim <i class="fa fa-arrow-right"></i> Bank Tujuan</td>
                                <td>:</td>
                                <td><span id="bank_pengirim"></span> <i class="fa fa-arrow-right"></i> <span id="bank_tujuan"></span></td>
                            </tr>
                        </table>
                        
                        <div class="form-group">
                            <center><b>Foto Bukti Pembayaran</b></center><br>
                            <img id="file" src="" class="img-responsive">
                        </div>
                        <div class="form-group">
                            <a href='javascript:;' id="btn-konfirmasi" data-konfirmasi='' type='button' class='btn btn-primary btn-block tooltips konfirmasi' data-original-title='Konfirmasi Pembayaran' data-dismiss="modal" data-toggle='tooltip' data-placement='top' title=''><i class='fa fa-check'></i> Konfirmasi</a>
                            <!-- <button type="button" class="btn btn-primary simpan btn-block"><i class="fa fa-check"></i> Konfirmasi</button> -->
                        </div>
                    </div>                    
                <!-- </form> -->
            </div>
            
        </div>
    </div>
</div>
<!-- Modal Konfirmasi -->

<script type="text/javascript">
    var datatb = $(".tableku").dataTable({
        "responsive": true,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "<?=base_url().$this->uri->segment(1).'/pesanan_data/'?>",
        "order": [[ 5, "DESC" ]],
        
    });
    $(document).ready(function(){
        $('#konfirmasi').on('show.bs.modal', function(e) {
            $(e.currentTarget).find('#btn-konfirmasi').attr("data-konfirmasi",$(e.relatedTarget).data('id_pesanan'));
            $(e.currentTarget).find('#id_pesanan').html($(e.relatedTarget).data('id_pesanan'));
            $(e.currentTarget).find('#waktu').html($(e.relatedTarget).data('waktu'));
            $(e.currentTarget).find('#nama_siswa').html($(e.relatedTarget).data('nama_siswa'));
            $(e.currentTarget).find('#nama_kelas').html($(e.relatedTarget).data('nama_kelas'));
            $(e.currentTarget).find('#total').html($(e.relatedTarget).data('total'));
            $(e.currentTarget).find('#waktu_bayar').html($(e.relatedTarget).data('waktu_bayar'));
            $(e.currentTarget).find('#nominal').html($(e.relatedTarget).data('nominal'));
            $(e.currentTarget).find('#atas_nama').html($(e.relatedTarget).data('atas_nama'));
            $(e.currentTarget).find('#bank_pengirim').html($(e.relatedTarget).data('bank_pengirim'));
            $(e.currentTarget).find('#bank_tujuan').html($(e.relatedTarget).data('bank_tujuan'));
            $(e.currentTarget).find('#file').attr("src", "<?=base_url();?>assets/bukti_pembayaran/"+$(e.relatedTarget).data('file'));

        });

    });

    function SwalKonfirmasi(konfirmasi){swal({title: 'Apakah kamu yakin ingin konfirmasi?',text: "Jika admin sudah mengkonfirmasi. Kelas akan dapat dibuka oleh siswa dan kofirmasi tidak dapat dibatalkan!",type: 'warning',showCancelButton: true,showLoaderOnConfirm: true,preConfirm: function() {return new Promise(function(resolve) {$.ajax({url: "<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(1).'_konfirmasi'?>",type: 'POST',data: {'konfirmasi':konfirmasi, '<?=$this->security->get_csrf_token_name()?>' : '<?=$this->security->get_csrf_hash()?>'},dataType: 'json'}).done(function(response){swal('Berhasil dikonfirmasi!', response.message, 'success');datatb.fnDraw();}).fail(function(){swal('Oops...', 'Terjadi Kesalahan !', 'error');datatb.fnDraw();});});},allowOutsideClick: false});}$(document).ready(function(){$(document).on('click', '.konfirmasi', function(e){var konfirmasi = $(this).data('konfirmasi');SwalKonfirmasi(konfirmasi);e.preventDefault();});
    });

</script>
