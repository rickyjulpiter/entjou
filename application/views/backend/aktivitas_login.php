<style type="text/css">    
    .tableku tr td:nth-child(2) {text-align: left;}
    .tableku tr td:nth-child(4) {text-align: left;}
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
                    <th>Username</th>
                    <th>Tipe User</th>
                    <th>IP</th>
                    <th>Waktu</th>
                    <th>Browser</th>
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
    "sAjaxSource": "<?=base_url().$this->uri->segment(1).'/aktivitas_data/'?>",
    "order": [[ 4, "DESC" ]],
    
});

</script>
