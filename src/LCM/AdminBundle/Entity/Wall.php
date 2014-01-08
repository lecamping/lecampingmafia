<?php

namespace LCM\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wall
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Wall
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
     * @ORM\Column(name="said", type="text")
     */
    private $said;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="day", type="datetime")
     */
    private $day;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="wallmsg")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;


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
     * Set said
     *
     * @param string $said
     * @return Wall
     */
    public function setSaid($said)
    {
        $this->said = $said;
    
        return $this;
    }

    /**
     * Get said
     *
     * @return string 
     */
    public function getSaid()
    {
        return $this->said;
    }

    /**
     * Set day
     *
     * @param \DateTime $day
     * @return Wall
     */
    public function setDay($day)
    {
        $this->day = $day;
    
        return $this;
    }

    /**
     * Get day
     *
     * @return \DateTime 
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set user
     *
     * @param \LCM\AdminBundle\Entity\User $user
     * @return Wall
     */
    public function setUser(\LCM\AdminBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \LCM\AdminBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}