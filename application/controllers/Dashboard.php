<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if(!$this->session->userdata('user_id')){
            redirect('auth/login');
        }
        $this->load->model('Transaksi_model');
        $this->load->helper('url');
    }

    // Dashboard utama
    public function index(){
        $year  = date('Y');
        $month = date('m');

        // summary bulan ini
        $data['summary'] = $this->Transaksi_model->get_monthly_summary($year, $month);

        // siapkan data chart
        $records = $this->Transaksi_model->get_by_month($year, $month);

        $chartData = [];
        foreach ($records as $row) {
            $tgl = date('Y-m-d', strtotime($row->tanggal));

            if (!isset($chartData[$tgl])) {
                $chartData[$tgl] = ['tanggal' => $tgl, 'pemasukan' => 0, 'pengeluaran' => 0];
            }

            if (strtolower($row->jenis) === 'masuk') {
                $chartData[$tgl]['pemasukan'] += $row->nominal;
            } else {
                $chartData[$tgl]['pengeluaran'] += $row->nominal;
            }
        }

        // rapihkan ke array numerik
        $chartData = array_values($chartData);

        $data['chartData'] = $chartData;

        $this->load->view('dashboard/index', $data);
    }

    // Debug: cek isi semua transaksi
    public function debug_all(){
        $data['summary'] = $this->Transaksi_model->get_summary_all();
        $debug = $this->Transaksi_model->get_all();

        echo "<h3>Debug Data Summary:</h3>";
        echo "<pre>";
        print_r($data['summary']);
        echo "</pre>";

        echo "<h3>Debug Semua Transaksi:</h3>";
        echo "<pre>";
        print_r($debug);
        echo "</pre>";
        exit;
    }
}
