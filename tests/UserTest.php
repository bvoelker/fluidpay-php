<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__.'/Data.php');
require_once(__DIR__.'/../PaymentGateway.php');
require_once( __DIR__.'/../vendor/fzaninotto/faker/src/autoload.php');
$faker = Faker\Factory::create();

class UserTest extends TestCase {
    public function testUserCreate() {
        global $faker;
        global $TestMerchantAPIKey;
        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $user = array(
            "username" => $faker->userName.$faker->numberBetween(1000, 10000),
            "password" => $faker->password.$faker->numberBetween(100, 1000),
            "name" => $faker->name,
            "phone" => substr(preg_replace('/\D/', '', $faker->phoneNumber), 0, 10),
            "email" => $faker->email,
            "timezone" => $faker->timezone,
            "status" => "active",
            "role" => "admin"
        );

        $result = $PG->createUser($user);
        $this->assertEquals(
            'success',
            $result['status']
        );

        return $result['data'];
    }

    public function testUserGet() {
        global $TestMerchantAPIKey;

        $user = $this->testUserCreate();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->getUser($user['id']);
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

    public function testCustomerUpdate() {
        global $faker;
        global $TestMerchantAPIKey;

        $user = $this->testUserCreate();

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

        $result = $PG->updateUSer($user);
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

//    public function testCustomerDelete() {
//        global $TestMerchantAPIKey;
//
//        // Create new customer first
//        $customer = $this->testCustomerCreate();
//
//        $PG = new PaymentGateway();
//        $PG->environment = 'local';
//        $PG->apiKey = $TestMerchantAPIKey;
//        $result = $PG->deleteCustomer($customer['id']);
//        $this->assertEquals(
//            'success',
//            $result['status']
//        );
//    }
}
