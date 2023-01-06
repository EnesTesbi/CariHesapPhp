<?php
include_once './baglan.php';

session_start();

if (!isset($_SESSION['user']) || (isset($_SESSION['user']) && isset($_GET['cikis']))) {
    session_destroy();
    header("Location:./login.php");
}

if (isset($_POST["kayit-btn"])) {
    $ad = $_POST['ad'] ?? null;
    $soyad = $_POST['soyad'] ?? null;
    $mail = $_POST['mail'] ?? null;
    $pass = md5($_POST['password']) ?? null;
    $tel = $_POST['tel'] ?? null;

    $sorgu = $baglan->prepare("INSERT INTO proje.kullanicilar (isim, soyisim, eposta, parola, tel) VALUES (?, ?, ?, ?, ?)");

    try {
        $sorgu->execute([$ad, $soyad, $mail, $pass, $tel]);
        echo "eklendi";
    } catch (PDOException $e) {
        echo "hata oluştu";
        print_r($e);
    }
}

if (isset($_GET['giris'])) {
    $mail = $_GET['email'];
    $pass = md5($_GET['password']);

    $sonuc = $baglan->query("SELECT * FROM proje.kullanicilar WHERE eposta = '$mail' AND parola = '$pass' ")->fetch(PDO::FETCH_ASSOC);

    if ($sonuc) {
        session_start();
        $_SESSION['id'] = $sonuc['id'];
        $_SESSION['user'] = $sonuc['isim'];
        header("Location:./index.php");
    } else {
        header("Location:./control.php?hata=1");
    }
}

if (isset($_POST["btnkayit"])) {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    $id = $_SESSION['id'];
    $borclular = $_POST['all'] ?? implode(',', $_POST['check_list']);
    $harcama = $_POST['harcama'];
    $aciklama = $_POST['aciklama'];
    $date = $_POST['date'];

    $sorgu = $baglan->prepare("INSERT INTO proje.harcamalar (kullanici_id, borclular, harcama, aciklama, date) VALUES (?, ?, ?, ?, ?)");

    try {
        $sorgu->execute([$id, $borclular, $harcama, $aciklama, $date]);
        header('Location:./index.php');
    } catch(PDOException $e) {
        echo 'hata';
        print_r($e);
    }
}

if (isset($_POST["GuncelleBtn"])) {
    $id = $_SESSION['id'];
    $ad = $_POST['ad'] ?? null;
    $soyad = $_POST['soyad'] ?? null;
    $mail = $_POST['mail'] ?? null;
    $pass = md5($_POST['password']) ?? null;
    $tel = $_POST['tel'] ?? null;

    if ($_POST['password'] == null) {
        $sorgu = $baglan->prepare("UPDATE kullanicilar SET isim=?,soyisim=?,eposta=?,tel=? WHERE id='$id'");
        try {
            $sorgu->execute([$ad, $soyad, $mail, $tel]);
            header("Location:./index.php");
        } catch (PDOException $e) {
            echo "hata oluştu";
            print_r($e);
        }
    } else {
        $sorgu = $baglan->prepare("UPDATE kullanicilar SET isim=?,soyisim=?,eposta=?,parola=?,tel=? WHERE id='$id'");
        try {
            $sorgu->execute([$ad, $soyad, $mail, $tel]);
            header("Location:./index.php");
        } catch (PDOException $e) {
            echo "hata oluştu";
            print_r($e);
        }
    }
}

?>