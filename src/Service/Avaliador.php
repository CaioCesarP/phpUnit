<?php

namespace Alura\Leilao\Service;

use Alura\Leilao\Model\Leilao;

class Avaliador
{
    private $maiorValor = -INF;
    private $menorValor = INF;
    private $MaioresValores;

    public function avalia(Leilao $leilao): void
    {
        //para cada lance do $leilao dado como $lance
        foreach ($leilao->getLances() as $lance) {
            //pega o maior valor e armazena em $maiorValor;
            if ($lance->getValor() > $this->maiorValor) {
                $this->maiorValor = $lance->getValor();
            }
            //pega o menor valor e armazena em $menorValor;
            if ($lance->getValor() < $this->menorValor) {
                $this->menorValor = $lance->getValor();
            }
        }
        //recebe o array do $leilao armazenando em $lances;
        $lances = $leilao->getLances();
        //ordena o array $lances (funciona igual ao sort do javascript);
        usort($lances, function ($lance1, $lance2) {
            return $lance2->getValor() - $lance1->getValor();
        });
        //atribui ao $maioresValores os três primeiros itens do array $lances após ser ordernado;
        $this->MaioresValores = array_slice($lances, 0, 3);
    }

    public function getMaiorValor(): float
    {
        return $this->maiorValor;
    }

    public function getMenorValor(): float
    {
        return $this->menorValor;
    }

    public function getMaioresLances() : array
    {
        return $this->MaioresValores;
    }
}
