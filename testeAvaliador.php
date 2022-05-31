<?php

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;

require 'vendor/autoload.php';

//método Arrange-Act-Assert/Given-When-Then;

//Arrange - Given
$leilao = new Leilao('Fiat 147 0km');

$maria = new Usuario('Maria');
$joao  = new Usuario('joao');

$leilao->recebeLance(new Lance($joao, 1500));
$leilao->recebeLance(new Lance($maria, 2000));

$leiloeiro = new Avaliador();

//Act - When
$leiloeiro->avalia($leilao);

$maiorValor = $leiloeiro->getMaiorValor();

//Assert - Then
$valorEsperado = 2000;

if ($valorEsperado == $maiorValor) {
    echo "Teste aprovado!\n";
} else {
    echo "Teste reprovado!\n";
}
