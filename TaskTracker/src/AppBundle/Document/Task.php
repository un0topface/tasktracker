<?php

namespace AppBundle\Document;

use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass="AppBundle\Repository\TaskRepository")
 * @MongoDB\HasLifecycleCallbacks()
 */
class Task
{
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
     * @MongoDB\ReferenceOne(targetDocument="Project")
     * @var Project
     */
    protected $project;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Comment", mappedBy="task", sort={"created": "ASC"})
     * @var Comment[]
     */
    protected $comments;

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
     * @MongoDB\Float
     * @var float
     */
    protected $timeHoursEstimate;

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
     * @MongoDB\String
     * @var string
     */
    protected $status;

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
     * @return array
     * @see $this->status
     */
    public function getAvailableStatuses()
    {
        $statuses = [
            'new'           => 'Новая',
            'in_progress'   => 'Выполняется',
            'postponed'     => 'Отложена',
            'closed'        => 'Закрыта',
            'denied'        => 'Отклонена',
        ];

        return $statuses;
    }

    /**
     * @param string $key
     * @return string
     */
    public function getFieldTranslation($key)
    {
        return [
            'title'             =>  'Название',
            'timeHoursEstimate' =>  'Оценка времени',
            'priorityLevel'     =>  'Приоритет',
            'progress'          =>  'Готовность',
            'deadLine'          =>  'Крайний срок',
            'status'            =>  'Статус',
            'customer'          =>  'Заказчик',
            'performer'         =>  'Исполнитель',
        ][$key];
    }

    /**
     * Task constructor.
     */
    public function __construct()
    {
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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Task
     */
    public function setId($id)
    {
        $this->id = $id;

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
     * @return Task
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * @param string $deadline
     * @return Task
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Task
     */
    public function setTitle($title)
    {
        $this->title = $title;

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
     * @return Task
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return User
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param User $customer
     * @return $this
     */
    public function setCustomer($customer)
    {
        if ($customer instanceof User) {
            $this->customer = $customer;
        }

        return $this;
    }

    /**
     * @return User
     */
    public function getPerformer()
    {
        return $this->performer;
    }

    /**
     * @param User $performer
     * @return $this
     */
    public function setPerformer($performer)
    {
        if ($performer instanceof User) {
            $this->performer = $performer;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getPriorityLevel()
    {
        if (empty($this->priorityLevel)) {
            return 3;
        }

        return $this->priorityLevel;
    }

    /**
     * @param int $priorityLevel
     * @return $this
     */
    public function setPriorityLevel($priorityLevel)
    {
        $this->priorityLevel = $priorityLevel;

        return $this;
    }

    /**
     * @return int
     */
    public function getProgress()
    {
        return $this->progress;
    }

    /**
     * @param int $progress
     * @return $this
     */
    public function setProgress($progress)
    {
        $this->progress = min(max(0, $progress), 100);

        return $this;
    }

    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param Project $project
     * @return Task
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return float
     */
    public function getTimeHoursEstimate()
    {
        return $this->timeHoursEstimate;
    }

    /**
     * @param float $timeHoursEstimate
     * @return Task
     */
    public function setTimeHoursEstimate($timeHoursEstimate)
    {
        $this->timeHoursEstimate = $timeHoursEstimate;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        if (empty($this->status)) {
            return $this->getAvailableStatuses()['new'];
        }
        return $this->status;
    }

    /**
     * @param string $status
     * @return Task
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Comment[]
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param Comment[] $comments
     * @return Task
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * @return array
     */
    public function export()
    {
        $data =  [
             'title'             =>  $this->getTitle(),
             'timeHoursEstimate' =>  $this->getTimeHoursEstimate(),
             'priorityLevel'     =>  $this->getPriorityLevel(),
             'progress'          =>  $this->getProgress(),
             'status'            =>  $this->getStatus(),
             'deadLine'          =>  $this->getDeadline(),
        ];

        if ($this->getCustomer() instanceof User) {
            $data['customer'] = $this->getCustomer()->getFullName();
        }

        if ($this->getPerformer() instanceof User) {
            $data['performer'] = $this->getPerformer()->getFullName();
        }

        return $data;
    }
}
