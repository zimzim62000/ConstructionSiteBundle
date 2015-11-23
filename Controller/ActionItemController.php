<?php

namespace ZIMZIM\ConstructionSiteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use ZIMZIM\ConstructionSiteBundle\Doctrine\ActionItemManager;
use ZIMZIM\ConstructionSiteBundle\Model\ActionItem;
use ZIMZIM\ConstructionSiteBundle\ZIMZIMConstructionSiteEvent;
use ZIMZIM\ToolsBundle\Controller\MainController;

/**
 * ActionItemController controller.
 *
 */
class ActionItemController extends MainController
{
    const DIR = 'ZIMZIMConstructionSiteBundle:ActionItem';

    /**
     * Lists all AcmeAI entities.
     *
     */
    public function indexAction()
    {
        $manager = $this->container->get('zimzim_construction_site_actionitemmanager');

        $data = array(
            'manager' => $manager,
            'dir' => self::DIR,
            'show' => 'zimzim_constructionsite_actionitem_show',
            'edit' => 'zimzim_constructionsite_actionitem_edit'
        );

        return $this->gridList($data);
    }

    /**
     * Creates a new AcmeAI entity.
     *
     */
    public function createAction(Request $request)
    {
        $manager = $this->container->get('zimzim_construction_site_actionitemmanager');
        $entity = $manager->createEntity();

        $form = $this->createCreateForm($entity, $manager);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $event = $this->container->get('zimzim_constructionsite.event.actionitem');
            $event->setActionItem($entity);
            $this->container->get('event_dispatcher')->dispatch(ZIMZIMConstructionSiteEvent::ActionItemAdd, $event);
            $this->createSuccess();

            return $this->redirect(
                $this->generateUrl('zimzim_constructionsite_actionitem_show', array('id' => $entity->getId()))
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
     * Creates a form to create a AcmeAI entity.
     *
     * @param AcmeAI $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ActionItem $entity, ActionItemManager $manager, $id_cs = null)
    {

        if (!isset($id_cs)) {
            $url = $this->generateUrl("zimzim_constructionsite_actionitem_create");
        } else {
            $url = $this->generateUrl("zimzim_constructionsite_actionitem_addoncs", array('id' => $id_cs));
            $managerCs = $this->container->get('zimzim_construction_site_constructionsitemanager');
            $cs = $managerCs->find($id_cs);
            if (!$cs) {
                throw $this->createNotFoundException('Unable to find ConstructionSite.');
            }
            $entity->setConstructionSite($cs);
        }
        $form = $this->createForm(
            $manager->getFormName(),
            $entity,
            array(
                'action' => $url,
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
     * Displays a form to create a new AcmeAI entity.
     *
     */
    public function newAction()
    {
        $manager = $this->container->get('zimzim_construction_site_actionitemmanager');
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
     * Finds and displays a AcmeAI entity.
     *
     */
    public function showAction($id)
    {
        $manager = $this->container->get('zimzim_construction_site_actionitemmanager');

        $entity = $manager->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AcmeAI entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            self::DIR.':show.html.twig',
            array(
                'entity' => $entity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing AcmeAI entity.
     *
     */
    public function editAction($id)
    {
        $manager = $this->container->get('zimzim_construction_site_actionitemmanager');
        $entity = $manager->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AcmeAI entity.');
        }

        $editForm = $this->createEditForm($entity, $manager);
        $deleteForm = $this->createDeleteForm($id);

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
     * Creates a form to edit a AcmeAI entity.
     *
     * @param AcmeAI $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(ActionItem $entity, ActionItemManager $manager)
    {
        $form = $this->createForm(
            $manager->getFormName(),
            $entity,
            array(
                'action' => $this->generateUrl(
                    'zimzim_constructionsite_actionitem_update',
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
     * Edits an existing AcmeAI entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $manager = $this->container->get('zimzim_construction_site_actionitemmanager');

        $entity = $manager->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AcmeAI entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $manager);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $event = $this->container->get('zimzim_constructionsite.event.actionitem');
            $event->setActionItem($entity);
            $this->container->get('event_dispatcher')->dispatch(ZIMZIMConstructionSiteEvent::ActionItemUpdate, $event);
            $this->updateSuccess();

            return $this->redirect(
                $this->generateUrl('zimzim_constructionsite_actionitem_show', array('id' => $id))
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
     * Deletes a AcmeAI entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $manager = $this->container->get('zimzim_construction_site_actionitemmanager');

            $entity = $manager->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AcmeAI entity.');
            }

            $event = $this->container->get('zimzim_constructionsite.event.actionitem');
            $event->setActionItem($entity);
            $this->container->get('event_dispatcher')->dispatch(ZIMZIMConstructionSiteEvent::ActionItemDelete, $event);
            $this->deleteSuccess();
        }

        return $this->redirect($this->generateUrl('zimzim_constructionsite_actionitem'));
    }

    /**
     * Creates a form to delete a AcmeAI entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('zimzim_constructionsite_actionitem_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add(
                'submit',
                'submit',
                array('label' => 'button.delete', 'attr' => array('class' => 'tiny button alert'))
            )
            ->getForm();
    }

    public function addActionItemOnConstructionSiteAction(Request $request, $id)
    {

        $manager = $this->container->get('zimzim_construction_site_actionitemmanager');
        $entity = $manager->createEntity();
        $form = $this->createCreateForm($entity, $manager, $id);

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $event = $this->container->get('zimzim_constructionsite.event.actionitem');
                $event->setActionItem($entity);
                $this->container->get('event_dispatcher')->dispatch(ZIMZIMConstructionSiteEvent::ActionItemUpdate, $event);
                $this->updateSuccess();

                return $this->redirect(
                    $this->generateUrl('zimzim_constructionsite_constructionsite_show', array('id' => $id))
                );

            }
        }

        return $this->render(
            self::DIR.':new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );

    }
}
