<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Books extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Books_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'books/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'books/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'books/index.html';
            $config['first_url'] = base_url() . 'books/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Books_model->total_rows($q);
        $books = $this->Books_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'books_data' => $books,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('books/books_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Books_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'name' => $row->name,
		'author' => $row->author,
		'isbn' => $row->isbn,
	    );
            $this->load->view('books/books_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('books'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('books/create_action'),
	    'id' => set_value('id'),
	    'name' => set_value('name'),
	    'author' => set_value('author'),
	    'isbn' => set_value('isbn'),
	);
        $this->load->view('books/books_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'name' => $this->input->post('name',TRUE),
		'author' => $this->input->post('author',TRUE),
		'isbn' => $this->input->post('isbn',TRUE),
	    );

            $this->Books_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('books'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Books_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('books/update_action'),
		'id' => set_value('id', $row->id),
		'name' => set_value('name', $row->name),
		'author' => set_value('author', $row->author),
		'isbn' => set_value('isbn', $row->isbn),
	    );
            $this->load->view('books/books_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('books'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'name' => $this->input->post('name',TRUE),
		'author' => $this->input->post('author',TRUE),
		'isbn' => $this->input->post('isbn',TRUE),
	    );

            $this->Books_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('books'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Books_model->get_by_id($id);

        if ($row) {
            $this->Books_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('books'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('books'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('name', 'name', 'trim|required');
	$this->form_validation->set_rules('author', 'author', 'trim|required');
	$this->form_validation->set_rules('isbn', 'isbn', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }


}