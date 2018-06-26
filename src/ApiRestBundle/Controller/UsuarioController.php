<?php

namespace ApiRestBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as FOS;
use AppBundle\Entity\TbUsuario;

class UsuarioController extends Controller
{
    /**
     * @FOS\Get("/busca-id/{id}", name="api_rest_usuario_busca_id", options={"method_prefix" = false, "expose"=true })
     * @FOS\View(statusCode=200, serializerEnableMaxDepthChecks=true, serializerGroups={"Default"})
     */
    public function buscaIdAction(Request $request, $id)
    {
        $servico = $this->get('api.service.usuario');
        $usuario = $servico->buscaId($id);

        return array(
            'usuario' => $usuario,
        );
    }

    /**
     * @FOS\Get("/listagem", name="api_rest_usuario_listagem", options={"method_prefix" = false, "expose"=true })
     * @FOS\View(statusCode=200, serializerEnableMaxDepthChecks=true, serializerGroups={"Default"})
     */
    public function listagemAction(Request $request)
    {
        $servico = $this->get('api.service.usuario');
        $usuarios = $servico->listagem();

        return array(
            'usuarios' => $usuarios,
        );
    }
    /**
     * @FOS\Post("/cadastrar", name="api_rest_usuario_cadastrar", options={"method_prefix" = false, "expose"=true })
     * @FOS\View(statusCode=200, serializerEnableMaxDepthChecks=true, serializerGroups={"Default"})
     */
    public function cadastrarAction(Request $request)
    {
        $servico = $this->get('api.service.usuario');
        $usuario = $servico->cadastrar($request);

        return array(
            'usuario' => $usuario,
        );
    }
    /**
     * @FOS\Put("/editar", name="api_rest_usuario_editar", options={"method_prefix" = false, "expose"=true })
     * @FOS\View(statusCode=200, serializerEnableMaxDepthChecks=true, serializerGroups={"Default"})
     */
    public function editarAction(Request $request)
    {
        $servico = $this->get('api.service.usuario');
        $usuario = $servico->editar($request);

        return array(
            'usuario' => $usuario,
        );
    }

    /**
     * @FOS\Delete("/deletar/{id}", name="api_rest_usuario_deletar", options={"method_prefix" = false, "expose"=true })
     * @FOS\View(statusCode=200, serializerEnableMaxDepthChecks=true, serializerGroups={"Default"})
     */
    public function deletarAction(Request $request, $id)
    {
        $servico = $this->get('api.service.usuario');
        $retorno = $servico->deletar($id);

        return array(
            'retorno' => $retorno,
        );
    }
}
