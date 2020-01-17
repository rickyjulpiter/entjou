<style type="text/css">    
    .tableku tr td:nth-child(2) {text-align: left;}
    .tableku tr td:nth-child(3) {text-align: left;}
    .tableku tr td:nth-child(4) {text-align: left;}
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
                    <th style="width:50px">No</th>
                    <th>Nama Siswa</th>
                    <th>Agenda</th>
                    <th>Deskripsi Agenda</th>
                    <th>Waktu Deadline</th>
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
    "sAjaxSource": "<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(1).'_data/'?>",
    "order": [[ 1, "ASC" ], [4, "DESC"]]
});
</script>
