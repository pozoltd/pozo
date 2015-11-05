<?php

namespace Pz\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="models")
 */
class Model {
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $rank;
	
	/**
	 * @ORM\Column(type="string", length=128)
	 */
	protected $label;
	
	/**
	 * @ORM\Column(type="string", length=128)
	 */
	protected $className;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $modelType;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $dataType;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $listType;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $numberPerPage;
	
	/**
	 * @ORM\Column(type="string", length=128)
	 */
	protected $defaultSortBy;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $defaultOrder;

	/**
	 * @ORM\Column(type="text")
	 */
	protected $columnsJson;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     * @return _Model
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    
        return $this;
    }

    /**
     * Get rank
     *
     * @return integer 
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set label
     *
     * @param string $label
     * @return _Model
     */
    public function setLabel($label)
    {
        $this->label = $label;
    
        return $this;
    }

    /**
     * Get label
     *
     * @return string 
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set className
     *
     * @param string $className
     * @return _Model
     */
    public function setClassName($className)
    {
        $this->className = $className;
    
        return $this;
    }

    /**
     * Get className
     *
     * @return string 
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Set modelType
     *
     * @param integer $modelType
     * @return _Model
     */
    public function setModelType($modelType)
    {
        $this->modelType = $modelType;
    
        return $this;
    }

    /**
     * Get modelType
     *
     * @return integer 
     */
    public function getModelType()
    {
        return $this->modelType;
    }

    /**
     * Set dataType
     *
     * @param integer $dataType
     * @return _Model
     */
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
    
        return $this;
    }

    /**
     * Get dataType
     *
     * @return integer 
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * Set listType
     *
     * @param integer $listType
     * @return _Model
     */
    public function setListType($listType)
    {
        $this->listType = $listType;
    
        return $this;
    }

    /**
     * Get listType
     *
     * @return integer 
     */
    public function getListType()
    {
        return $this->listType;
    }

    /**
     * Set numberPerPage
     *
     * @param integer $numberPerPage
     * @return _Model
     */
    public function setNumberPerPage($numberPerPage)
    {
        $this->numberPerPage = $numberPerPage;
    
        return $this;
    }

    /**
     * Get numberPerPage
     *
     * @return integer 
     */
    public function getNumberPerPage()
    {
        return $this->numberPerPage;
    }

    /**
     * Set defaultSortBy
     *
     * @param string $defaultSortBy
     * @return _Model
     */
    public function setDefaultSortBy($defaultSortBy)
    {
        $this->defaultSortBy = $defaultSortBy;
    
        return $this;
    }

    /**
     * Get defaultSortBy
     *
     * @return string 
     */
    public function getDefaultSortBy()
    {
        return $this->defaultSortBy;
    }

    /**
     * Set columnsJson
     *
     * @param string $columnsJson
     * @return _Model
     */
    public function setColumnsJson($columnsJson)
    {
        $this->columnsJson = $columnsJson;
    
        return $this;
    }

    /**
     * Get columnsJson
     *
     * @return string 
     */
    public function getColumnsJson()
    {
        return $this->columnsJson;
    }
}