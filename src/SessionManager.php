<?php

namespace Deg540\PHPTestingBoilerplate;

interface SessionManager
{
    public function getSessions(): int;

    public function login(string $userName, string $password): bool;
}