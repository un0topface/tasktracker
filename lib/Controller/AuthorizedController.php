<?php

namespace Lib\Controller;

use Lib\Controller\Exception\NotAuthorizedException;

/**
 * Контроллер для авторизованного пользователя
 */
abstract class AuthorizedController extends BaseController {
    /**
     * @var int|null геттер userId
     */
    private $userId;

    /**
     * Геттер userId
     * @return int|null
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * AuthorizedController constructor.
     */
    public function __construct() {
        if (isset($_SESSION['userId'])) {
            $this->userId = $_SESSION['userId'];
        } else {
            throw new NotAuthorizedException();
        }
    }
}
