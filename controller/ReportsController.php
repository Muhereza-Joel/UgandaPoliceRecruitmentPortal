<?php
namespace controller;

use core\Request;
use model\Model;
use TCPDF;
use view\BladeView;

class ReportsController{

    private $blade_view;
    private $model;
    private $app_name_full;
    private $app_name;

    public function __construct()
    {
        $this->blade_view = new BladeView();
        $this->model = new Model();
        $this->app_name_full = getenv("APP_NAME_FULL");
        $this->app_name = getenv("APP_NAME");
    }

    public function export_shortlist_report()
    {
        $request = Request::capture();
        $district = $request->input('district');
        
        $result = $this->model->export_shortlist($district);

        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        // Set document information
        $pdf->SetCreator($this->app_name_full);
        $pdf->SetAuthor($this->app_name_full);
        $pdf->SetTitle('Shortlist Report');
        $pdf->SetSubject($this->app_name_full);
        $pdf->SetKeywords('TCPDF, PDF, Uganda Police, Police, Recruitment, Uganda, Uganda Police Recruitment System');
        $pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->setHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->setFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFont('helvetica', '', 14);


        $pdf->AddPage();
        date_default_timezone_set('Africa/Nairobi');

        // Set some content
        $html = $this->blade_view->render('shortListReportLayout', [
            'appNameFull' => $this->app_name_full,
            'appName' => $this->app_name,
            'currentDate' => date('Y-m-d h:i:s'),
            'currentTime' => date('h:i:s'),
            'shortlist' => $result['response'],
        ]);


        // Output the HTML content
        $pdf->writeHTML($html);

        // Close and output PDF
        $pdfContent =  $pdf->Output('Shortlist.pdf', 'S');

       

        Request::send_pdf_response(200, $pdfContent);
        exit;
    }
}
?>