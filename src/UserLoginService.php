<?php

namespace Deg540\PHPTestingBoilerplate;

class UserLoginService
{
    private array $loggedUsers = [];

    public function loginManually(): string
    {
        return "user logged";
    }

}