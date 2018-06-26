<?php
namespace ApiRestBundle\Service\Util;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Form\FormFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use AppBundle\Entity\TbUsuario;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

abstract class BaseService
{

    /**
     * @var EntityManager
     * $em Doctrine EntityManager
    */
    protected $em;

    /**
     * @var FormFactory
     *
     * $formFactory Symfony Form Factory
    */
    protected $formFactory;

    /**
     * @var ObjectRepository|null
     *
     * $repositorio ObjectRepository
    */
    protected $repositorio = null;

    /**
     * @var Array
     *
     * $erro Array para armazenar erros do serviço
    */
    protected $erros = array();

    /**
     * Seta serviço EntityManager
     *
     * @param  EntityManager $em
     *
     * @return mixed              Serviço que estende de ServicoBaseService
     */
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;

        return $this;
    }

    /**
     * Seta serviço FormFactory
     *
     * @param  FormFactory $formFactory
     *
     * @return ServicoBase                    Servico base
     */
    public function setFormFactory(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;

        return $this;
    }

    /**
     * Seta variavel de repositório
     * @param string $repository Nome do repositório
     *
     * @return ServicoBase             Servico base
     */
    public function setRepository($repository)
    {
        $this->repositorio = $this->em->getRepository($repository);

        return $this;
    }

    /**
     * Retorna um array contendo erros do serviço
     *
     * @return Array    array contendo erros
     */
    public function getErros()
    {
        return $this->erros;
    }

    /**
     * Formata erros de formulários para um array
     *
     * @param  \Symfony\Component\Form\Form $form
     * @return array
     */
    protected function formataErrosForm(\Symfony\Component\Form\Form $form)
    {
        $erros = array();
        //Itera sobre os erros do formulário root
        foreach ($form->getErrors() as $erro) {

            if ($form->isRoot()) {
                $erros['#'][] = $erro->getMessage();
            } else {
                $erros[$form->createView()->vars['full_name']][] = $erro->getMessage();
            }
        }
        //Valida todos os erros dos formulários filhos
        foreach ($form->all() as $filho) {
            if (!$filho->isValid()) {
                $erros = array_merge($erros, $this->formataErrosForm($filho));
            }
        }
        $this->erros = $erros;
        return $erros;
    }

    /**
     * @param \Symfony\Component\Form\Form $form
     * @return array
     */
    public function getFormErrors(\Symfony\Component\Form\Form $form)
    {
        if ($form instanceof \Symfony\Component\Form\Form) {
            // find errors of this element
            foreach ($form->getErrors() as $error) {
                $errors[] = self::$translator->trans($error->getMessage(), array(), 'validators');
            }

            // iterate over errors of all children
            foreach ($form->all() as $key => $child) {
                if($child instanceof \Symfony\Component\Form\Form) {
                    /** @var $child \Symfony\Component\Form\Form */
                    $err = self::getFormErrors($child);
                    if (count($err) > 0) {
                        $this->erros = array_merge($errors, $err);
                    }
                }
            }
        }

        return $this->erros;
    }
    /**
     * @param \Symfony\Component\Form\Form $form
     * @return array
     */
    public function childErrors(\Symfony\Component\Form\Form $form)
    {
        $errors = array();
        foreach ($form->getErrors() as $error) {
            $message = $error->getMessage();
            array_push($errors, $message);
        }
        return $errors;
    }
}
