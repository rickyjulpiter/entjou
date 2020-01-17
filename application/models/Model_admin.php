<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Model_admin extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->id_user      = $this->encrypt->decode($this->session->userdata('id_user'));        
        $this->nama         = $this->encrypt->decode($this->session->userdata('nama'));
    }    
    function get_data($table, $where, $aColumns, $sWhere, $sOrder, $sLimit, $sIndexColumn=NULL){
       if (!empty($sIndexColumn)) {
            $filter = $sWhere.' '.$sOrder.' '.$sLimit;
            $select = '*';
        }else{
            $filter = '';
            $select = $sIndexColumn;
        }
        $query = $this->db->query("
            SELECT $select FROM (
                SELECT * from $table WHERE $where
            ) A 
            $filter 
        ");        
        return $query;
    }
    
    //CRUD
    function select_data($table, $select=NULL, $where=NULL, $group=NULL, $order_by=NULL,$num=NULL,$offset=NULL,$field_like=NULL,$like=NULL){
        if (!empty($select)) {
            $this->db->select($select);
        }if (!empty($where)) {
            $this->db->where($where);
        }if (!empty($group)) {
            $this->db->group_by($group);
        }if (!empty($order_by)) {
            $this->db->order_by($order_by);
        }if (!empty($num)) {
            $this->db->limit($num, $offset);
        }if (!empty($field_like) AND !empty($like)) {
            $this->db->like($field_like, $like,'both');
        }
        return $this->db->get($table)->result_array();
    }    
    function insert_data($table, $data){
        $res = $this->db->insert($table, $data);
        if($res >= 1){
            $this->session->set_flashdata("notif", "<div class=\"col-md-12\"><div class=\"alert alert-info\" id=\"alert\">Tambah Data Berhasil !!</div></div>");
        }else{
            $this->session->set_flashdata("notif", "<div class=\"col-md-12\"><div class=\"alert alert-danger\" id=\"alert\">Tambah Data Gagal !!</div></div>");
        }
        return TRUE;
    }
    function update_data($table, $data, $where){
        $res = $this->db->update($table, $data, $where);
        if($res >= 1){
            $this->session->set_flashdata("notif", "<div class=\"col-md-12\"><div class=\"alert alert-info\" id=\"alert\">Ubah Data Berhasil !!</div></div>");
        }else{
            $this->session->set_flashdata("notif", "<div class=\"col-md-12\"><div class=\"alert alert-danger\" id=\"alert\">Ubah Data Gagal !!</div></div>");
        }
        return TRUE;
    }
    function delete_data($table, $where){
        $res = $this->db->delete($table, $where);
        if($res >= 1){
            $response['status']  = 'success';
            $response['message'] = 'Data Berhasil di Hapus ...';            
        }else{
            $response['status']  = 'error';
            $response['message'] = 'Data Gagal di Hapus ...';            
        }
        return $response; 
    }
    function select_datast($table, $select=NULL, $where=NULL, $coloumn=NULL, $where_in=NULL, $order_by=NULL, $limit=NULL){
        if (!empty($select)) {
            $this->db->select($select);
        }if (!empty($where)) {
            $this->db->where($where);
        }if (!empty($where_in)) {
            $this->db->where_in($coloumn,$where_in);
        }if (!empty($order_by)) {
            $this->db->order_by($order_by);
        }if (!empty($limit)) {
            $this->db->limit($limit);
        }
        return $this->db->get($table)->result_array();
    }
    
    Public function get_agenda(){
        $sql = "SELECT * FROM agenda WHERE agenda.start BETWEEN ? AND ? AND id_siswa=$this->id_user AND status='proses'
          ORDER BY agenda.start ASC";
        return $this->db->query($sql, array($_GET['start'], $_GET['end']))->result();
    }
    Public function add_agenda(){
        $today = "'".date('Y-m-d H:i:s')."'";
        $id_siswa = $this->id_user;
        $nama_siswa = "'".$this->nama."'";
        $sql = "INSERT INTO agenda (title,agenda.start,agenda.end,deskripsi, color,allDay, id_siswa, nama_siswa, waktu_post) VALUES (?,?,?,?,?,'true',$id_siswa,$nama_siswa,$today)";
        $this->db->query($sql, array($_POST['title'], $_POST['start'],$_POST['end'], $_POST['deskripsi'], $_POST['color']));
        return ($this->db->affected_rows()!=1)?false:true;
    }
    Public function update_agenda(){
         $sql = "UPDATE agenda SET title = ?, deskripsi = ?, color = ? WHERE id_agenda = ?";
         $this->db->query($sql, array($_POST['title'],$_POST['deskripsi'], $_POST['color'], $_POST['id']));
        return ($this->db->affected_rows()!=1)?false:true;
    }
    Public function delete_agenda(){
        $sql = "DELETE FROM agenda WHERE id_agenda = ?";
        $this->db->query($sql, array($_GET['id']));
        return ($this->db->affected_rows()!=1)?false:true;
    }
    Public function drag_update_agenda(){
        $sql = "UPDATE agenda SET  agenda.start = ? ,agenda.end = ?  WHERE id_agenda = ?";
        $this->db->query($sql, array($_POST['start'],$_POST['end'], $_POST['id']));
        return ($this->db->affected_rows()!=1)?false:true;
    }




}