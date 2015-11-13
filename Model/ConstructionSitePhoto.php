<?php

namespace ZIMZIM\ConstructionSiteBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use APY\DataGridBundle\Grid\Mapping as GRID;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use ZIMZIM\ToolsBundle\Model\APYDataGrid\ApyDataGridFilePathInterface;


/**
 * ConstructionSitePhoto
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 *
 */

abstract class ConstructionSitePhoto implements ApyDataGridFilePathInterface
{

    protected function getUploadDir()
    {
        return "";
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../../../web/' . $this->getUploadDir();
    }




    /* !!!!!!!!!!!!! PHOTO BEFORE !!!!!!!!!!!!! */
    /**
     * @Assert\Image(maxSize="200000", maxWidth="500", maxHeight="500", mimeTypes={"image/jpg", "image/gif", "image/png", "image/jpeg"})
     */
    public $fileBefore;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @GRID\Column(operatorsVisible=false, safe=false, title="ZIMZIMConstructionSiteBundle.grid.filebefore")
     */
    public $pathBefore;


    public function getAbsolutePathBefore()
    {
        return null === $this->pathBefore ? null : $this->getUploadRootDir() . '/' . $this->pathBefore;
    }

    public function getWebPathBefore()
    {
        return null === $this->pathBefore ? null : $this->getUploadDir() . '/' . $this->pathBefore;
    }




    /* !!!!!!!!!!!!! PHOTO PENDING!!!!!!!!!!!!! */
    /**
     * @Assert\Image(maxSize="200000", maxWidth="500", maxHeight="500", mimeTypes={"image/jpg", "image/gif", "image/png", "image/jpeg"})
     */
    public $filePending;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @GRID\Column(operatorsVisible=false, safe=false, title="ZIMZIMConstructionSiteBundle.grid.filepending")
     */
    public $pathPending;


    public function getAbsolutePathPending()
    {
        return null === $this->pathPending ? null : $this->getUploadRootDir() . '/' . $this->pathPending;
    }

    public function getWebPathPending()
    {
        return null === $this->pathPending ? null : $this->getUploadDir() . '/' . $this->pathPending;
    }




    /* !!!!!!!!!!!!! PHOTO AFTER !!!!!!!!!!!!! */
    /**
     * @Assert\Image(maxSize="200000", maxWidth="500", maxHeight="500", mimeTypes={"image/jpg", "image/gif", "image/png", "image/jpeg"})
     */
    public $fileAfter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @GRID\Column(operatorsVisible=false, safe=false, title="ZIMZIMConstructionSiteBundle.grid.fileafter")
     */
    public $pathAfter;


    public function getAbsolutePathAfter()
    {
        return null === $this->pathAfter ? null : $this->getUploadRootDir() . '/' . $this->pathAfter;
    }

    public function getWebPathAfter()
    {
        return null === $this->pathAfter ? null : $this->getUploadDir() . '/' . $this->pathAfter;
    }


    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (isset($this->fileBefore)) {
            if (null !== $this->fileBefore) {
                $oldFile = $this->getAbsolutePathBefore();
                if ($oldFile && isset($this->pathBefore)) {
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
                $this->pathBefore = $this->createFileName($this->fileBefore);
            }
        }

        if (isset($this->filePending)) {
            if (null !== $this->filePending) {
                $oldFile = $this->getAbsolutePathPending();
                if ($oldFile && isset($this->pathPending)) {
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
                $this->pathPending = $this->createFileName($this->filePending);
            }
        }

        if (isset($this->fileAfter)) {
            if (null !== $this->fileAfter) {
                $oldFile = $this->getAbsolutePathAfter();
                if ($oldFile && isset($this->pathAfter)) {
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
                $this->pathAfter = $this->createFileName($this->fileAfter);
            }
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (isset($this->fileBefore)) {
            $this->fileBefore->move($this->getUploadRootDir(), $this->pathBefore);
            unset($this->fileBefore);
        }
        if (isset($this->filePending)) {
            $this->filePending->move($this->getUploadRootDir(), $this->pathPending);
            unset($this->filePending);
        }
        if (isset($this->fileAfter)) {
            $this->fileAfter->move($this->getUploadRootDir(), $this->pathAfter);
            unset($this->fileAfter);
        }
    }


    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePathBefore()) {
            unlink($file);
        }
        if ($file = $this->getAbsolutePathPending()) {
            unlink($file);
        }
        if ($file = $this->getAbsolutePathAfter()) {
            unlink($file);
        }
    }


    public function getListAttrImg()
    {
        return array('pathBefore', 'pathPending', 'pathAfter');
    }

    protected function createFileName(UploadedFile $file)
    {
        $random = rand(1, 1000);
        $extension = strrchr($file->getClientOriginalName(), '.');
        $filename = str_replace($extension, '', $file->getClientOriginalName());
        return urlencode($filename) . '-' . $random . '.' . $file->guessExtension();
    }
}