<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends CI_Controller {
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
            'title'     => 'Manajemen Games',
            'isi'       => 'backend/view_materi'
        );
        $this->load->view('layout', $data);
        
    }

    function quiz_detail(){                 
        $this->form_validation->set_rules('pertanyaan_pg', 'Pertanyaan Pilihan Ganda', 'trim|required');
        $this->form_validation->set_rules('pg1', 'Pilihan Jawaban A', 'trim|required');
        $this->form_validation->set_rules('pg2', 'Pilihan Jawaban B', 'trim|required');
        $this->form_validation->set_rules('pg3', 'Pilihan Jawaban C', 'trim|required');
        $this->form_validation->set_rules('pg4', 'Pilihan Jawaban D', 'trim|required');
        $this->form_validation->set_rules('jawaban_pg', 'Pilihan Jawaban A', 'trim|required');
                
        if ($this->form_validation->run() != false) { //insert                
            $id = $this->input->post('id_quiz');
            
            $id_materi  = $this->input->post('id_materi');
            $id_stage   = $this->input->post('id_stage');
            $id_kelas   = $this->input->post('id_kelas');
            $nama_stage = $this->input->post('nama_stage');
            $nama_kelas = $this->input->post('nama_kelas');
            $data  = array(
                'id_materi'     => $id_materi,
                'id_stage'      => $id_stage,
                'id_kelas'      => $id_kelas,
                'pertanyaan_pg' => $this->input->post('pertanyaan_pg'),
                'pg1'           => $this->input->post('pg1'),
                'pg2'           => $this->input->post('pg2'),
                'pg3'           => $this->input->post('pg3'),
                'pg4'           => $this->input->post('pg4'),
                'jawaban_pg'    => $this->input->post('jawaban_pg'),
                'pertanyaan_isian'=> $this->input->post('pertanyaan_isian'),
                'jawaban_isian' => $this->input->post('jawaban_isian'),
                'id_user'       => $this->id_user,
                'nama_user'     => $this->nama,
                'waktu_edit'    => date('Y-m-d H:i:s')
            );
            if (empty($id)) {                
                $data['waktu_post']     = date('Y-m-d H:i:s');
                $this->model_admin->insert_data('_quiz', $data);
                $this->notif('success','Quiz Berhasil ditambahkan');
            }else{
                $where = array('id_materi'=>$id_materi);
                $this->model_admin->update_data('_quiz', $data, $where);
                $this->notif('success','Quiz Berhasil diperbarui');
            }            
            redirect('materi');
        }else{
            $id = $this->encrypt->decode($this->input->get('id_materi'));
            if (!empty($id)) {
                $data=$this->model_admin->select_data('_quiz', null, array('id_materi'=>$id));
            }else{
                $data='';
            }
            $data=array('title' => 'Data Quiz',
                'data'          => $data,
                'isi'           => 'backend/view_quiz_detail',
            );
            $this->load->view('layout', $data);
        }
    }

    function quiz_nilai(){
        $data = array(
            'title'    => 'Penilaian Quiz Siswa',
            'isi'      => 'backend/view_quiz_nilai',
        );
        $this->load->view('layout', $data);
    } 

    function quiz_nilai_data(){
        if ($this->tipe_user=="admin") {
            $where = 'id_hasil!=""';
        }elseif ($this->tipe_user=="guru") {
            $where = 'id_kelas IN ('.$this->kelas_guru()[0].')';
        }
        
        $aColumns = array('id_hasil', 'nama_siswa', 'nama_kelas', 'nama_stage', 'judul_materi', 'waktu_post', 'nilai', 'id_hasil');
        $sIndexColumn = "id_agenda"; //primary key
        
        $dt = $this->data('view_penilaian_quiz', $where, $sIndexColumn, $aColumns);
        $nomor_urut = $dt[0];
        $rResult    = $dt[1];
        $output     = $dt[2];
        foreach ($rResult->result_array() as $data){
            $output['data'][]=array(
                $nomor_urut,                
                $data['nama_siswa'],
                $data['nama_kelas'],
                $data['nama_stage'],
                $data['judul_materi'],
                $data['waktu_post'],
                $data['nilai'],
                "<a href='".base_url()."quiz/quiz_nilai_detail?id_siswa=".$this->encrypt->encode($data['id_siswa'])."&id_quiz=".$this->encrypt->encode($data['id_quiz'])."' class='btn btn-warning btn-sm tooltips' data-original-title='Lihat Quiz' data-toggle='tooltip' data-placement='top' title=''><i class='fa fa-eye'></i></a>",
            );
            $nomor_urut++;
        }        
        echo json_encode( $output );
    }

    function quiz_nilai_detail(){
        $this->form_validation->set_rules('nilai', 'Nilai', 'trim|required');
        
        if ($this->form_validation->run() != false) { //insert
            $id_siswa = $this->encrypt->decode($this->input->post('id_siswa'));
            $id_quiz  = $this->encrypt->decode($this->input->post('id_quiz'));
            $data  = array(
                'nilai'         => $this->input->post('nilai'),
                'id_guru'       => $this->id_user,
                'nama_guru'     => $this->nama,                
                'waktu_nilai'   => date('Y-m-d H:i:s')
            );
            if (!empty($id_siswa) && !empty($id_quiz)) {
                $where = array(
                    'id_siswa'  => $id_siswa,
                    'id_quiz'   => $id_quiz
                );
                $this->model_admin->update_data('_quiz_hasil', $data, $where);
                $this->notif('success','Quiz <b>"'.$this->input->post('nama_siswa').'"</b> Telah Dinilai');
                redirect('quiz/quiz_nilai');
            }else{
                show_404();
            }
        }else{
            $id_siswa = $this->encrypt->decode($this->input->get('id_siswa'));
            $id_quiz  = $this->encrypt->decode($this->input->get('id_quiz'));
            if (!empty($id_siswa) && !empty($id_quiz)) {
                $where = array(
                    'id_siswa'  => $id_siswa,
                    'id_quiz'   => $id_quiz
                );
                $hasil_quiz = $this->model_admin->select_data('view_penilaian_quiz', null, $where);
                $quiz = $this->model_admin->select_data('_quiz',null, array('id_quiz'=>$id_quiz));
            }else{
                $hasil_quiz   = '';
                $quiz = '';
            }
            $data=array('title' => 'Hasil Quiz',
                'quiz'          => $quiz,
                'hasil_quiz'    => $hasil_quiz,
                'isi'           => 'backend/view_quiz_nilai_detail',
            );
            $this->load->view('layout', $data);
        }
    }

    function kelas_guru(){
        $id_guru = "'".$this->id_user."'";
        $guru = $this->model_admin->select_data('_kelas','id_kelas, id_guru',array('status'=>'Y'),null,null,null,null,'id_guru',$id_guru);
        $id_kelas_guru = "";
        $ar_id_kelas_guru = array();
        foreach ($guru as $key => $value) {
            if ($key==(count($guru)-1)) {
                $id_kelas_guru .= $value['id_kelas'];
            }else{
                $id_kelas_guru .= $value['id_kelas'].',';
            }
            $ar_id_kelas_guru [] = $value['id_kelas'];
            
        }
        return array($id_kelas_guru,$ar_id_kelas_guru);
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

