<?php
class Home extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    if (empty($this->session->userdata('is_login'))) {
      redirect(base_url('auth'));
    }
    $this->load->model('notes/Notes_model');
    $this->load->model('users/Users_model');
  }

  public function index()
  {
    if ($this->session->userdata('role') == 'Admin') { $notesTable = $this->Notes_model->getAll(); }
    else { $notesTable = $this->Notes_model->getAllFromUser($this->session->userdata('id')); }
    $usersTable = $this->Users_model->getAll();
    $data['user'] = $this->session->userdata();
    $data['page'] = "Home";
    $data['dashboard'] = array( 'notes' => count($notesTable), 'users' => count($usersTable));

    $this->template->write_view('navbar', 'templates/snippets/navbar', $data, TRUE);
    $this->template->write_view('sidebar', 'templates/snippets/sidebar', '', TRUE);
    $this->template->write_view('breadcrumb', 'templates/snippets/breadcrumb', '', TRUE);
    $this->template->write_view('content', 'home', '', TRUE);
    $this->template->write_view('footer', 'templates/snippets/footer', '', TRUE);
    $this->template->render();
  }
}
