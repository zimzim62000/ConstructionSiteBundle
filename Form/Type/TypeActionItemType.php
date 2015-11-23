<?php

namespace ZIMZIM\ConstructionSiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use ZIMZIM\ToolsBundle\Doctrine\Manager;

class TypeActionItemType extends AbstractType
{
    private $typeActionItemManager;

    public function  __construct(Manager $typeActionItemManager)
    {
        $this->typeActionItemManager = $typeActionItemManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                null,
                array('label' => 'typeactionitem.name', 'translation_domain' => 'ZIMZIMConstructionSite')
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->typeActionItemManager->getClassName(),
            'attr' => array(
                'class' => 'customerpanel'
            ),
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'zimzim_constructionsitebundle_typeactionitemtype';
    }
}
