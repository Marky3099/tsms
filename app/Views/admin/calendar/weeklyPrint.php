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

    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'imgicon.jpg';
        $this->Image($image_file, 60, 10, 30, 30, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Position at 15 mm from bottom
        $this->SetY(15);
         $this->SetX(100);
        // Set font
        $this->SetFont('helvetica', 'B', 12);
        // Title
        $this->Cell(0, 0, 'Maylaflor Air-Conditioning and Refrigeration Services, Inc.', 0, false, 'L', 0, '', 0, false, 'T', 'B');
    }

    // Page footer
    public function Footer() {
        $this->SetXY(220,190);
        $this->SetFont('helvetica','', 10);
        $userp= $_SESSION['username'];
        $this->Cell(0, 10, 'Prepared By: '.$userp, 0, false, 'L', 0, '', 0, false, 'T', 'M');
    	//date
    	 $this->SetXY(17,62);
        $this->SetFont('helvetica','', 10);
        // Setting Date ( I have set the date here )
        $tDate=date('F d, Y');
        $this->Cell(0, 10, 'Date Printed: '.$tDate, 0, false, 'L', 0, '', 0, false, 'T', 'M');
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
$pdf->SetTitle('Weekly Scheduled Tasks');
$pdf->SetSubject('Weekly Scheduled Tasks');


// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------


// set font
$pdf->SetFont('times', '', 11);

// add a page
$pdf->AddPage('L');

// set some text to print
$txt = <<<EOD
A. Dominguez  St., Malibay,  Pasay City, 1300 2958 
                              Telefax #:  8851-1005 / 8425-9958 /  8697-4066  / 8806-4790 
                              Email Add:  maylaflorairconditioningref27@gmail.com
EOD;
$pdf->SetXY(40, 23);
// print a block of text using Write()
$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

$monday = strtotime('last monday', strtotime('tomorrow'));

$sunday = strtotime('+6 days', $monday);


$html = '<span style="text-align: center;"><b>Weekly Scheduled Tasks - '.date('F j', $monday) .  ' to '  . date('j Y', $sunday).'</b><br></span><br><br><br><br>';
$pdf->SetXY(25, 45);
$pdf->SetFont('helvetica', '', 11);
if($week){
$html .= '<table cellspacing="0" cellpadding="15" border="1" id="table1">
				       <thead>
				          <tr style = "background-color: #A8D08D; text-align: center; font-size:11px;">
				             <th>Date</th>
                             <th>Time</th>
                             <th>Branch Area</th>
                             <th>Branch Name</th>
                             <th>Service/Task</th> 
                             <th>Service Type</th> 
                             <th>Device Brand/Type</th> 
                             <th>Aircon Type</th> 
                             <th>FCU No.</th>
                             <th>Qty</th> 
                             <th>Assigned Person</th>
                             <th>Status</th>
				          </tr>
				       </thead>
				       <tbody>';
     
        // dd($all_events);
     foreach($week as $w){
				   
				   $html .='     <tr style="font-size:9px; text-align: center;">
				             <td>'.date('m-d-Y',strtotime($w->start_event)).'</td>
                             <td>';
                             if($w->time == "00:00:00"){$html .='N/A'; } 
                             else{$html .=$w->time;} $html .='</td>
                             <td>'.$w->area.'</td>
                             <td>'.$w->client_branch.'</td>
                             <td>'.$w->serv_name.'</td>
                             <td>'.$w->serv_type.'</td>
                             <td>'.$w->device_brand.'</td>
                             <td>'.$w->aircon_type.'</td><td>';
                    $data1 = explode(',',$w->fcu_array);
                    $count1 = 0;
                
                    foreach($data1 as $fc){
                     if($count1 < (count($data1) - 1) ){ 
                       $html .=' '. $fc.'<br>';
                        }
                         $count1+=1;
                    }
                    $html .='</td>
                             <td>'.$w->quantity.'</td><td>';

                    $data = explode(',',$w->emp_array);
                    $count = 0;
                
                    foreach($data as $emp){
                     if($count < (count($data) - 1) ){ 
                       $html .=' '. $emp.'<br>';
                        }
                         $count+=1;
                    }
                    $html .='</td>';
				     $html .='<td style="color:#4F6FA6;">'.$w->status.'</td>
				          </tr>';
				         
				        }

				        
$html .='</tbody>
		</table>';
    }else{
        $html .='<h1 style="text-align:center;">No Data Available!</h1>';
    }

$pdf->writeHTML($html, true, 0, true, true);
// ---------------------------------------------------------

//Close and output PDF document

$pdf->Output('Weekly_Tasks_Report_'.date('F j', $monday) .  ' to '  . date('j Y', $sunday).'.pdf', 'D');

//============================================================+
// END OF FILE
//============================================================+