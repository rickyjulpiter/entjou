<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    function GetData($tableName,$select=null,$where=null,$order_by=null,$join=null,$key=null,$num=null,$offset=null,$group_by=null){

        if ($select!=null) {
            $this->db->select($select);
        }if ($join!=null) {
            $this->db->join($join,$key);
        }if ($where!=null) {
            $this->db->where($where);
        }if ($order_by!=null) {
            $this->db->order_by($order_by);
        }if ($num!=null) {
            $this->db->limit($num, $offset);
        }if ($group_by!=null) {
            $this->db->group_by($group_by);
        }
    	$data = $this->db->get($tableName);
    	return $data->result_array();        
    }    
    function InsertData($tableName,$data){
    	$res = $this->db->insert($tableName,$data);    	        
        return $res;
    }
    function InsertDataBatch($tableName,$data){
        $res = $this->db->insert_batch($tableName,$data);
        return $res;
    }
    function UpdateDataBatch($tableName,$data,$where){
        $res = $this->db->update_batch($tableName,$data,$where);
        return $res;
    }
    function UpdateData($tableName,$data,$where){
    	$res = $this->db->update($tableName,$data,$where);    	        
        return $res;
    }
    function DeleteData($tableName,$where){
    	$res = $this->db->delete($tableName,$where);    	        
        return $res;
    }
}
