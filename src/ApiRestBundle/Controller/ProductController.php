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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{

    private function getService()
    {
        return $this->get('api.service.product');
    }

    protected function apiResponse($data, $status_code = 200)
    {
        $json = $this->container->get('jms_serializer')
            ->serialize($data, 'json');

        return new Response($json, $status_code, array(
            'Content-Type' => 'application/json'
        ));
    }

    /**
     * @FOS\Post("/", name="api_rest_product_create", options={"method_prefix" = false, "expose"=true })
     * @FOS\View(statusCode=200, serializerEnableMaxDepthChecks=true, serializerGroups={"Default"})
     */
    public function createAction(Request $request)
    {
        try{
            $service = $this->getService();

            $product = $service->create($request);

            return $this->apiResponse(array('product' => $product), 200);

        }catch(\Exception $ex) {
            throw new HttpException(500, $ex->getMessage());
        }

    }

    /**
     * @FOS\Get("/find/{id}", name="api_rest_product_find_by_id", options={"method_prefix" = false, "expose"=true })
     * @FOS\View(statusCode=200, serializerEnableMaxDepthChecks=true, serializerGroups={"Default"})
     */
    public function findByIdAction(Request $request, $id)
    {
        try {
            $service = $this->getService();

            $product = $service->findById($id);
            if(!$product) {
                return $this->apiResponse('Product not found', 404);
            }
            return $this->apiResponse(array('product' => $product), 200);

        } catch (\Exception $ex) {
            return $this->apiResponse($ex->getMessage(), 500);
        }

    }


    /**
     * @FOS\Get("/list", name="api_rest_product_list", options={"method_prefix" = false, "expose"=true })
     * @FOS\View(statusCode=200, serializerEnableMaxDepthChecks=true, serializerGroups={"Default"})
     */
    public function listAction(Request $request)
    {
        try {
            $service = $this->getService();

            $products = $service->seek();
            return $this->apiResponse(array('products' => $products), 200);
        }catch(\Exception $ex) {
            return $this->apiResponse($ex->getMessage(), 500);
        }

    }



    /**
     * @FOS\Put("/", name="api_rest_product_update", options={"method_prefix" = false, "expose"=true })
     * @FOS\View(statusCode=200, serializerEnableMaxDepthChecks=true, serializerGroups={"Default"})
     */
    public function updateAction(Request $request)
    {
        try {
            $service = $this->getService();
            $product = $service->edit($request);
            return $this->apiResponse(array('product' => $product));

        }catch(\Exception $ex) {
            return $this->apiResponse($ex->getMessage(), 500);
        }

    }

    /**
     * @FOS\Delete("/{id}", name="api_rest_product_delete", options={"method_prefix" = false, "expose"=true })
     * @FOS\View(statusCode=200, serializerEnableMaxDepthChecks=true, serializerGroups={"Default"})
     */
    public function deleteAction(Request $request, $id)
    {
        try {
            $service = $this->getService();
            $result = $service->delete($id);

            return $this->apiResponse(array('deleted' => $result));

        }catch(\Exception $ex) {
            return $this->apiResponse($ex->getMessage(), 500);
        }

    }
}