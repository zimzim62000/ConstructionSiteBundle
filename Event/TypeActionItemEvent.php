<?php

namespace ZIMZIM\ConstructionSiteBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class TypeActionItemEvent extends Event
{

    /** @var  TypeActionItem */
    private $typeActionItem;

    /**
     * @return TypeActionItem
     */
    public function getTypeActionItem()
    {
        return $this->typeActionItem;
    }

    /**
     * @param TypeActionItem $typeActionItem
     */
    public function setTypeActionItem($typeActionItem)
    {
        $this->typeActionItem = $typeActionItem;

        return $this;
    }
}