<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('ModelMeja');
    $this->load->model('ModelPesanan');
    $this->load->model('ModelPembayaran');
  }

  public function index()
  {
    $data['dataPesananMeja'] = $this->ModelMeja->getMejaTerisiTanggalSekarang()->result();
    $data['title'] = "SPR - Kasir";
    $this->load->view('views_template/view_header', $data);
    $this->load->view('views_template/view_navbar_kasir');
    $this->load->view('view_kasir', $data);
    $this->load->view('views_template/view_footer');
  }

  public function getMejaTerisi()
  {
    $data['dataMejaTerisi'] = $this->ModelMeja->getMejaTerisiTanggalSekarang()->result();
    $callback = array(
      'dataMejaTerisi' => $data['dataMejaTerisi']
    );

    echo json_encode($callback);
  }

  public function getPesananMeja()
  {
    $idPesanan = $this->input->post('idPesanan');
    $data['dataPesananMeja'] = $this->ModelPesanan->getPesananMejaByIdPesanan($idPesanan)->result();
    $data['dataTotalHargaPesanan'] = $this->ModelPesanan->getTotalHargaPesanan($idPesanan)->row();
    $this->load->view('dataTabelBayarPesananUser', $data);
  }

  public function prosesBayarTunai()
  {
    date_default_timezone_set('Asia/Jakarta');
    $idPesanan = $this->input->post('idPesanan');
    $idMeja = $this->input->post('idMeja');
    $dataPembayaran = array(
      'id_pembayaran' => $this->db->insert_id(),
      'id_pesanan' => $idPesanan,
      'tanggal_pembayaran' => date("Y-m-d"),
      'model_pembayaran' => 1
    );
    $this->ModelPembayaran->simpanPembayaran($dataPembayaran);
    $this->ModelMeja->updateStatusMeja($idMeja, '1');
    $callback = array(
      'status' => 'sukses',
      'data' => $dataPembayaran
    );

    echo json_encode($callback);
  }
}
