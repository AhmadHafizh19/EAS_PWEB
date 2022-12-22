<?php
session_start();
//menyertakan file fpdf, file fpdf.php di dalam folder FPDF yang diekstrak
include "fpdf/fpdf.php";
include_once('includes/config.php');
$userid = $_SESSION['id'];
$query=mysqli_query($con,"select * from users where id='$userid'");
$result = mysqli_fetch_assoc($query);

// var_dump($result);
// die;

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('foto/639f39a3693e2.png',10, 10, -300);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(50,10,'KARTU PESERTA',1,0,'C');
    $this->Cell(50,10,'TES CPNS 2023',1,0,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
//membuat objek baru bernama pdf dari class FPDF
//dan melakukan setting kertas l : landscape, A5 : ukuran kertas
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$pdf->Ln(40);
$pdf->Cell(0,10,'NAMA:                                                      '.$result['fname'].' '.$result['lname'] ,0,1);
$pdf->Cell(0,10,'NIK:                                                          '.$result['nik'],0,1);
$pdf->Cell(0,10,'JENIS KELAMIN:                                     '.$result['jenis_kelamin'],0,1);
$pdf->Cell(0,10,'TANGAL LAHIR:                                      '.$result['tanggal_lahir'],0,1);
$pdf->Cell(0,10,'PILIHAN KEMENTERIAN:                       '.$result['pilihan'],0,1) ;
$pdf->Cell(0,10,'TANGGAL TES (YYYY/MM/DD):            '.$result['tanggal_tes'],0,1) ;
$pdf->Cell(0,10,'LOKASI TES:                                          '.$result['lokasi_tes'],0,1) ;
$pdf->Ln(40);


// for($i=1;$i<=40;$i++)
//     $pdf->Cell(0,10,'Printing line number '.$i,0,1);
$pdf->Output();


?>