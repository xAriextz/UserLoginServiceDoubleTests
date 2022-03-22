<?php

declare(strict_types=1);

namespace UserLoginService\Tests\Application;

use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;
use UserLoginService\Application\SessionManager;
use UserLoginService\Application\UserLoginService;
use UserLoginService\Domain\User;
use UserLoginService\Tests\Doubles\DummySessionManager;
use UserLoginService\Tests\Doubles\FakeSessionManager;
use UserLoginService\Tests\Doubles\MockSessionManager;
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
    /**
     * @test
     */
    /*
    public function userNotSecurelyLoggedInIfUserDoesNotExistInExternalService()
    {
        $user = new User("user_name", "password");
        $sessionManager = new  MockSessionManager();
        $userLoginService =  new UserLoginService($sessionManager);

        $sessionManager->times(1);
        $sessionManager->withArguments("user_name");
        $sessionManager->andThrowException("User does not exist");

        $secureLoginResponse = $userLoginService->secureLogin($user);

        $this->assertTrue($sessionManager->verifyValid());
        $this->assertEquals("Usuario no existe", $secureLoginResponse);
    }
    */
    /**
     * @test
     */
    public function userNotSecurelyLoggedInIfUserDoesNotExistInExternalServiceMockery()
    {
        $user = new User("user_name");
        $sessionManager = Mockery::mock(SessionManager::class);
        $userLoginService =  new UserLoginService($sessionManager);

        $sessionManager
            ->expects('secureLogin')
            ->with('user_name')
            ->once()
            ->andThrow(new Exception('User does not exist'));

        $secureLoginResponse = $userLoginService->secureLogin($user);

        $this->assertEquals("Usuario no existe", $secureLoginResponse);
    }
    /**
     * @test
     */
    public function userLoggedInManuallyMockery()

    {
        $user = new User("user_name");
        $expectedLoggedUsers = [$user];
        $sessionManager = Mockery::mock(SessionManager::class);
        $userLoginService = new UserLoginService($sessionManager);

        //Tenemos que comprobar que toda la lógica está en el userLoginService
        //y que no llamamos al sessionManager
        //$sessionManager
          //  ->;

        $userLoginService->manualLogin($user);

        $this->assertEquals($expectedLoggedUsers, $userLoginService->getLoggedUsers());
    }

    /**
     * @test
     */
    /*
    public function countsExternalSessionsMockery()
    {
        $sessionManager = Mockery::mock(SessionManager::class);
        $userLoginService = new UserLoginService($sessionManager);


        $sessionManager
            ->expects('countExternalSessions')
            ->once()
            ->andReturnArg(2)
            ->andReturn(2);
        $numExternalSessions = $userLoginService->countExternalSessions();

        $this->assertEquals(2, $numExternalSessions);
    }
    /**
     * @test
     */
    /*
    public function userLoggedOutUserBeingLoggedInMockery()
    {
        $spy = \Mockery::spy(SessionManager::class);
        $userLoginService = new UserLoginService($spy);
        $user = new User("userName");
        $userLoginService->manualLogin($user);
        
        $spy->logout($user->getUserName());

        $this->assertTrue($spy->shouldHaveReceived()->logout($user->getUserName()));
    }
    */


}
