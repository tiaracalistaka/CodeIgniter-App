<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Data_model'); // Load model dengan benar
    }

    public function index() {
        $data['tables'] = $this->Data_model->getAllTables();
        $data['selected_table'] = null;
        $data['columns'] = [];
        $data['records'] = [];

        $this->load->view('data_view', $data);
    }

    public function fetch_table() {
        $table_name = $this->input->post('table_name');

        if ($table_name) {
            $data['tables'] = $this->Data_model->getAllTables();
            $data['selected_table'] = $table_name;
            $data['columns'] = $this->Data_model->getTableColumns($table_name);
            $data['records'] = $this->Data_model->getTableData($table_name);
        } else {
            $data['tables'] = $this->Data_model->getAllTables();
            $data['selected_table'] = null;
            $data['columns'] = [];
            $data['records'] = [];
        }

        $this->load->view('data_view', $data);
    }
}
