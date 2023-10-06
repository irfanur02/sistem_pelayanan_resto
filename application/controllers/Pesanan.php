<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesanan extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('ModelMenu');
    $this->load->model('ModelPesanan');
    $this->load->model('ModelMeja');
    $this->load->model('ModelPembayaran');
  }

  public function getMeja($meja)
  {
    $data['dataMenu'] = $this->ModelMenu->ambilDataMenu()->result();
    $data['title'] = "RESTO";
    $data['meja'] = $meja;
    $this->load->view('views_template/view_header', $data);
    $this->load->view('views_template/view_navbar', $data);
    $this->load->view('view_home_page', $data);
    $this->load->view('views_template/view_footer');
  }

  public function addMejaPesanan()
  {
    date_default_timezone_set('Asia/Jakarta');
    $token = $this->input->post('tokenPesanan');
    $noMeja = $this->input->post('noMeja');
    $idMeja = $this->ModelMeja->getIdMejaByNoMeja($noMeja)->row()->id_meja;
    // $statusMeja = $this->ModelMeja->cekStatusMeja($idMeja)->row()->status_ketersediaan;
    $dataPesanan = array(
      'id_pesanan' => $this->db->insert_id(),
      'id_meja' => $idMeja,
      'token' => $token,
      'tanggal_pesanan' => date("Y-m-d H:i:s")
    );
    $this->ModelPesanan->simpanDataMejaTerisi($dataPesanan);
    $this->ModelMeja->updateStatusMeja($idMeja, '2');
    $idPesanan = $this->ModelPesanan->getIdPesananTokenTanggalSekarang($idMeja, $token)->row()->id_pesanan;
    $jumlahPesananMeja = $this->ModelPesanan->getJumlahPesananMeja($idPesanan)->row();
    $callback = array(
      'status' => 'sukses',
      'dataJumlahPesanan' => ($jumlahPesananMeja != null) ? $jumlahPesananMeja : "0",
      'dataIdPesanan' => $idPesanan,
      'cekToken' => 'true'
    );
    echo json_encode($callback);
  }

  public function cekPesananToken()
  {
    date_default_timezone_set('Asia/Jakarta');
    $token = $this->input->post('tokenPesanan');
    $noMeja = $this->input->post('noMeja');
    $idMeja = $this->ModelMeja->getIdMejaByNoMeja($noMeja)->row()->id_meja;
    $tanggalToken = $this->ModelPesanan->cekTokenByTanggalSekarang($token)->result();
    $idPesanan = $this->ModelPesanan->getIdPesananTokenTerbaru($idMeja, $token)->row()->id_pesanan;
    $cekPembayaranToken = $this->ModelPembayaran->cekPembayaranByIdPesanan($idPesanan)->result();
    if ($tanggalToken == null || $cekPembayaranToken != null) {
      $dataPesanan = array(
        'id_pesanan' => $this->db->insert_id(),
        'id_meja' => $idMeja,
        'token' => $token,
        // pesanan session = random char
        'tanggal_pesanan' => date("Y-m-d H:i:s")
      );
      $this->ModelPesanan->simpanDataMejaTerisi($dataPesanan);
      $this->ModelMeja->updateStatusMeja($idMeja, 2);

      $idPesanan = $this->ModelPesanan->getIdPesananTokenTerbaru($idMeja, $token)->row()->id_pesanan;
      $jumlahPesananMeja = $this->ModelPesanan->getJumlahPesananMeja($idPesanan)->row();
      $callback = array(
        'status' => 'sukses',
        'dataJumlahPesanan' => ($jumlahPesananMeja != null) ? $jumlahPesananMeja->jumlah : "0",
        'dataIdPesanan' => $idPesanan,
        'cekToken' => 'true'
      );
    } else {
      // cek pesanan session
      // jika pesanan tidak memilih menu selama 15 menit dari tanggal pesanan dibuat
      //    ubah pesanan session = null
      $idPesanan = $this->ModelPesanan->getIdPesananTokenTerbaru($idMeja, $token)->row()->id_pesanan;
      $jumlahPesananMeja = $this->ModelPesanan->getJumlahPesananMeja($idPesanan)->row();
      $callback = array(
        'status' => 'sukses',
        'dataJumlahPesanan' => ($jumlahPesananMeja != null) ? $jumlahPesananMeja->jumlah : "0",
        'dataIdPesanan' => $idPesanan,
        'cekToken' => 'true',
      );
    }
    echo json_encode($callback);
  }

  public function addItemPesanan()
  {
    date_default_timezone_set('Asia/Jakarta');
    $noMeja = $this->input->post('noMeja');
    $token = $this->input->post('tokenPesanan');
    $jumlahItemMenu = $this->input->post('jumlahItemMenu');
    $idMenu = $this->input->post('idMenu');
    $idMeja = $this->ModelMeja->getIdMejaByNoMeja($noMeja)->row()->id_meja;
    $idPesanan = $this->ModelPesanan->getIdPesananTokenTerbaru($idMeja, $token)->row()->id_pesanan;
    $cekMenu = $this->ModelPesanan->cekMenuPesanan($idPesanan, $idMenu)->row();
    if ($cekMenu && $cekMenu->status_pesanan < 2) {
      $this->ModelPesanan->updateJumlahPesananIdMenu($jumlahItemMenu, $idMenu, $idPesanan);
      $callback = array(
        'status' => 'sukses',
        'data' => "menu sudah ada"
      );
    } else {
      $dataDetailPesanan = array(
        'id_pesanan' => $idPesanan,
        'id_menu' => $idMenu,
        'jumlah' => $jumlahItemMenu,
        'status_pesanan' => '1'
      );
      $this->ModelPesanan->simpanDetailPesanan($dataDetailPesanan);

      $callback = array(
        'status' => 'sukses',
        'data' => "menu belum ada"
      );
    }
    echo json_encode($callback);
  }

  public function viewDetailPesanan($idPesanan)
  {
    $cekPembayaranToken = $this->ModelPembayaran->cekPembayaranByIdPesanan($idPesanan)->result();
    if ($cekPembayaranToken != null) {
      redirect('pesanan');
    } else {
      $noMeja = $this->ModelPesanan->getNoMejaByIdPesanan($idPesanan)->row_array()['no_meja'];
      $data['title'] = "RESTO";
      $data['meja'] = $noMeja;
      $data['dataPesananMeja'] = $this->ModelPesanan->getPesananMejaByIdPesanan($idPesanan)->result();
      $data['pesananMejaByPilih'] = $this->ModelPesanan->getPesananMejaByPilih($idPesanan)->result();
      $data['dataTotalHargaPesanan'] = $this->ModelPesanan->getTotalHargaPesanan($idPesanan)->row();
      $data['jumlahPesananMeja'] = $this->ModelPesanan->getJumlahPesananMeja($idPesanan)->row();
      $data['jumlahPesananMejaByMasak'] = $this->ModelPesanan->getJumlahPesananMejaByMasak($idPesanan)->row();
      $data['dataPesananMejaByMasak'] = $this->ModelPesanan->getdataPesananMejaByMasak($idPesanan)->result();
      $data['idPesanan'] = $idPesanan;
      $this->load->view('views_template/view_header', $data);
      $this->load->view('views_template/view_navbar', $data);
      $this->load->view('view_detail_pesanan', $data);
      $this->load->view('views_template/view_footer');
    }
  }

  public function updateTabelPesananUser()
  {
    date_default_timezone_set('Asia/Jakarta');
    $idPesanan = $this->input->post('idPesanan');
    $data['dataPesananMeja'] = $this->ModelPesanan->getPesananMejaByIdPesanan($idPesanan)->result();
    $data['dataTotalHargaPesanan'] = $this->ModelPesanan->getTotalHargaPesanan($idPesanan)->row();
    $data['jumlahPesananMejaByMasak'] = $this->ModelPesanan->getJumlahPesananMejaByMasak($idPesanan)->row();
    $data['dataPesananMejaByMasak'] = $this->ModelPesanan->getdataPesananMejaByMasak($idPesanan)->result();
    $datetime_1 = date("Y-m-d H:i:s");
    $datetime_2 = $this->ModelPesanan->getUpdateTimePesanan()->row()->UPDATE_TIME;
    $start_datetime = new DateTime($datetime_1);
    $diff = $start_datetime->diff(new DateTime($datetime_2));
    $html = $this->load->view('dataTabelPesananUser', $data, true);
    if ($diff->s < 5) {
      $callback = array(
        'dataHTML' => $html,
        'jumlahPesananDimasak' => $data['jumlahPesananMejaByMasak']->jumlah,
        'pesanan' => 'true'
      );
    } else {
      $callback = array(
        'pesanan' => 'false'
      );
    }
    echo json_encode($callback);
  }

  public function deleteItemPesanan()
  {
    $idMenu = $this->input->post('idMenu');
    $idPesanan = $this->input->post('idPesanan');
    $this->ModelPesanan->deleteItemMenuPesanan($idMenu, $idPesanan);
    $callback = array(
      'status' => 'sukses'
    );
    echo json_encode($callback);
  }
}
