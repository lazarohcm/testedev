<?php
/**
 * Created by PhpStorm.
 * User: unasus
 * Date: 6/27/18
 * Time: 9:35 AM
 */

namespace AppBundle\Form;


use AppBundle\Entity\TbProduct;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TbProductType extends AbstractType
{

    /**
     * {@inheritdoc}
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // parent::buildForm($builder, $options); // TODO: Change the autogenerated stub
        $builder->add('name', TextType::class, [
            'label' => 'Name',
            'attr' => []
        ])->add('value', CurrencyType::class, [
            'label' => 'Value',
        ]);
    }

    /**
     * {@inheritdoc}
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
//    parent::configureOptions($resolver); // TODO: Change the autogenerated stub
        $resolver->setDefault([
            'data_class' => TbProduct::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ]);
    }

    public function getBlockPrefix()
    {
//        return parent::getBlockPrefix(); // TODO: Change the autogenerated stub
        return 'product';
    }
}