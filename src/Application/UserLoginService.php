<?php

namespace UserLoginService\Application;

use UserLoginService\Domain\User;
use function Sodium\add;

class UserLoginService
{
    private SessionManager $sessionManager;
    private array $loggedUsers = [];

    public function __construct(SessionManager $sessionManager)
    {
        $this->sessionManager = $sessionManager;
    }

    public function manualLogin(User $user): string
    {
        array_push($this->loggedUsers, $user);
        return "user logged";
    }

    public function getLoggedUsers(): array
    {
        return $this->loggedUsers;
    }

    public function countExternalSessions(): int
    {
        return $this->sessionManager->getSessions();
    }

    public function login(String $userName, String $password): String
    {
        if($this->sessionManager->login($userName, $password))
        {
            $user = new User($userName);
            array_push($this->loggedUsers, $user);
            return "Login correcto";
        }
        else
            return "Login incorrecto";

    }

}