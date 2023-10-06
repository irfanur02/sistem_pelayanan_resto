<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelPesanan extends CI_Model
{

  function simpanDataMejaTerisi($data)
  {
    $this->db->insert('pesanan', $data); // Untuk mengeksekusi perintah insert data
  }

  // public function getIdPesananTokenTanggalSekarang($idMeja, $token)
  // {
  //   date_default_timezone_set('Asia/Jakarta');
  //   $this->db->select("id_pesanan");
  //   $this->db->from('pesanan');
  //   $this->db->where('id_meja', $idMeja);
  //   $this->db->where('token', $token);
  //   $this->db->where('SUBSTRING(tanggal_pesanan, 1, 10) = ', date("Y-m-d"));
  //   return $this->db->get();
  // }

  public function getIdPesananTokenTerbaru($idMeja, $token)
  {
    date_default_timezone_set('Asia/Jakarta');
    $this->db->select("id_pesanan");
    $this->db->from('pesanan');
    $this->db->where('id_meja', $idMeja);
    $this->db->where('token', $token);
    $this->db->where('SUBSTRING(tanggal_pesanan, 1, 10) = ', date("Y-m-d"));
    $this->db->order_by('pesanan.id_pesanan', 'DESC');
    $this->db->limit(1);
    return $this->db->get();
  }

  public function cekMenuPesanan($idPesanan, $idMenu)
  {
    $this->db->select('id_menu, status_pesanan');
    $this->db->from('detail_pesanan');
    $this->db->where('id_pesanan', $idPesanan);
    $this->db->where('id_menu', $idMenu);
    return $this->db->get();
  }

  public function updateJumlahPesananIdMenu($jumlahItemMenu, $idMenu, $idPesanan)
  {
    $this->db->set('jumlah', 'jumlah + ' . $jumlahItemMenu, false);
    $this->db->where('id_pesanan', $idPesanan);
    $this->db->where('id_menu', $idMenu);
    $this->db->update('detail_pesanan');
  }

  public function getJumlahPesananMeja($idPesanan)
  {
    $this->db->select("SUM(jumlah) as jumlah");
    $this->db->from('detail_pesanan');
    $this->db->where('id_pesanan', $idPesanan);
    $this->db->group_by('id_pesanan');
    return $this->db->get();
  }

  function cekTokenByTanggalSekarang($token)
  {
    date_default_timezone_set('Asia/Jakarta');
    $this->db->select('*');
    $this->db->from('pesanan');
    $this->db->where('token', $token);
    $this->db->where('SUBSTRING(tanggal_pesanan, 1, 10) = ', date("Y-m-d"));
    return $this->db->get();
  }

  function simpanDetailPesanan($data)
  {
    $this->db->insert('detail_pesanan', $data); // Untuk mengeksekusi perintah insert data
  }

  public function getNoMejaByIdPesanan($idPesanan)
  {
    $this->db->select("meja.no_meja as no_meja");
    $this->db->from('pesanan');
    $this->db->join('meja', 'meja.id_meja = pesanan.id_meja');
    $this->db->where('pesanan.id_pesanan', $idPesanan);
    return $this->db->get();
  }

  public function getPesananMejaByIdPesanan($idPesanan)
  {
    $this->db->select("detail_pesanan.status_pesanan, detail_pesanan.id_menu, menu.gambar_menu, menu.nama_menu, SUM(detail_pesanan.jumlah) as jumlah, SUM(detail_pesanan.jumlah * menu.harga_menu) as harga_menu, detail_pesanan.id_pesanan");
    $this->db->from('detail_pesanan');
    $this->db->join('menu', 'menu.id_menu = detail_pesanan.id_menu');
    $this->db->where('detail_pesanan.id_pesanan', $idPesanan);
    $this->db->where('detail_pesanan.status_pesanan > ', '1');
    $this->db->group_by('detail_pesanan.id_menu');
    return $this->db->get();
  }

  public function getPesananMejaByPilih($idPesanan)
  {
    $this->db->select("detail_pesanan.id_menu, menu.gambar_menu, menu.nama_menu, SUM(detail_pesanan.jumlah) as jumlah, detail_pesanan.id_pesanan");
    $this->db->from('detail_pesanan');
    $this->db->join('menu', 'menu.id_menu = detail_pesanan.id_menu');
    $this->db->where('detail_pesanan.id_pesanan', $idPesanan);
    $this->db->where('detail_pesanan.status_pesanan', '1');
    $this->db->group_by('detail_pesanan.id_menu');
    return $this->db->get();
  }

  public function getJumlahPesananMejaByMasak($idPesanan)
  {
    $this->db->select("SUM(jumlah) as jumlah");
    $this->db->from('detail_pesanan');
    $this->db->where('status_pesanan', 2);
    $this->db->where('id_pesanan', $idPesanan);
    $this->db->group_by('status_pesanan');
    return $this->db->get();
  }

  public function getdataPesananMejaByMasak($idPesanan)
  {
    $this->db->select("id_menu, SUM(jumlah) as jumlah");
    $this->db->from('detail_pesanan');
    $this->db->where('status_pesanan', 2);
    $this->db->where('id_pesanan', $idPesanan);
    $this->db->group_by('id_menu');
    $this->db->group_by('status_pesanan');
    return $this->db->get();
  }

  public function getTotalHargaPesanan($idPesanan)
  {
    $this->db->select("SUM(detail_pesanan.jumlah * menu.harga_menu) as total_harga");
    $this->db->from('detail_pesanan');
    $this->db->join('menu', 'menu.id_menu = detail_pesanan.id_menu');
    $this->db->where('detail_pesanan.id_pesanan', $idPesanan);
    $this->db->where('detail_pesanan.status_pesanan > ', '1');
    $this->db->group_by('detail_pesanan.id_pesanan');
    return $this->db->get();
  }

  function updateDataItemPesanan($dataUpdateItemPesanan, $dataIdMenu, $idPesanan, $idAntrian)
  {
    $this->db->where('id_pesanan', $idPesanan);
    $this->db->where('id_menu', $dataIdMenu);
    $this->db->where('id_antrian_masak', $idAntrian);
    $this->db->update('detail_pesanan', $dataUpdateItemPesanan);
  }

  function deleteItemMenuPesanan($idMenu, $idPesanan)
  {
    $this->db->where('id_menu', $idMenu);
    $this->db->where('id_pesanan', $idPesanan);
    $this->db->delete('detail_pesanan');
  }

  function updateDataPesananKeAntrian($idPesanan, $dataUpdateItemPesanan, $dataIdMenu)
  {
    $this->db->where('id_pesanan', $idPesanan);
    $this->db->where('id_menu', $dataIdMenu);
    $this->db->where('status_pesanan < ', '2');
    $this->db->update('detail_pesanan', $dataUpdateItemPesanan);
  }

  public function getUpdateTimePesanan()
  {
    $this->db->select('UPDATE_TIME');
    $this->db->from('information_schema.tables');
    $this->db->where('TABLE_SCHEMA', 'db_sistem_pelayanan_resto');
    $this->db->where('TABLE_NAME', 'detail_pesanan');
    return $this->db->get();
  }
}
