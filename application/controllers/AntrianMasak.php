<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AntrianMasak extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('ModelAntrianMasak');
    $this->load->model('ModelPesanan');
    $this->load->model('ModelMeja');
  }

  public function masukAntrianMasak()
  {
    $noMeja = $this->input->post('noMeja');
    $idPesanan = $this->input->post('idPesanan');
    $dataIdMenu = $this->input->post('dataIdMenu');
    $dataJumlah = $this->input->post('dataJumlah');
    $idMeja = $this->ModelMeja->getIdMejaByNoMeja($noMeja)->row()->id_meja;
    $dataAntrianMasak = array(
      'id_antrian_masak' => $this->db->insert_id(),
      'id_meja' => $idMeja
    );
    $this->ModelAntrianMasak->simpanDataAntrianMasak($dataAntrianMasak);
    $idAntrianMasak = $this->ModelAntrianMasak->getMaxIdAntrianMasak()->row();
    for ($i = 0; $i < count($dataIdMenu); $i++) {
      $dataUpdateItemPesanan = array(
        'id_antrian_masak' => $idAntrianMasak->id_antrian_masak,
        'jumlah' => $dataJumlah[$i],
        'status_pesanan' => '2'
      );
      $this->ModelPesanan->updateDataPesananKeAntrian($idPesanan, $dataUpdateItemPesanan, $dataIdMenu[$i]);
    }
    $callback = array(
      'status' => 'sukses',
      'data' => $idAntrianMasak->id_antrian_masak
    );
    echo json_encode($callback);
  }

  public function viewDapur()
  {
    $data['dataAntrianMinuman'] = $this->ModelAntrianMasak->getAntrianMinumanTanggalSekarang()->result();
    $data['dataAntrianMakanan'] = $this->ModelAntrianMasak->getAntrianMakananTanggalSekarang()->result();
    $data['dataDetailAntrianMinuman'] = $this->ModelAntrianMasak->getDetailAntrianMinumanTanggalSekarang()->result();
    $data['dataDetailAntrianMakanan'] = $this->ModelAntrianMasak->getDetailAntrianMakananTanggalSekarang()->result();
    $data['title'] = "SPR - Dapur";
    $this->load->view('views_template/view_header', $data);
    $this->load->view('view_dapur', $data);
    $this->load->view('views_template/view_footer');
  }

  public function updateViewDapur()
  {
    date_default_timezone_set('Asia/Jakarta');
    $data['dataAntrianMinuman'] = $this->ModelAntrianMasak->getAntrianMinumanTanggalSekarang()->result();
    $data['dataAntrianMakanan'] = $this->ModelAntrianMasak->getAntrianMakananTanggalSekarang()->result();
    $data['dataDetailAntrianMinuman'] = $this->ModelAntrianMasak->getDetailAntrianMinumanTanggalSekarang()->result();
    $data['dataDetailAntrianMakanan'] = $this->ModelAntrianMasak->getDetailAntrianMakananTanggalSekarang()->result();
    $datetime_1 = date("Y-m-d H:i:s");
    $datetime_2 = $this->ModelPesanan->getUpdateTimePesanan()->row()->UPDATE_TIME;
    $start_datetime = new DateTime($datetime_1);
    $diff = $start_datetime->diff(new DateTime($datetime_2));
    $html = $this->load->view('dataTabelDapur', $data, true);
    if ($diff->s < 5) {
      $callback = array(
        'dataHTML' => $html,
        'pesanan' => 'true'
      );
    } else {
      $callback = array(
        'pesanan' => 'false'
      );
    }
    echo json_encode($callback);
  }

  public function viewPelayan()
  {
    $data['dataAntrianMinuman'] = $this->ModelAntrianMasak->getAntrianMinumanTanggalSekarang()->result();
    $data['dataAntrianMakanan'] = $this->ModelAntrianMasak->getAntrianMakananTanggalSekarang()->result();
    $data['dataDetailAntrianMinuman'] = $this->ModelAntrianMasak->getDetailAntrianMinumanTanggalSekarang()->result();
    $data['dataDetailAntrianMakanan'] = $this->ModelAntrianMasak->getDetailAntrianMakananTanggalSekarang()->result();
    $data['title'] = "SPR - Pelayan";
    $this->load->view('views_template/view_header', $data);
    $this->load->view('view_pelayan', $data);
    $this->load->view('views_template/view_footer');
  }

  public function updateViewPelayan()
  {
    date_default_timezone_set('Asia/Jakarta');
    $data['dataAntrianMinuman'] = $this->ModelAntrianMasak->getAntrianMinumanTanggalSekarang()->result();
    $data['dataAntrianMakanan'] = $this->ModelAntrianMasak->getAntrianMakananTanggalSekarang()->result();
    $data['dataDetailAntrianMinuman'] = $this->ModelAntrianMasak->getDetailAntrianMinumanTanggalSekarang()->result();
    $data['dataDetailAntrianMakanan'] = $this->ModelAntrianMasak->getDetailAntrianMakananTanggalSekarang()->result();
    // $this->load->view('dataTabelPelayan', $data);
    $datetime_1 = date("Y-m-d H:i:s");
    $datetime_2 = $this->ModelPesanan->getUpdateTimePesanan()->row()->UPDATE_TIME;
    $start_datetime = new DateTime($datetime_1);
    $diff = $start_datetime->diff(new DateTime($datetime_2));
    $html = $this->load->view('dataTabelPelayan', $data, true);
    if ($diff->s < 5) {
      $callback = array(
        'dataHTML' => $html,
        'pesanan' => 'true'
      );
    } else {
      $callback = array(
        'pesanan' => 'false'
      );
    }
    echo json_encode($callback);
  }

  public function updateIdstatusPesananSelesai()
  {
    $idMenu = $this->input->post('idMenu');
    $idPesanan = $this->input->post('idPesanan');
    $idAntrian = $this->input->post('idAntrian');
    $dataUpdateItemPesanan = array(
      'status_pesanan' => '3'
    );
    $this->ModelPesanan->updateDataItemPesanan($dataUpdateItemPesanan, $idMenu, $idPesanan, $idAntrian);
    $callback = array(
      'status' => 'sukses'
    );
    echo json_encode($callback);
  }
}
