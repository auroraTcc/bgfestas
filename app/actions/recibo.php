<?php
require_once "$rootPath/vendor/autoload.php";

use Dompdf\Dompdf;
use Dompdf\Options;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

function gerarRecibo($dados, $rootPath) {
    $loader = new FilesystemLoader("$rootPath/app/templates");
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