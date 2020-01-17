<?php 
$CI =& get_instance();
?>
<style type="text/css">
    .single-item{padding-right: 25px;}
    h2.sidebar-title a:hover {color: black !important;}
    .error {color: #ac2925;margin-bottom: 15px;}
    .event-tooltip {
        width:150px;
        background: rgba(0, 0, 0, 0.85);
        color:#FFF;
        padding:10px;
        position:absolute;
        z-index:10001;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 11px;

    }
</style>
<link href='<?php echo base_url();?>assets/frontend/css/fullcalendar.css' rel='stylesheet' />
<link href="<?php echo base_url();?>assets/frontend/css/bootstrapValidator.min.css" rel="stylesheet" />        
<script src='<?php echo base_url();?>assets/frontend/js/moment.min.js'></script>
<script src="<?php echo base_url();?>assets/frontend/js/bootstrapValidator.min.js"></script>
<script src="<?php echo base_url();?>assets/frontend/js/fullcalendar.min.js"></script>

<!-- Registration Page Area Start Here -->
<div class="registration-page-area bg-secondary" style="padding: 25px 0 70px;">
    <div class="container">
        <h2 class="sidebar-title">Agenda
        <div class="pull-right">
            <form>
                <?php 
                $p = array('Hari Ini','Kemarin','Akan Datang');
                $x = $this->input->get('p');
                ?>
                <select class="form-control" name="p" onchange="this.form.submit()">
                    <?php 
                    foreach ($p as $key => $value) {
                        if ($value==$x) {
                            $selected = "selected";
                        }else{
                            $selected = "";
                        }
                        echo "<option value='$value' $selected>$value</option>";
                    }
                    ?>
                </select>
            </form>
        </div>
        </h2>
        <?=$this->session->flashdata('notif')?>
        <?php 
        if (empty($x) OR $x=="Hari Ini") { ?>
            <div class="single-item">
                <h2 align="center">Hari Ini</h2>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-siswa">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($agenda_today as $key => $value) {
                                if ($value['status']=='berhasil') {
                                    $status = "<label class='label label-success'>Berhasil</label>";
                                    $tooltip = "Waktu Mulai : ".$value['durasi_mulai']." || Waktu Selesai : ".$value['durasi_selesai'];
                                }elseif ($value['status']=='tunda') {
                                    $status = "<label class='label label-warning'>Tunda</label>";
                                    $tooltip = "Tanggal Lanjutan : ".$value['waktu_lanjutan'];
                                }elseif ($value['status']=='gagal') {
                                    $status = "<label class='label label-danger'>Gagal</label>";
                                    $tooltip = "Agenda Gagal Dilakukan";
                                }else{
                                    $status = "<label class='label label-info'>Proses</label>";
                                    $tooltip = "Agenda Sedang Berlangsung";
                                }
                                if (!empty($value['durasi_mulai'])) {
                                    $durasi_mulai = Tools::tgl_indo($value['durasi_mulai'],'d-m-Y');
                                }else{
                                    $durasi_mulai = '';
                                }
                                if (!empty($value['durasi_selesai'])) {
                                    $durasi_selesai = Tools::tgl_indo($value['durasi_selesai'],'d-m-Y');
                                }else{
                                    $durasi_selesai = '';
                                }
                                if (!empty($value['waktu_lanjutan'])) {
                                    $waktu_lanjutan = Tools::tgl_indo($value['waktu_lanjutan'],'d-m-Y');
                                }else{
                                    $waktu_lanjutan = '';
                                }
                                ?>
                            <tr class="tooltips" data-toggle="tooltip" data-original-title="<?=$tooltip?>" data-placement="top">
                                <td align="center"><?=($key+1)?></td>
                                <td align="center"><?=$status?></td>
                                <td align="center"><?=Tools::tgl_indo($value['start'],'d-m-Y')?></td>
                                <td><?=$value['title']?></td>
                                <td><?=$value['deskripsi']?></td>
                                <td style="background-color: <?=$value['color']?>"></td>
                                <td align="center"><a href="#konfirmasi" data-toggle="modal" data-id_agenda="<?=$value['id_agenda']?>"
                                data-judul="<?=$value['title']?>" 
                                data-deskripsi="<?=$value['deskripsi']?>"
                                data-tanggal_deadline="<?=Tools::tgl_indo($value['start'],'d-m-Y')?>" 
                                data-status="<?=$value['status']?>" 
                                data-durasi_mulai="<?=$durasi_mulai?>" 
                                data-durasi_selesai="<?=$durasi_selesai?>" 
                                data-waktu_lanjutan="<?=$waktu_lanjutan?>"
                                class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Konfirmasi</a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php }elseif ($x=="Akan Datang") {?>
            <div class="single-item">
                <h2 align="center">Yang Akan Datang</h2>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-siswa">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($agenda_coming as $key => $value) {
                                if ($value['status']=='berhasil') {
                                    $status = "<label class='label label-success'>Berhasil</label>";
                                    $tooltip = "Waktu Mulai : ".$value['durasi_mulai']." || Waktu Selesai : ".$value['durasi_selesai'];
                                }elseif ($value['status']=='tunda') {
                                    $status = "<label class='label label-warning'>Tunda</label>";
                                    $tooltip = "Tanggal Lanjutan : ".$value['waktu_lanjutan'];
                                }elseif ($value['status']=='gagal') {
                                    $status = "<label class='label label-danger'>Gagal</label>";
                                    $tooltip = "Agenda Gagal Dilakukan";
                                }else{
                                    $status = "<label class='label label-info'>Proses</label>";
                                    $tooltip = "Agenda Sedang Berlangsung";
                                }
                                if (!empty($value['durasi_mulai'])) {
                                    $durasi_mulai = Tools::tgl_indo($value['durasi_mulai'],'d-m-Y');
                                }else{
                                    $durasi_mulai = '';
                                }
                                if (!empty($value['durasi_selesai'])) {
                                    $durasi_selesai = Tools::tgl_indo($value['durasi_selesai'],'d-m-Y');
                                }else{
                                    $durasi_selesai = '';
                                }
                                if (!empty($value['waktu_lanjutan'])) {
                                    $waktu_lanjutan = Tools::tgl_indo($value['waktu_lanjutan'],'d-m-Y');
                                }else{
                                    $waktu_lanjutan = '';
                                }
                                ?>
                            <tr class="tooltips" data-toggle="tooltip" data-original-title="<?=$tooltip?>" data-placement="top">
                                <td align="center"><?=($key+1)?></td>
                                <td align="center"><?=$status?></td>
                                <td align="center"><?=Tools::tgl_indo($value['start'],'d-m-Y')?></td>
                                <td><?=$value['title']?></td>
                                <td><?=$value['deskripsi']?></td>
                                <td style="background-color: <?=$value['color']?>"></td>
                                <td align="center"><a href="#konfirmasi" data-toggle="modal" data-id_agenda="<?=$value['id_agenda']?>"
                                data-judul="<?=$value['title']?>" 
                                data-deskripsi="<?=$value['deskripsi']?>"
                                data-tanggal_deadline="<?=Tools::tgl_indo($value['start'],'d-m-Y')?>" 
                                data-status="<?=$value['status']?>" 
                                data-durasi_mulai="<?=$durasi_mulai?>" 
                                data-durasi_selesai="<?=$durasi_selesai?>" 
                                data-waktu_lanjutan="<?=$waktu_lanjutan?>"
                                class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Konfirmasi</a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php }elseif ($x=="Kemarin") { ?>
            <div class="single-item">
                <h2 align="center">Kemarin</h2>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-siswa">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($agenda_yest as $key => $value) {
                                if ($value['status']=='berhasil') {
                                    $status = "<label class='label label-success'>Berhasil</label>";
                                    $tooltip = "Waktu Mulai : ".$value['durasi_mulai']." || Waktu Selesai : ".$value['durasi_selesai'];
                                }elseif ($value['status']=='tunda') {
                                    $status = "<label class='label label-warning'>Tunda</label>";
                                    $tooltip = "Tanggal Lanjutan : ".$value['waktu_lanjutan'];
                                }elseif ($value['status']=='gagal') {
                                    $status = "<label class='label label-danger'>Gagal</label>";
                                    $tooltip = "Agenda Gagal Dilakukan";
                                }else{
                                    $status = "<label class='label label-info'>Proses</label>";
                                    $tooltip = "Agenda Sedang Berlangsung";
                                }
                                if (!empty($value['durasi_mulai'])) {
                                    $durasi_mulai = Tools::tgl_indo($value['durasi_mulai'],'d-m-Y');
                                }else{
                                    $durasi_mulai = '';
                                }
                                if (!empty($value['durasi_selesai'])) {
                                    $durasi_selesai = Tools::tgl_indo($value['durasi_selesai'],'d-m-Y');
                                }else{
                                    $durasi_selesai = '';
                                }
                                if (!empty($value['waktu_lanjutan'])) {
                                    $waktu_lanjutan = Tools::tgl_indo($value['waktu_lanjutan'],'d-m-Y');
                                }else{
                                    $waktu_lanjutan = '';
                                }
                                ?>
                            <tr class="tooltips" data-toggle="tooltip" data-original-title="<?=$tooltip?>" data-placement="top">
                                <td align="center"><?=($key+1)?></td>
                                <td align="center"><?=$status?></td>
                                <td align="center"><?=Tools::tgl_indo($value['start'],'d-m-Y')?></td>
                                <td><?=$value['title']?></td>
                                <td><?=$value['deskripsi']?></td>
                                <td style="background-color: <?=$value['color']?>"></td>
                                <td align="center"><a href="#konfirmasi" data-toggle="modal" data-id_agenda="<?=$value['id_agenda']?>"
                                data-judul="<?=$value['title']?>" 
                                data-deskripsi="<?=$value['deskripsi']?>"
                                data-tanggal_deadline="<?=Tools::tgl_indo($value['start'],'d-m-Y')?>" 
                                data-status="<?=$value['status']?>" 
                                data-durasi_mulai="<?=$durasi_mulai?>" 
                                data-durasi_selesai="<?=$durasi_selesai?>" 
                                data-waktu_lanjutan="<?=$waktu_lanjutan?>"
                                class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Konfirmasi</a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>

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
                <a href="<?=base_url('siswa/agenda')?>" class="btn btn-block btn-menu aktif">Agenda</a>
            </div>
            <div class="col-md-2">
                <a href="<?=base_url('siswa/pengumuman')?>" class="btn btn-block btn-menu">Pengumuman</a>
            </div>
            <div class="col-md-2">
                <a href="<?=base_url('siswa/pesanan')?>" class="btn btn-block btn-menu">Pesanan</a>
            </div>
            <div class="col-md-1"></div>
        </div>
        <!-- End Menu Siswa -->
        <!-- Start Form Biodata -->
        <div class="row">
            <div class="panel-body">
                <small><i>Catatan : klik pada tanggal dan buat agenda kamu</i></small>
                <div id='calendar'></div>
            </div>
        </div>
        <!-- End Form Biodata -->

    </div>
</div>
<!-- Registration Page Area End Here -->
<!-- Modal agdenda -->
<div id="agenda" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <b>Agenda</b>
                <button type="button" class="close" data-dismiss="modal"><b style="color: red">x</b></button>
            </div>
            <div class="modal-body">
                <span class="error"></span>
                <div class="panel-body">
                    <form class="form-horizontal" id="crud-form">
                        <input type="hidden" id="start">
                        <input type="hidden" id="end">
                        <div class="form-group">
                            <label>Judul</label>
                            <textarea class="form-control" name="judul" maxlength="100" id="judul" placeholder="Maksimal 100 karakter" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" placeholder="Deskripsikan agenda kamu" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Warna</label>
                            <select name="color" class="form-control" id="color">
                                <option value="">-Pilih-</option>
                                <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
                                <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
                                <option style="color:#008000;" value="#008000">&#9724; Green</option>                       
                                <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
                                <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
                                <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
                                <option style="color:#000;" value="#000">&#9724; Black</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer" id="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal agenda -->
<!-- Modal konfirmasi -->
<div id="konfirmasi" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <b>Konfirmasi Agenda</b>
                <button type="button" class="close" data-dismiss="modal"><b style="color: red">x</b></button>
            </div>
            <form class="form-horizontal" method="post" action="<?=base_url().'siswa/agenda_konfirmasi'?>">
                <div class="modal-body">
                    <div class="panel-body">
                        <input type="hidden" name="id_agenda" id="id_agenda">
                        <div class="form-group">
                            <label>Judul</label>
                            <textarea class="form-control" maxlength="100" id="konf_judul" placeholder="Maksimal 100 karakter" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea id="konf_deskripsi" class="form-control" rows="4" placeholder="Deskripsikan agenda kamu" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Deadline</label>
                            <input type="text" id="konf_tgl_deadline" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Aksi</label>
                            <select name="status" class="form-control" id="status">
                                <option value="proses">-Pilih-</option>
                                <option value="berhasil">Berhasil</option>
                                <option value="gagal">Gagal</option>
                                <option value="tunda">Tunda</option>
                            </select>
                        </div>
                        <div class="form-group" id="berhasil">
                            <label>Durasi</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="durasi_mulai" id="durasi_mulai" class="form-control tanggal" placeholder="Waktu mulai" readonly>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="durasi_selesai" id="durasi_selesai" class="form-control tanggal" placeholder="Waktu selesai" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id="tunda">
                            <label>Tanggal Lanjutan</label>
                            <input type="text" name="waktu_lanjutan" id="waktu_lanjutan" class="form-control tanggal" placeholder="Tanggal lanjutan" readonly>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal konfirmasi -->
<!-- <script src="<?= base_url();?>assets/frontend/js/calendar.js"></script> -->
<script type="text/javascript">
    /*Calender agenda*/
    var currentDate;
    var currentEvent;
    var base_url = "<?=base_url()?>";
    $(document).ready(function(){
        $('#calendar').fullCalendar({
            header: {
                left: 'prev, next, today',
                center: 'title',
                right: 'month, basicWeek, basicDay'
            },
            eventLimit: true,
            events: base_url+'siswa/get_agenda',
            selectable: true,
            selectHelper:true,
            editable: true,
            select: function(start, end){
                $('#start').val(moment(start).format('YYYY-MM-DD'));
                $('#end').val(moment(end).format('YYYY-MM-DD'));
                modal({
                    buttons:{
                        add: {
                            id: 'add-agenda',
                            css: 'btn-success',
                            label: 'Tambah'
                        }
                    },
                });

            },
            eventDrop: function(event, delta, revertFunc, start, end){
                start = event.start.format('YYYY-MM-DD HH:mm:ss');
                if(event.end){
                    end = event.end.format('YYYY-MM-DD HH:mm:ss');
                }else{
                    end = start;
                }
                $.post(base_url+'siswa/agenda_drag_update',{
                    id:event.id_agenda,
                    start: start,
                    end: end
                },function(result){
                    swal("Berhasil!", "Tanggal agenda kamu berhasil di ubah", "success");
                });
            },
            // Event Mouseover
            eventMouseover: function(calEvent, jsEvent, view){
                var tooltip = '<div class="event-tooltip">' + calEvent.deskripsi +  '</div>';
                $("body").append(tooltip);

                $(this).mouseover(function(e) {
                    $(this).css('z-index', 10000);
                    $('.event-tooltip').fadeIn('500');
                    $('.event-tooltip').fadeTo('10', 1.9);
                }).mousemove(function(e) {
                    $('.event-tooltip').css('top', e.pageY + 10);
                    $('.event-tooltip').css('left', e.pageX + 20);
                });
            },
            eventMouseout: function(calEvent, jsEvent) {
                $(this).css('z-index', 8);
                $('.event-tooltip').remove();
            },
            // Handle Existing Event Click
            eventClick: function(calEvent, jsEvent, view) {
                currentEvent = calEvent;
                modal({
                    buttons: {
                        delete: {
                            id: 'delete-agenda',
                            css: 'btn-danger',
                            label: 'Hapus'
                        },
                        update: {
                            id: 'update-agenda',
                            css: 'btn-success',
                            label: 'Edit'
                        }
                    },
                    event: calEvent
                });
            }
        });
    });

    // Prepares the modal window according to data passed
    function modal(data) {
        // Clear buttons except Cancel
        $('#modal-footer button:not(".btn-default")').remove();
        // Set input values
        $('#judul').val(data.event ? data.event.title : '');        
        $('#deskripsi').val(data.event ? data.event.deskripsi : '');
        $('#color').val(data.event ? data.event.color : '');
        // Create Butttons
        $.each(data.buttons, function(index, button){
            $('#modal-footer').prepend('<button type="button" id="' + button.id  + '" class="btn ' + button.css + '">' + button.label + '</button>')
        });
        //Show Modal
        $('#agenda').modal('show');
    }

    // Handle Click on Add Button
    $('#agenda').on('click', '#add-agenda',  function(e){
        if(validator(['judul', 'deskripsi'])) {
            $.post(base_url+'siswa/agenda_add', {
                title: $('#judul').val(),
                deskripsi: $('#deskripsi').val(),
                color: $('#color').val(),
                start: $('#start').val(),
                end: $('#end').val(),
                
            }, function(data){
                $('#agenda').modal('hide');
                $('#calendar').fullCalendar("refetchEvents");
                swal("Berhasil!", "Agenda kamu berhasil ditambahkan","success");
                location.reload();
            });
        }
    });

    // Handle click on Update Button
    $('#agenda').on('click', '#update-agenda',  function(e){
        if(validator(['judul', 'deskripsi'])) {
            $.post(base_url+'siswa/agenda_update', {
                id: currentEvent.id_agenda,
                title: $('#judul').val(),
                deskripsi: $('#deskripsi').val(),
                color: $('#color').val()
            }, function(data){
                $('#agenda').modal('hide');
                $('#calendar').fullCalendar("refetchEvents");
                swal("Berhasil!", "Agenda kamu berhasil diperbarui","success");
            });
        }
    });

    // Handle Click on Delete Button
    $('#agenda').on('click', '#delete-agenda',  function(e){
        $.get(base_url+'siswa/agenda_delete?id=' + currentEvent.id_agenda, function(data){
            $('#agenda').modal('hide');
            $('#calendar').fullCalendar("refetchEvents");
            swal("Berhasil!", "Agenda kamu berhasil dihapus","success");
        });
    });


    // Dead Basic Validation For Inputs
    function validator(elements) {
        var errors = 0;
        $.each(elements, function(index, element){
            if($.trim($('#' + element).val()) == '') errors++;
        });
        if(errors) {
            $('.error').html('Judul dan deskripsi tidak boleh kosong');
            return false;
        }
        return true;
    }
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#konfirmasi').on('show.bs.modal', function(e) {
            $(e.currentTarget).find('#id_agenda').val($(e.relatedTarget).data('id_agenda'));
            $(e.currentTarget).find('#konf_judul').val($(e.relatedTarget).data('judul'));
            $(e.currentTarget).find('#konf_deskripsi').val($(e.relatedTarget).data('deskripsi'));
            $(e.currentTarget).find('#konf_tgl_deadline').val($(e.relatedTarget).data('tanggal_deadline'));
            $(e.currentTarget).find('#status').val($(e.relatedTarget).data('status'));
            $(e.currentTarget).find('#durasi_mulai').val($(e.relatedTarget).data('durasi_mulai'));
            $(e.currentTarget).find('#durasi_selesai').val($(e.relatedTarget).data('durasi_selesai'));
            $(e.currentTarget).find('#waktu_lanjutan').val($(e.relatedTarget).data('waktu_lanjutan'));
        });
        if ($('#status').val()=='berhasil') {
            $('#berhasil').show();
            $('#tunda').hide();
        }else if ($('#status').val()=='tunda') {
            $('#berhasil').hide();
            $('#tunda').show();
        }else{
            $('#berhasil').hide();
            $('#tunda').hide();
        }
        $('#status').on('change', function(){
            if ($(this).val()=='berhasil') {
                $('#berhasil').show();
                $('#tunda').hide();
                $('#waktu_lanjutan').val('NULL');
            }else if ($(this).val()=='tunda') {
                $('#berhasil').hide();
                $('#tunda').show();
                $('#durasi_mulai').val('NULL');
                $('#durasi_selesai').val('NULL');
            }else{
                $('#berhasil').hide();
                $('#tunda').hide();
                $('#durasi_mulai').val('NULL');
                $('#durasi_selesai').val('NULL');
                $('#waktu_lanjutan').val('NULL');
            }
        });
    });
</script>