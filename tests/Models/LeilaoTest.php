<?php

namespace Alura\Leilao\Tests\Model;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{

    /**
     * @dataProvider geraLances
     */
    public function testLeilaoDeveReceberLances(int $qtdLances, Leilao $leilao, array $valores): void
    {
        static::assertCount($qtdLances, $leilao->getLances());

        foreach ($valores as $index => $valor) {
            static::assertEquals($valor, $leilao->getLances()[$index]->getValor());
        }
    }

    /**
     * @dataProvider geraLancesRepetidos
     */
    public function testLeilaoNaoDeveReceberLancesRepetidos(int $qtdLances, Leilao $leilao, array $valores): void
    {
        static::assertCount($qtdLances, $leilao->getLances());

        foreach ($valores as $index => $valor) {
            static::assertEquals($valor, $leilao->getLances()[$index]->getValor());
        }
    }

    /**
     * @dataProvider geraMuitosLancesRepetidos
     */
    public function testLeilaoNaoDeveReceberMaisDeCincoLancesPorUsuario(int $qtdLances, Leilao $leilao): void
    {
        static::assertCount($qtdLances, $leilao->getLances());

        $lances = $leilao->getLances();
        static::assertEquals(2800, end($lances)->getValor());
    }

    public function geraLances(): array
    {
        $leilao1 = new Leilao('Boi Bandido');
        $leilao2 = new Leilao('Boi Soberano');

        $vini = new Usuario('Vinicius');
        $bru = new Usuario('Bruna');

        $leilao1->recebeLance(new Lance($vini, 2000));

        $leilao2->recebeLance(new Lance($vini, 1000));
        $leilao2->recebeLance(new Lance($bru, 1200));

        return [
            "1Lance" => [1, $leilao1, [2000]],
            "2Lances" => [2, $leilao2, [1000, 1200]]
        ];
    }

    public function geraLancesRepetidos(): array
    {
        $leilao1 = new Leilao('Boi Bandido');
        $leilao2 = new Leilao('Boi Soberano');

        $vini = new Usuario('Vinicius');
        $bru = new Usuario('Bruna');

        $leilao1->recebeLance(new Lance($vini, 2000));
        $leilao1->recebeLance(new Lance($vini, 3000));

        $leilao2->recebeLance(new Lance($vini, 1000));
        $leilao2->recebeLance(new Lance($bru, 1200));
        $leilao2->recebeLance(new Lance($vini, 1400));

        return [
            "repedidoEmSequencia" => [1, $leilao1, [2000]],
            "repetidoForaDeSequencia" => [3, $leilao2, [1000, 1200, 1400]]
        ];
    }

    public function geraMuitosLancesRepetidos(): array
    {
        $leilao = new Leilao('Boi Bandido');

        $vini = new Usuario('Vinicius');
        $bru = new Usuario('Bruna');

        // aceitos
        $leilao->recebeLance(new Lance($vini, 1000));
        $leilao->recebeLance(new Lance($bru, 1200));
        $leilao->recebeLance(new Lance($vini, 1400));
        $leilao->recebeLance(new Lance($bru, 1600));
        $leilao->recebeLance(new Lance($vini, 1800));
        $leilao->recebeLance(new Lance($bru, 2000));
        $leilao->recebeLance(new Lance($vini, 2200));
        $leilao->recebeLance(new Lance($bru, 2400));
        $leilao->recebeLance(new Lance($vini, 2600));
        $leilao->recebeLance(new Lance($bru, 2800));

        // ignorado
        $leilao->recebeLance(new Lance($vini, 3000));

        return [
            "repedido6vezes" => [10, $leilao]
        ];
    }
}
