<style type="text/css">    
    .tableku tr td:nth-child(2) {text-align: left;}
    .tableku tr td:nth-child(4) {text-align: left;}
</style>
<?php 
$id_kelas   = $this->input->get('id_kelas');
$nama_kelas = $this->input->get('nama_kelas');
$id_stage   = $this->input->get('id_stage');
$nama_stage = $this->input->get('nama_stage');
?>
<section class="panel panel-info">
    <header class="panel-heading">
        <?=$title?> || <?=$nama_kelas.' - '.$nama_stage?>
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
                    <th style="width:50px">No</th>
                    <th>Kelas</th>
                    <th>Stage</th>
                    <th>Judul Materi</th>
                    <th>Materi</th>
                    <th>Games</th>
                    <th>Quiz</th>
                    <th>Project</th>
                    <th>Aksi</th>
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
    "sAjaxSource": "<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(1).'_data?id_kelas='.$id_kelas.'&nama_kelas='.$nama_kelas.'&id_stage='.$id_stage.'&nama_stage='.$nama_stage?>",
    "order": [[ 1, "ASC" ], [ 2, "ASC" ], [ 3, "ASC" ]],
    "columnDefs": [
    { "orderable": false, "targets": 4 }, { "orderable": false, "targets": 5 }, { "orderable": false, "targets": 6 }, { "orderable": false, "targets": 7 }, { "orderable": false, "targets": 8 }]
});
$('.dataTables_length').each(function () {
    $(this).addClass('text-right');
    $(this).append('<a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(1).'_detail?id_kelas='.$id_kelas.'&nama_kelas='.$nama_kelas.'&id_stage='.$id_stage.'&nama_stage='.$nama_stage?>" class="btn btn-default btn-sm pull-left" data-original-title="Tambah Data" data-toggle="tooltip" type="button" style="border"><i class="fa fa-plus"></i> Tambah</a>&nbsp&nbsp');
});

</script>
