<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Curhat extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('model_admin');
        $this->load->model('model');
        $this->id_user      = $this->encrypt->decode($this->session->userdata('id_user'));
        $this->nama         = $this->encrypt->decode($this->session->userdata('nama'));
        $this->tipe_user    = $this->encrypt->decode($this->session->userdata('tipe_user'));
        include 'Tools.php';
        if ($this->tipe_user == "admin" and !empty($this->tipe_user)) {
        } else {
            show_404();
        }
    }

    function index()
    {
        $data = array(
            'title'     => 'Curhat',
            'isi'       => 'backend/view_curhat'
        );
        $this->load->view('layout', $data);
    }

    function curhat_data()
    {
        $aColumns = array('id', 'nama', 'nowa', 'email', 'namausaha', 'deskripsi', 'curhatan');
        $sIndexColumn = "id"; //primary key
        $where = "id!=''";
        $dt = $this->data('curhat', $where, $sIndexColumn, $aColumns);
        $nomor_urut = $dt[0];
        $rResult    = $dt[1];
        $output     = $dt[2];
        foreach ($rResult->result_array() as $data) {
            $output['data'][] = array(
                $nomor_urut,
                $data['nama'],
                $data['nowa'],
                $data['email'],
                $data['namausaha'],
                $data['deskripsi'],
                $data['curhatan'],
                "<a href='" . base_url() . $this->uri->segment(1) . "/testimoni_detail/" . $this->encrypt->encode($data['id']) . "' class='btn btn-warning btn-sm' data-original-title='Ubah Data' data-toggle='tooltip'><i class='fa fa-pencil'></i></a>
                <a href='javascript:;' data-hapus='" . $this->encrypt->encode($data['id']) . "' class='btn btn-danger btn-sm hapus' data-original-title='Hapus Data' data-toggle='tooltip'><i class='fa fa-trash'></i></a>",
            );
            $nomor_urut++;
        }
        echo json_encode($output);
    }

    // function testimoni_data()
    // {
    //     $aColumns = array('id_testimoni', 'nama_siswa', 'nama_kelas', 'isi', 'waktu', 'id_testimoni');
    //     $sIndexColumn = "id_testimoni"; //primary key
    //     $where = "id_testimoni!=''";
    //     $dt = $this->data('testimoni', $where, $sIndexColumn, $aColumns);
    //     $nomor_urut = $dt[0];
    //     $rResult    = $dt[1];
    //     $output     = $dt[2];
    //     foreach ($rResult->result_array() as $data) {
    //         $output['data'][] = array(
    //             $nomor_urut,
    //             $data['nama_siswa'],
    //             $data['nama_kelas'],
    //             $data['isi'],
    //             $data['waktu'],
    //             "<a href='" . base_url() . $this->uri->segment(1) . "/testimoni_detail/" . $this->encrypt->encode($data['id_testimoni']) . "' class='btn btn-warning btn-sm' data-original-title='Ubah Data' data-toggle='tooltip'><i class='fa fa-pencil'></i></a>
    //             <a href='javascript:;' data-hapus='" . $this->encrypt->encode($data['id_testimoni']) . "' class='btn btn-danger btn-sm hapus' data-original-title='Hapus Data' data-toggle='tooltip'><i class='fa fa-trash'></i></a>",
    //         );
    //         $nomor_urut++;
    //     }
    //     echo json_encode($output);
    // }
    // function testimoni_detail($id = NULL)
    // {
    //     $this->form_validation->set_rules('nama_siswa', 'Nama testimoni', 'trim|required');
    //     $this->form_validation->set_rules('isi', 'Jumlah Stage', 'trim|required');

    //     if ($this->form_validation->run() != false) { //insert                
    //         $id = $this->encrypt->decode($this->input->post('id'));
    //         $data  = array(
    //             'id_siswa'      => 0,
    //             'nama_siswa'    => ucwords($this->input->post('nama_siswa')),
    //             'nama_kelas'    => $this->input->post('nama_kelas'),
    //             'isi'           => $this->input->post('isi'),
    //             'waktu'    => date('Y-m-d H:i:s')
    //         );
    //         if (empty($id)) {
    //             $this->model_admin->insert_data('testimoni', $data);
    //         } else {
    //             $where = array('id_testimoni' => $id);
    //             $this->model_admin->update_data('testimoni', $data, $where);
    //         }
    //         redirect('testimoni');
    //     } else {
    //         $id = $this->encrypt->decode($id);
    //         if (!empty($id)) {
    //             $where = array('id_testimoni' => $id);
    //             $data = $this->model_admin->select_data('testimoni', null, $where);
    //         } else {
    //             $data       = '';
    //         }
    //         $data = array(
    //             'title' => 'Data testimoni',
    //             'data'          => $data,
    //             'isi'           => 'backend/view_testimoni_detail',
    //         );
    //         $this->load->view('layout', $data);
    //     }
    // }


    // function testimoni_hapus()
    // {
    //     $id = $this->encrypt->decode($this->input->post('hapus'));
    //     if (!empty($id)) {
    //         $where = array('id_testimoni' => $id);

    //         $response = $this->model_admin->delete_data('testimoni', $where);
    //         echo json_encode($response);
    //     }
    // }

    /*--------------------- <tools> ----------------------*/
    function data($table, $where, $sIndexColumn, $aColumns)
    {
        error_reporting(0);
        $sLimit = "";
        if (isset($_REQUEST['iDisplayStart']) && $_REQUEST['iDisplayLength'] != '-1') {
            $sLimit = "LIMIT " . $this->security->xss_clean($_REQUEST['iDisplayStart']) . ", " . $this->security->xss_clean($_REQUEST['iDisplayLength']);
        }
        $numbering = $this->security->xss_clean($_REQUEST['iDisplayStart']);
        $page = 1;/*//pagging // ordering*/
        if (isset($_REQUEST['iSortCol_0'])) {
            $sOrder = "ORDER BY  ";
            for ($i = 0; $i < intval($_REQUEST['iSortingCols']); $i++) {
                if ($_REQUEST['bSortable_' . intval($_REQUEST['iSortCol_' . $i])] == "true") {
                    $sOrder .= $aColumns[intval($_REQUEST['iSortCol_' . $i])] . " " . $this->security->xss_clean($_REQUEST['sSortDir_' . $i]) . ", ";
                }
            }
            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }/*// filtering*/
        $sWhere = "";
        if ($_REQUEST['sSearch'] != "") {
            $sWhere = "WHERE (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i] . " LIKE '%" . $this->security->xss_clean($_REQUEST['sSearch']) . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        }/*// individual column filtering*/
        for ($i = 0; $i < count($aColumns); $i++) {
            if ($_REQUEST['bSearchable_' . $i] == "true" && $_REQUEST['sSearch_' . $i] != '') {
                if ($sWhere == "") {
                    $sWhere = "WHERE ";
                } else {
                    $sWhere .= " AND ";
                }
                $sWhere .= $aColumns[$i] . " LIKE '%" . $this->security->xss_clean($_REQUEST['sSearch_' . $i]) . "%' ";
            }
        }

        $rResult = $this->model_admin->get_data($table, $where, $aColumns, $sWhere, $sOrder, $sLimit, 'x');
        $iFilteredTotal = 10;
        $rResultTotal = $this->model_admin->get_data($table, $where, $aColumns, $sWhere, NULL, NULL, $sIndexColumn);
        $iTotal = $rResultTotal->num_rows();
        $iFilteredTotal = $iTotal;

        $output = array("sEcho" => intval($_REQUEST['sEcho']), "iTotalRecords" => $iTotal, "iTotalDisplayRecords" => $iFilteredTotal, "data" => array());

        $nomor_urut = $_REQUEST['iDisplayStart'] + 1;

        return array($nomor_urut, $rResult, $output);
    }
    function input($post, $data)
    {
        if ($this->input->post($post)) {
            echo $this->input->post($post);
        } elseif (!empty($data)) {
            echo $data;
        }
    }
    function notif($button, $pesan)
    {
        $this->session->set_flashdata('notif', '<center><div class="alert alert-' . $button . '" role="alert" style="border:solid 1px;">' . $pesan . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></center>');
    }
    function kode2($ak)
    {
        $kode = "";
        if ($ak > 0 and $ak < 10) {
            $kode = "0" . $ak;
        } elseif ($ak >= 10 and $ak < 100) {
            $kode = $ak;
        }
        return $kode;
    }
}
