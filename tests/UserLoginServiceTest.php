<?php

declare(strict_types=1);

namespace Deg540\PHPTestingBoilerplate\Test;

use Deg540\PHPTestingBoilerplate\UserLoginService;
use PHPUnit\Framework\TestCase;

final class UserLoginServiceTest extends TestCase
{
    /**
     * @test
     */
    public function userIsLoggedIn()
    {
        $userLoginService = new UserLoginService();

        $this->assertEquals("user logged", $userLoginService->loginManually());
    }
}
