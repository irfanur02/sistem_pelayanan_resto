<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelMeja extends CI_Model
{
  function updateStatusMeja($idMeja, $statusMeja)
  {
    $this->db->set('status_ketersedian', $statusMeja);
    $this->db->where('id_meja', $idMeja);
    $this->db->update('meja');
  }

  function cekStatusMeja($meja)
  {
    $this->db->select('status_ketersedian');
    $this->db->from('meja');
    $this->db->where('no_meja', $meja);
    return $this->db->get();
  }

  function getIdMejaByNoMeja($noMeja)
  {
    $this->db->select('id_meja');
    $this->db->from('meja');
    $this->db->where('no_meja', $noMeja);
    return $this->db->get();
  }

  function getMejaTerisiTanggalSekarang()
  {
    date_default_timezone_set('Asia/Jakarta');
    $this->db->select('pem.id_pesanan');
    $this->db->from('pembayaran pem');
    $this->db->where('pem.id_pesanan = pesanan.id_pesanan', null);
    $sub_query = $this->db->get_compiled_select();

    $this->db->select('pesanan.id_pesanan, meja.id_meja, meja.no_meja');
    $this->db->from('pesanan');
    $this->db->join('meja', 'meja.id_meja = pesanan.id_meja');
    $this->db->join('detail_pesanan', 'detail_pesanan.id_pesanan = pesanan.id_pesanan');
    $this->db->where("NOT EXISTS ($sub_query)");
    $this->db->where('SUBSTRING(pesanan.tanggal_pesanan, 1, 10) = ', date("Y-m-d"));
    $this->db->where('detail_pesanan.status_pesanan > ', '1');
    $this->db->group_by('pesanan.id_pesanan');
    return $this->db->get();

    // SELECT pesanan.id_pesanan, meja.id_meja, meja.no_meja
    // FROM meja
    // JOIN pesanan ON pesanan.id_meja = meja.id_meja
    // JOIN detail_pesanan ON detail_pesanan.id_pesanan = pesanan.id_pesanan
    // WHERE NOT EXISTS (SELECT pem.id_pesanan FROM pembayaran pem WHERE pem.id_pesanan = pesanan.id_pesanan)
    //   AND SUBSTRING(pesanan.tanggal_pesanan, 1, 10) = '2023-09-18'
    //   AND detail_pesanan.status_pesanan > '1'
    // GROUP BY pesanan.id_pesanan
  }
}
