<?php

namespace AppBundle\Document;

use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass="AppBundle\Repository\CommentRepository")
 * @MongoDB\HasLifecycleCallbacks()
 */
class Comment
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    /**
     * @MongoDB\String
     * @var string
     */
    protected $message;

    /**
     * @MongoDB\ReferenceOne(targetDocument="User")
     * @var User
     */
    protected $author;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Task", inversedBy="comments")
     * @var Task
     */
    protected $task;

    /**
     * @MongoDB\String
     * @var string
     */
    protected $created;

    /**
     * @MongoDB\String
     * @var string
     */
    protected $updated;

    /**
     * @MongoDB\Hash)
     * @var array
     */
    protected $log;

    /**
     * @MongoDB\prePersist
     */
    public function prePersist()
    {
        $this->setCreated((new DateTime())->format('Y-m-d H:i:s'));
    }

    /**
     * @MongoDB\PreUpdate()
     */
    public function preUpdate()
    {
        $this->setUpdated((new DateTime())->format('Y-m-d H:i:s'));
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Comment
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Comment
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param User $author
     * @return Comment
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return Task
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @param Task $task
     * @return Comment
     */
    public function setTask($task)
    {
        $this->task = $task;
        return $this;
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
     * @return Comment
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return string
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param string $updated
     * @return Comment
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * @return array
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * @param array $log
     * @return Comment
     */
    public function setLog($log)
    {
        $this->log = $log;
        return $this;
    }
}
