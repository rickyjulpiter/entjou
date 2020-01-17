<style type="text/css">    
    .tableku tr td:nth-child(2) {text-align: left;}
    .tableku tr td:nth-child(4) {text-align: left;}
    .tableku tr td:nth-child(5) {text-align: left;}
</style>
<?php 
$id_post  = $this->uri->segment(3);
?>
<section class="panel panel-info">
    <header class="panel-heading">
        <?=$title?>
        <span class="tools pull-right">
            <button type="button" class="btn btn-warning" onclick="window.history.go(-1)"><i class="fa fa-chevron-left"></i> Kembali</button>
         </span>
    </header>
    <div class="panel-body">
        <div class="col-md-12">
            <h4><a href="<?=base_url().$blog[0]['slug']?>" target="_blank"><?=$blog[0]['judul']?></a></h4>
        </div>
        <?=$this->session->flashdata('notif')?>
        <div class="col-md-12">
            <br/>
            <table class="table table-striped table-bordered tableku">
            <thead>
                <tr>
                    <th style="width:50px">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Website</th>
                    <th>Komentar</th>
                    <th>Waktu Post</th>
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
    "sAjaxSource": "<?=base_url().$this->uri->segment(1).'/blog_komentar_data/'.$id_post?>",
    "order": [[ 1, "ASC" ]],
    
});

</script>
