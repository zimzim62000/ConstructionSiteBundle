<?php

namespace ZIMZIM\ConstructionSiteBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class ConstructionSiteEvent extends Event
{

    /** @var  ConstructionSite */
    private $constructionSite;

    /**
     * @return ConstructionSite
     */
    public function getConstructionSite()
    {
        return $this->constructionSite;
    }

    /**
     * @param ConstructionSite $constructionSite
     */
    public function setConstructionSite($constructionSite)
    {
        $this->constructionSite = $constructionSite;

        return $this;
    }
}