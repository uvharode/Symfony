<?php

namespace App\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="csv")
 */
class CSV_Upload
{

    /**
     * @MongoDB\Id
     */
    protected $id;
    /** @MongoDB\Field(type="hash") */
    protected $file_content;
    /** @MongoDB\Field(type="string") */
    protected $filename;
    /** @MongoDB\Field(type="string") */
    protected $uplodedBy;
      
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

        // $file_content = $this->file_content;
        // if($file_content != NULL){
        //     return explode(" ",$file_content);
        // }
        // else {
        //     return $this->file_content;
        // }
    }
    public function setFileContent($file_content)
    {
        $this->file_content = $file_content;
        return $this;
    }

    public function getUploadedBy()
    {
        return $this->uplodedBy;
    }
    public function setUploadedBy(string $uplodedBy)
    {
        $this->uplodedBy = $uplodedBy;
        return $this;
    }
   
    
}