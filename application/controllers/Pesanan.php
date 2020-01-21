<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesanan extends CI_Controller
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
            'title'     => 'Manajemen Pesanan',
            'isi'       => 'backend/view_pesanan'
        );
        $this->load->view('layout', $data);
    }
    function pesanan_data()
    {
        $where = 'id_pesanan!=""';

        $aColumns = array('id_pesanan', 'id_pesanan', 'nama_siswa', 'nama_kelas', 'total', 'waktu', 'status', 'id_pesanan');
        $sIndexColumn = "id_pesanan"; //primary key

        $dt = $this->data('pesanan', $where, $sIndexColumn, $aColumns);
        $nomor_urut = $dt[0];
        $rResult    = $dt[1];
        $output     = $dt[2];
        foreach ($rResult->result_array() as $data) {
            if ($data['status'] == 'menunggu_bayar') {
                $status = '<label class="label label-warning">Menunggu Pembayaran</label>';
            } elseif ($data['status'] == 'proses') {
                $status = '<label class="label label-info">Proses</label>';
            } else {
                $status = '<label class="label label-success">Dibayar</label>';
            }
            $byr = $this->pemesanan_pembayaran($data['id_pesanan']);
            if (!empty($byr) or $data['status'] == 'proses') {
                $aksi = "<a href='#konfirmasi' 
                data-waktu='" . $data['waktu'] . " WIB'
                data-id_pesanan='" . $data['id_pesanan'] . "' 
                data-nama_siswa='" . $data['nama_siswa'] . "' 
                data-nama_kelas='" . $data['nama_kelas'] . "' 
                data-total='Rp " . number_format($data['total'], 0, ',', '.') . "' 
                data-waktu_bayar='" . Tools::tgl_indo($byr[0]['waktu_bayar'], 'd F Y') . "' 
                data-nominal='Rp " . number_format($byr[0]['nominal'], 0, ',', '.') . "'
                data-atas_nama='" . $byr[0]['atas_nama'] . "' 
                data-bank_pengirim='" . $byr[0]['bank_pengirim'] . "' 
                data-bank_tujuan='" . $byr[0]['bank_tujuan'] . "' 
                data-file='" . $byr[0]['file'] . "'
                class='btn btn-success btn-sm' data-toggle='modal'><i class='fa fa-check'></i> Konfirmasi</a>";
            } else {
                $aksi = "-";
            }

            $output['data'][] = array(
                $nomor_urut,
                $data['id_pesanan'],
                $data['nama_siswa'],
                $data['nama_kelas'],
                "Rp " . number_format($data['total'], 0, ',', '.'),
                $data['waktu'],
                $status,
                $aksi
            );
            $nomor_urut++;
        }
        echo json_encode($output);
    }

    function pemesanan_pembayaran($id_pesanan)
    {
        $data = $this->model_admin->select_data('pembayaran', null, array('id_pesanan' => $id_pesanan));
        return $data;
    }

    function pesanan_konfirmasi()
    {
        $id = $this->input->post('konfirmasi');
        if (!empty($id)) {
            $where = array('id_pesanan' => $id);
            $data = array(
                'status' => 'dibayar'
            );
            $response = $this->model_admin->update_data('pesanan', $data, $where);
            echo json_encode($response);
        }
    }

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
}
