<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cari Hesap</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  <style>
  @import url('https://fonts.googleapis.com/css2?family=Acme&display=swap');

    h2{
      font-family: 'Acme';
    }
  </style>
</head>
<body>
<div class="container text-center pt-5">
  <div class="row mt-5">
    <div class="col">
      <h2>Cari Hesap Otamasyonu</h2>
    </div>
    <form action="control.php" method="GET" novalidate class="row mt-4 needs-validation">
          <div class="col-4 bg-light  p-4 border-0 shadow-lg rounded mx-auto">
            <svg  class="mb-4" xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
              <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
              <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
            </svg>
            <div class="mb-4 form-floating">
            <input type="email" name="email" placeholder="none@gmail.com" class="form-control" aria-describedby="emailHelp" id="email"  required>
            <div class="invalid-feedback">Eposta geçerli değil</div>
            <label for="email">Email</label>
          </div>  
          <div class="form-floating mb-4 ">
            <input name="password" type="password" minlength="8" maxlength="20" class="form-control" placeholder="password" id="password" required>
            <div class="invalid-feedback">Your password must be 8-20 characters long</div>
            <label for="password">Şifre</label>
          </div>
          <button type="submit" name="giris" class="btn btn-primary btn-lg mb-2">Giriş Yap</button><br>
          <a href="kayit.html" class="link-primary">Kayıt Olmak İçin Tıklayın</a>
        
        </form>

        <?php
        if (isset($_GET['hata'])) { ?>
         <div class="alert alert-danger alert-dismissible d-flex align-items-center fade show mt-3">
            <i class="bi-exclamation-octagon-fill me-4"></i>
              Kullanıcı adı veya Şifre hatalı
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php } ?>
      </div>
      
    
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script>
  (() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.eventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()
</script>
</body>
</html>