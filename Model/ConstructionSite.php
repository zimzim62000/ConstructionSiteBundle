<?php

namespace ZIMZIM\ConstructionSiteBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use APY\DataGridBundle\Grid\Mapping as GRID;
use Symfony\Component\Validator\Constraints as Assert;
use ZIMZIM\ToolsBundle\Model\MetaSEO;

/**
 * ConstructionSite
 *
 * @ORM\MappedSuperclass
 *
 */

abstract class ConstructionSite extends ConstructionSitePhoto
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @GRID\Column(operatorsVisible=false, visible=false, filterable=false)
     */
    protected $id;

    /**
     * @var string
     *
     * @GRID\Column(operatorsVisible=false, title="ZIMZIMConstructionSite.name", filter="select",  selectFrom="source")
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     *
     * @GRID\Column(operatorsVisible=false, visible=false, filterable=false, title="ZIMZIMConstructionSite.text")
     *
     * @ORM\Column(name="text", type="text")
     */
    protected $text;


    /**
     * @var string
     *
     * @GRID\Column(operatorsVisible=false, visible=false, filterable=false, title="ZIMZIMConstructionSite.city")
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    protected $city;

    /**
     * @var \Date
     *
     * @GRID\Column(operatorsVisible=false, filterable=false, title="ZIMZIMConstructionSite.date")
     *
     * @ORM\Column(name="date", type="date")
     */
    protected $date;

    /**
     * @var String
     *
     * @GRID\Column(operatorsVisible=false, visible=false, filterable=false, title="ZIMZIMConstructionSite.duration")
     *
     * @ORM\Column(name="duration", type="string", length=255)
     */
    protected $duration;

    /**
     * @var \DateTime
     *
     * @GRID\Column(operatorsVisible=false, visible=false, filterable=false, title="ZIMZIMConstructionSite.created_at")
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

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
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return \Date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \Date $date
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return String
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param String $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFileBefore()
    {
        return $this->fileBefore;
    }

    /**
     * @param mixed $fileBefore
     */
    public function setFileBefore($fileBefore)
    {
        $this->fileBefore = $fileBefore;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPathBefore()
    {
        return $this->pathBefore;
    }

    /**
     * @param mixed $pathBefore
     */
    public function setPathBefore($pathBefore)
    {
        $this->pathBefore = $pathBefore;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFilePending()
    {
        return $this->filePending;
    }

    /**
     * @param mixed $filePending
     */
    public function setFilePending($filePending)
    {
        $this->filePending = $filePending;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPathPending()
    {
        return $this->pathPending;
    }

    /**
     * @param mixed $pathPending
     */
    public function setPathPending($pathPending)
    {
        $this->pathPending = $pathPending;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFileAfter()
    {
        return $this->fileAfter;
    }

    /**
     * @param mixed $fileAfter
     */
    public function setFileAfter($fileAfter)
    {
        $this->fileAfter = $fileAfter;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPathAfter()
    {
        return $this->pathAfter;
    }

    /**
     * @param mixed $pathAfter
     */
    public function setPathAfter($pathAfter)
    {
        $this->pathAfter = $pathAfter;

        return $this;
    }

    use MetaSEO;
}
