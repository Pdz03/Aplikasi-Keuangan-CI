<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    protected $table = 'users';

    public function get_by_username($username){
        return $this->db->get_where($this->table, ['username' => $username])->row();
    }

    public function create_admin(){
        $exists = $this->db->get_where($this->table, ['username' => 'admin'])->row();
        if ($exists) {
            return false; // sudah ada
        }

        $data = [
            'username' => 'admin',
            'password' => password_hash('TerangBulanKeju2025', PASSWORD_BCRYPT),
            'role'     => 'admin'
        ];

        return $this->db->insert($this->table, $data);
    }
}
