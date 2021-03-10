<?php

namespace Deg540\PHPTestingBoilerplate;

class User
{
    private string $userName;

    /**
     * User constructor.
     * @param string $userName
     */
    public function __construct(string $userName)
    {
        $this->userName = $userName;
    }
}