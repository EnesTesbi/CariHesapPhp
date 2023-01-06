<?php
include_once './control.php';

$id = $_SESSION['id'];
$query = "SELECT * FROM kullanicilar where id='$id'";
$kullanici = $baglan->query($query)->fetch(PDO::FETCH_ASSOC);

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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Acme&display=swap');

        h2 {
            font-family: 'Acme';
        }
    </style>
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

                            <li><a class="dropdown-item" href="./güncelle.php">Profili Güncelle</a></li>
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
    <div class="container text-center">
        <div class="row mt-1">
            <div class="col">
                <h2>Kayıt Güncelleme</h2>
            </div>
            <form id="kayitForm" method="POST" action="control.php" novalidate class="row mt-1 needs-validation">
                <div class="col-4 bg-dark  p-4 border-0 shadow-lg rounded mx-auto">

                    <svg class="mb-4" xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="white"
                        class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                        <path fill-rule="evenodd"
                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                    </svg>

        
                    <div class="mb-4 form-floating">
                        <input name="ad" type="text" value="<?= $kullanici['isim'] ?>" placeholder="deneme"
                            class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                        <div class="invalid-feedback">Boş geçilemez</div>
                        <label for="exampleInputEmail1">Ad</label>
                    </div>
                    <div class="mb-4 form-floating">
                        <input name="soyad" value="<?= $kullanici['soyisim'] ?>" type="text" placeholder="deneme" class="form-control"
                            id="exampleInputEmail1" aria-describedby="emailHelp" required>
                        <div class="invalid-feedback">Boş geçilemez</div>
                        <label for="exampleInputEmail1">Soyad</label>
                    </div>

                    <div class="mb-4 form-floating">
                        <input name="mail" value="<?= $kullanici['eposta'] ?>" type="email" placeholder="none@gmail.com" class="form-control"
                            id="exampleInputEmail1" aria-describedby="emailHelp" required>
                        <div class="invalid-feedback">Eposta geçerli değil</div>
                        <label for="exampleInputEmail1">Email</label>
                    </div>
                    <div class="form-floating mb-4 ">
                        <input name="password" type="password" minlength="8" maxlength="20" class="form-control"
                            placeholder="password" id="exampleInputPassword1">
                        <div class="invalid-feedback">Your password must be 8-20 characters long</div>
                        <label for="exampleInputPassword1">Şifre</label>
                    </div>
                    <div class="mb-4 form-floating">
                        <input name="tel" type="text"  value="<?= $kullanici['tel'] ?>" placeholder="5372518734" class="form-control" id="tel"
                            aria-describedby="emailHelp" required>
                        <div class="invalid-feedback">Boş geçilemez</div>
                        <label for="exampleInputEmail1">Telefon</label>
                    </div>
                    <button name="GuncelleBtn" type="submit" class="btn btn-success btn-lg mb-2">Güncelle</button><br>

            </form>
        </div>


    </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/imask"></script>
    <script>
        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()

        const maskoption = { mask: '+{9\\0} (000) 000 0000' };
        const mask = IMask(tel, maskoption);

        kayitForm.addEventListener('submit', e => {
            tel.value = mask.unmaskedValue;
        })
    </script>
</body>

</html>