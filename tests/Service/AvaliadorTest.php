<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\TestCase;
use Alura\Leilao\Service\Avaliador;

class AvaliadorTest extends TestCase
{

    private Avaliador $leiloeiro;

    protected function setUp(): void
    {
        $this->leiloeiro = new Avaliador();
    }

    /**
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testAvaliadorDeveEncontrarOMaiorValorDeLance(Leilao $leilao): void
    {
        $this->leiloeiro->avalia($leilao);
        $maiorValor = $this->leiloeiro->getMaiorValor();

        self::assertEquals(1500, $maiorValor);
    }

    /**
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testAvaliadorDeveEncontrarOMenorValorDeLance(Leilao $leilao): void
    {
        $this->leiloeiro->avalia($leilao);
        $maiorValor = $this->leiloeiro->getMenorValor();

        self::assertEquals(1000, $maiorValor);
    }


    /**
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testAvaliadorDeveEncontrarTresMaioresValores(Leilao $leilao): void
    {
        $this->leiloeiro->avalia($leilao);
        $maiores = $this->leiloeiro->getMaioresLances();

        self::assertCount(3, $maiores);
        self::assertEquals(1500, $maiores[0]->getValor());
        self::assertEquals(1400, $maiores[1]->getValor());
        self::assertEquals(1200, $maiores[2]->getValor());
    }


    public function leilaoEmOrdemCrescente(): array
    {
        $leilao = new Leilao('Boi Bandido');

        $vini = new Usuario('Vinicius');
        $bru = new Usuario('Bruna');
        $gui = new Usuario('Guilherme');
        $gabs = new Usuario('Gabriel');

        $leilao->recebeLance(new Lance($vini, 1000));
        $leilao->recebeLance(new Lance($bru, 1200));
        $leilao->recebeLance(new Lance($gui, 1400));
        $leilao->recebeLance(new Lance($gabs, 1500));

        return [
            "emOrdemCrescente" => [$leilao]
        ];
    }

    public function leilaoEmOrdemDecrescente(): array
    {
        $leilao = new Leilao('Boi Bandido');

        $vini = new Usuario('Vinicius');
        $bru = new Usuario('Bruna');
        $gui = new Usuario('Guilherme');
        $gabs = new Usuario('Gabriel');

        $leilao->recebeLance(new Lance($gabs, 1500));
        $leilao->recebeLance(new Lance($gui, 1400));
        $leilao->recebeLance(new Lance($bru, 1200));
        $leilao->recebeLance(new Lance($vini, 1000));

        return [
            "emOrdemDecrescente" => [$leilao]
        ];
    }

    public function leilaoEmOrdemAleatoria(): array
    {
        $leilao = new Leilao('Boi Bandido');

        $vini = new Usuario('Vinicius');
        $bru = new Usuario('Bruna');
        $gui = new Usuario('Guilherme');
        $gabs = new Usuario('Gabriel');

        $leilao->recebeLance(new Lance($gabs, 1500));
        $leilao->recebeLance(new Lance($vini, 1000));
        $leilao->recebeLance(new Lance($bru, 1200));
        $leilao->recebeLance(new Lance($gui, 1400));

        return [
            "emOrdemAleatória" => [$leilao]
        ];
    }
}
