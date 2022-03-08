<?php

declare(strict_types=1);

namespace UserLoginService\Tests\Application;

use PHPUnit\Framework\TestCase;
use UserLoginService\Application\UserLoginService;
use UserLoginService\Domain\User;
use UserLoginService\Tests\Doubles\DummySessionManager;
use UserLoginService\Tests\Doubles\FakeSessionManager;
use UserLoginService\Tests\Doubles\SpySessionManager;
use UserLoginService\Tests\Doubles\StubSessionManager;


final class UserLoginServiceTest extends TestCase
{
    /**
     * @test user[]
     */
    public function userIsLoggedInManually()
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
    /**
     * @test
     */
    public function checksLoginExternalServiceHechoEnCasa()
    {
        $userLoginService = new UserLoginService(new StubSessionManager());

        $resultMessage = $userLoginService->login("usuarioPrueba", "passwordPrueba");

        $this->assertEquals("Login correcto", $resultMessage);
    }
    /**
     * @test
     */
    public function checksCorrectLoginExternalServiceHechoEnClase() //Este es el bueno
    {
        $userName = "userName";
        $password = "password";
        $userLoginService = new UserLoginService(new FakeSessionManager());

        $resultMessage = $userLoginService->login("$userName", "$password");

        $this->assertEquals(UserLoginService::LOGIN_CORRECTO, $resultMessage);
    }
    /**
     * @test
     */
    public function checksIncorrectLoginExternalServiceHechoEnClase() //Este es el bueno
    {
        $userName = "userName2";
        $password = "password";
        $userLoginService = new UserLoginService(new FakeSessionManager());

        $resultMessage = $userLoginService->login("$userName", "$password");

        $this->assertEquals(UserLoginService::LOGIN_INCORRECTO, $resultMessage);
    }
    /**
     * @test
     */
    public function userLoggedOutUserNotBeingLoggedIn()
    {
        $userLoginService = new UserLoginService(new DummySessionManager());
        $user = new User("userName");

        $resultMessage = $userLoginService->logout($user);

        $this->assertEquals(UserLoginService::USUARIO_NO_LOGEADO, $resultMessage);
    }
    /**
     * @test
     */
    public function userLoggedOutUserBeingLoggedIn()
    {
        $sessionManager = new  SpySessionManager();
        $userLoginService = new UserLoginService($sessionManager);
        $user = new User("userName");
        $userLoginService->manualLogin($user);

        $resultMessage = $userLoginService->logout($user);

        $sessionManager->verifyLogoutCalls(1);

        $this->assertEquals(UserLoginService::OK, $resultMessage);
    }


}
