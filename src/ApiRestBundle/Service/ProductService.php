<?php
/**
 * Created by PhpStorm.
 * User: unasus
 * Date: 6/27/18
 * Time: 9:17 AM
 */

namespace ApiRestBundle\Service;


use ApiRestBundle\Service\Util\BaseService;
use AppBundle\Entity\TbProduct;
use AppBundle\Form\TbProductType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductService extends BaseService
{
    public function seek()
    {
        try {
            $products = $this->repositorio->findAll();

            return $products;
        } catch (\Exception $ex) {
            throw $ex;
        }

    }

    public function create(Request $request)
    {
        try {

            $attributes = $request->get('product');
            $attributes['value'] = floatval($attributes['value']);
            $product = new TbProduct();
            $form = $this->createForm($product);
            $form->submit($attributes);

            if (!$form->isValid()) {
                throw new \Exception($form->getErrors());
            }

            return $this->save($product);
        } catch (\Exception $ex) {
            throw $ex;
        }

    }

    public function createForm(TbProduct $entity = null)
    {
        $product = $entity == null ? new  TbProduct() : $entity;

        $form = $this->formFactory->create(TbProductType::class, $product);
        return $form;
    }

    public function save(TbProduct $product)
    {
        try {
            $this->em->persist($product);
            $this->em->flush();

            return $product;
        } catch (\Exception $ex) {
            throw $ex;
        }

    }

    public function edit(Request $request)
    {
        try {
            $attributes = $request->get('product');

            if (!isset($attributes['id'])) {
                throw new NotFoundHttpException('Product not found');
            }

            $product = $this->findById($attributes['id']);

            $form = $this->createForm($product);
            $form->submit($attributes);

            if (!$form->isValid()) {
                throw new \Exception($form->getErros());
            }

            return $this->save($product);
        } catch (\Exception $ex) {
            throw $ex;
        } catch (NotFoundHttpException $ex) {
            throw $ex;
        }

    }

    public function findById($id)
    {
        try {
            $product = $this->repositorio->find($id);
            return $product;

            if (!$product) {
                throw new NotFoundHttpException('Nothing found!');
            }
        } catch (\Exception $ex) {
            throw $ex;
        }

    }

    public function delete($id)
    {
        try {
            $product = $this->findById($id);
            if (!$product) {
                throw new NotFoundHttpException('Product  not found');
            }
            $this->em->remove($product);
            $this->em->flush();
            return true;
        } catch (\Exception $ex) {
            throw $ex;
        } catch (NotFoundHttpException $ex) {
            throw $ex;
        }

    }


}