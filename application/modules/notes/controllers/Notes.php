<?php
class Notes extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    if (empty($this->session->userdata('is_login'))) {
      redirect(base_url('auth'));
    }
    $this->load->model('Notes_model');
  }

  public function index()
  {
    $this->template->add_js('assets/plugins/datatables/jquery.dataTables.min.js');
    $this->template->add_js('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js');
    $this->template->add_js('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js');
    $this->template->add_js('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js');
    $this->template->add_js('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js');
    $this->template->add_js('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js');
    $this->template->add_js('assets/plugins/jszip/jszip.min.js');
    $this->template->add_js('assets/plugins/pdfmake/pdfmake.min.js');
    $this->template->add_js('assets/plugins/pdfmake/vfs_fonts.js');
    $this->template->add_js('assets/plugins/datatables-buttons/js/buttons.html5.min.js');
    $this->template->add_js('assets/plugins/datatables-buttons/js/buttons.print.min.js');
    $this->template->add_js('assets/plugins/datatables-buttons/js/buttons.colVis.min.js');
    $this->template->add_js('assets/js/notes/scripts.js');

    $this->template->add_css('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css');
    $this->template->add_css('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css');
    $this->template->add_css('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css');

    $userRole = $this->session->userdata('role');
    if ($userRole == 'Admin') $notesTable = $this->Notes_model->getAll();
    else $notesTable = $this->Notes_model->getAllFromUser($this->session->userdata('id'));
    $data = array('notesTable' => $notesTable);
    $data['page'] = "Notes";
    $data['user'] = $this->session->userdata();

    $this->template->write_view('navbar', 'templates/snippets/navbar', $data, TRUE);
    $this->template->write_view('sidebar', 'templates/snippets/sidebar', '', TRUE);
    $this->template->write_view('breadcrumb', 'templates/snippets/breadcrumb', '', TRUE);
    $this->template->write_view('content', 'index', '', TRUE);
    $this->template->write_view('footer', 'templates/snippets/footer', '', TRUE);
    $this->template->render();
  }

  public function getAll()
  {
    if ($this->session->userdata('role') == 'Admin') $notesTable = $this->Notes_model->getAll();
    else $notesTable = $this->Notes_model->getAllFromUser($this->session->userdata('id'));
    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode(array(
        'text' => 'Success',
        'data' => $notesTable
      )));
  }

  public function add()
  {
    $this->load->helper(array('form', 'url'));
    $Notes_model = $this->Notes_model; //objek model
    $validation = $this->form_validation; //objek form validation
    $validation->set_rules($Notes_model->rules()); //menerapkan rules validasi pada model
    //kondisi jika semua kolom telah divalidasi, maka akan menjalankan method add pada model
    if ($validation->run()) {
      $Notes_model->add();
      $newTable = $this->getAll();
      $newTable = json_decode($newTable->final_output);
      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode(array(
          'text' => 'Success',
          'data' => $newTable->data
        )));
    } else {
      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(array(
          'text' => 'failed',
          'data' => validation_errors()
        )));
    }
  }

  public function update($id)
  {
    $this->load->helper(array('form', 'url'));
    $Notes_model = $this->Notes_model; //objek model
    $validation = $this->form_validation; //objek form validation
    $validation->set_rules($Notes_model->rules()); //menerapkan rules validasi pada model
    //kondisi jika semua kolom telah divalidasi, maka akan menjalankan method add pada model
    if ($validation->run()) {
      $Notes_model->updateById($id);
      $newTable = $this->getAll();
      $newTable = json_decode($newTable->final_output);
      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode(array(
          'text' => 'Success',
          'data' => $newTable->data
        )));
    } else {
      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(array(
          'text' => 'failed',
          'data' => validation_errors()
        )));
    }
  }

  public function delete($id)
  {
    $this->Notes_model->deleteById($id);
    $newTable = $this->getAll();
    $newTable = json_decode($newTable->final_output);
    return $this->output
      ->set_content_type('application/json')
      ->set_status_header(200)
      ->set_output(json_encode(array(
        'text' => 'Success',
        'data' => $newTable->data
      )));
  }

  public function get($id)
  {
    $data = $this->Notes_model->getById($id);
    return $this->output
      ->set_content_type('application/json')
      ->set_status_header(200)
      ->set_output(json_encode(array(
        'text' => 'Success',
        'data' => $data
      )));
  }
  
}
