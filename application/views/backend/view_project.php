<style type="text/css">    
    .tableku tr td:nth-child(2) {text-align: left;}
    .tableku tr td:nth-child(4) {text-align: left;}
</style>
<?php 
$id_materi  = $this->input->get('id_materi');
$judul_materi= $this->input->get('judul_materi');
$id_kelas   = $this->input->get('id_kelas');
$nama_kelas = $this->input->get('nama_kelas');
$id_stage   = $this->input->get('id_stage');
$nama_stage = $this->input->get('nama_stage');
?>
<section class="panel panel-info">
    <header class="panel-heading">
        <?=$title?>
        <span class="tools pull-right">
            <button type="button" class="btn btn-warning" onclick="window.history.go(-1)"><i class="fa fa-chevron-left"></i> Kembali</button>
         </span>
    </header>
    <div class="panel-body">
        <div class="col-md-12" align="center">
            <h4><?=$nama_kelas.' - '.$nama_stage. ' ['.$judul_materi.']'?></h4>
        </div>
        <?=$this->session->flashdata('notif')?>
        <div class="col-md-12">
            <br/>
            <table class="table table-striped table-bordered tableku">
            <thead>
                <tr>
                    <th style="width:50px">No</th>
                    <th>Nama Siswa</th>
                    <th>Judul Project</th>
                    <th>Dibuat</th>
                    <th>Deadline</th>
                    <th>Status</th>
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
    "sAjaxSource": "<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(1).'_data/'.$id_materi?>",
    "order": [[ 1, "ASC" ]],
    
});

</script>
