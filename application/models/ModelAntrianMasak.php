<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelAntrianMasak extends CI_Model
{
  function simpanDataAntrianMasak($dataAntrian)
  {
    $this->db->insert('antrian_masak', $dataAntrian);
  }

  function getMaxIdAntrianMasak()
  {
    $this->db->select_max('id_antrian_masak');
    return $this->db->get('antrian_masak');
  }

  function getAntrianMinumanTanggalSekarang()
  {
    date_default_timezone_set('Asia/Jakarta');
    $this->db->select('antrian_masak.id_antrian_masak, meja.no_meja');
    $this->db->from('antrian_masak');
    $this->db->join('meja', 'meja.id_meja = antrian_masak.id_meja');
    $this->db->join('detail_pesanan', 'detail_pesanan.id_antrian_masak = antrian_masak.id_antrian_masak');
    $this->db->join('menu', 'menu.id_menu = detail_pesanan.id_menu');
    $this->db->join('pesanan', 'pesanan.id_pesanan = detail_pesanan.id_pesanan');
    $this->db->where('menu.id_kategori_menu', 2);
    $this->db->where('detail_pesanan.status_pesanan', 2);
    $this->db->where('SUBSTRING(pesanan.tanggal_pesanan, 1, 10) = ', date('Y-m-d'));
    $this->db->group_by('antrian_masak.id_antrian_masak');
    return $this->db->get();
  }

  function getAntrianMakananTanggalSekarang()
  {
    date_default_timezone_set('Asia/Jakarta');
    $this->db->select('antrian_masak.id_antrian_masak, meja.no_meja');
    $this->db->from('antrian_masak');
    $this->db->join('meja', 'meja.id_meja = antrian_masak.id_meja');
    $this->db->join('detail_pesanan', 'detail_pesanan.id_antrian_masak = antrian_masak.id_antrian_masak');
    $this->db->join('menu', 'menu.id_menu = detail_pesanan.id_menu');
    $this->db->join('pesanan', 'pesanan.id_pesanan = detail_pesanan.id_pesanan');
    $this->db->where('menu.id_kategori_menu', 1);
    $this->db->where('detail_pesanan.status_pesanan', 2);
    $this->db->where('SUBSTRING(pesanan.tanggal_pesanan, 1, 10) = ', date('Y-m-d'));
    $this->db->group_by('antrian_masak.id_antrian_masak');
    return $this->db->get();
  }

  function getDetailAntrianMinumanTanggalSekarang()
  {
    date_default_timezone_set('Asia/Jakarta');
    $this->db->select('antrian_masak.id_antrian_masak, detail_pesanan.id_pesanan, detail_pesanan.id_menu, menu.nama_menu, menu.id_kategori_menu, detail_pesanan.jumlah');
    $this->db->from('antrian_masak');
    $this->db->join('detail_pesanan', 'detail_pesanan.id_antrian_masak = antrian_masak.id_antrian_masak');
    $this->db->join('menu', 'menu.id_menu = detail_pesanan.id_menu');
    $this->db->join('pesanan', 'pesanan.id_pesanan = detail_pesanan.id_pesanan');
    $this->db->where('menu.id_kategori_menu', '2');
    $this->db->where('detail_pesanan.status_pesanan', 2);
    $this->db->where('SUBSTRING(pesanan.tanggal_pesanan, 1, 10) = ', date('Y-m-d'));
    return $this->db->get();
  }

  function getDetailAntrianMakananTanggalSekarang()
  {
    date_default_timezone_set('Asia/Jakarta');
    $this->db->select('antrian_masak.id_antrian_masak, detail_pesanan.id_pesanan, detail_pesanan.id_menu, menu.nama_menu, menu.id_kategori_menu, detail_pesanan.jumlah');
    $this->db->from('antrian_masak');
    $this->db->join('detail_pesanan', 'detail_pesanan.id_antrian_masak = antrian_masak.id_antrian_masak');
    $this->db->join('menu', 'menu.id_menu = detail_pesanan.id_menu');
    $this->db->join('pesanan', 'pesanan.id_pesanan = detail_pesanan.id_pesanan');
    $this->db->where('menu.id_kategori_menu', '1');
    $this->db->where('detail_pesanan.status_pesanan', 2);
    $this->db->where('SUBSTRING(pesanan.tanggal_pesanan, 1, 10) = ', date('Y-m-d'));
    return $this->db->get();
  }
}
