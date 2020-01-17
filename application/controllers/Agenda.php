<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('model_admin');
        $this->load->model('model');
        $this->id_user      = $this->encrypt->decode($this->session->userdata('id_user'));        
        $this->nama         = $this->encrypt->decode($this->session->userdata('nama'));
        $this->tipe_user    = $this->encrypt->decode($this->session->userdata('tipe_user'));
        include 'Tools.php';
    }    
    function index(){    
        $data=array(
            'title'     => 'Agenda Siswa',
            'isi'       => 'backend/agenda'
        );
        $this->load->view('layout', $data);
        
    }

    function agenda_data(){
        $aColumns = array('id_agenda', 'nama_siswa', 'title', 'deskripsi', 'start', 'status', 'id_agenda'); 
        $sIndexColumn = "id_agenda"; //primary key
        $where = "id_agenda!=''";
        $dt = $this->data('agenda', $where, $sIndexColumn, $aColumns);
        $nomor_urut = $dt[0];
        $rResult    = $dt[1];
        $output     = $dt[2];
        foreach ($rResult->result_array() as $data){
            if ($data['status']=="proses") {
                $status = "<label class='label label-info'>Berlangsung</label>";
            }elseif ($data['status']=="tunda") {
                $status = "<label class='label label-warning' data-toggle='tooltip' data-original-title='Lanjutan : ".Tools::tgl_indo($data['waktu_lanjutan'],'d-m-Y')."'>Tunda</label>";
            }elseif ($data['status']=="gagal") {
                $status = "<label class='label label-danger'>Gagal</label>";
            }elseif ($data['status']=="berhasil") {
                $status = "<label class='label label-success' data-toggle='tooltip' data-html='true' data-original-title='Mulai : ".Tools::tgl_indo($data['durasi_mulai'],'d-m-Y')." <br> Selesai : ".Tools::tgl_indo($data['durasi_selesai'],'d-m-Y')."'>Berhasil</label>";
            }
            $output['data'][]=array(
                $nomor_urut,
                $data['nama_siswa'],
                $data['title'],
                Tools::limit_words($data['deskripsi'],5),
                Tools::tgl_indo($data['start'],'d-m-Y'),
                $status
            );
            $nomor_urut++;
        }        
        echo json_encode( $output );
    }


    
    /*--------------------- <tools> ----------------------*/
    function data($table, $where, $sIndexColumn, $aColumns){  
        error_reporting(0);
        $sLimit = "";if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' ){$sLimit = "LIMIT ".$this->security->xss_clean( $_REQUEST['iDisplayStart'] ).", ".$this->security->xss_clean( $_REQUEST['iDisplayLength'] );}$numbering = $this->security->xss_clean( $_REQUEST['iDisplayStart'] );$page = 1;/*//pagging // ordering*/if ( isset( $_REQUEST['iSortCol_0'] ) ){$sOrder = "ORDER BY  ";for ( $i=0 ; $i<intval( $_REQUEST['iSortingCols'] ) ; $i++ ){if ( $_REQUEST[ 'bSortable_'.intval($_REQUEST['iSortCol_'.$i]) ] == "true" ){$sOrder .= $aColumns[ intval( $_REQUEST['iSortCol_'.$i] ) ]." ".$this->security->xss_clean( $_REQUEST['sSortDir_'.$i] ) .", ";}}$sOrder = substr_replace( $sOrder, "", -2 );if ( $sOrder == "ORDER BY" ){$sOrder = "";}}/*// filtering*/$sWhere = "";if ( $_REQUEST['sSearch'] != "" ){$sWhere = "WHERE (";
            for ( $i=0 ; $i<count($aColumns) ; $i++ ){$sWhere .= $aColumns[$i]." LIKE '%".$this->security->xss_clean( $_REQUEST['sSearch'] )."%' OR ";}$sWhere = substr_replace( $sWhere, "", -3 );$sWhere .= ')';}/*// individual column filtering*/for ( $i=0 ; $i<count($aColumns) ; $i++ ){if ( $_REQUEST['bSearchable_'.$i] == "true" && $_REQUEST['sSearch_'.$i] != '' ){if ( $sWhere == "" ){$sWhere = "WHERE ";}else{$sWhere .= " AND ";}$sWhere .= $aColumns[$i]." LIKE '%".$this->security->xss_clean($_REQUEST['sSearch_'.$i])."%' ";}}
        
        $rResult = $this->model_admin->get_data($table,$where,$aColumns, $sWhere, $sOrder, $sLimit, 'x'); 
        $iFilteredTotal = 10;
        $rResultTotal = $this->model_admin->get_data($table,$where,$aColumns, $sWhere, NULL, NULL, $sIndexColumn); 
        $iTotal = $rResultTotal->num_rows();
        $iFilteredTotal = $iTotal;
        
        $output = array("sEcho" => intval($_REQUEST['sEcho']),"iTotalRecords" => $iTotal,"iTotalDisplayRecords" => $iFilteredTotal,"data" => array());
        
        $nomor_urut=$_REQUEST['iDisplayStart']+1;

        return array($nomor_urut, $rResult, $output);
    }

    function input($post,$data){
        if($this->input->post($post)){
            echo $this->input->post($post);
        }elseif (!empty($data)) {
            echo $data;
        }
    }
}
