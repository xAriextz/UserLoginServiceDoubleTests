<?php

declare(strict_types=1);

namespace UserLoginService\Tests\Application;

use PHPUnit\Framework\TestCase;
use UserLoginService\Application\UserLoginService;
use UserLoginService\Domain\User;
use UserLoginService\Tests\Doubles\DummySessionManager;
use UserLoginService\Tests\Doubles\StubSessionManager;


final class UserLoginServiceTest extends TestCase
{
    /**
     * @test user[]
     */
    public function userIsLoggedIn()
    {
        $user = new User("user logged");
        $expectedLoggedUsers = [$user];
        $userLoginService = new UserLoginService(new DummySessionManager());

        $userLoginService->manualLogin($user);

        $this->assertEquals($expectedLoggedUsers, $userLoginService->getLoggedUsers());
    }
    /**
     * @test
     */
    public function throwsEmpty()
    {
        $userLoginService = new UserLoginService(new DummySessionManager());

        $this->assertEmpty($userLoginService->getLoggedUsers());
    }
    /**
     * @test
     */
    public function countsExternalSessions()
    {
        $userLoginService = new UserLoginService(new StubSessionManager());

        $numExternalSessions = $userLoginService->countExternalSessions();

        $this->assertEquals(2, $numExternalSessions);
    }

}
