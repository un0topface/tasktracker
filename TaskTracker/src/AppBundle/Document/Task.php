<?php

namespace AppBundle\Document;

use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 * @MongoDB\HasLifecycleCallbacks()
 */
class Task {
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    /**
     * @MongoDB\String
     * @var string
     */
    protected $title;

    /**
     * @MongoDB\String
     * @var string
     */
    protected $message;

    /**
     * @MongoDB\ReferenceOne(targetDocument="User")
     * @var User
     */
    protected $customer;

    /**
     * @MongoDB\ReferenceOne(targetDocument="User")
     * @var User
     */
    protected $performer;

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
     * @MongoDB\String
     * @var string
     */
    protected $deadline;

    /**
     * @MongoDB\Integer
     * @var int
     */
    protected $priorityLevel;

    /**
     * @MongoDB\Integer
     * @var int
     */
    protected $progress;

    /**
     * @MongoDB\prePersist
     */
    public function prePersist() {
        $this->setCreated((new DateTime())->format('Y-m-d H:i:s'));
    }

    /**
     * @MongoDB\PreUpdate()
     */
    public function preUpdate() {
        $this->setUpdated((new DateTime())->format('Y-m-d H:i:s'));
    }

    /**
     * Task constructor.
     */
    public function __construct() {
        parent::__construct();
        // your own logic
    }

    /**
     * @return string
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * @param string $created
     * @return $this
     */
    public function setCreated($created) {
        $this->created = $created;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Task
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUpdated() {
        return $this->updated;
    }

    /**
     * @param string $updated
     * @return Task
     */
    public function setUpdated($updated) {
        $this->updated = $updated;
        return $this;
    }

    /**
     * @return string
     */
    public function getDeadline() {
        return $this->deadline;
    }

    /**
     * @param string $deadline
     * @return Task
     */
    public function setDeadline($deadline) {
        $this->deadline = $deadline;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Task
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Task
     */
    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    /**
     * @return User
     */
    public function getCustomer() {
        return $this->customer;
    }

    /**
     * @param User $customer
     */
    public function setCustomer($customer) {
        $this->customer = $customer;
    }

    /**
     * @return User
     */
    public function getPerformer() {
        return $this->performer;
    }

    /**
     * @param User $performer
     */
    public function setPerformer($performer) {
        $this->performer = $performer;
    }

    /**
     * @return int
     */
    public function getPriorityLevel() {
        return $this->priorityLevel;
    }

    /**
     * @param int $priorityLevel
     */
    public function setPriorityLevel($priorityLevel) {
        $this->priorityLevel = $priorityLevel;
    }

    /**
     * @return int
     */
    public function getProgress() {
        return $this->progress;
    }

    /**
     * @param int $progress
     */
    public function setProgress($progress) {
        $this->progress = $progress;
    }
}
