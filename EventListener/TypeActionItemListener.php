<?php

namespace ZIMZIM\ConstructionSiteBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use ZIMZIM\ConstructionSiteBundle\Event\TypeActionItemEvent;
use ZIMZIM\ConstructionSiteBundle\ZIMZIMConstructionSiteEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class TypeActionItemListener implements EventSubscriberInterface
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
            ZIMZIMConstructionSiteEvent::TypeActionItemAdd => 'typeActionItemAdd',
            ZIMZIMConstructionSiteEvent::TypeActionItemUpdate => 'typeActionItemUpdate',
            ZIMZIMConstructionSiteEvent::TypeActionItemDelete => 'typeActionItemDelete',
        );
    }

    public function typeActionItemAdd(TypeActionItemEvent $event)
    {
        $this->em->persist($event->getTypeActionItem());
        $this->em->flush();

    }

    public function typeActionItemUpdate(TypeActionItemEvent $event)
    {
        $this->em->persist($event->getTypeActionItem());
        $this->em->flush();
    }

    public function typeActionItemDelete(TypeActionItemEvent $event)
    {
        $this->em->remove($event->getTypeActionItem());
        $this->em->flush();
    }
}