<?php

namespace UserLoginService\Tests\Doubles;

use UserLoginService\Application\SessionManager;

class MockSessionManager implements SessionManager
{

    private $times = 0;
    private $userName;
    public function __construct()
    {
    }

    public function getSessions(): int
    {
        // TODO: Implement getSessions() method.
    }

    public function login(string $userName, string $password): bool
    {
        // TODO: Implement login() method.
    }

    public function logout(string $userName)
    {
        // TODO: Implement logout() method.
    }

    public function time(int $times)
    {
        $this->times = $times;
    }

    public function withArguments(String $userName)
    {
        $this->userName = $userName;
    }

    public function andThrowException(String $userName)
    {

    }

    public function verifyValid()
    {
        if($this->times == 1 and $this->userNAme = "user_name")
            return true;
        else
            return false;
    }

    public function secureLogin(string $getUserName)
    {
        // TODO: Implement secureLogin() method.
    }
}