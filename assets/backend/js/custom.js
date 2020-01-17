$(document).ready(function() {
    $('body').tooltip({
        selector: '[data-toggle=tooltip]'
    });
});
/** ******  left menu  *********************** **/
$(function () {
    // panel collapsible
    $('.panel .tools .fa').click(function () {
        var el = $(this).parents(".panel").children(".panel-body");
        if ($(this).hasClass("fa-chevron-down")) {
            $(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
            el.slideUp(200);
        } else {
            $(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
            el.slideDown(200); }
    });
    // panel close
    $('.panel .tools .fa-times').click(function () {
        $(this).parents(".panel").parent().remove();
    });
});
$(function () {
    $('#sidebar-menu li ul').slideUp();
    $('#sidebar-menu li').removeClass('active');

    $('#sidebar-menu li').click(function () {
        if ($(this).is('.active')) {
            $(this).removeClass('active');
            $('ul', this).slideUp();
            $(this).removeClass('nv');
            $(this).addClass('vn');
        } else {
            $('#sidebar-menu li ul').slideUp();
            $(this).removeClass('vn');
            $(this).addClass('nv');
            $('ul', this).slideDown();
            $('#sidebar-menu li').removeClass('active');
            $(this).addClass('active');
        }
    });

    $('#menu_toggle').click(function () {
        if ($('body').hasClass('nav-md')) {
            $('body').removeClass('nav-md');
            $('body').addClass('nav-sm');
            $('.left_col').removeClass('scroll-view');
            $('.left_col').removeAttr('style');
            $('.sidebar-footer').hide();

            if ($('#sidebar-menu li').hasClass('active')) {
                $('#sidebar-menu li.active').addClass('active-sm');
                $('#sidebar-menu li.active').removeClass('active');
            }
        } else {
            $('body').removeClass('nav-sm');
            $('body').addClass('nav-md');
            $('.sidebar-footer').show();

            if ($('#sidebar-menu li').hasClass('active-sm')) {
                $('#sidebar-menu li.active-sm').addClass('active');
                $('#sidebar-menu li.active-sm').removeClass('active-sm');
            }
        }
    });
});

/* Sidebar Menu active class */
$(function () {
    var url = window.location.href.split('?')[0];
    $('#sidebar-menu a[href="' + url + '"]').parent('li').addClass('current-page');
    $('#sidebar-menu a').filter(function () {
        return this.href == url;
    }).parent('li').addClass('current-page').parent('ul').slideDown().parent().addClass('active');
});
/** ******  Range Datepicker  *********************** **/
var $start = $('#start'), $end = $('#end');
var stval = new Date($start.val()), enval = new Date($end.val());

if ($start.val() != "") {
    var stdate = new Date($start.val());
    var endate = new Date($end.val());
    var stmax = new Date($start.val());
    var enmax = new Date($end.val());
}else{
    var stdate = new Date();
    var endate = new Date();
    var stmax = false;
    var enmax = false;
}
$start.datepicker({
    startDate: stdate,
    maxDate: enmax,
    onSelect: function (fd, date) {
        $end.data('datepicker').update('minDate', date);
        $end.focus();
    }
});
$end.datepicker({
    startDate: endate,
    minDate: stmax,
    onSelect: function (fd, date) {
        $start.data('datepicker').update('maxDate', date)
    }
});