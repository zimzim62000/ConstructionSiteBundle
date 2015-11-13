<?php

namespace ZIMZIM\ConstructionSiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use ZIMZIM\ToolsBundle\Doctrine\Manager;

class ConstructionSiteType extends AbstractType
{
    private $constructionSiteManager;

    public function  __construct(Manager $constructionSiteManager)
    {
        $this->constructionSiteManager = $constructionSiteManager;
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
                array('label' => 'constructionsite.name', 'translation_domain' => 'ZIMZIMConstructionSite')
            )
            ->add('text',
                null,
                array('label' => 'constructionsite.text', 'translation_domain' => 'ZIMZIMConstructionSite')
            )
            ->add('titleSeo',
                null,
                array('label' => 'constructionsite.titleSeo', 'translation_domain' => 'ZIMZIMConstructionSite')
            )
            ->add('descSeo',
                null,
                array('label' => 'constructionsite.descSeo', 'translation_domain' => 'ZIMZIMConstructionSite')
            )
            ->add('city',
                null,
                array('label' => 'constructionsite.city', 'translation_domain' => 'ZIMZIMConstructionSite')
            )
            ->add('date',
                null,
                array('label' => 'constructionsite.date', 'translation_domain' => 'ZIMZIMConstructionSite')
            )
            ->add('duration',
                null,
                array('label' => 'constructionsite.duration', 'translation_domain' => 'ZIMZIMConstructionSite')
            )
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {

                $constructionSite = $event->getData();
                $form = $event->getForm();

                $tmpFileNameBefore = $tmpFileNamePending = $tmpFileNameAfter = "";
                if($constructionSite->getId() !== null){
                    $tmpFileNameBefore = $constructionSite->getWebPathBefore();
                    $tmpFileNamePending = $constructionSite->getWebPathPending();
                    $tmpFileNameAfter = $constructionSite->getWebPathAfter();
                }

                $form->add(
                    'fileBefore',
                    'zimzim_toolsbundle_zimzimimage',
                    array(
                        'label' => 'constructionsite.imagebefore',
                        'translation_domain' => 'ZIMZIMConstructionSite',
                        'attr' => array(
                            'url' => $tmpFileNameBefore,
                            'label-inline' => 'label-inline'
                        )
                    )
                );

                $form->add(
                    'filePending',
                    'zimzim_toolsbundle_zimzimimage',
                    array(
                        'label' => 'constructionsite.imagepending',
                        'translation_domain' => 'ZIMZIMConstructionSite',
                        'attr' => array(
                            'url' => $tmpFileNamePending,
                            'label-inline' => 'label-inline'
                        )
                    )
                );

                $form->add(
                    'fileAfter',
                    'zimzim_toolsbundle_zimzimimage',
                    array(
                        'label' => 'constructionsite.imageafter',
                        'translation_domain' => 'ZIMZIMConstructionSite',
                        'attr' => array(
                            'url' => $tmpFileNameAfter,
                            'label-inline' => 'label-inline'
                        )
                    )
                );

            });
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->constructionSiteManager->getClassName(),
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
        return 'zimzim_constructionsitebundle_constructionsitetype';
    }
}
