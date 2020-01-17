<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Model_login extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    function update_data($table, $data, $where){
        $res = $this->db->update($table, $data, $where);
        return TRUE;
    }
    function cek_login($username,$password){
        $this->db->select('id_user, username, nama_lengkap, allow_login, tipe_user, last_login, foto');
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        return $this->db->get('users')->result_array();
    }
    function cek_cookie($cookie){
        $this->db->select('id_user, username, nama_lengkap, allow_login, tipe_user, last_login');
        $this->db->where('cookie', $cookie);
        return $this->db->get('users')->result_array();
    }
}