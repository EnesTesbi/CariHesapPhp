<?php
include_once './control.php';
$query = "SELECT kullanicilar.isim, kullanicilar.id FROM kullanicilar";
$kullanicilar = $baglan->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Hesap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#"><img width="50px" height="50px" src="./iste_arma.png"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link " href="./">Ana Sayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./odemeler.php">Ödemeler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./ekle.php">Harcama Ekle</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="./profile.php" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <?= $_SESSION['user'] ?? 'Profil' ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="navbarDropdown">

                            <li><a class="dropdown-item" href="./guncelle.php">Profili Güncelle</a></li>
                            <hr class="dropdown-divider h-100">
                    </li>
                    <li class="bg-danger"><a class="dropdown-item bg-danger h-100" href="control.php?cikis=1">Çıkış
                            Yap</a></li>
                </ul>
                </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container text-center pt-1">
        <div class="row mt-3">
            <form action="control.php" method="POST" novalidate class="row mt-1 needs-validation">

                <div class="col-4 bg-dark p-4 border-0 shadow-lg rounded mx-auto">
                    <div class="label text-light col-form-label-lg fw-bold mb-4 ">Harcamaya Dahil Olan Kullanıcılar
                    </div>
                    <div class="accordion" id="accordion">
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Kullanıcılar
                        </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordion">
                        <div class="accordion-body d-flex flex-column flex-wrap justify-content-start">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="all" value="all" type="checkbox" role="switch" id="switch-all">
                                    <label class="form-check-label" for="switch-all">Hepsi</label>
                                </div>
                            <?php
                            foreach ($kullanicilar as $kullanici) { ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="check_list[]" value="<?= $kullanici['id'] ?>" type="checkbox" role="switch" id="switch<?= $kullanici['id'] ?>">
                                    <label class="form-check-label" for="switch<?= $kullanici['id'] ?>"><?= $kullanici['isim'] ?></label>
                                </div>
                            <?php } ?>
                        </div>
                        </div>
                    </div>
                    <div class="mb-4 form-floating">
                        <input type="number" name="harcama" placeholder="123213" class="form-control" aria-describedby="emailHelp" id="harcama" required>
                        <div class="invalid-feedback">Eposta geçerli değil</div>
                        <label for="harcama">TL</label>
                    </div>
                    <div class="mb-4 text-light">
                        <label for="aciklama" class="form-label">Açıklama</label>
                        <textarea class="form-control" id="aciklama" rows="5" name="aciklama"></textarea>
                    </div>
                    <input type="date" class="form-control mb-4" name="date" id="datepicker">

                    <button type="submit" name="btnkayit" class="btn btn-success btn-lg mb-2">Harcama Ekle</button><br>
            </form>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

</body>

</html>