<?php

namespace Pz\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Pz\ORM\ORM")
 * @ORM\Table(name="contents")
 */
class Content {
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=256)
	 */
	protected $slug;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $modelId;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $active;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $rank;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $parentId;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $added;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $modified;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $date1;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $date2;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $date3;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $date4;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $date5;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $date6;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $date7;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $date8;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $date9;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $date10;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $date11;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $date12;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $date13;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $date14;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $date15;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $date16;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $date17;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $date18;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $date19;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $date20;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text1;

	/**
	 * @ORM\Column(type="text")
	 */
	protected $text2;

	/**
	 * @ORM\Column(type="text")
	 */
	protected $text3;

	/**
	 * @ORM\Column(type="text")
	 */
	protected $text4;

	/**
	 * @ORM\Column(type="text")
	 */
	protected $text5;

	/**
	 * @ORM\Column(type="text")
	 */
	protected $text6;

	/**
	 * @ORM\Column(type="text")
	 */
	protected $text7;

	/**
	 * @ORM\Column(type="text")
	 */
	protected $text8;

	/**
	 * @ORM\Column(type="text")
	 */
	protected $text9;

	/**
	 * @ORM\Column(type="text")
	 */
	protected $text10;

	/**
	 * @ORM\Column(type="text")
	 */
	protected $text11;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text12;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text13;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text14;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text15;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text16;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text17;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text18;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text19;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text20;
	

	/**
	 * @ORM\Column(type="text")
	 */
	protected $text21;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text22;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text23;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text24;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text25;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text26;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text27;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text28;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text29;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text30;
	

	/**
	 * @ORM\Column(type="text")
	 */
	protected $text31;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text32;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text33;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text34;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text35;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text36;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text37;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text38;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text39;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text40;

	/**
	 * @ORM\Column(type="text")
	 */
	protected $text41;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text42;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text43;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text44;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text45;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text46;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text47;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text48;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text49;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $text50;


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
     * Set slug
     *
     * @param string $slug
     * @return Content
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set modelId
     *
     * @param integer $modelId
     * @return Content
     */
    public function setModelId($modelId)
    {
        $this->modelId = $modelId;
    
        return $this;
    }

    /**
     * Get modelId
     *
     * @return integer 
     */
    public function getModelId()
    {
        return $this->modelId;
    }

    /**
     * Set active
     *
     * @param integer $active
     * @return Content
     */
    public function setActive($active)
    {
        $this->active = $active;
    
        return $this;
    }

    /**
     * Get active
     *
     * @return integer 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     * @return Content
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
     * Set parentId
     *
     * @param integer $parentId
     * @return Content
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    
        return $this;
    }

    /**
     * Get parentId
     *
     * @return integer 
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set added
     *
     * @param \DateTime $added
     * @return Content
     */
    public function setAdded($added)
    {
        $this->added = $added;
    
        return $this;
    }

    /**
     * Get added
     *
     * @return \DateTime 
     */
    public function getAdded()
    {
        return $this->added;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     * @return Content
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
    
        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime 
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Set date1
     *
     * @param \DateTime $date1
     * @return Content
     */
    public function setDate1($date1)
    {
        $this->date1 = $date1;
    
        return $this;
    }

    /**
     * Get date1
     *
     * @return \DateTime 
     */
    public function getDate1()
    {
        return $this->date1;
    }

    /**
     * Set date2
     *
     * @param \DateTime $date2
     * @return Content
     */
    public function setDate2($date2)
    {
        $this->date2 = $date2;
    
        return $this;
    }

    /**
     * Get date2
     *
     * @return \DateTime 
     */
    public function getDate2()
    {
        return $this->date2;
    }

    /**
     * Set date3
     *
     * @param \DateTime $date3
     * @return Content
     */
    public function setDate3($date3)
    {
        $this->date3 = $date3;
    
        return $this;
    }

    /**
     * Get date3
     *
     * @return \DateTime 
     */
    public function getDate3()
    {
        return $this->date3;
    }

    /**
     * Set date4
     *
     * @param \DateTime $date4
     * @return Content
     */
    public function setDate4($date4)
    {
        $this->date4 = $date4;
    
        return $this;
    }

    /**
     * Get date4
     *
     * @return \DateTime 
     */
    public function getDate4()
    {
        return $this->date4;
    }

    /**
     * Set date5
     *
     * @param \DateTime $date5
     * @return Content
     */
    public function setDate5($date5)
    {
        $this->date5 = $date5;
    
        return $this;
    }

    /**
     * Get date5
     *
     * @return \DateTime 
     */
    public function getDate5()
    {
        return $this->date5;
    }

    /**
     * Set date6
     *
     * @param \DateTime $date6
     * @return Content
     */
    public function setDate6($date6)
    {
        $this->date6 = $date6;
    
        return $this;
    }

    /**
     * Get date6
     *
     * @return \DateTime 
     */
    public function getDate6()
    {
        return $this->date6;
    }

    /**
     * Set date7
     *
     * @param \DateTime $date7
     * @return Content
     */
    public function setDate7($date7)
    {
        $this->date7 = $date7;
    
        return $this;
    }

    /**
     * Get date7
     *
     * @return \DateTime 
     */
    public function getDate7()
    {
        return $this->date7;
    }

    /**
     * Set date8
     *
     * @param \DateTime $date8
     * @return Content
     */
    public function setDate8($date8)
    {
        $this->date8 = $date8;
    
        return $this;
    }

    /**
     * Get date8
     *
     * @return \DateTime 
     */
    public function getDate8()
    {
        return $this->date8;
    }

    /**
     * Set date9
     *
     * @param \DateTime $date9
     * @return Content
     */
    public function setDate9($date9)
    {
        $this->date9 = $date9;
    
        return $this;
    }

    /**
     * Get date9
     *
     * @return \DateTime 
     */
    public function getDate9()
    {
        return $this->date9;
    }

    /**
     * Set date10
     *
     * @param \DateTime $date10
     * @return Content
     */
    public function setDate10($date10)
    {
        $this->date10 = $date10;
    
        return $this;
    }

    /**
     * Get date10
     *
     * @return \DateTime 
     */
    public function getDate10()
    {
        return $this->date10;
    }

    /**
     * Set date11
     *
     * @param \DateTime $date11
     * @return Content
     */
    public function setDate11($date11)
    {
        $this->date11 = $date11;
    
        return $this;
    }

    /**
     * Get date11
     *
     * @return \DateTime 
     */
    public function getDate11()
    {
        return $this->date11;
    }

    /**
     * Set date12
     *
     * @param \DateTime $date12
     * @return Content
     */
    public function setDate12($date12)
    {
        $this->date12 = $date12;
    
        return $this;
    }

    /**
     * Get date12
     *
     * @return \DateTime 
     */
    public function getDate12()
    {
        return $this->date12;
    }

    /**
     * Set date13
     *
     * @param \DateTime $date13
     * @return Content
     */
    public function setDate13($date13)
    {
        $this->date13 = $date13;
    
        return $this;
    }

    /**
     * Get date13
     *
     * @return \DateTime 
     */
    public function getDate13()
    {
        return $this->date13;
    }

    /**
     * Set date14
     *
     * @param \DateTime $date14
     * @return Content
     */
    public function setDate14($date14)
    {
        $this->date14 = $date14;
    
        return $this;
    }

    /**
     * Get date14
     *
     * @return \DateTime 
     */
    public function getDate14()
    {
        return $this->date14;
    }

    /**
     * Set date15
     *
     * @param \DateTime $date15
     * @return Content
     */
    public function setDate15($date15)
    {
        $this->date15 = $date15;
    
        return $this;
    }

    /**
     * Get date15
     *
     * @return \DateTime 
     */
    public function getDate15()
    {
        return $this->date15;
    }

    /**
     * Set date16
     *
     * @param \DateTime $date16
     * @return Content
     */
    public function setDate16($date16)
    {
        $this->date16 = $date16;
    
        return $this;
    }

    /**
     * Get date16
     *
     * @return \DateTime 
     */
    public function getDate16()
    {
        return $this->date16;
    }

    /**
     * Set date17
     *
     * @param \DateTime $date17
     * @return Content
     */
    public function setDate17($date17)
    {
        $this->date17 = $date17;
    
        return $this;
    }

    /**
     * Get date17
     *
     * @return \DateTime 
     */
    public function getDate17()
    {
        return $this->date17;
    }

    /**
     * Set date18
     *
     * @param \DateTime $date18
     * @return Content
     */
    public function setDate18($date18)
    {
        $this->date18 = $date18;
    
        return $this;
    }

    /**
     * Get date18
     *
     * @return \DateTime 
     */
    public function getDate18()
    {
        return $this->date18;
    }

    /**
     * Set date19
     *
     * @param \DateTime $date19
     * @return Content
     */
    public function setDate19($date19)
    {
        $this->date19 = $date19;
    
        return $this;
    }

    /**
     * Get date19
     *
     * @return \DateTime 
     */
    public function getDate19()
    {
        return $this->date19;
    }

    /**
     * Set date20
     *
     * @param \DateTime $date20
     * @return Content
     */
    public function setDate20($date20)
    {
        $this->date20 = $date20;
    
        return $this;
    }

    /**
     * Get date20
     *
     * @return \DateTime 
     */
    public function getDate20()
    {
        return $this->date20;
    }

    /**
     * Set text1
     *
     * @param string $text1
     * @return Content
     */
    public function setText1($text1)
    {
        $this->text1 = $text1;
    
        return $this;
    }

    /**
     * Get text1
     *
     * @return string 
     */
    public function getText1()
    {
        return $this->text1;
    }

    /**
     * Set text2
     *
     * @param string $text2
     * @return Content
     */
    public function setText2($text2)
    {
        $this->text2 = $text2;
    
        return $this;
    }

    /**
     * Get text2
     *
     * @return string 
     */
    public function getText2()
    {
        return $this->text2;
    }

    /**
     * Set text3
     *
     * @param string $text3
     * @return Content
     */
    public function setText3($text3)
    {
        $this->text3 = $text3;
    
        return $this;
    }

    /**
     * Get text3
     *
     * @return string 
     */
    public function getText3()
    {
        return $this->text3;
    }

    /**
     * Set text4
     *
     * @param string $text4
     * @return Content
     */
    public function setText4($text4)
    {
        $this->text4 = $text4;
    
        return $this;
    }

    /**
     * Get text4
     *
     * @return string 
     */
    public function getText4()
    {
        return $this->text4;
    }

    /**
     * Set text5
     *
     * @param string $text5
     * @return Content
     */
    public function setText5($text5)
    {
        $this->text5 = $text5;
    
        return $this;
    }

    /**
     * Get text5
     *
     * @return string 
     */
    public function getText5()
    {
        return $this->text5;
    }

    /**
     * Set text6
     *
     * @param string $text6
     * @return Content
     */
    public function setText6($text6)
    {
        $this->text6 = $text6;
    
        return $this;
    }

    /**
     * Get text6
     *
     * @return string 
     */
    public function getText6()
    {
        return $this->text6;
    }

    /**
     * Set text7
     *
     * @param string $text7
     * @return Content
     */
    public function setText7($text7)
    {
        $this->text7 = $text7;
    
        return $this;
    }

    /**
     * Get text7
     *
     * @return string 
     */
    public function getText7()
    {
        return $this->text7;
    }

    /**
     * Set text8
     *
     * @param string $text8
     * @return Content
     */
    public function setText8($text8)
    {
        $this->text8 = $text8;
    
        return $this;
    }

    /**
     * Get text8
     *
     * @return string 
     */
    public function getText8()
    {
        return $this->text8;
    }

    /**
     * Set text9
     *
     * @param string $text9
     * @return Content
     */
    public function setText9($text9)
    {
        $this->text9 = $text9;
    
        return $this;
    }

    /**
     * Get text9
     *
     * @return string 
     */
    public function getText9()
    {
        return $this->text9;
    }

    /**
     * Set text10
     *
     * @param string $text10
     * @return Content
     */
    public function setText10($text10)
    {
        $this->text10 = $text10;
    
        return $this;
    }

    /**
     * Get text10
     *
     * @return string 
     */
    public function getText10()
    {
        return $this->text10;
    }

    /**
     * Set text11
     *
     * @param string $text11
     * @return Content
     */
    public function setText11($text11)
    {
        $this->text11 = $text11;
    
        return $this;
    }

    /**
     * Get text11
     *
     * @return string 
     */
    public function getText11()
    {
        return $this->text11;
    }

    /**
     * Set text12
     *
     * @param string $text12
     * @return Content
     */
    public function setText12($text12)
    {
        $this->text12 = $text12;
    
        return $this;
    }

    /**
     * Get text12
     *
     * @return string 
     */
    public function getText12()
    {
        return $this->text12;
    }

    /**
     * Set text13
     *
     * @param string $text13
     * @return Content
     */
    public function setText13($text13)
    {
        $this->text13 = $text13;
    
        return $this;
    }

    /**
     * Get text13
     *
     * @return string 
     */
    public function getText13()
    {
        return $this->text13;
    }

    /**
     * Set text14
     *
     * @param string $text14
     * @return Content
     */
    public function setText14($text14)
    {
        $this->text14 = $text14;
    
        return $this;
    }

    /**
     * Get text14
     *
     * @return string 
     */
    public function getText14()
    {
        return $this->text14;
    }

    /**
     * Set text15
     *
     * @param string $text15
     * @return Content
     */
    public function setText15($text15)
    {
        $this->text15 = $text15;
    
        return $this;
    }

    /**
     * Get text15
     *
     * @return string 
     */
    public function getText15()
    {
        return $this->text15;
    }

    /**
     * Set text16
     *
     * @param string $text16
     * @return Content
     */
    public function setText16($text16)
    {
        $this->text16 = $text16;
    
        return $this;
    }

    /**
     * Get text16
     *
     * @return string 
     */
    public function getText16()
    {
        return $this->text16;
    }

    /**
     * Set text17
     *
     * @param string $text17
     * @return Content
     */
    public function setText17($text17)
    {
        $this->text17 = $text17;
    
        return $this;
    }

    /**
     * Get text17
     *
     * @return string 
     */
    public function getText17()
    {
        return $this->text17;
    }

    /**
     * Set text18
     *
     * @param string $text18
     * @return Content
     */
    public function setText18($text18)
    {
        $this->text18 = $text18;
    
        return $this;
    }

    /**
     * Get text18
     *
     * @return string 
     */
    public function getText18()
    {
        return $this->text18;
    }

    /**
     * Set text19
     *
     * @param string $text19
     * @return Content
     */
    public function setText19($text19)
    {
        $this->text19 = $text19;
    
        return $this;
    }

    /**
     * Get text19
     *
     * @return string 
     */
    public function getText19()
    {
        return $this->text19;
    }

    /**
     * Set text20
     *
     * @param string $text20
     * @return Content
     */
    public function setText20($text20)
    {
        $this->text20 = $text20;
    
        return $this;
    }

    /**
     * Get text20
     *
     * @return string 
     */
    public function getText20()
    {
        return $this->text20;
    }

    /**
     * Set text21
     *
     * @param string $text21
     * @return Content
     */
    public function setText21($text21)
    {
        $this->text21 = $text21;
    
        return $this;
    }

    /**
     * Get text21
     *
     * @return string 
     */
    public function getText21()
    {
        return $this->text21;
    }

    /**
     * Set text22
     *
     * @param string $text22
     * @return Content
     */
    public function setText22($text22)
    {
        $this->text22 = $text22;
    
        return $this;
    }

    /**
     * Get text22
     *
     * @return string 
     */
    public function getText22()
    {
        return $this->text22;
    }

    /**
     * Set text23
     *
     * @param string $text23
     * @return Content
     */
    public function setText23($text23)
    {
        $this->text23 = $text23;
    
        return $this;
    }

    /**
     * Get text23
     *
     * @return string 
     */
    public function getText23()
    {
        return $this->text23;
    }

    /**
     * Set text24
     *
     * @param string $text24
     * @return Content
     */
    public function setText24($text24)
    {
        $this->text24 = $text24;
    
        return $this;
    }

    /**
     * Get text24
     *
     * @return string 
     */
    public function getText24()
    {
        return $this->text24;
    }

    /**
     * Set text25
     *
     * @param string $text25
     * @return Content
     */
    public function setText25($text25)
    {
        $this->text25 = $text25;
    
        return $this;
    }

    /**
     * Get text25
     *
     * @return string 
     */
    public function getText25()
    {
        return $this->text25;
    }

    /**
     * Set text26
     *
     * @param string $text26
     * @return Content
     */
    public function setText26($text26)
    {
        $this->text26 = $text26;
    
        return $this;
    }

    /**
     * Get text26
     *
     * @return string 
     */
    public function getText26()
    {
        return $this->text26;
    }

    /**
     * Set text27
     *
     * @param string $text27
     * @return Content
     */
    public function setText27($text27)
    {
        $this->text27 = $text27;
    
        return $this;
    }

    /**
     * Get text27
     *
     * @return string 
     */
    public function getText27()
    {
        return $this->text27;
    }

    /**
     * Set text28
     *
     * @param string $text28
     * @return Content
     */
    public function setText28($text28)
    {
        $this->text28 = $text28;
    
        return $this;
    }

    /**
     * Get text28
     *
     * @return string 
     */
    public function getText28()
    {
        return $this->text28;
    }

    /**
     * Set text29
     *
     * @param string $text29
     * @return Content
     */
    public function setText29($text29)
    {
        $this->text29 = $text29;
    
        return $this;
    }

    /**
     * Get text29
     *
     * @return string 
     */
    public function getText29()
    {
        return $this->text29;
    }

    /**
     * Set text30
     *
     * @param string $text30
     * @return Content
     */
    public function setText30($text30)
    {
        $this->text30 = $text30;
    
        return $this;
    }

    /**
     * Get text30
     *
     * @return string 
     */
    public function getText30()
    {
        return $this->text30;
    }

    /**
     * Set text31
     *
     * @param string $text31
     * @return Content
     */
    public function setText31($text31)
    {
        $this->text31 = $text31;
    
        return $this;
    }

    /**
     * Get text31
     *
     * @return string 
     */
    public function getText31()
    {
        return $this->text31;
    }

    /**
     * Set text32
     *
     * @param string $text32
     * @return Content
     */
    public function setText32($text32)
    {
        $this->text32 = $text32;
    
        return $this;
    }

    /**
     * Get text32
     *
     * @return string 
     */
    public function getText32()
    {
        return $this->text32;
    }

    /**
     * Set text33
     *
     * @param string $text33
     * @return Content
     */
    public function setText33($text33)
    {
        $this->text33 = $text33;
    
        return $this;
    }

    /**
     * Get text33
     *
     * @return string 
     */
    public function getText33()
    {
        return $this->text33;
    }

    /**
     * Set text34
     *
     * @param string $text34
     * @return Content
     */
    public function setText34($text34)
    {
        $this->text34 = $text34;
    
        return $this;
    }

    /**
     * Get text34
     *
     * @return string 
     */
    public function getText34()
    {
        return $this->text34;
    }

    /**
     * Set text35
     *
     * @param string $text35
     * @return Content
     */
    public function setText35($text35)
    {
        $this->text35 = $text35;
    
        return $this;
    }

    /**
     * Get text35
     *
     * @return string 
     */
    public function getText35()
    {
        return $this->text35;
    }

    /**
     * Set text36
     *
     * @param string $text36
     * @return Content
     */
    public function setText36($text36)
    {
        $this->text36 = $text36;
    
        return $this;
    }

    /**
     * Get text36
     *
     * @return string 
     */
    public function getText36()
    {
        return $this->text36;
    }

    /**
     * Set text37
     *
     * @param string $text37
     * @return Content
     */
    public function setText37($text37)
    {
        $this->text37 = $text37;
    
        return $this;
    }

    /**
     * Get text37
     *
     * @return string 
     */
    public function getText37()
    {
        return $this->text37;
    }

    /**
     * Set text38
     *
     * @param string $text38
     * @return Content
     */
    public function setText38($text38)
    {
        $this->text38 = $text38;
    
        return $this;
    }

    /**
     * Get text38
     *
     * @return string 
     */
    public function getText38()
    {
        return $this->text38;
    }

    /**
     * Set text39
     *
     * @param string $text39
     * @return Content
     */
    public function setText39($text39)
    {
        $this->text39 = $text39;
    
        return $this;
    }

    /**
     * Get text39
     *
     * @return string 
     */
    public function getText39()
    {
        return $this->text39;
    }

    /**
     * Set text40
     *
     * @param string $text40
     * @return Content
     */
    public function setText40($text40)
    {
        $this->text40 = $text40;
    
        return $this;
    }

    /**
     * Get text40
     *
     * @return string 
     */
    public function getText40()
    {
        return $this->text40;
    }

    /**
     * Set text41
     *
     * @param string $text41
     * @return Content
     */
    public function setText41($text41)
    {
        $this->text41 = $text41;
    
        return $this;
    }

    /**
     * Get text41
     *
     * @return string 
     */
    public function getText41()
    {
        return $this->text41;
    }

    /**
     * Set text42
     *
     * @param string $text42
     * @return Content
     */
    public function setText42($text42)
    {
        $this->text42 = $text42;
    
        return $this;
    }

    /**
     * Get text42
     *
     * @return string 
     */
    public function getText42()
    {
        return $this->text42;
    }

    /**
     * Set text43
     *
     * @param string $text43
     * @return Content
     */
    public function setText43($text43)
    {
        $this->text43 = $text43;
    
        return $this;
    }

    /**
     * Get text43
     *
     * @return string 
     */
    public function getText43()
    {
        return $this->text43;
    }

    /**
     * Set text44
     *
     * @param string $text44
     * @return Content
     */
    public function setText44($text44)
    {
        $this->text44 = $text44;
    
        return $this;
    }

    /**
     * Get text44
     *
     * @return string 
     */
    public function getText44()
    {
        return $this->text44;
    }

    /**
     * Set text45
     *
     * @param string $text45
     * @return Content
     */
    public function setText45($text45)
    {
        $this->text45 = $text45;
    
        return $this;
    }

    /**
     * Get text45
     *
     * @return string 
     */
    public function getText45()
    {
        return $this->text45;
    }

    /**
     * Set text46
     *
     * @param string $text46
     * @return Content
     */
    public function setText46($text46)
    {
        $this->text46 = $text46;
    
        return $this;
    }

    /**
     * Get text46
     *
     * @return string 
     */
    public function getText46()
    {
        return $this->text46;
    }

    /**
     * Set text47
     *
     * @param string $text47
     * @return Content
     */
    public function setText47($text47)
    {
        $this->text47 = $text47;
    
        return $this;
    }

    /**
     * Get text47
     *
     * @return string 
     */
    public function getText47()
    {
        return $this->text47;
    }

    /**
     * Set text48
     *
     * @param string $text48
     * @return Content
     */
    public function setText48($text48)
    {
        $this->text48 = $text48;
    
        return $this;
    }

    /**
     * Get text48
     *
     * @return string 
     */
    public function getText48()
    {
        return $this->text48;
    }

    /**
     * Set text49
     *
     * @param string $text49
     * @return Content
     */
    public function setText49($text49)
    {
        $this->text49 = $text49;
    
        return $this;
    }

    /**
     * Get text49
     *
     * @return string 
     */
    public function getText49()
    {
        return $this->text49;
    }

    /**
     * Set text50
     *
     * @param string $text50
     * @return Content
     */
    public function setText50($text50)
    {
        $this->text50 = $text50;
    
        return $this;
    }

    /**
     * Get text50
     *
     * @return string 
     */
    public function getText50()
    {
        return $this->text50;
    }
}