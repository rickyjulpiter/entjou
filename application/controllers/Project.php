<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('model_admin');
        $this->load->model('model');   
        $this->id_user      = $this->encrypt->decode($this->session->userdata('id_user'));        
        $this->nama         = $this->encrypt->decode($this->session->userdata('nama'));
        $this->tipe_user    = $this->encrypt->decode($this->session->userdata('tipe_user'));
        include 'Tools.php';
        if (($this->tipe_user=="admin" OR $this->tipe_user=="guru") AND !empty($this->tipe_user)) {
        }else{
            show_404();
        }
    }    
    function index(){        
        $data=array(
            'title'     => 'Project Siswa',
            'isi'       => 'backend/view_project'
        );
        $this->load->view('layout', $data);
        
    }
    function project_data($id_materi=NULL){
        
        $where = 'id_materi="'.$this->encrypt->decode($id_materi).'"';
        /*$where = 'id_materi!=""';*/
        
        $aColumns = array('id_materi', 'nama_siswa', 'title', 'waktu_post', 'start', 'status'); 
        $sIndexColumn = "id_agenda"; //primary key
        
        $dt = $this->data('agenda', $where, $sIndexColumn, $aColumns);
        $nomor_urut = $dt[0];
        $rResult    = $dt[1];
        $output     = $dt[2];
        foreach ($rResult->result_array() as $data){
            if ($data['status']=='berhasil') {
                $durasi_mulai = Tools::tgl_indo($data['durasi_mulai'],'d-m-Y');
                $durasi_selesai = Tools::tgl_indo($data['durasi_selesai'],'d-m-Y');
            }else{
                $durasi_mulai = "-";
                $durasi_selesai = "-";
            }
            if ($data['status']=='tunda') {
                $waktu_lanjutan = Tools::tgl_indo($data['waktu_lanjutan'],'d-m-Y');
            }else{
                $waktu_lanjutan = "-";
            }

            if ($data['status']=='proses') {
                $status = '<label class="label label-info">Proses</label>';
            }elseif ($data['status']=='gagal') {
                $status = '<label class="label label-danger">Gagal</label>';
            }elseif ($data['status']=='tunda') {
                $status = '<label class="label label-warning tooltips" data-original-title="Tanggal Lanjutan : '.$waktu_lanjutan.'" data-toggle="tooltip" data-placement="top">Tunda</label>';
            }elseif ($data['status']=='berhasil') {
                $status = '<label class="label label-success tooltips" data-original-title="Tanggal Mulai : '.$durasi_mulai.' || Tanggal Selesai : '.$durasi_selesai.'" data-toggle="tooltip" data-placement="top">Berhasil</label>';
            }

            $output['data'][]=array(
                $nomor_urut,                
                $data['nama_siswa'],
                $data['title'],
                $data['waktu_post'],
                Tools::tgl_indo($data['start'],'d-m-Y'),
                $status,
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
    function notif($button,$pesan){
        $this->session->set_flashdata('notif','<center><div class="alert alert-'.$button.'" role="alert" style="border:solid 1px;">'.$pesan.'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></center>');
    }
}
