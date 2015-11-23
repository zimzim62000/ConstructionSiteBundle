<?php

namespace ZIMZIM\ConstructionSiteBundle;

final class ZIMZIMConstructionSiteEvent
{
    /** @ConstructionSite */
    const ConstructionSiteAdd = 'zimzim.constructionsite.constructionsite.add';
    const ConstructionSiteUpdate = 'zimzim.constructionsite.constructionsite.update';
    const ConstructionSiteDelete = 'zimzim.constructionsite.constructionsite.delete';

    /** @TypeActionItem */
    const TypeActionItemAdd = 'zimzim.constructionsite.typeactionitem.add';
    const TypeActionItemUpdate = 'zimzim.constructionsite.typeactionitem.update';
    const TypeActionItemDelete = 'zimzim.constructionsite.typeactionitem.delete';
}