<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__.'/Data.php');
require_once(__DIR__.'/../PaymentGateway.php');
require_once( __DIR__.'/../vendor/fzaninotto/faker/src/autoload.php');
$faker = Faker\Factory::create();

class UserTest extends TestCase {
    public function testCreateUser() {
        global $faker;
        global $TestMerchantAPIKey;
        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $user = array(
            "username" => $faker->userName.$faker->numberBetween(1000, 10000),
            "password" => $faker->password.'Aa'.$faker->numberBetween(100, 1000).'!',
            "name" => $faker->name,
            "phone" => substr(preg_replace('/\D/', '', $faker->phoneNumber), 0, 10),
            "email" => $faker->email,
            "timezone" => $faker->timezone,
            "status" => "active",
            "role" => "admin"
        );

        $result = $PG->createUser($user);
        if ($result['status'] != 'success') {
            print_r($user);
            print_r($result);
        }
        $this->assertEquals(
            'success',
            $result['status']
        );

        return $result['data'];
    }

    public function testGetCurrentUser() {
        global $TestMerchantAPIKey;

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->getCurrentUser();
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

    public function testGetAllUsers() {
        global $TestMerchantAPIKey;

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->getAllUsers();
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

    public function testGetUser() {
        global $TestMerchantAPIKey;

        $user = $this->testCreateUser();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->getUser($user['id']);
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

    public function testUpdateUser() {
        global $faker;
        global $TestMerchantAPIKey;

        $user = $this->testCreateUser();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $user = array(
            "id" => $user['id'],
            "name" => $faker->name,
            "phone" => substr(preg_replace('/\D/', '', $faker->phoneNumber), 0, 10),
            "email" => $faker->email,
            "timezone" => $faker->timezone,
            "status" => "active",
            "role" => "admin"
        );

        $result = $PG->updateUser($user);
        if ($result['status'] != 'success') {
            print_r($result);
        }
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

    public function testDeleteCustomer() {
        global $TestMerchantAPIKey;

        // Create new customer first
        $user = $this->testCreateUser();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->deleteUser($user['id']);
        $this->assertEquals(
            'success',
            $result['status']
        );
    }
}
