<?php 
$tipe_user    = $this->encrypt->decode($this->session->userdata('tipe_user'));
?>
<style type="text/css">    
    .tableku tr td:nth-child(2) {text-align: left;}
    .tableku tr td:nth-child(3) {text-align: right;}
</style>
<section class="panel panel-info">
    <header class="panel-heading">
        <?=$title?> 
        <span class="tools pull-right">
            <a class="fa fa-chevron-down" href="javascript:;"></a>
            <a class="fa fa-times" href="javascript:;"></a>
         </span>
    </header>
    <div class="panel-body">
        <?=$this->session->flashdata('notif')?>
        <div class="col-md-12">
            <br/>
            <table class="table table-striped table-bordered tableku">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th width="150">Nama</th>
                    <th width="100">Harga</th>
                    <th>Jumlah Stage</th>
                    <th>Batas Peserta</th>                    
                    <th>Fasilitator</th>
                    <th width="130">Waktu</th>
                    <th>Status</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            </table>
            <div style="text-align:center;"></div>
        </div>
    </div>
</section>
<script type="text/javascript">
var datatb = $(".tableku").dataTable({
    "responsive": true,
    "bProcessing": true,
    "bServerSide": true,
    "sAjaxSource": "<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(1).'_data/'?>",
    "order": [[ 6, "DESC" ]]
});
<?php 
if ($tipe_user=="admin") {?>
$('.dataTables_length').each(function () {
    $(this).addClass('text-right');
    $(this).append('<a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(1).'_detail/'?>" class="btn btn-default btn-sm pull-left" data-original-title="Tambah Data" data-toggle="tooltip" type="button" style="border"><i class="fa fa-plus"></i> Tambah</a>&nbsp&nbsp');
});
<?php } ?>

</script>
