<?php
include_once './control.php';

$id = $_SESSION['id'];
$odemelerSorgu = "SELECT kullanicilar.id, kullanicilar.isim, kullanicilar.soyisim, harcamalar.harcama, harcamalar.aciklama, harcamalar.borclular, harcamalar.date FROM proje.harcamalar INNER JOIN proje.kullanicilar ON proje.harcamalar.kullanici_id != $id AND proje.harcamalar.kullanici_id = proje.kullanicilar.id";
$odeceneklerSorgu = "SELECT kullanicilar.id, kullanicilar.isim, kullanicilar.soyisim, harcamalar.borclular, SUM(harcamalar.harcama) as toplam FROM proje.harcamalar INNER JOIN proje.kullanicilar ON proje.harcamalar.kullanici_id != $id AND proje.harcamalar.kullanici_id = proje.kullanicilar.id GROUP BY kullanicilar.id, harcamalar.borclular";
$kullaniciSayisi = $baglan->query("SELECT COUNT(id) FROM proje.kullanicilar")->fetch(PDO::FETCH_ASSOC);
$kullaniciSayisi = array_values($kullaniciSayisi)[0];

$harcamalar = $baglan->query($odemelerSorgu)->fetchAll(PDO::FETCH_ASSOC);
$odenecekler = $baglan->query($odeceneklerSorgu)->fetchAll(PDO::FETCH_ASSOC);

// $result = array();
// foreach ($odenecekler as $element) {
//     $result[$element['id']][] = $element;
// }

// echo "<pre>";
// print_r($result);
// echo "</pre>";

$odenecekler = array_reduce($odenecekler, function ($carry, $item){
    if (!isset($carry[$item['id']])) {
        $carry[$item['id']] = [
            'isim' => $item['isim'],
            'soyisim' => $item['soyisim'],
            'toplam' => 0
        ];
    }
    if ($item['borclular'] == 'all') {
        $carry[$item['id']]['toplam'] += number_format((float)$item['toplam'] / $GLOBALS['kullaniciSayisi'], 2, '.', '');
    }
    else {
        $borclular = explode(',', $item['borclular']);
        if (in_array($_SESSION['id'], $borclular))
            $carry[$item['id']]['toplam'] += number_format((float)$item['toplam'] / count($borclular), 2, '.', '');
    }
    return $carry;
}, []);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Hesap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#"><img width="50px" height="50px" src="./iste_arma.png" ></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="./">Ana Sayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./odemeler.php">Ödemeler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./ekle.php">Harcama Ekle</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="btn btn-outline-primary" role="button" target = "_blank" href="./dompdf.php?doc=my">Dosyayı İndir</a>
                    </li>
                    <li class="nav-item dropdown-center">
                        <a class="nav-link dropdown-toggle text-warning" href="#" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">Borçlar</a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                            <?php
                            foreach ($odenecekler as $odeme) {
                                $harcamaAd = $odeme['isim'];
                                $harcamaSoyad = $odeme['soyisim'];
                                $toplam = $odeme['toplam'];
                            ?>
                                    <li>
                                        <div class="dropdown-item-text d-flex justify-content-between" style="">
                                            <p><?= $harcamaAd . ' ' . $harcamaSoyad . '&nbsp;&nbsp;&nbsp;'?></p>
                                            <span class="text-danger"><?= $toplam ?></span>
                                        </div>
                                    </li>
                            <?php } ?> 
                        </ul>
                    </li>
                    <li class="nav-item dropdown-center">
                        <a class="nav-link dropdown-toggle" href="./profile.php" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <?= $_SESSION['user'] ?? 'Profil' ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="./guncelle.php">Profili Güncelle</a></li>
                            <li>
                                <hr class="dropdown-divider h-100">
                            </li>
                            <li class="bg-danger"><a class="dropdown-item bg-danger h-100" href="control.php?cikis=1">Çıkış Yap</a></li>
                        </ul>                        
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <div>
            <h3>Yapılacak Ödemeler</h3>
        </div>
        <div class="row">
            <table class="table table-hover table-striped mt-3 table-secondary shadow-lg">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">İsim</th>
                        <th scope="col">Soyisim</th>
                        <th scope="col">Açıklama</th>
                        <th scope="col">İşlem Tarihi</th>
                        <th scope="col">Harcama</th>
                        <th scope="col">Yapılacak Ödeme</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($harcamalar as $harcama) {
                        if ($harcama['borclular'] == 'all' || in_array($_SESSION['id'], explode(',', $harcama['borclular']))) {

                            if ($harcama['borclular'] == 'all') {
                                $yapilacakOdeme = number_format((float)$harcama['harcama'] / $kullaniciSayisi, 2, '.', '');
                            }
                            else {
                                $borclular = explode(',', $harcama['borclular']);
                                if (in_array($_SESSION['id'], $borclular))
                                $yapilacakOdeme = number_format((float)$harcama['harcama'] / count($borclular), 2, '.', '');
                            }
                    ?>
                    <tr>
                        <th scope="row">
                            <?= ++$i ?>
                        </th>
                        <td>
                            <?= $harcama['isim'] ?>
                        </td>
                        <td>
                            <?= $harcama['soyisim'] ?>
                        </td>
                        <td>
                            <?= $harcama['aciklama'] ?>
                        </td>
                        <td>
                            <?= $harcama['date'] ?>
                        </td>
                        <td>
                            <?= $harcama['harcama'] ?>
                        </td>
                        <td class="text-danger ">
                            <?= $yapilacakOdeme ?>
                        </td>
                    </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

</body>

</html>