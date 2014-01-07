<?php

namespace LCM\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User as BaseUser;
use LCM\AdminBundle\Entity\User as User;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    protected $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    protected $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="facebookId", type="string", length=255)
     */
    protected $facebookId;

    /**
     * @ORM\ManyToMany(targetEntity="Startup", mappedBy="founders")
     */
    private $startup;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function __toString() { return $this->getEmail(); }

    public function getRoles()
    {
        $roles = parent::getRoles();
        if($this->getEmail() == "cochet@gmail.com")
            $roles[] = 'ROLE_ADMIN';
        return $roles;
    }

    
    /**
     * @param Array
     */
    public function setFBData($fbdata)
    {
        if (isset($fbdata['id'])) {
            $this->setFacebookId($fbdata['id']);
            $this->setUsername($fbdata['id']);
            $this->addRole('ROLE_FACEBOOK');
        }
        if (isset($fbdata['first_name'])) {
            $this->setFirstname($fbdata['first_name']);
        }
        if (isset($fbdata['last_name'])) {
            $this->setLastname($fbdata['last_name']);
        }
        if (isset($fbdata['email'])) {
            $this->setEmail($fbdata['email']);
        }
    }

    public function getExpiresAt() { return $this->expiresAt; }
    public function getCredentialsExpireAt() { return $this->credentialsExpireAt; }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
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
     * Set lastname
     *
     * @param string $lastname
     * @return User
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
     * Set facebookId
     *
     * @param string $facebookId
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
    
        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string 
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->startup = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add startup
     *
     * @param \LCM\AdminBundle\Entity\Startup $startup
     * @return User
     */
    public function addStartup(\LCM\AdminBundle\Entity\Startup $startup)
    {
        $this->startup[] = $startup;
    
        return $this;
    }

    /**
     * Remove startup
     *
     * @param \LCM\AdminBundle\Entity\Startup $startup
     */
    public function removeStartup(\LCM\AdminBundle\Entity\Startup $startup)
    {
        $this->startup->removeElement($startup);
    }

    /**
     * Get startup
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStartup()
    {
        return $this->startup;
    }
}