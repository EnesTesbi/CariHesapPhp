<?php
include_once('./control.php');
$sorgu = "SELECT kullanicilar.id, kullanicilar.isim, kullanicilar.soyisim, harcamalar.harcama, harcamalar.aciklama, harcamalar.date FROM proje.harcamalar, proje.kullanicilar  WHERE  proje.harcamalar.kullanici_id = proje.kullanicilar.id ORDER BY proje.harcamalar.date ASC";
$harcamalar = $baglan->query($sorgu)->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>anasayfa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#"><img width="50px" height="50px" src="./iste_arma.png" ></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./">Ana Sayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./odemeler.php">Ödemeler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./ekle.php">Harcama Ekle</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="btn btn-outline-primary" target = "_blank" role="button" href="./pdf.php?doc=all">Dosyayı İndir</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="./profile.php" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <?= $_SESSION['user'] ?? 'Profil' ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="navbarDropdown">
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
        <div class="row mt-2">
            <div class="col">
                <h2>Tüm Harcamalar</h2>
                <div class="row">
                    <table class="table table-hover table-striped mt-3 table-secondary shadow-lg" index="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">İsim</th>
                                <th scope="col">Soyisim</th>
                                <th scope="col">Açıklama</th>
                                <th scope="col">İşlem Tarihi</th>
                                <th scope="col">Harcama</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($harcamalar as $harcama) {
                                $id = $harcama['id'];
                                $renk = "table-success";
                            ?>
                            <tr class="<?=$id==$_SESSION['id'] ? $renk : ''?>">
                                <th scope="row">
                                    <?= $i++ ?>
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
                            </tr>
                            <?php }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
        crossorigin="anonymous"></script>
</body>

</html>