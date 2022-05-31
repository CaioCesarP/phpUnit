<?PHP

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;

use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{

    private $leiloeiro;

    protected function setUp(): void
    {
        $this->leiloeiro = new Avaliador();
    }

    /**
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoForaDeOrdem
     */

    public function testAvaliadorDeveEncontrarOMaiorValorDeLances($leilao)
    {
        $this->leiloeiro->avalia($leilao);

        $maiorValor = $this->leiloeiro->getMaiorValor();

        //Assert - Then
        self::assertEquals(2500, $maiorValor);
    }

    /**
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoForaDeOrdem
     */

    public function testAvaliadorDeveEncontrarOMenorValorDeLances($leilao)
    {
        $this->leiloeiro->avalia($leilao);

        $menorValor = $this->leiloeiro->getMenorValor();

        //Assert - Then
        self::assertEquals(1500, $menorValor);
    }

    /**
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoForaDeOrdem
     */

    public function testAvaliadorDeveEncontrarOsTresMaioresValores($leilao)
    {
        $this->leiloeiro->avalia($leilao);

        //recebe os maiores valores
        $maiores = $this->leiloeiro->getMaioresLances();

        static::assertCount(3, $maiores);
        static::assertEquals(2500, $maiores[0]->getValor());
        static::assertEquals(2000, $maiores[1]->getValor());
        static::assertEquals(1800, $maiores[2]->getValor());
        static::assertGreaterThan($maiores[1]->getValor(), $maiores[0]->getValor());
    }

    /* ------ DADOS ------ */
    public function leilaoEmOrdemCrescente()
    {
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao  = new Usuario('Joao');
        $caio  = new Usuario('Caio');
        $jorge = new Usuario('Jorge');

        $leilao->recebeLance(new Lance($joao, 1500));
        $leilao->recebeLance(new Lance($jorge, 1800));
        $leilao->recebeLance(new Lance($caio, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));

        return [
            "Ordem-Crescente" => [$leilao]
        ];
    }

    public function leilaoEmOrdemDecrescente()
    {
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao  = new Usuario('Joao');
        $caio  = new Usuario('Caio');
        $jorge = new Usuario('Jorge');

        $leilao->recebeLance(new Lance($joao, 1500));
        $leilao->recebeLance(new Lance($jorge, 1800));
        $leilao->recebeLance(new Lance($caio, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));

        return [
            "Ordem-Decrescente" => [$leilao]
        ];
    }

    public function leilaoForaDeOrdem()
    {
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao  = new Usuario('Joao');
        $caio  = new Usuario('Caio');
        $jorge = new Usuario('Jorge');

        $leilao->recebeLance(new Lance($joao, 1500));
        $leilao->recebeLance(new Lance($jorge, 1800));
        $leilao->recebeLance(new Lance($caio, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));

        return [
            "Fora-de-Ordem" => [$leilao]
        ];
    }
}
