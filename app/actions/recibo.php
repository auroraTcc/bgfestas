<?php
require_once "../../vendor/autoload.php";

use Dompdf\Dompdf;
use Dompdf\Options;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

function gerarRecibo($dados) {

    $loader = new FilesystemLoader("../templates");
    $twig = new Environment($loader);

    $html = $twig->render("recibo.html.twig", $dados);

    $options = new Options();
    $options->set('defaultFont', 'Arial');
    $dompdf = new Dompdf($options);

    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    return $dompdf->output();
}