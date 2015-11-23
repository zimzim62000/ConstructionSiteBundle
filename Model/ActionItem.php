<?php

namespace ZIMZIM\ConstructionSiteBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use APY\DataGridBundle\Grid\Mapping as GRID;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * ActionItem
 *
 * @ORM\MappedSuperclass
 *
 */
abstract class ActionItem extends ConstructionSitePhoto
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @GRID\Column(operatorsVisible=false, visible=true, filterable=true, sortable=true)
     */
    protected $id;

    /**
     * @var string
     *
     * @GRID\Column(operatorsVisible=false, title="ZIMZIMActionItem.name", filter="select",  selectFrom="source")
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     *
     * @GRID\Column(operatorsVisible=false, visible=false, filterable=false, title="ZIMZIMActionItem.text")
     *
     * @ORM\Column(name="text", type="text")
     */
    protected $text;

    /**
     * @var TypeActionItem
     *
     * @GRID\Column(operatorsVisible=false, field="typeActionItem.name", title="ZIMZIMActionItem.typeActionItem")
     *
     * @ORM\ManyToOne(targetEntity="TypeActionItem")
     * @ORM\JoinColumn(name="id_type_action_item", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $typeActionItem;

    /**
     * @var ConstructionSite
     *
     * @GRID\Column(operatorsVisible=false, field="constructionSite.name", title="ZIMZIMActionItem.constructionSite")
     *
     * @Gedmo\SortableGroup
     *
     * @ORM\ManyToOne(targetEntity="ConstructionSite", inversedBy="actionItems")
     * @ORM\JoinColumn(name="id_construction_site", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $constructionSite;

    /**
     * @Gedmo\SortablePosition
     *
     * @GRID\Column(operatorsVisible=false, title="ZIMZIMActionItem.position")
     *
     * @ORM\Column(name="position", type="integer")
     */
    protected $position;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

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

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    public function __toString(){
        return $this->name;
    }
}