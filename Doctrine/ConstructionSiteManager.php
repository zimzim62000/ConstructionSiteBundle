<?php

namespace ZIMZIM\ConstructionSiteBundle\Doctrine;

use ZIMZIM\ToolsBundle\Doctrine\Manager;

class ConstructionSiteManager extends Manager
{

    public function getConstructionSiteByDate()
    {
        return $this->getRepository()->findBy(array(), array('date' => 'DESC'));
    }

    public function findBySlug($slug)
    {
        return $this->getRepository()->findOneBy(array('slug' => $slug));
    }
}