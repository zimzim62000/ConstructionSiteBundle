<?php

namespace ZIMZIM\ConstructionSiteBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class ActionItemEvent extends Event
{

    /** @var  ActionItem */
    private $actionItem;

    /**
     * @return ActionItem
     */
    public function getActionItem()
    {
        return $this->actionItem;
    }

    /**
     * @param ActionItem $actionItem
     */
    public function setActionItem($actionItem)
    {
        $this->actionItem = $actionItem;

        return $this;
    }
}