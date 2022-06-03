<?php

namespace Alura\Leilao\Model;

class Leilao
{
    /** @var Lance[] */
    private $lances;
    /** @var string */
    private $descricao;
    /** @var boolean */
    private $finalizado = false;

    public function __construct(string $descricao)
    {
        $this->descricao = $descricao;
        $this->lances = [];
        $this->finalizado = false;
    }

    public function recebeLance(Lance $lance)
    {
        if (!empty($this->lances) && $this->ehDoUltimoUsuario($lance)) {
            throw new \DomainException("Usuário não pode propor 2 lances consecutivos.");
        }

        $totalDeLancesPorUsuario = $this->quantidadeDeLancesDoUsuario(
            $lance->getUsuario()
        );
        if ($totalDeLancesPorUsuario >= 5) {
            throw new \DomainException("Usuário não pode propor mais que 5 lances.");
        }

        $this->lances[] = $lance;
    }

    /**
     * @return Lance[]
     */
    public function getLances(): array
    {
        return $this->lances;
    }

    public function finaliza()
    {
        $this->finalizado = true;
    }

    public function estaFinalizado(): bool
    {
        return $this->finalizado;
    }

    /**
     * @param $lance
     * @return bool
     */
    private function ehDoUltimoUsuario($lance): bool
    {
        $ultimoLance = $this->lances[array_key_last($this->lances)];
        return $lance->getUsuario() == $ultimoLance->getUsuario();
    }

    private function quantidadeDeLancesDoUsuario($usuario): int
    {
        $returnTotalAcumulado = function ($totalAcumulado, $lanceAtual) use ($usuario) {
            if ($lanceAtual->getUsuario() == $usuario) {
                return $totalAcumulado + 1;
            }
            return $totalAcumulado;
        };

        $totalDeLancesUsuario = array_reduce(
            $this->lances,
            $returnTotalAcumulado,
            0
        );

        return $totalDeLancesUsuario;
    }
}
