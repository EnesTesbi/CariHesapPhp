<?php
try {
  $baglan = new PDO("mysql:host=localhost;dbname=proje", "root", "");
} catch (PDOException $e) {
  die($e);
}
?>