<?php
session_start();

if (isset($_SESSION['funcionario'])) {
    $isLogged = true;
} else {
    $isLogged = false;
}