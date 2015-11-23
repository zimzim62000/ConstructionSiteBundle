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
 *
 */
abstract class ConstructionSitePhoto implements ApyDataGridFilePathInterface
{
    /**
     * @ORM\Column(name="updatedFiles", type="datetime")
     * @GRID\Column(operatorsVisible=false, visible=false)
     */
    public $updatedFiles;

    protected function getUploadDir()
    {
        return "";
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }


    /* !!!!!!!!!!!!! PHOTO BEFORE !!!!!!!!!!!!! */
    /**
     * @Assert\Image(maxSize="200000", maxWidth="1024", maxHeight="1024", mimeTypes={"image/jpg", "image/gif", "image/png", "image/jpeg"})
     */
    public $fileBefore;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @GRID\Column(operatorsVisible=false, filterable=false, sortable=false, safe=false, title="ZIMZIMConstructionSite.filebefore")
     */
    public $pathBefore;


    public function getAbsolutePathBefore()
    {
        return null === $this->pathBefore ? null : $this->getUploadRootDir().'/'.$this->pathBefore;
    }

    public function getWebPathBefore()
    {
        return null === $this->pathBefore ? null : $this->getUploadDir().'/'.$this->pathBefore;
    }




    /* !!!!!!!!!!!!! PHOTO PENDING!!!!!!!!!!!!! */
    /**
     * @Assert\Image(maxSize="200000", maxWidth="1024", maxHeight="1024", mimeTypes={"image/jpg", "image/gif", "image/png", "image/jpeg"})
     */
    public $filePending;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @GRID\Column(operatorsVisible=false, filterable=false, sortable=false, safe=false, title="ZIMZIMConstructionSite.filepending")
     */
    public $pathPending;


    public function getAbsolutePathPending()
    {
        return null === $this->pathPending ? null : $this->getUploadRootDir().'/'.$this->pathPending;
    }

    public function getWebPathPending()
    {
        return null === $this->pathPending ? null : $this->getUploadDir().'/'.$this->pathPending;
    }




    /* !!!!!!!!!!!!! PHOTO AFTER !!!!!!!!!!!!! */
    /**
     * @Assert\Image(maxSize="200000", maxWidth="1024", maxHeight="1024", mimeTypes={"image/jpg", "image/gif", "image/png", "image/jpeg"})
     */
    public $fileAfter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @GRID\Column(operatorsVisible=false,filterable=false, sortable=false, safe=false, title="ZIMZIMConstructionSite.fileafter")
     */
    public $pathAfter;


    public function getAbsolutePathAfter()
    {
        return null === $this->pathAfter ? null : $this->getUploadRootDir().'/'.$this->pathAfter;
    }

    public function getWebPathAfter()
    {
        return null === $this->pathAfter ? null : $this->getUploadDir().'/'.$this->pathAfter;
    }


    /**
     * @ORM\PostPersist()
     */
    public function createDir()
    {
        if (!file_exists($this->getUploadRootDir())) {
            mkdir($this->getUploadRootDir(), 0777);
        }
        $this->upload();
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        $this->updatedFiles = new \DateTime('now');

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
     * @ORM\PreRemove()
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

        return urlencode($filename).'-'.$random.'.'.$file->guessExtension();
    }

    /**
     * @return mixed
     */
    public function getUpdatedFiles()
    {
        return $this->updatedFiles;
    }

    /**
     * @param mixed $updatedFiles
     */
    public function setUpdatedFiles($updatedFiles)
    {
        $this->updatedFiles = $updatedFiles;

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
}