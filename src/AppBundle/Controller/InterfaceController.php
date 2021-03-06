<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class InterfaceController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:interface:index.html.twig');
    }
    /**
     * @Route("/usuario-index", name="usuario_index", options={"expose"=true})
     */
    public function indexUsuarioAction(Request $request)
    {
        return $this->render('AppBundle:interface/usuario:index.html.twig');
    }

    /**
     * @Route("/product-index", name="product_index", options={"expose"=true})
     */
    public function indexProductAction(Request $request)
    {
        return $this->render('AppBundle:interface/product:index.html.twig');
    }
    /**
     * @Route("/usuario-cadastro", name="usuario_cadastro", options={"expose"=true})
     */
    public function cadastroUsuarioAction(Request $request)
    {
        $servico = $this->get('api.service.usuario');

        $form = $servico->createForm();
        return $this->render(
            'AppBundle:interface/usuario:cadastro.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/product-create", name="product_create", options={"expose"=true})
     */
    public function cadastroProductAction(Request $request)
    {
        $servico = $this->get('api.service.product');

        $form = $servico->createForm();
        return $this->render(
            'AppBundle:interface/product:cadastro.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/usuario-editar/{id}", name="usuario_editar", options={"expose"=true})
     */
    public function editarUsuarioAction(Request $request, $id)
    {
        return $this->render(
            'AppBundle:interface/usuario:editar.html.twig',
            array(
                'id' => $id,
            )
        );
    }

    /**
     * @Route("/product-edit/{id}", name="product_edit", options={"expose"=true})
     */
    public function editarProductAction(Request $request, $id)
    {
        return $this->render(
            'AppBundle:interface/product:editar.html.twig',
            array(
                'id' => $id,
            )
        );
    }
}
