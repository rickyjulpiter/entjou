
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
                    <th style="width:50px">No</th>
                    <th>Foto</th>
                    <th>Kategori</th>
                    <th width="150">Waktu</th>
                    <th>Link</th>
                    <th>Publish</th>
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
    "order": [[2, "ASC"], [3, "DESC"]]
});
$('.dataTables_length').each(function () {
    $(this).addClass('text-right');
    $(this).append('<a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(1).'_detail/'?>" class="btn btn-default btn-sm pull-left" data-original-title="Tambah Data" data-toggle="tooltip" type="button" style="border"><i class="fa fa-plus"></i> Tambah</a>&nbsp&nbsp');
});

</script>
