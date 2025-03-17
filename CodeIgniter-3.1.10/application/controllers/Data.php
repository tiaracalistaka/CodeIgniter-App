<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Data_model');
    }

    public function index() {
        $data['tables'] = $this->Data_model->getAllTables();
        $data['selected_table'] = null;
        $data['columns'] = [];
        $data['records'] = [];
        $data['error_message'] = '';

        $this->load->view('data_view', $data);
    }

    public function fetch_table() {
        $table_name = $this->input->post('table_name');

        if ($table_name) {
            $data['tables'] = $this->Data_model->getAllTables();
            $data['selected_table'] = $table_name;
            $data['columns'] = $this->Data_model->getTableColumns($table_name);
            $data['records'] = $this->Data_model->getTableData($table_name);
            $data['error_message'] = '';
        } else {
            $data['tables'] = $this->Data_model->getAllTables();
            $data['selected_table'] = null;
            $data['columns'] = [];
            $data['records'] = [];
            $data['error_message'] = '';
        }

        $this->load->view('data_view', $data);
    }

    public function insert() {
        $table_name = $this->input->post('table_name');
        $columns = $this->Data_model->getTableColumns($table_name);
        $data = [];

        foreach ($columns as $column) {
            $data[$column] = $this->input->post($column);
        }

        $result = $this->Data_model->insertData($table_name, $data);

        if ($result !== true) {
            $data['error_message'] = implode("<br>", $result);
        } else {
            $data['error_message'] = "Data berhasil ditambahkan!";
        }

        $this->fetch_table();
    }
}
