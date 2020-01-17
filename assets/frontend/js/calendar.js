    /*Calender agenda*/
var currentDate;
var currentEvent;
var base_url = "http://localhost/entjou/";
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