<?php
session_start();
if(!isset($_SESSION['user'])){
  header('location: index.php?mess=Du har inte rätt att vara här!');
}
?>