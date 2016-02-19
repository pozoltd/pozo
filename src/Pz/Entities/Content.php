<?php

namespace Pz\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="contents")
 */
class Content
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     */
    protected $slug;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $modelId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $rank;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $parentId;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $added;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $modified;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $startdate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $enddate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $firstdate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $lastdate;

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
     * @ORM\Column(type="text", nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $isactive;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $subtitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $shortdescription;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $category;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $subcategory;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $phone;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $mobile;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $fax;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $facebook;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $twitter;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $pinterest;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $linkedIn;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $instagram;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $qq;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $weico;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $address;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $website;


    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $author;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $authorbio;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $url;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $value;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $image;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $gallery;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $thumbnail;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $lastname;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $firstname;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $name;


    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $region;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $destination;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $excerpts;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $about;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $latitude;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $longitude;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $price;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $saleprice;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $features;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $account;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $username;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $password;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $extra1;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $extra2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $extra3;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $extra4;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $extra5;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $extra6;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $extra7;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $extra8;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $extra9;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $extra10;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $extra11;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $extra12;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $extra13;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $extra14;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $extra15;

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
     * Set isactive
     *
     * @param string $isactive
     * @return Content
     */
    public function setIsactive($isactive)
    {
        $this->isactive = $isactive;

        return $this;
    }

    /**
     * Get isactive
     *
     * @return string
     */
    public function getIsactive()
    {
        return $this->isactive;
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
     * Set startdate
     *
     * @param \DateTime $startdate
     * @return Content
     */
    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;

        return $this;
    }

    /**
     * Get startdate
     *
     * @return \DateTime
     */
    public function getStartdate()
    {
        return $this->startdate;
    }

    /**
     * Set enddate
     *
     * @param \DateTime $enddate
     * @return Content
     */
    public function setEnddate($enddate)
    {
        $this->enddate = $enddate;

        return $this;
    }

    /**
     * Get enddate
     *
     * @return \DateTime
     */
    public function getEnddate()
    {
        return $this->enddate;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Content
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set firstdate
     *
     * @param \DateTime $firstdate
     * @return Content
     */
    public function setFirstdate($firstdate)
    {
        $this->firstdate = $firstdate;

        return $this;
    }

    /**
     * Get firstdate
     *
     * @return \DateTime
     */
    public function getFirstdate()
    {
        return $this->firstdate;
    }

    /**
     * Set lastdate
     *
     * @param \DateTime $lastdate
     * @return Content
     */
    public function setLastdate($lastdate)
    {
        $this->lastdate = $lastdate;

        return $this;
    }

    /**
     * Get lastdate
     *
     * @return \DateTime
     */
    public function getLastdate()
    {
        return $this->lastdate;
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
     * Set title
     *
     * @param string $title
     * @return Content
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set subtitle
     *
     * @param string $subtitle
     * @return Content
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * Get subtitle
     *
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set shortdescription
     *
     * @param string $shortdescription
     * @return Content
     */
    public function setShortdescription($shortdescription)
    {
        $this->shortdescription = $shortdescription;

        return $this;
    }

    /**
     * Get shortdescription
     *
     * @return string
     */
    public function getShortdescription()
    {
        return $this->shortdescription;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Content
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Content
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set category
     *
     * @param string $category
     * @return Content
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set subcategory
     *
     * @param string $subcategory
     * @return Content
     */
    public function setSubcategory($subcategory)
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    /**
     * Get subcategory
     *
     * @return string
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Content
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     * @return Content
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return Content
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Content
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     * @return Content
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     * @return Content
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set pinterest
     *
     * @param string $pinterest
     * @return Content
     */
    public function setPinterest($pinterest)
    {
        $this->pinterest = $pinterest;

        return $this;
    }

    /**
     * Get pinterest
     *
     * @return string
     */
    public function getPinterest()
    {
        return $this->pinterest;
    }

    /**
     * Set linkedIn
     *
     * @param string $linkedIn
     * @return Content
     */
    public function setLinkedIn($linkedIn)
    {
        $this->linkedIn = $linkedIn;

        return $this;
    }

    /**
     * Get linkedIn
     *
     * @return string
     */
    public function getLinkedIn()
    {
        return $this->linkedIn;
    }

    /**
     * Set instagram
     *
     * @param string $instagram
     * @return Content
     */
    public function setInstagram($instagram)
    {
        $this->instagram = $instagram;

        return $this;
    }

    /**
     * Get instagram
     *
     * @return string
     */
    public function getInstagram()
    {
        return $this->instagram;
    }

    /**
     * Set qq
     *
     * @param string $qq
     * @return Content
     */
    public function setQq($qq)
    {
        $this->qq = $qq;

        return $this;
    }

    /**
     * Get qq
     *
     * @return string
     */
    public function getQq()
    {
        return $this->qq;
    }

    /**
     * Set weico
     *
     * @param string $weico
     * @return Content
     */
    public function setWeico($weico)
    {
        $this->weico = $weico;

        return $this;
    }

    /**
     * Get weico
     *
     * @return string
     */
    public function getWeico()
    {
        return $this->weico;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Content
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return Content
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Content
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set authorbio
     *
     * @param string $authorbio
     * @return Content
     */
    public function setAuthorbio($authorbio)
    {
        $this->authorbio = $authorbio;

        return $this;
    }

    /**
     * Get authorbio
     *
     * @return string
     */
    public function getAuthorbio()
    {
        return $this->authorbio;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Content
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return Content
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Content
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set gallery
     *
     * @param string $gallery
     * @return Content
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return string
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     * @return Content
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Content
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Content
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Content
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set region
     *
     * @param string $region
     * @return Content
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set destination
     *
     * @param string $destination
     * @return Content
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Set excerpts
     *
     * @param string $excerpts
     * @return Content
     */
    public function setExcerpts($excerpts)
    {
        $this->excerpts = $excerpts;

        return $this;
    }

    /**
     * Get excerpts
     *
     * @return string
     */
    public function getExcerpts()
    {
        return $this->excerpts;
    }

    /**
     * Set about
     *
     * @param string $about
     * @return Content
     */
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * Get about
     *
     * @return string
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return Content
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Content
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Content
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set saleprice
     *
     * @param string $saleprice
     * @return Content
     */
    public function setSaleprice($saleprice)
    {
        $this->saleprice = $saleprice;

        return $this;
    }

    /**
     * Get saleprice
     *
     * @return string
     */
    public function getSaleprice()
    {
        return $this->saleprice;
    }

    /**
     * Set features
     *
     * @param string $features
     * @return Content
     */
    public function setFeatures($features)
    {
        $this->features = $features;

        return $this;
    }

    /**
     * Get features
     *
     * @return string
     */
    public function getFeatures()
    {
        return $this->features;
    }

    /**
     * Set account
     *
     * @param string $account
     * @return Content
     */
    public function setAccount($account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Content
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Content
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set extra1
     *
     * @param string $extra1
     * @return Content
     */
    public function setExtra1($extra1)
    {
        $this->extra1 = $extra1;

        return $this;
    }

    /**
     * Get extra1
     *
     * @return string
     */
    public function getExtra1()
    {
        return $this->extra1;
    }

    /**
     * Set extra2
     *
     * @param string $extra2
     * @return Content
     */
    public function setExtra2($extra2)
    {
        $this->extra2 = $extra2;

        return $this;
    }

    /**
     * Get extra2
     *
     * @return string
     */
    public function getExtra2()
    {
        return $this->extra2;
    }

    /**
     * Set extra3
     *
     * @param string $extra3
     * @return Content
     */
    public function setExtra3($extra3)
    {
        $this->extra3 = $extra3;

        return $this;
    }

    /**
     * Get extra3
     *
     * @return string
     */
    public function getExtra3()
    {
        return $this->extra3;
    }

    /**
     * Set extra4
     *
     * @param string $extra4
     * @return Content
     */
    public function setExtra4($extra4)
    {
        $this->extra4 = $extra4;

        return $this;
    }

    /**
     * Get extra4
     *
     * @return string
     */
    public function getExtra4()
    {
        return $this->extra4;
    }

    /**
     * Set extra5
     *
     * @param string $extra5
     * @return Content
     */
    public function setExtra5($extra5)
    {
        $this->extra5 = $extra5;

        return $this;
    }

    /**
     * Get extra5
     *
     * @return string
     */
    public function getExtra5()
    {
        return $this->extra5;
    }

    /**
     * Set extra6
     *
     * @param string $extra6
     * @return Content
     */
    public function setExtra6($extra6)
    {
        $this->extra6 = $extra6;

        return $this;
    }

    /**
     * Get extra6
     *
     * @return string
     */
    public function getExtra6()
    {
        return $this->extra6;
    }

    /**
     * Set extra7
     *
     * @param string $extra7
     * @return Content
     */
    public function setExtra7($extra7)
    {
        $this->extra7 = $extra7;

        return $this;
    }

    /**
     * Get extra7
     *
     * @return string
     */
    public function getExtra7()
    {
        return $this->extra7;
    }

    /**
     * Set extra8
     *
     * @param string $extra8
     * @return Content
     */
    public function setExtra8($extra8)
    {
        $this->extra8 = $extra8;

        return $this;
    }

    /**
     * Get extra8
     *
     * @return string
     */
    public function getExtra8()
    {
        return $this->extra8;
    }

    /**
     * Set extra9
     *
     * @param string $extra9
     * @return Content
     */
    public function setExtra9($extra9)
    {
        $this->extra9 = $extra9;

        return $this;
    }

    /**
     * Get extra9
     *
     * @return string
     */
    public function getExtra9()
    {
        return $this->extra9;
    }

    /**
     * Set extra10
     *
     * @param string $extra10
     * @return Content
     */
    public function setExtra10($extra10)
    {
        $this->extra10 = $extra10;

        return $this;
    }

    /**
     * Get extra10
     *
     * @return string
     */
    public function getExtra10()
    {
        return $this->extra10;
    }

    /**
     * Set extra11
     *
     * @param string $extra11
     * @return Content
     */
    public function setExtra11($extra11)
    {
        $this->extra11 = $extra11;

        return $this;
    }

    /**
     * Get extra11
     *
     * @return string
     */
    public function getExtra11()
    {
        return $this->extra11;
    }

    /**
     * Set extra12
     *
     * @param string $extra12
     * @return Content
     */
    public function setExtra12($extra12)
    {
        $this->extra12 = $extra12;

        return $this;
    }

    /**
     * Get extra12
     *
     * @return string
     */
    public function getExtra12()
    {
        return $this->extra12;
    }

    /**
     * Set extra13
     *
     * @param string $extra13
     * @return Content
     */
    public function setExtra13($extra13)
    {
        $this->extra13 = $extra13;

        return $this;
    }

    /**
     * Get extra13
     *
     * @return string
     */
    public function getExtra13()
    {
        return $this->extra13;
    }

    /**
     * Set extra14
     *
     * @param string $extra14
     * @return Content
     */
    public function setExtra14($extra14)
    {
        $this->extra14 = $extra14;

        return $this;
    }

    /**
     * Get extra14
     *
     * @return string
     */
    public function getExtra14()
    {
        return $this->extra14;
    }

    /**
     * Set extra15
     *
     * @param string $extra15
     * @return Content
     */
    public function setExtra15($extra15)
    {
        $this->extra15 = $extra15;

        return $this;
    }

    /**
     * Get extra15
     *
     * @return string
     */
    public function getExtra15()
    {
        return $this->extra15;
    }
}