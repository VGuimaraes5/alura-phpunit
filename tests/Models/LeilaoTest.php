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

    public function testLeilaoNaoDeveReceberLancesRepetidos(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Usuário não pode propor 2 lances consecutivos');

        $leilao = new Leilao('Boi Bandido');
        $vini = new Usuario('Vinicius');

        $leilao->recebeLance(new Lance($vini, 2000));
        $leilao->recebeLance(new Lance($vini, 3000));
    }

    public function testLeilaoNaoDeveReceberMaisDeCincoLancesPorUsuario(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Usuário não pode propor mais de 5 lances por leilão');

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

        // throw exception
        $leilao->recebeLance(new Lance($vini, 3000));
    }

    public function geraLances(): array
    {
        $leilao1 = new Leilao('Boi Bandido');
        $leilao2 = new Leilao('Boi Soberano');

        $vini = new Usuario('Vinicius');
        $bru = new Usuario('Bruna');

        $leilao1->recebeLance(new Lance($vini, 1000));

        $leilao2->recebeLance(new Lance($vini, 1000));
        $leilao2->recebeLance(new Lance($bru, 1500));
        $leilao2->recebeLance(new Lance($vini, 2000));

        return [
            "1Lance" => [1, $leilao1, [1000]],
            "3LancesAlternados" => [3, $leilao2, [1000, 1500, 2000]]
        ];
    }
}
