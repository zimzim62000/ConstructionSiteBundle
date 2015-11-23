<?php

namespace ZIMZIM\ConstructionSiteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use ZIMZIM\ConstructionSiteBundle\Doctrine\TypeActionItemManager;
use ZIMZIM\ConstructionSiteBundle\Model\TypeActionItem;
use ZIMZIM\ConstructionSiteBundle\ZIMZIMConstructionSiteEvent;
use ZIMZIM\ToolsBundle\Controller\MainController;

/**
 * TypeActionItemController controller.
 *
 */
class TypeActionItemController extends MainController
{

    const DIR = 'ZIMZIMConstructionSiteBundle:TypeActionItem';

    /**
     * Lists all AcmeTAI entities.
     *
     */
    public function indexAction()
    {
        $manager = $this->container->get('zimzim_construction_site_typeactionitemmanager');

        $data = array(
            'manager' => $manager,
            'dir' => self::DIR,
            'show' => 'zimzim_constructionsite_typeactionitem_show',
            'edit' => 'zimzim_constructionsite_typeactionitem_edit'
        );

        return $this->gridList($data);
    }

    /**
     * Creates a new AcmeTAI entity.
     *
     */
    public function createAction(Request $request)
    {
        $manager = $this->container->get('zimzim_construction_site_typeactionitemmanager');
        $entity = $manager->createEntity();
        $form = $this->createCreateForm($entity, $manager);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $event = $this->container->get('zimzim_constructionsite.event.typeactionitem');
            $event->setTypeActionItem($entity);
            $this->container->get('event_dispatcher')->dispatch(ZIMZIMConstructionSiteEvent::TypeActionItemAdd, $event);
            $this->createSuccess();

            return $this->redirect(
                $this->generateUrl('zimzim_constructionsite_typeactionitem_show', array('id' => $entity->getId()))
            );
        }

        return $this->render(
            self::DIR.':new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Creates a form to create a AcmeTAI entity.
     *
     * @param AcmeTAI $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TypeActionItem $entity, TypeActionItemManager $manager)
    {
        $form = $this->createForm(
            $manager->getFormName(),
            $entity,
            array(
                'action' => $this->generateUrl('zimzim_constructionsite_typeactionitem_create'),
                'method' => 'POST',
            )
        );

        $form->add(
            'submit',
            'submit',
            array('label' => 'button.validate', 'attr' => array('class' => 'tiny button success'))
        );

        return $form;
    }

    /**
     * Displays a form to create a new AcmeTAI entity.
     *
     */
    public function newAction()
    {
        $manager = $this->container->get('zimzim_construction_site_typeactionitemmanager');
        $entity = $manager->createEntity();
        $form = $this->createCreateForm($entity, $manager);

        return $this->render(
            self::DIR.':new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a AcmeTAI entity.
     *
     */
    public function showAction($id)
    {
        $manager = $this->container->get('zimzim_construction_site_typeactionitemmanager');

        $entity = $manager->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AcmeTAI entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            self::DIR . ':show.html.twig',
            array(
                'entity' => $entity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing AcmeTAI entity.
     *
     */
    public function editAction($id)
    {
        $manager = $this->container->get('zimzim_construction_site_typeactionitemmanager');

        $entity = $manager->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AcmeTAI entity.');
        }

        $editForm = $this->createEditForm($entity, $manager);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            self::DIR. ':edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to edit a AcmeTAI entity.
     *
     * @param AcmeTAI $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(TypeActionItem $entity, TypeActionItemManager $manager)
    {
        $form = $this->createForm(
            $manager->getFormName(),
            $entity,
            array(
                'action' => $this->generateUrl(
                    'zimzim_constructionsite_typeactionitem_update',
                    array('id' => $entity->getId())
                ),
                'method' => 'PUT',
            )
        );

        $form->add(
            'submit',
            'submit',
            array('label' => 'button.validate', 'attr' => array('class' => 'tiny button success'))
        );

        return $form;
    }

    /**
     * Edits an existing AcmeTAI entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $manager = $this->container->get('zimzim_construction_site_typeactionitemmanager');

        $entity = $manager->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AcmeTAI entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $manager);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $event = $this->container->get('zimzim_constructionsite.event.typeactionitem');
            $event->setTypeActionItem($entity);
            $this->container->get('event_dispatcher')->dispatch(ZIMZIMConstructionSiteEvent::TypeActionItemUpdate, $event);
            $this->updateSuccess();

            return $this->redirect(
                $this->generateUrl('zimzim_constructionsite_typeactionitem_show', array('id' => $id))
            );
        }

        return $this->render(
            self::DIR.':edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a AcmeTAI entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $manager = $this->container->get('zimzim_construction_site_typeactionitemmanager');

            $entity = $manager->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AcmeTAI entity.');
            }

            $event = $this->container->get('zimzim_constructionsite.event.typeactionitem');
            $event->setTypeActionItem($entity);
            $this->container->get('event_dispatcher')->dispatch(ZIMZIMConstructionSiteEvent::TypeActionItemDelete, $event);
            $this->deleteSuccess();
        }

        return $this->redirect($this->generateUrl('zimzim_constructionsite_typeactionitem'));
    }

    /**
     * Creates a form to delete a AcmeTAI entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('zimzim_constructionsite_typeactionitem_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add(
                'submit',
                'submit',
                array('label' => 'button.delete', 'attr' => array('class' => 'tiny button alert'))
            )
            ->getForm();
    }
}
