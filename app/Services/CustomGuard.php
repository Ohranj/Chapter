<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Auth\Authenticatable;

class CustomGuard implements StatefulGuard
{
    private $provider;
    private $name;
    private $session;
    private $prefix = 'wifewuife';

    public function __construct($provider, $name, $session) {
        $this->provider = $provider;
        $this->name = $name;
        $this->session = $session;
    }


    /**
     * Attempt to authenticate a user using the given credentials.
     *
     * @param  array  $credentials
     * @param  bool  $remember
     * @return bool
     */
    public function attempt(array $credentials = [], $remember = false) {
        $user = $this->provider->retrieveByCredentials($credentials);
        if (!$user) return false;
        $passwordsMatch = Hash::check($credentials['password'], $user->password);
        if (!$passwordsMatch) return false;
        $this->login($user);
        return true;
    }

    /**
     * Log a user into the application without sessions or cookies.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function once(array $credentials = []) {
        dd('once');
        return false;
    }

    /**
     * Log a user into the application.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  bool  $remember
     * @return void
     */
    public function login(Authenticatable $user, $remember = false) {
        $this->session->put($this->prefix . '_id', $user->id);
        $this->session->put($this->prefix . '_remember', $remember);
    }

    /**
     * Log the given user ID into the application.
     *
     * @param  mixed  $id
     * @param  bool  $remember
     * @return \Illuminate\Contracts\Auth\Authenticatable|bool
     */
    public function loginUsingId($id, $remember = false) {
        dd('login using id');
        return false;
    }

    /**
     * Log the given user ID into the application without sessions or cookies.
     *
     * @param  mixed  $id
     * @return \Illuminate\Contracts\Auth\Authenticatable|bool
     */
    public function onceUsingId($id) {
        dd('once using id');
        return false;
    }

    /**
     * Determine if the user was authenticated via "remember me" cookie.
     *
     * @return bool
     */
    public function viaRemember() {
        dd('via remember');
        return false;
    }

    /**
     * Log the user out of the application.
     *
     * @return void
     */
    public function logout() {
        dd('logout');
        $this->session->forget($this->prefix . '_id');
        $this->session->forget($this->prefix . '_remember');
        null;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check() {
        return $this->session->has($this->prefix . '_id');
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest() {
        dd('guest');
        return false;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user() {
        return User::find($this->id());
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|string|null
     */
    public function id() {
        return $this->session->get($this->prefix . '_id', null);
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = []) {
        dd('validate');
        return false;
    }

    /**
     * Determine if the guard has a user instance.
     *
     * @return bool
     */
    public function hasUser() {
        dd('has user');
        return false;
    }

    /**
     * Set the current user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return void
     */
    public function setUser(Authenticatable $user) {
        dd('set user');
        null;
    }
}
