<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

class FirebaseService
{
    protected $auth;

    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(config('firebase.credentials'));
        $this->auth = $factory->createAuth();
    }

    public function verifyToken($token)
    {
        try {
            return $this->auth->verifyIdToken($token);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getAuth()
    {
        return $this->auth;
    }
}
