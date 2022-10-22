<?php

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;

require 'vendor/autoload.php';

// Arrange - Given 
$leilao = new Leilao('Boi Bandido');

$vini = new Usuario('Vinicius');
$bru = new Usuario("Bruna");

$leilao->recebeLance(new Lance($vini, 1000));
$leilao->recebeLance(new Lance($bru, 1200));

$leiloeiro = new Avaliador();

// Act - When
$leiloeiro->avalia($leilao);
$maiorValor = $leiloeiro->getMaiorValor();

//Assert - Then
$maiorValorEsperado = 1200;
if ($maiorValor == $maiorValorEsperado) {
    echo 'TESTE OK';
} else {
    echo 'TESTE FALHOU';
}
