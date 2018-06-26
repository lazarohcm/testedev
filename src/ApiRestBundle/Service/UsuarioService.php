<?php
namespace ApiRestBundle\Service;

use ApiRestBundle\Service\Util\BaseService;
use AppBundle\Entity\TbUsuario;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\TbUsuarioType;
use Symfony\Component\HttpKernel\Exception;
use AppBundle\Exception\FormException;

class UsuarioService extends BaseService
{
    public function buscaId($id)
    {
        $usuario = $this->repositorio->find($id);
        if (!$usuario){
            throw new \Exception('Usuário não encontrado!');
        }

        return $usuario;
    }

    public function listagem()
    {
        $usuarios = $this->repositorio->findAll();
        return $usuarios;
    }

    public function cadastrar(Request $request)
    {
        $dados = $request->get('usuario');
        $usuario = new TbUsuario();
        $form = $this->createForm($usuario);
        $form->submit($dados);


        if (!$form->isValid()) {
            throw new \Exception($form->getErrors());
        }

        return $this->save($usuario);
    }

    public function editar(Request $request)
    {
        $dados = $request->get('usuario');

        if (!isset($dados['id'])){
            throw new \Exception('Dados inválidos!');
        }

        $usuario = $this->buscaId($dados['id']);

        $form = $this->createForm($usuario);
        $form->submit($dados);

        if (!$form->isValid()) {
            throw new \Exception($form->getErrors());
        }

        return $this->save($usuario);

    }

    public function deletar($id)
    {
        $usuario = $this->buscaId($id);
        $this->em->remove($usuario);
        $this->em->flush();
        return true;
    }

    public function save(TbUsuario $usuario)
    {
        $this->em->persist($usuario);
        $this->em->flush();

        return $usuario;
    }

    public function createForm(TbUsuario $entity = null)
    {
        $usuario = $entity == null ? new TbUsuario() : $entity;
        $form = $this->formFactory->create(TbUsuarioType::class, $usuario);
        return $form;
    }
}
