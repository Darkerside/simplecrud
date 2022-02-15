<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Roles_model extends CI_Model
{
  public function getAll() {
    $this->db->select('roles.*');
    $this->db->order_by('id', 'ASC');
    $this->db->from('roles');
    $query = $this->db->get();
    return $query->result();
  }
}
