<?php

namespace tests\unit\Controllers;

use GuzzleHttp\Client as GuzzleClient;

class UsersControllerTest extends \PHPUnit\Framework\TestCase
{
    protected $guzzle;
    protected $baseUrl;

    public function testCreateUserReturnsSuccessMessage()
    {
        $postData = [
            'first_name' => 'ahmed',
            'last_name' => 'alaa',
            'email' => 'ahmedalaa' . rand() . '@gmail.com',
            'password' => 'secret',
        ];
        $this->assertEquals('Account Created', $this->apiCall('create', 'post', $postData));
    }

    /**
     * @param string $api
     * @param string $method
     * @param null $postData
     * @return bool or array of data
     */
    public function apiCall($api, $method = 'get', $postData = null)
    {
        $this->guzzle = new GuzzleClient(['base_url' => $this->baseUrl]);
        $url = $this->baseUrl . $api;
        $response = $this->guzzle->$method($url, [
            'form_params' => $postData,
        ]);
        $responseData = json_decode($response->getBody()->getContents());
        if ($response->getStatusCode() == 200) {
            if (isset($responseData->message)) {
                return $responseData->message;
            }
            return $responseData;
        }
    }

    public function testAccountCreationFailedReturnsError()
    {
        $postData = [];
        $this->assertEquals('Account Already Exists', $this->apiCall('create', 'post', $postData));
    }

    public function testUserCantRegisterTwiceWithTheSameMail()
    {
        $postData = [
            'firsts_name' => 'ahmed',
            'last_name' => 'alaa',
            'email' => 'ahmedalaahagag@gmail.com',
            'password' => 'secret',
        ];
        $this->apiCall('create', 'post', $postData);
        $this->assertEquals('Account Already Exists', $this->apiCall('create', 'post', $postData));
    }

    public function testLoginReturnsUserObject()
    {
        $postData = [
            'email' => 'ahmedalaahagag@gmail.com',
            'password' => 'secret',
        ];
        $expected = '{
            "0": "5",
            "1": "Ahmed",
            "2": "Alaa",
            "3": "ahmedalaahagag@gmail.com",
            "4": "$2y$10$27wCbpYwzzWsTWo4JKLGAuvSCyDN.8YHIrfpzTrYsPzM/rlF0a2Iu",
            "id": "5",
            "first_name": "Ahmed",
            "last_name": "Alaa",
            "email": "ahmedalaahagag@gmail.com",
            "password": "$2y$10$27wCbpYwzzWsTWo4JKLGAuvSCyDN.8YHIrfpzTrYsPzM/rlF0a2Iu"
        }';
        $this->assertEquals(json_decode($expected), $this->apiCall('login', 'post', $postData));
    }

    public function testLoginReturnsErrorMessageWhenProvidedWrongPassword()
    {
        $postData = [
            'email' => 'ahmedalaahagag@gmail.com',
            'password' => 'wrong',
        ];
        $this->assertEquals('Password is wrong', $this->apiCall('login', 'post', $postData));
    }

    public function testLoginReturnsErrorMessageWhenParametersAreMissing()
    {
        $postData = [
            'password' => 'secret',
        ];
        $this->assertEquals('Email / password is missing', $this->apiCall('login', 'post', $postData));
    }

    public function testLoginShouldReturnMessageWhenLoginWhenAlreadyLoggedIn()
    {
        $postData = [
            'email' => 'ahmedalaahagag@gmail.com',
            'password' => 'secret',
        ];
        $this->apiCall('login', 'post', $postData);
        $this->assertEquals('Already Logged In', $this->apiCall('login', 'post', $postData));
    }

    public function testDeleteReturnsMessageWhenTheIDIsNotProvided()
    {
        $getData = [];
        $this->assertEquals('id is missing', $this->apiCall('/', 'delete', $getData));
    }

    public function testDeleteShouldHaveTheUserLoggedInBeforeDeleting()
    {
        $getData = [
            'id' => 7
        ];
        $this->assertEquals('id is missing', $this->apiCall('/', 'delete', $getData));
    }

    /*public function testDeleteRemovesDataFromTheSession(){

    }

    public function testDeleteReturnsMessageWhenDeleteIsSuccessful(){

    }

    public function testDeleteReturnsMessageWhenDeleteIsFails(){

    }

    public function testCharacterSavesLoggedInUserCharacterToSession(){

    }

    public function testCharacterShouldReturnMessageIfTheUserIsNotLoggedIn(){

    }

    public function testCharacterShouldReturnCharacterObject(){
    }

    public function testCharacterShouldReturnMessageIfUserDidntCreatCharacters(){

    }

    public function testUpdateShouldReplaceTheDataInSession(){

    }

    public function testUpdateShouldHaveLoggedInUser(){

    }

    public function testUpdateShouldReturnMessageWhenUserIsNotLoggedIn(){

    }

    public function testUpdateShouldReturnMessageWhenParametersAreMissing(){

    }*/

    protected function setUp()
    {
        $this->baseUrl = 'http://localhost:8080/user/';
    }
    //TODO : build communication library to test calling the APIs
    //For the sake of building every thing from scratch this will only be used during the testing only (Guzzle)

    protected function tearDown()
    {
        parent::tearDown(); // TODO: Change the autogenerated stub
        $this->guzzle = null;
    }

}