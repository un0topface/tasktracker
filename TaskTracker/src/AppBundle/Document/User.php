<?php

namespace AppBundle\Document;

use DateTime;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 * @MongoDB\HasLifecycleCallbacks()
 * @MongoDB\Document(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    /**
     * @MongoDB\String
     * @var string
     */
    protected $fullName;

    /**
     * @MongoDB\String
     * @var string
     */
    protected $created;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @MongoDB\prePersist
     */
    public function prePersist()
    {
        $this->setCreated((new DateTime())->format('Y-m-d H:i:s'));
    }

    /**
     * @return string
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param string $created
     * @return $this
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     * @return $this
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }
}
