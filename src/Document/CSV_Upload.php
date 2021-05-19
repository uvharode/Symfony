<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

use DateTimeInterface;

/**
 * @MongoDB\Document
 */
class CSV_Upload
{
    /**
     * @MongoDB\Id
     * */
    protected $id;
    /**@MongoDB\Field(type="string")*/
    protected $filename;
    /**@MongoDB\Field(type="date")*/
    protected $uploadDate;
    /**@MongoDB\Field(type="file")*/
    protected $file_content;
    /**@MongoDB\Field(type="int")*/
    protected $length;
    /**@MongoDB\Field(type="int")*/
    protected $chunkSize;
    /**@MongoDB\Field(type="string")*/
    protected $md5;

    public function getId()
    {
        return $this->id;
    }

    public function getFileName()
    {
        return $this->filename;
    }
    public function setFileName(string $filename)
    {
        $this->filename = $filename;
        return $this;
    }

    public function getFileContent()
    {
        return $this->file_content;
    }
    public function setFileContent($file_content)
    {
        $this->file_content = $file_content;
        return $this;
    }
    public function getChunkSize()
    {
        return $this->chunkSize;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function getMd5()
    {
        return $this->md5;
    }

    public function getUploadDate()
    {
        return $this->uploadDate;
    }
    
}