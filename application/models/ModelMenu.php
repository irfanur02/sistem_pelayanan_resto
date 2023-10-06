<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelMenu extends CI_Model
{

  function ambilDataMenu()
  {
    $this->db->select('id_menu, nama_menu, gambar_menu, harga_menu');
    $this->db->from('menu');
    $this->db->order_by('nama_menu', 'ASC');
    return $this->db->get();
  }
}
