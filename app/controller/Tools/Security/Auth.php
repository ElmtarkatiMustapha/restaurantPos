<?php

namespace TOOL\Security;

use TOOL\HTTP\REQ;
use TOOL\HTTP\RES;
use APP\User;
use TOOL\HTTP\RESException;

class Auth
{

    /**
     * Logged in
     * 
     * @var ?object
     */
    public static ?object $loggedIn = null;


    /**
     * Logged in method
     * 
     * @return ?object
     */
    static function loggedIn()
    {

        // Check has setup
        if (self::$loggedIn) return self::$loggedIn;

        // Check Token session
        if (!REQ::$auth || !$verify = Token::verify(REQ::$auth))
            return false;
 
        // Check id
        if (!$verify->id) return null;

        // Get user
        $user = User::read($verify->id)->data;

        // Invalid auth
        if (!$user->id) return null;

        // Unset password
        unset($user->password);

        // Set loggedIn data
        return self::$loggedIn = $user;
    }

    /**
     * Header method
     * 
     * @param array $roles
     */
    static function header(?array $roles = null)
    {

        // Check auth
        if (!self::loggedIn())

            throw new RESException('Unauth', RES::UNAUTH);

        // Check roles
        if ($roles && !in_array(self::loggedIn()->type, $roles))

            throw new RESException('Unrole', RES::UNROLE);
    }
}
