<?php

namespace ZIMZIM\ConstructionSiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use ZIMZIM\ToolsBundle\Doctrine\Manager;

class ActionItemType extends AbstractType
{

    private $actionTypeManager;

    public function  __construct(Manager $actionTypeManager)
    {
        $this->actionTypeManager = $actionTypeManager;
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
                array('label' => 'actionitem.name', 'translation_domain' => 'ZIMZIMConstructionSite')
            )
            ->add(
                'text',
                null,
                array('label' => 'actionitem.text', 'translation_domain' => 'ZIMZIMConstructionSite')
            )
            ->add(
                'position',
                null,
                array('label' => 'actionitem.position', 'translation_domain' => 'ZIMZIMConstructionSite')
            )
            ->add(
                'typeActionItem',
                null,
                array(
                    'label' => 'actionitem.typeActionItem',
                    'translation_domain' => 'ZIMZIMConstructionSite',
                    'empty_value' => false
                )
            )
            ->add(
                'constructionSite',
                null,
                array(
                    'label' => 'actionitem.constructionSite',
                    'translation_domain' => 'ZIMZIMConstructionSite',
                    'empty_value' => false
                )
            );

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {

                $actionItem = $event->getData();
                $form = $event->getForm();

                $tmpFileNameBefore = $tmpFileNamePending = $tmpFileNameAfter = "";
                if ($actionItem->getId() !== null) {
                    $tmpFileNameBefore = $actionItem->getWebPathBefore();
                    $tmpFileNamePending = $actionItem->getWebPathPending();
                    $tmpFileNameAfter = $actionItem->getWebPathAfter();
                }

                if($actionItem->getConstructionSite() !== null && $actionItem->getConstructionSite()->getId() !== null){
                    $form->remove('constructionSite');
                }

                $form->add(
                    'fileBefore',
                    'zimzim_toolsbundle_zimzimimage',
                    array(
                        'label' => 'actionitem.imagebefore',
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
                        'label' => 'actionitem.imagepending',
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
                        'label' => 'actionitem.imageafter',
                        'translation_domain' => 'ZIMZIMConstructionSite',
                        'attr' => array(
                            'url' => $tmpFileNameAfter,
                            'label-inline' => 'label-inline'
                        )
                    )
                );

            }
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => $this->actionTypeManager->getClassName(),
                'attr' => array(
                    'class' => 'customerpanel'
                )
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'zimzim_constructionsitebundle_actionitemtype';
    }
}
