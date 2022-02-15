<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Notes_model extends CI_Model
{
  private $table = 'notes';

  //validasi form, method ini akan mengembailkan data berupa rules validasi form       
  public function rules()
  {
    return [
      [
        'field' => 'noteBody',
        'label' => 'Notes',
        'rules' => 'trim|required',
        'errors' => [
          'required' => 'Field %s tidak boleh kosong',
        ],
      ],
      [
        'field' => 'noteTitle',
        'label' => 'Title',
        'rules' => 'trim|required',
        'errors' => [
          'required' => 'Field %s tidak boleh kosong',
        ],
      ],
    ];
  }

  public function getAll() {
    $this->db->select('notes.*, users.username');
    $this->db->join('users', 'users.id = notes.user_id', 'left');
    $this->db->order_by('id', 'ASC');
    $this->db->from('notes');
    $query = $this->db->get();
    return $query->result();
  }

  public function getAllFromUser($id) {
    $this->db->select('notes.*, users.username');
    $this->db->where('notes.id', $id);
    $this->db->join('users', 'users.id = notes.user_id', 'left');
    $this->db->order_by('id', 'ASC');
    $this->db->from('notes');
    $query = $this->db->get();
    return $query->result();
  }

  public function getById($id) {
    $this->db->select('notes.*, users.username');
    $this->db->where('notes.id', $id);
    $this->db->join('users', 'users.id = notes.user_id', 'left');
    $this->db->from('notes');
    $query = $this->db->get();
    return $query->row();
  }

  public function updateById($id) {
    $title = htmlspecialchars($this->input->post('noteTitle'));
    $notes = htmlspecialchars($this->input->post('noteBody'));
    $data = [
      'note_title' => $title,
      'note_body' => $notes,
    ];
    $this->db->select('notes.*');
    $this->db->where('notes.id', $id);
    $this->db->from('notes');
    return $this->db->update('notes', $data);
  }

  public function add()
  {
    $title = htmlspecialchars($this->input->post('noteTitle'));
    $notes = htmlspecialchars($this->input->post('noteBody'));
    $data = [
      'user_id' => $this->session->userdata('id'),
      'note_title' => $title,
      'note_body' => $notes,
      'created_at' => time(),
    ];
    return $this->db->insert($this->table, $data);
  }

  public function deleteById($id)
  {
    $this->db->where('id', $id);
    return $this->db->delete('notes');
  }
}
