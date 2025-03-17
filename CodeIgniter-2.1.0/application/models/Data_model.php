<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database(); 
    }

    public function getAllTables() {
        $query = $this->db->query("SHOW TABLES");
        return array_column($query->result_array(), key($query->row_array()));
    }

    public function getTableColumns($table_name) {
        $query = $this->db->query("SHOW COLUMNS FROM $table_name");
        return array_column($query->result_array(), 'Field');
    }

    public function getTableData($table_name) {
        return $this->db->get($table_name)->result_array();
    }
}
