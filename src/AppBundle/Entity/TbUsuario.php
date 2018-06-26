<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TbUsuario
 *
 * @ORM\Table(name="tb_usuario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TbUsuarioRepository")
 */
class TbUsuario
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255)
     */
    private $nome;

    /**
     * @var bool
     *
     * @ORM\Column(name="situacao", type="boolean")
     */
    private $situacao;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return TbUsuario
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set situacao
     *
     * @param boolean $situacao
     *
     * @return TbUsuario
     */
    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;

        return $this;
    }

    /**
     * Get situacao
     *
     * @return bool
     */
    public function getSituacao()
    {
        return $this->situacao;
    }
}

