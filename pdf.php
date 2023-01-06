<?php
include_once('./control.php');
require_once('./FPDF/fpdf.php');



class pdF extends FPDF
{
 
    function Header()
    {
         
        $this->SetFont('courier','B',14);; 
        $this->Cell(280, 20, 'Toplam Yapilan Harcamlar', 0, 1, 'C');
    }

    function HeaderTable()
    { 
        $this->SetFont('courier','B',14);; 
        $this->Cell(5, 6, '#', 1, 0, 'C');
        $this->Cell(30, 6, 'Ad', 1, 0, 'C');
        $this->Cell(40, 6, 'Soyad', 1, 0, 'C');
        $this->Cell(120, 6, 'Aciklama', 1, 0, 'C');
        $this->Cell(50, 6, 'islem Tarihi', 1, 0, 'C');
        $this->Cell(40, 6, 'Harcamalar', 1, 1, 'C');
        
    }
    function MainTable()
    {      try {
        $baglan = new PDO("mysql:host=localhost;dbname=proje", "root", "");
      } catch (PDOException $e) {
        die($e);
      }

      $sorgu = "SELECT kullanicilar.isim, kullanicilar.soyisim, harcamalar.harcama, harcamalar.aciklama, harcamalar.date FROM proje.harcamalar, proje.kullanicilar WHERE  proje.harcamalar.kullanici_id = proje.kullanicilar.id";
      $harcamalar = $baglan->query($sorgu)->fetchAll(PDO::FETCH_ASSOC);
 
        $i = 0;
        $sayac = 0;
        foreach ($harcamalar as $harcama) {
            $sayac += $harcama['harcama'];
            $i++;
             
            $this->SetFont('courier','B',14);
            $this->Cell(5, 10, $i, 1, 0, 'C');
            $this->Cell(30, 10,$harcama['isim'], 1, 0, 'C');
            $this->Cell(40, 10, $harcama['soyisim'], 1, 0, 'C');
            $this->Cell(120, 10,$harcama['aciklama'], 1, 0, 'L');
            $this->Cell(50, 10,$harcama['date'], 1, 0, 'C');
            $this->Cell(40, 10, $harcama['harcama'], 1, 1, 'C');
        }
         
        $this->SetFont('courier','B',14);
        $this->Cell(45, 10, 'Toplam Harcama', 0, 0, 'C');
        $this->Cell(443, 10, $sayac . ' TL', 0, 1, 'C');
    }

}
$pdf = new pdF();
$pdf->AddPage('P', 'A3');
$pdf->HeaderTable();
$pdf->MainTable();
$pdf->Output();

?>