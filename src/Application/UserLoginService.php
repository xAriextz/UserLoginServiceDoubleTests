<?php

namespace UserLoginService\Application;

use Exception;
use PhpParser\Node\Scalar\String_;
use UserLoginService\Domain\User;
use function Sodium\add;

class UserLoginService
{
    const LOGIN_CORRECTO = "Login correcto";
    const LOGIN_INCORRECTO = "Login incorrecto";
    const OK = "Ok";
    const USUARIO_NO_LOGEADO = "Usuario no logeado";
    private SessionManager $sessionManager;
    private array $loggedUsers = [];

    public function __construct(SessionManager $sessionManager)
    {
        $this->sessionManager = $sessionManager;
    }

    public function manualLogin(User $user): string
    {
        array_push($this->loggedUsers, $user);
        return "user logged";
    }

    public function getLoggedUsers(): array
    {
        return $this->loggedUsers;
    }

    public function countExternalSessions(): int
    {
        return $this->sessionManager->getSessions();
    }

    public function login(String $userName, String $password): String
    {
        if($this->sessionManager->login($userName, $password))
        {
            $user = new User($userName);
            array_push($this->loggedUsers, $user);
            return  self::LOGIN_CORRECTO;
        }
        else
            return self::LOGIN_INCORRECTO;

    }

    public function logout(User $user): String
    {
        if(!in_array($user, $this->getLoggedUsers()))
        {
            return self::USUARIO_NO_LOGEADO;
        }
        $this->sessionManager->logout($user->getUserName());

        return self::OK;
    }

    public function secureLogin(User $user): String
    {
        try{
            $this->sessionManager->secureLogin($user->getUserName());
        }catch (Exception $exception){
            if($exception->getMessage() == "User does not exist") {
                return "Usuario no existe";
            }

        }
        return "OK";
    }
}