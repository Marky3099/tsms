<?php
//============================================================+
// File name   : example_003.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 003 for TCPDF class
//               Custom Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Custom Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once(APPPATH.'libraries\tcpdf\tcpdf.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    protected $last_page_flag = false;

    public function Close() {
        $this->last_page_flag = true;
        parent::Close();
    }


    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'imgicon.jpg';
        $this->Image($image_file, 60, 10, 30, 30, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Position at 15 mm from bottom
        $this->SetY(15);
         // $this->SetX(100);
        // Set font
        $this->SetFont('helvetica', 'B', 12);
        // Title
        $this->Cell(0, 0, 'Maylaflor Air-Conditioning and Refrigeration Services, Inc.', 0, false, 'C', 0, '', 0, false, 'T', 'B');
        //width //height //txt'' //border //ln //align'' //fill //link //stretch //ignore_min_height'' //calign //valign

        //subheader Address
        $this->SetY(25);
        $this->SetFont('helvetica', '', 11);
        $this->Cell(0, 0, ' A. Dominguez  St., Malibay,  Pasay City, 1300 2958', 0, false, 'C', 0, '', 0, false, 'T', 'B');
        // Address cont..
        $this->SetY(30);
        $this->SetFont('helvetica', '', 11);
        $this->Cell(0, 0, 'Telefax #:  8851-1005 / 8425-9958 /  8697-4066  / 8806-4790 ', 0, false, 'C', 0, '', 0, false, 'T', 'B');
        // Address cont..
        $this->SetY(35);
        $this->SetFont('helvetica', '', 11);
        $this->Cell(0, 0, 'Email Add:  maylaflorairconditioningref27@gmail.com', 0, false, 'C', 0, '', 0, false, 'T', 'B');

        //Title 
        $this->SetY(45);
        $this->SetFont('helvetica', 'B', 11);
        $html = 'Detailed Exception Report of '.$this->year.' ('.$this->quarter.' Quarter)';
        $this->Cell(0, 0,$html , 0, false, 'C', 0, '', 0, false, 'T', 'B'); 

        //Date Printed
         // $this->SetXY(17,62);
        $this->SetY(65);
        $this->SetFont('helvetica','', 10);
        // Setting Date ( I have set the date here )
        $tDate=date('F d, Y');
        $this->Cell(0, 0, 'Date Printed: '.$tDate, 0, false, 'L', 0, '', 0, false, 'T', 'M');               
        
    }

    // Page footer
    public function Footer() {
        if ($this->last_page_flag) {
        // ... footer for the last page ...
             $this->SetXY(20,170);
        $msg = 'This Exception Report contains a detailed report of pending services of the Maylaflor Airconditioning and Refrigeration Services, Inc. from different client branches in areas '.$this->uniq_area;
        $this->SetFont('helvetica','', 10);
        // $this->Cell(0, 10, $msg, 0, false, 'L', 0, '', 0, false, 'T', 'M');
        $this->MultiCell(250, 160, $msg, 0, 'C', 0, 1,'','', false, 0, true, true,0);

        $this->SetXY(22,185);
        $this->SetFont('helvetica','', 10);
        $this->Cell(0, 10, 'Prepared By: ', 0, false, 'L', 0, '', 0, false, 'T', 'M');

        $this->SetXY(60,188);
        $this->SetFont('helvetica','', 10); 
        $this->Cell(0, 10, 'Rosario A. Arcinue', 0, false, 'L', 0, '', 0, false, 'T', 'M');

        $this->SetXY(60,190);
        $this->SetFont('helvetica','B', 10); 
        $this->Cell(0, 10, '_______________', 0, false, 'L', 0, '', 0, false, 'T', 'M');

        $this->SetXY(60,195);
        $this->SetFont('helvetica','B', 10); 
        $this->Cell(0, 10, 'Sales Department', 0, false, 'L', 0, '', 0, false, 'T', 'M');
        }
        // Page
        $this->SetY(1);
        $this->SetX(280);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Maylaflor Air-Conditioning and Refrigeration Services, Inc.');
$pdf->SetTitle('Detailed Exception Report');
$pdf->SetSubject('Detailed Exception Report');


// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(15, 77, 10, 10);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 55);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------


// set font
// $pdf->SetFont('times', '', 11);
$pdf->uniq_area = implode(", ",$uniq_area);
$pdf->year = date("Y");
$pdf->branch = $cBranch;
$pdf->quarter = $quarter;
// add a page
$pdf->AddPage('L');

$pdf->SetXY(15, 70);
$pdf->SetFont('helvetica', '', 11);

if($task){
    $html = '<table cellspacing="0" cellpadding="10" border="1" id="table1">
    <thead>
    <tr style = "background-color: #A8D08D; text-align: center; font-size:11px;">
    <th>Date</th>
    <th>Branch Name</th>
    <th>Service Type</th>
    <th>Device Brand/<br>Type</th> 
    <th>Aircon Type</th> 
    <th>Qty</th> 
    <th>Assigned Technician</th>
    <th>Status</th>
    </tr>
    </thead>
    <tbody>';
    
        // dd($all_events);
    foreach($task as $dat){
     
     $html .='     <tr style="font-size:9px; text-align: center;">
     <td>'.date('m-d-Y',strtotime($dat->start_event)).'</td>
     <td>'.$dat->client_branch.'</td>
     <td>'.$dat->serv_type.'</td>
      <td>';
      $current ='';

      foreach($distinct as $data){
       if($dat->id ==  $data->id){
           if($current !=  $data->device_brand){
               $html .=  '*'.$data->device_brand. '<br><br>';
                $current =$data->device_brand; 
           }   
       }
      }
             $html .='</td>
              <td>';
              $current_aircon_type ='';

           foreach($distinct as $data){
            if($dat->id ==  $data->id){
                if($current_aircon_type !=  $data->aircon_type){
                    $html .=  '*'.$data->aircon_type. '<br><br>';
                     $current_aircon_type =$data->aircon_type; 
                }   
            }
           }
           $html .='</td><td>';
           
            $current ='';

            foreach($distinct as $data){
             if($dat->id ==  $data->id){
                 if($current !=  $data->device_brand){
                     $html .=  '*'.$data->quantity. '<br><br>';
                      $current =$data->device_brand; 
                 }   
             }
            }
                 $html .='</td><td>';

             $data = explode(',',$dat->emp_array);
             $count = 0;
             
             foreach($data as $emp){
               if($count < (count($data) - 1) ){ 
                 $html .='* '. $emp.'<br>';
             }
             $count+=1;
            }
            $html .='</td>';
            $html .='<td style="color:#4F6FA6;">'.$dat->status.'</td>
            </tr>';

            }


            $html .='</tbody>
            </table>';

}else{
    $html ='<h1 style="text-align:center;">No Data Available!</h1>';
}

$pdf->writeHTML($html, true, 0, true, true);
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Exception_Report_'.$quarter.'_Quarter_of_'.date("Y").'.pdf', 'I');
exit();
//============================================================+
// END OF FILE
//============================================================+