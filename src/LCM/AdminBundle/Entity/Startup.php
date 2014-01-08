<?php

namespace LCM\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Startup
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Startup
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="season", type="integer")
     */
    private $season;

    /**
     * @var string
     *
     * @ORM\Column(name="pitch", type="text")
     */
    private $pitch;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255)
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=1)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="socialnetworks", type="text")
     */
    private $socialnetworks;

    /**
     * @var integer
     *
     * @ORM\ManyToMany(targetEntity="User", inversedBy="startup")
     * @ORM\JoinTable(name="user_startup")
     */
    private $founders;


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
     * Set name
     *
     * @param string $name
     * @return Startup
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
     * Set season
     *
     * @param integer $season
     * @return Startup
     */
    public function setSeason($season)
    {
        $this->season = $season;
    
        return $this;
    }

    /**
     * Get season
     *
     * @return integer 
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set pitch
     *
     * @param string $pitch
     * @return Startup
     */
    public function setPitch($pitch)
    {
        $this->pitch = $pitch;
    
        return $this;
    }

    /**
     * Get pitch
     *
     * @return string 
     */
    public function getPitch()
    {
        return $this->pitch;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return Startup
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
     * Set status
     *
     * @param string $status
     * @return Startup
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }


    public function hasFavicon()
    {
        if(!strlen($this->getWebsite())) {
            return false;
        }

        $filename = $this->getFaviconSrc();

        $curl = curl_init($filename);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        
        $result = curl_exec($curl);
        
        $ret = false;

        //
        if ($result !== false) {
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($statusCode == 200) {
                $ret = true;   
            }
        }
        curl_close($curl);
        return $ret;
    }

    public function getFacebookUrl()
    {
        $t = json_decode($this->getSocialnetworks(), true);
        return isset($t['facebook']) ? $t['facebook'] : '';
    }

    public function getTwitterUrl()
    {
        $t = json_decode($this->getSocialnetworks(), true);
        return isset($t['twitter']) ? $t['twitter'] : '';
    }

    public function getAngelistUrl()
    {
        $t = json_decode($this->getSocialnetworks(), true);
        return isset($t['angelist']) ? $t['angelist'] : '';
    }

    public function getLinkedInUrl()
    {
        $t = json_decode($this->getSocialnetworks(), true);
        return isset($t['linkedin']) ? $t['linkedin'] : '';
    }

    public function getMail()
    {
        $t = json_decode($this->getSocialnetworks(), true);
        return isset($t['mail']) ? $t['mail'] : '';
    }

    /**
     * Set faviconSrc
     *
     * @param string $faviconSrc
     * @return Startup
     */
    public function getFaviconSrc()
    {
        return $this->getWebsite().'/favicon.ico';
    }

    /**
     * Set socialnetworks
     *
     * @param string $socialnetworks
     * @return Startup
     */
    public function setSocialnetworks($socialnetworks)
    {
        $this->socialnetworks = $socialnetworks;
    
        return $this;
    }

    /**
     * Get socialnetworks
     *
     * @return string 
     */
    public function getSocialnetworks()
    {
        return $this->socialnetworks;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->founders = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString() { return $this->getName(); }
    
    /**
     * Add founders
     *
     * @param \LCM\AdminBundle\Entity\User $founders
     * @return Startup
     */
    public function addFounder(\LCM\AdminBundle\Entity\User $founders)
    {
        $this->founders[] = $founders;
    
        return $this;
    }

    /**
     * Remove founders
     *
     * @param \LCM\AdminBundle\Entity\User $founders
     */
    public function removeFounder(\LCM\AdminBundle\Entity\User $founders)
    {
        $this->founders->removeElement($founders);
    }

    /**
     * Get founders
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFounders()
    {
        return $this->founders;
    }
}