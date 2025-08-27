<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Mpdf\Mpdf;

class Laporan extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Transaksi_model');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        if(!$this->session->userdata('user_id')){
            redirect('auth/login');
        }
    }

    public function index(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('year', 'Tahun', 'required|numeric');
        $this->form_validation->set_rules('month', 'Bulan', 'required|numeric');

        $year  = $this->input->post('year') ?? date('Y');
        $month = $this->input->post('month') ?? date('m');

        if ($this->form_validation->run() == FALSE) {
            $data['errors'] = validation_errors('<div class="alert alert-danger">','</div>');
        } else {
            $data['errors'] = '';
        }

        $data['year']   = $year;
        $data['month']  = $month;
        $data['rekap']  = $this->Transaksi_model->get_by_month($year, $month);
        $data['summary'] = $this->Transaksi_model->get_monthly_summary($year, $month);

        $this->load->view('laporan/index', $data);
    }

    public function export_pdf(){
        $year  = $this->input->get('year') ?? date('Y');
        $month = $this->input->get('month') ?? date('m');

        $rekap   = $this->Transaksi_model->get_by_month($year, $month);
        $summary = $this->Transaksi_model->get_monthly_summary($year, $month);

        $html = $this->load->view('laporan/pdf', [
            'rekap'   => $rekap,
            'summary' => $summary,
            'year'    => $year,
            'month'   => $month
        ], TRUE);

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output("Laporan_{$year}_{$month}.pdf", "D");
    }

    public function export_excel(){
        $year  = $this->input->get('year') ?? date('Y');
        $month = $this->input->get('month') ?? date('m');

        $rekap   = $this->Transaksi_model->get_by_month($year, $month);
        $summary = $this->Transaksi_model->get_monthly_summary($year, $month);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Judul
        $sheet->setCellValue('A1', "Laporan Bulanan $month-$year");
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        // Header tabel
        $sheet->setCellValue('A3', 'Tanggal');
        $sheet->setCellValue('B3', 'Jenis');
        $sheet->setCellValue('C3', 'Nominal');
        $sheet->setCellValue('D3', 'Keterangan');
        $sheet->getStyle('A3:D3')->getFont()->setBold(true);

        // Data
        $row = 4;
        foreach ($rekap as $r) {
            $sheet->setCellValue("A$row", $r->tanggal);
            $sheet->setCellValue("B$row", ucfirst($r->jenis));
            $sheet->setCellValue("C$row", $r->nominal);
            $sheet->setCellValue("D$row", $r->keterangan);
            $row++;
        }

        // Ringkasan
        $row += 1;
        $sheet->setCellValue("B$row", "Total Pemasukan");
        $sheet->setCellValue("C$row", $summary['pemasukan']);
        $row++;
        $sheet->setCellValue("B$row", "Total Pengeluaran");
        $sheet->setCellValue("C$row", $summary['pengeluaran']);

        // Download file
        $writer = new Xlsx($spreadsheet);
        $filename = "Laporan_{$year}_{$month}.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
