<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    protected $table = 'users';
    public function __construct(){
        parent::__construct();
    }

    public function get_by_username($username){
        return $this->db->get_where($this->table, ['username'=>$username])->row();
    }

    // TODO: tambah method create user / seed admin
}
