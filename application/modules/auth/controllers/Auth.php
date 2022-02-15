<?php
class Auth extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('users/Users_model');
  }

  public function index()
  {
    $this->load->view('auth/base/header');
    $this->load->view('login');
    $this->load->view('auth/base/footer');
  }

  public function login()
  {
    $config = array(
      array(
        'field' => 'username',
        'label' => 'Username',
        'rules' => 'trim|required|min_length[3]',
        'errors' => [
          'required' => 'Field %s tidak boleh kosong',
          'min_length' => '%s harus minimal 3 Character'
        ],
      ),
      array(
        'field' => 'password',
        'label' => 'Password',
        'rules' => 'trim|required',
        'errors' => [
          'required' => 'Field %s tidak boleh kosong'
        ]
      ),
    );
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    // select * from login where user = ?
    $user = $this->db->get_where('users', ['username' => $username])->row_array();

    if ($user) {
      if (password_verify($password, $user['password'])) {
        $role = $this->db->get_where('roles', ['id' => $user['role_id']])->row_array();

        // membuat session
        $this->session->set_userdata('id', $user['id']);
        $this->session->set_userdata('username', $user['username']);
        $this->session->set_userdata('role', $role['role_name']);
        $this->session->set_userdata('is_login', TRUE);

        // redirect ke admin
        redirect(base_url('home'));
      } else {

        // jika password salah
        $this->session->set_flashdata('failed', 'Password salah !');
        redirect(base_url('auth'));
      }
    } else {
      $this->session->set_flashdata('failed', 'Username tidak Tersedia !');
      redirect(base_url('auth'));
    }
  }

  public function register()
  {
    $this->load->helper(array('form', 'url'));
    $Users_model = $this->Users_model; //objek model
    $validation = $this->form_validation; //objek form validation
    $validation->set_rules($Users_model->rules()); //menerapkan rules validasi pada model
    //kondisi jika semua kolom telah divalidasi, maka akan menjalankan method add pada model
    if ($validation->run()) {
      $Users_model->add();
      $this->session->set_flashdata('success', 'You can Login');
      redirect(base_url('auth'));
    } else {
      $this->load->view('auth/base/header');
      $this->load->view('register');
      $this->load->view('auth/base/footer');
    }
  }

  public function logout()
  {
    $this->session->sess_destroy();
    redirect(base_url('auth'));
  }
}
