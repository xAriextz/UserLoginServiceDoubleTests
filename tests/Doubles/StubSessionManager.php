<?php

namespace UserLoginService\Tests\Doubles;


use UserLoginService\Application\SessionManager;

class StubSessionManager implements SessionManager
{

    public function getSessions(): int
    {
        return 2;
    }

    public function login(string $userName, string $password): bool
    {
        return true;
    }

    public function logout(string $userName)
    {
        // TODO: Implement logout() method.
    }

    public function secureLogin(string $getUserName)
    {
        // TODO: Implement secureLogin() method.
    }
}