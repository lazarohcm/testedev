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

class ProductService extends BaseService
{
    public function findById($id) {
        $product = $this->repositorio->find($id);

        if(!$product) {
            throw new \Exception('Nothing found!');
        }
        return $product;
    }

    public function seek() {
        $products = $this->repositorio->findAll();

        return $products;
    }

    public function create(Request $request){
        $attributes = $request->get('product');
        $attributes['value'] = floatval($attributes['value']);
        $product = new TbProduct();
        $form = $this->createForm($product);
        $form->submit($attributes);

        if(!$form->isValid()) {
            throw new \Exception($form->getErrors());
        }

        return $this->save($product);
    }

    public function edit(Request $request) {
        $attributes = $request->get('product');

        if(!isset($attributes['id'])) {
            throw new \Exception('THe provided is invalid');
        }

        $product = $this->findById($attributes['id']);

        $form = $this->createForm($product);
        $form->submit($attributes);

        if(!$form->isValid()) {
            throw new \Exception($form->getErros());
        }

        return $this->save($product);
    }

    public function delete($id) {
        $product = $this->findById($id);
        $this->em->remove($product);
        $this->em->flush();
        return true;
    }


    public function save(TbProduct $product) {
        $this->em->persist($product);
        $this->em->flush();

        return $product;
    }

    public function createForm(TbProduct $entity = null) {
        $product = $entity == null ? new  TbProduct() : $entity;

        $form = $this->formFactory->create(TbProductType::class, $product);
        return $form;
    }


}