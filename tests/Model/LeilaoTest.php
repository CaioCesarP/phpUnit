<?php

namespace Alura\Leilao\Tests\Model;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Model\Leilao;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{
    public function testLeilaoNaoDeveReceberLancesRepetidos()
    {
        $leilao = new Leilao("Variante");

        $ana = new Usuario("Ana");

        $leilao->recebeLance(new Lance($ana, 1000));
        $leilao->recebeLance(new Lance($ana, 2000));

        $lance = $leilao->getLances();

        static::assertCount(1, $lance);
        static::assertEquals(1000, $lance[0]->getValor());
    }

    /**
     * @dataProvider geraLances
     */
    public function testLeilaoDeveReceberLances(
        int $qtdLances,
        $leilao,
        array $valores
    ) {
        static::assertCount($qtdLances, $leilao->getLances());

        foreach ($valores as $i => $valorEsperado) {
            static::assertEquals($valorEsperado, $leilao->getLances()[$i]->getValor());
        }
    }

    public function geraLances()
    {
        $joao = new Usuario("João");
        $maria = new Usuario(("Mária"));


        $leilaoComDoisLances = new Leilao("Fiat 147 0KM");
        $leilaoComDoisLances->recebeLance(new Lance($joao, 1000));
        $leilaoComDoisLances->recebeLance(new Lance($maria, 2000));

        $leilaoComUmLance = new Leilao("Fusca 1972 0KM");
        $leilaoComUmLance->recebeLance(new Lance($joao, 5000));

        return [
            "Leilão-com-dois-lances" => [2, $leilaoComDoisLances, [1000, 2000]],
            "Leilão-com-um-lance" => [1, $leilaoComUmLance, [5000]],
        ];
    }
}
