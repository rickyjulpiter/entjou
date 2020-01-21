<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Curhat extends CI_Controller
{
    function index()
    {
        $this->load->view('frontend/maucurhat');
    }

    function curhat_tambah()
    {
        $nama       = $this->input->post('nama');
        $nowa    = $this->input->post('nowa');
        $email       = $this->input->post('email');
        $namausaha      = $this->input->post('namausaha');
        $deskripsi    = $this->input->post('deskripsi');
        $curhatan   = $this->input->post('curhatan');

        $data = array(
            'nama'     => strip_tags($nama),
            'nowa'   => strip_tags($nowa),
            'email'  => strip_tags($email),
            'namausaha'  => strip_tags($namausaha),
            'deskripsi'  => strip_tags($deskripsi),
            'curhatan'  => strip_tags($curhatan)
        );
        $this->model_admin->insert_data('curhat', $data);
        if ($website != "kontak") {
            $this->notif('success', 'Komentar anda berhasil diterbitkan');
        } else {
            $this->notif('success', 'Pesan anda sudah kami terima. Jawaban akan kami kirim ke alamat email yang anda masukan');
        }
        redirect(base_url('home/') . $slug . '#komentar');
    }
}
