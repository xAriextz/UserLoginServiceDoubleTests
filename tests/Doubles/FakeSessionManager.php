<?php

namespace UserLoginService\Tests\Doubles;

use UserLoginService\Application\SessionManager;

class FakeSessionManager implements SessionManager
{

    public function getSessions(): int
    {
        // TODO: Implement getSessions() method.
    }

    public function login(string $userName, string $password): bool
    {
        if($userName == "userName" and $password == "password")
            return true;
        else
            return false;
    }

    public function logout(string $userName)
    {
        // TODO: Implement logout() method.
    }
}