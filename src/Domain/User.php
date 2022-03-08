<?php

namespace UserLoginService\Domain;

class User
{
    private string $userName;

    public function __construct(string $userName)
    {
        $this->userName = $userName;
    }

    public function getUserName(): String
    {
        return $this->userName;
    }

}