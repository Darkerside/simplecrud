<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Users_model extends CI_Model
{
  private $table = 'users';

  //validasi form, method ini akan mengembailkan data berupa rules validasi form       
  public function rules()
  {
    return [
      [
        'field' => 'username',
        'label' => 'Username',
        'rules' => 'trim|required|min_length[3]',
        'errors' => [
          'required' => 'Field %s tidak boleh kosong',
          'min_length' => '%s harus minimal 3 Character'
        ],
      ],
      [
        'field' => 'roleId',
        'label' => 'Role',
        'rules' => 'trim|required',
        'errors' => [
          'required' => 'Field %s tidak boleh kosong',
        ],
      ],
      [
        'field' => 'password',
        'label' => 'Password',
        'rules' => 'trim|required',
        'errors' => [
          'required' => 'Field %s tidak boleh kosong'
        ]
      ],
      [
        'field' => 'retype',
        'label' => 'Retype Password',
        'rules' => 'trim|required|matches[password]',
        'errors' => [
          'required' => 'Field %s tidak boleh kosong',
          'matches' => 'Field %s tidak sama dengan Password'
        ]
      ],
    ];
  }

  public function getAll() {
    $this->db->select('users.*, roles.role_name');
    $this->db->join('roles', 'roles.id = users.role_id', 'left');
    $this->db->order_by('id', 'ASC');
    $this->db->from('users');
    $query = $this->db->get();
    return $query->result();
  }

  public function add()
  {
    $user = htmlspecialchars($this->input->post('username'));
    $pass = htmlspecialchars($this->input->post('password'));
    $role = htmlspecialchars($this->input->post('roleId'));
    $active = htmlspecialchars($this->input->post('isActive'));
    $data = [
      'username' => $user,
      'password' => password_hash($pass, PASSWORD_DEFAULT),
      'role_id' => $role,
      'is_active' => $active,
      'created_at' => time()
    ];
    return $this->db->insert($this->table, $data);
  }

  public function login()
  {
    $user = htmlspecialchars($this->input->post('username'));
    $pass = htmlspecialchars($this->input->post('password'));
    $data = [
      'username' => $user,
      'password' => password_hash($pass, PASSWORD_DEFAULT),
      'is_active' => 1,
      'created_at' => time()
    ];
    return $this->db->insert($this->table, $data);
  }

  public function getById($id) {
    $this->db->select('users.*, roles.role_name');
    $this->db->where('users.id', $id);
    $this->db->join('roles', 'roles.id = users.role_id', 'left');
    $this->db->from('users');
    $query = $this->db->get();
    return $query->row();
  }

  public function updateById($id) {
    $user = htmlspecialchars($this->input->post('username'));
    $role = htmlspecialchars($this->input->post('roleId'));
    $active = htmlspecialchars($this->input->post('isActive'));
    $data = [
      'username' => $user,
      'role_id' => $role,
      'is_active' => $active,
    ];
    $this->db->select('users.*');
    $this->db->where('users.id', $id);
    $this->db->from('users');
    return $this->db->update('users', $data);
  }

  public function deleteById($id)
  {
    $this->db->where('id', $id);
    return $this->db->delete('users');
  }
}
