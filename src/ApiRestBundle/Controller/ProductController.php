<?php
/**
 * Created by PhpStorm.
 * User: unasus
 * Date: 6/27/18
 * Time: 10:00 AM
 */

namespace ApiRestBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as FOS;

class ProductController extends Controller
{
    private function getService()
    {
        return $this->get('api.service.product');
    }

    /**
     * @FOS\Get("/find/{id}", name="api_rest_product_find_by_id", options={"method_prefix" = false, "expose"=true })
     * @FOS\View(statusCode=200, serializerEnableMaxDepthChecks=true, serializerGroups={"Default"})
     */
    public function findByIdAction(Request $request, $id)
    {
        $service = $this->getService();

        $product = $service->findById($id);

        return [
            'product' => $product
        ];
    }

    /**
     * @FOS\Get("/list", name="api_rest_product_list", options={"method_prefix" = false, "expose"=true })
     * @FOS\View(statusCode=200, serializerEnableMaxDepthChecks=true, serializerGroups={"Default"})
     */
    public function listAction(Request $request)
    {
        $service = $this->getService();

        $products = $service->seek();

        return [
            'products' => $products
        ];
    }

    /**
     * @FOS\Post("/", name="api_rest_product_create", options={"method_prefix" = false, "expose"=true })
     * @FOS\View(statusCode=200, serializerEnableMaxDepthChecks=true, serializerGroups={"Default"})
     */
    public function createAction(Request $request)
    {
        $service = $this->getService();

        $product = $service->create($request);

        return [
            'product' => $product
        ];

    }

    /**
     * @FOS\Put("/", name="api_rest_product_update", options={"method_prefix" = false, "expose"=true })
     * @FOS\View(statusCode=200, serializerEnableMaxDepthChecks=true, serializerGroups={"Default"})
     */
    public function updateAction(Request $request)
    {
        $servico = $this->getService();
        $product = $servico->edit($request);

        return array(
            'product' => $product,
        );
    }

    /**
     * @FOS\Delete("/{id}", name="api_rest_product_delete", options={"method_prefix" = false, "expose"=true })
     * @FOS\View(statusCode=200, serializerEnableMaxDepthChecks=true, serializerGroups={"Default"})
     */
    public function deleteAction(Request $request, $id)
    {
        $servico = $this->getService();
        $retorno = $servico->delete($id);

        return array(
            'deleted' => $retorno,
        );
    }
}