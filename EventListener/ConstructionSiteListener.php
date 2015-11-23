<?php

namespace ZIMZIM\ConstructionSiteBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use ZIMZIM\ConstructionSiteBundle\Event\ConstructionSiteEvent;
use ZIMZIM\ConstructionSiteBundle\ZIMZIMConstructionSiteEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class ConstructionSiteListener implements EventSubscriberInterface
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
            ZIMZIMConstructionSiteEvent::ConstructionSiteAdd => 'constructionAdd',
            ZIMZIMConstructionSiteEvent::ConstructionSiteUpdate => 'constructionUpdate',
            ZIMZIMConstructionSiteEvent::ConstructionSiteDelete => 'constructionDelete',
        );
    }

    public function constructionAdd(ConstructionSiteEvent $event)
    {

        $this->em->persist($event->getConstructionSite());
        $this->em->flush();

    }

    public function constructionUpdate(ConstructionSiteEvent $event)
    {

        $event->getConstructionSite()->preUpload();
        $this->em->persist($event->getConstructionSite());
        $this->em->flush();

    }

    public function constructionDelete(ConstructionSiteEvent $event)
    {

        $this->em->remove($event->getConstructionSite());
        $this->em->flush();
    }
}