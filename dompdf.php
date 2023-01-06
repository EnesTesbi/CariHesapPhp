<?php
include_once('./control.php');
require_once('./FPDF/fpdf.php');



class pdF extends FPDF
{

    function Header()
    {

        $this->SetFont('courier', 'B', 14);
        ;
        $this->Cell(280, 20, 'Toplam Yapilacak Odemeler', 0, 1, 'C');
    }

    function HeaderTable()
    {
        $this->SetFont('courier', 'B', 14);
        ;
        $this->Cell(5, 6, '#', 1, 0, 'C');
        $this->Cell(30, 6, 'Ad', 1, 0, 'C');
        $this->Cell(30, 6, 'Soyad', 1, 0, 'C');
        $this->Cell(105, 6, 'Aciklama', 1, 0, 'C');
        $this->Cell(40, 6, 'islem Tarihi', 1, 0, 'C');
        $this->Cell(30, 6, 'Harcamalar', 1, 0, 'C');
        $this->Cell(40, 6, 'Odemeler    ', 1, 1, 'C');

    }
    function MainTable()
    {
        try {
            $baglan = new PDO("mysql:host=localhost;dbname=proje", "root", "");
        } catch (PDOException $e) {
            die($e);
        }
        $id = $_SESSION['id'];
        $sorgu = "SELECT kullanicilar.isim, kullanicilar.soyisim, harcamalar.harcama, harcamalar.aciklama, harcamalar.date FROM proje.harcamalar, proje.kullanicilar WHERE  proje.harcamalar.kullanici_id = proje.kullanicilar.id";
        $odemelerSorgu = "SELECT kullanicilar.id, kullanicilar.isim, kullanicilar.soyisim, harcamalar.harcama, harcamalar.aciklama, harcamalar.borclular, harcamalar.date FROM proje.harcamalar INNER JOIN proje.kullanicilar ON proje.harcamalar.kullanici_id != $id AND proje.harcamalar.kullanici_id = proje.kullanicilar.id";
        $odeceneklerSorgu = "SELECT kullanicilar.id, kullanicilar.isim, kullanicilar.soyisim, harcamalar.borclular, SUM(harcamalar.harcama) as toplam FROM proje.harcamalar INNER JOIN proje.kullanicilar ON proje.harcamalar.kullanici_id != $id AND proje.harcamalar.kullanici_id = proje.kullanicilar.id GROUP BY kullanicilar.id, harcamalar.borclular";
        $kullaniciSayisi = $baglan->query("SELECT COUNT(id) FROM proje.kullanicilar")->fetch(PDO::FETCH_ASSOC);
        $kullaniciSayisi = array_values($kullaniciSayisi)[0];

        $harcamalar = $baglan->query($odemelerSorgu)->fetchAll(PDO::FETCH_ASSOC);
        $odenecekler = $baglan->query($odeceneklerSorgu)->fetchAll(PDO::FETCH_ASSOC);

        $i = 0;
        $sayac = 0;
        foreach ($harcamalar as $harcama) {
            $i++;
            if ($harcama['borclular'] == 'all' || in_array($_SESSION['id'], explode(',', $harcama['borclular']))) {
                
                if ($harcama['borclular'] == 'all') {
                    $yapilacakOdeme = number_format((float) $harcama['harcama'] / $kullaniciSayisi, 2, '.', '');
                    $sayac += $yapilacakOdeme;
                } 
                else {
                    $borclular = explode(',', $harcama['borclular']);
                    if (in_array($_SESSION['id'], $borclular))
                    $yapilacakOdeme = number_format((float) $harcama['harcama'] / count($borclular), 2, '.', '');
                    $sayac += $yapilacakOdeme;
                }
                $this->SetFont('courier', 'B', 14);
                $this->Cell(5, 10, $i, 1, 0, 'L');
                $this->Cell(30, 10, $harcama['isim'], 1, 0, 'L');
                $this->Cell(30, 10, $harcama['soyisim'], 1, 0, 'L');
                $this->Cell(105, 10, $harcama['aciklama'], 1, 0, 'L');
                $this->Cell(40, 10, $harcama['date'], 1, 0, 'L');
                $this->Cell(30, 10, $harcama['harcama'], 1, 0, 'L');
                $this->Cell(40, 10, $yapilacakOdeme, 1, 1, 'L');            
            }
            
        }
        $this->Cell(499, 10, $sayac.' TL', 0, 0, 'C');            
        
    }
}

$pdf = new pdF();
$pdf->AddPage('P', 'A3');
$pdf->HeaderTable();
$pdf->MainTable();
$pdf->Output();

?>
