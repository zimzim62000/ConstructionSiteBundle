<?php

namespace ZIMZIM\ConstructionSiteBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use ZIMZIM\ConstructionSiteBundle\Event\ActionItemEvent;
use ZIMZIM\ConstructionSiteBundle\ZIMZIMConstructionSiteEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class ActionItemListener implements EventSubscriberInterface
{
    private $em;

    private $token;

    private $checker;

    public function __construct(EntityManager $entityManager, TokenStorage $token, AuthorizationChecker $checker)
    {
        $this->em = $entityManager;
        $this->token = $token;
        $this->checker = $checker;
    }

    public static function getSubscribedEvents()
    {
        return array(
            ZIMZIMConstructionSiteEvent::ActionItemAdd => 'actionItemAdd',
            ZIMZIMConstructionSiteEvent::ActionItemUpdate => 'actionItemUpdate',
            ZIMZIMConstructionSiteEvent::ActionItemDelete => 'actionItemDelete',
        );
    }

    public function actionItemAdd(ActionItemEvent $event)
    {
        $this->em->persist($event->getActionItem());
        $this->em->flush();

    }

    public function actionItemUpdate(ActionItemEvent $event)
    {
        $this->em->persist($event->getActionItem());
        $this->em->flush();
    }

    public function actionItemDelete(ActionItemEvent $event)
    {
        $this->em->remove($event->getActionItem());
        $this->em->flush();
    }
}