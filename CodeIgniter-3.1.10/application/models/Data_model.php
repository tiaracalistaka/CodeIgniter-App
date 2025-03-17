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

    public function checkForeignKeys($table_name, $data) {
        // Ambil struktur tabel untuk mencari foreign key
        $query = $this->db->query("
            SELECT COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME 
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
            WHERE TABLE_NAME = '$table_name' 
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        $foreign_keys = $query->result_array();
        $errors = [];

        foreach ($foreign_keys as $fk) {
            $column = $fk['COLUMN_NAME'];
            $ref_table = $fk['REFERENCED_TABLE_NAME'];
            $ref_column = $fk['REFERENCED_COLUMN_NAME'];

            if (isset($data[$column])) {
                $value = $data[$column];

                // Cek apakah nilai sudah ada di tabel referensi
                $exists = $this->db->where($ref_column, $value)->count_all_results($ref_table);
                
                if ($exists == 0) {
                    $errors[] = "Data '$value' untuk kolom '$column' tidak ditemukan di tabel '$ref_table'. Harap tambahkan terlebih dahulu.";
                }
            }
        }

        return $errors;
    }

    public function insertData($table_name, $data) {
        $errors = $this->checkForeignKeys($table_name, $data);
        if (!empty($errors)) {
            return $errors;
        }

        $this->db->insert($table_name, $data);
        return true;
    }
}
