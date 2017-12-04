<?php

namespace App\Controllers;

use App\Core\App;
use App\Models\Character;
use App\Models\User;

/**
 * Class UsersController
 * @package App\Controllers
 */
class UsersController extends Controller
{
    private $userModel;
    private $characterModel;

    /**
     * UsersController constructor.
     * initializing the required modals for this controller
     * @param App $app
     */
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->userModel = $this->builder()->on(User::class);
        $this->characterModel = $this->builder()->on(Character::class);
    }

    /**
     * creates a user from user name and password sends mail to the user
     * @return mixed string creation status
     */
    public function create()
    {
        try {
            if (($this->userModel->select(['email' => $this->parameters['email']])) != false) {
                return $this->app()->response()->json(["message" => "Account Already Exists"]);
            }
            if (array_key_exists('password', $this->parameters)) {
                $this->parameters['password'] = password_hash($this->parameters['password'], PASSWORD_DEFAULT);
            }
            sendMail($this->parameters['email'], "Fearless verification", "You account is ready ! Start you adventure now!");
            $saved = $this->userModel->insert($this->parameters);
            if ($saved) {
                return $this->app()->response()->json(["message" => "Account Created"]);
            }
            return $this->app()->response()->json(["message" => "Account Creation Failed"]);
        } catch (\Exception $e) {
            die ($e->getMessage());
        }
    }

    /**
     * login user using user name and password
     * @return mixed string login status
     */
    // TODO : add token when logging in to be used as Auth-token in the application
    public function login()
    {
        if (array_key_exists('email', $this->parameters) && array_key_exists('password', $this->parameters)) {
            $user = $this->userModel->select(['email' => $this->parameters['email']]);
            if (password_verify($this->parameters['password'], $user['password'])) {
                $this->app()->session->set('fearless_user', $user);
                return $this->app()->response()->json($user);
            }
            return $this->app()->response()->json(["message" => "Password is wrong"]);
        }
        return $this->app()->response()->json(["message" => "Email / password is missing"]);
    }

    /**
     * deletes user
     * @return mixed
     */
    public function delete()
    {
        if (array_key_exists('id', $this->parameters)) {
            $deleted = $this->userModel->delete(["id" => $this->parameters['id']]);
            if ($deleted) {
                $this->app()->session->delete('fearless_user');
                return $this->app()->response()->json(["message" => "Account Deleted"]);
            }
            return $this->app()->response()->json(["message" => "Account Deletion Failed"]);
        }
        return $this->app()->response()->json(["message" => "id is missing"]);
    }

    /**
     * gets user created character
     * @return mixed
     */
    public function character()
    {
        $user = $this->app()->session->get('fearless_user');
        if ($user) {
            $character = $this->characterModel->select(['user_id' => $user['id']]);
            if ($character) {
                $this->app()->session->set('fearless_character', $character);
                return $this->app()->response()->json($character);
            }
            return $this->app()->response()->json(["message" => "No character for this user ! please create a character first"]);
        }
        return $this->app()->response()->json(["message" => "You must login first"]);
    }

    /**
     * update the  email of the user
     * @return mixed
     */
    public function update()
    {
        if (array_key_exists('email', $this->parameters)) {
            $user = $this->app()->session->get('fearless_user');
        }
        $this->userModel->update(["email" => $this->parameters["email"]], ["id" => $user['id']]);
        $user['email'] = $this->parameters["email"];
        $this->app()->session->replace('fearless_user', $user);
        return $this->app()->response()->json(["message" => "email is missing"]);
    }
}