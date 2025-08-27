<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_model extends CI_Model {
    protected $table = 'transaksi';
    public function __construct(){
        parent::__construct();
    }

    public function insert($data){
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data){
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id){
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    public function get($id){
        return $this->db->get_where($this->table, ['id'=>$id])->row();
    }

    public function get_all(){
        return $this->db->order_by('tanggal', 'DESC')->get($this->table)->result();
    }

    public function get_by_month($year, $month){
        $this->db->where("YEAR(tanggal)", $year);
        $this->db->where("MONTH(tanggal)", $month);
        return $this->db->order_by('tanggal','ASC')->get($this->table)->result();
    }

    public function get_monthly_summary($year, $month){
        // Returns total pemasukan and pengeluaran for the month
        $pemasukan = (float)$this->db->select_sum('nominal')->where(['jenis'=>'masuk'])->where("YEAR(tanggal)", $year)->where("MONTH(tanggal)", $month)->get($this->table)->row()->nominal;
        $pengeluaran = (float)$this->db->select_sum('nominal')->where(['jenis'=>'keluar'])->where("YEAR(tanggal)", $year)->where("MONTH(tanggal)", $month)->get($this->table)->row()->nominal;
        return ['pemasukan'=>$pemasukan, 'pengeluaran'=>$pengeluaran];
    }

    // TODO: add pagination, filters, and optimized queries for big data
}