<?php

namespace Alura\Leilao\Model;

class Leilao
{
    /** @var Lance[] */
    private $lances;
    /** @var string */
    private $descricao;

    public function __construct(string $descricao)
    {
        $this->descricao = $descricao;
        $this->lances = [];
    }

    public function recebeLance(Lance $lance)
    {
        if (!empty ($this->lances) && $this->ehDoUltimoUsuario($lance)) {
            return;
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

    /**
     * @param $lance
     * @return bool
     */
    private function ehDoUltimoUsuario($lance) : bool
    {
        return $lance->getUsuario() == $this->lances[count($this->lances) - 1]->getUsuario();
    }
}
