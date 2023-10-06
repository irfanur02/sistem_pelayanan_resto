<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelPembayaran extends CI_Model
{
  public function cekPembayaranByIdPesanan($idPesanan)
  {
    date_default_timezone_set('Asia/Jakarta');
    $this->db->select("id_pesanan");
    $this->db->from('pembayaran');
    $this->db->where('id_pesanan', $idPesanan);
    $this->db->where('SUBSTRING(tanggal_pembayaran, 1, 10) = ', date("Y-m-d"));
    return $this->db->get();
  }

  public function simpanPembayaran($dataPembayaran)
  {
    $this->db->insert('pembayaran', $dataPembayaran);
  }
}
