<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkup extends CI_Controller {
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
            'title'     => 'Manajemen Checkup',
            'isi'       => 'backend/view_checkup'
        );
        $this->load->view('layout', $data);
        
    }
    function checkup_data(){
        $aColumns = array('id_checkup', 'nama_siswa', 'waktu', 'status', 'id_checkup'); 
        $sIndexColumn = "id_checkup"; //primary key
        $where = "id_checkup!=''";
        $dt = $this->data('checkup', $where, $sIndexColumn, $aColumns);
        $nomor_urut = $dt[0];
        $rResult    = $dt[1];
        $output     = $dt[2];

        foreach ($rResult->result_array() as $data){            
            if ($data['status']=='Y') {
                $status = "<label class='label label-success'>Sudah Ada Hasil</label>";
            }else{
                $status = "<label class='label label-danger'>Belum Ada Hasil</label>";
            }
            $output['data'][]=array(
                $nomor_urut,
                $data['nama_siswa'],                
                $data['waktu'],
                $status,
                "<a href='".base_url().$this->uri->segment(1)."/checkup_detail/".$this->encrypt->encode($data['id_checkup'])."' class='btn btn-warning btn-sm tooltips' data-original-title='Periksa dan Jawab' data-toggle='tooltip' data-placement='top' title=''><i class='fa fa-eye'></i> Lihat Selengkapnya</a>",                
            );
            $nomor_urut++;
        }        
        echo json_encode( $output );
    }
    function checkup_detail($id=NULL){                  
        $this->form_validation->set_rules('j1', 'Jawaban', 'trim|required');
        $this->form_validation->set_rules('j2', 'Jawaban', 'trim|required');
        $this->form_validation->set_rules('j3', 'Jawaban', 'trim|required');
        $this->form_validation->set_rules('j4', 'Jawaban', 'trim|required');


        if ($this->form_validation->run() != false) { //insert                
            if (!empty($id)) {
                $where1 = array('id_checkup'=>$this->encrypt->decode($id));
                $data1 = array('status'=>'Y');
                $this->model_admin->update_data('checkup', $data1, $where1);
            }

            $id_checkup = $this->input->post('id_checkup');
            $data  = array(
                'id_checkup'    => $this->encrypt->decode($id),
                'id_siswa'      => $this->input->post('id_siswa'),
                'nama_siswa'    => $this->input->post('nama_siswa'),
                'id_guru'       => $this->id_user,
                'nama_guru'     => $this->nama,
                'j1'            => $this->input->post('j1'),
                'j2'            => $this->input->post('j2'),
                'j3'            => $this->input->post('j3'),
                'j4'            => $this->input->post('j4'),
                'waktu_edit'    => date('Y-m-d H:i:s')
            );
            if (empty($id_checkup)) {
                $data['waktu_post']     = date('Y-m-d H:i:s');
                $this->model_admin->insert_data('hasil_checkup', $data);
                $this->notif('success', 'Checkup <b>'.$this->input->post('nama_siswa').'</b> telah diperiksa dan dijawab');
            }else{
                $where = array('id_checkup'=>$id_checkup);
                $this->model_admin->update_data('hasil_checkup', $data, $where);
                $this->notif('success', 'Jawaban Checkup <b>'.$this->input->post('nama_siswa').'</b> berhasil diperbarui');
            }
            redirect('checkup');
        }else{
            $id = $this->encrypt->decode($id);
            if (!empty($id)) {
                $data=$this->model_admin->select_data('hasil_checkup', null, array('id_checkup'=>$id));
            }else{
                $data='';
            }
            $data=array('title' => 'Data Checkup Siswa',
                'data'          => $data,
                'form_checkup'  => $this->model_admin->select_data('form_checkup'),
                'checkup'       => $this->model_admin->select_data('checkup', null, array('id_checkup'=>$id)),
                'isi'           => 'backend/view_checkup_detail',
            );
            $this->load->view('layout', $data);
        }
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
    function by($id_user){
        $data = $this->model_admin->select_data('users',null,array('id_user'=>$id_user));
        return $data;
    }

}

