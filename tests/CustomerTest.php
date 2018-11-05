<?php
use PHPUnit\Framework\TestCase;
require_once (__DIR__.'/CustomerSeed.php');
require_once(__DIR__.'/Data.php');
require_once(__DIR__.'/../PaymentGateway.php');
require_once( __DIR__.'/../vendor/fzaninotto/faker/src/autoload.php');
$faker = Faker\Factory::create();

class CustomerTest extends TestCase {
    public function testCreateCustomer() {
        $cusSeed = new CustomerSeed();
        $result = $cusSeed->createCustomer();
        $this->assertNotNull($result['id']);
    }

    public function testGetCustomer() {
        global $TestMerchantAPIKey;

        $cusSeed = new CustomerSeed();
        $customer = $cusSeed->createCustomer();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->getCustomer($customer['id']);
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

    public function testUpdateCustomer() {
        global $faker;
        global $TestMerchantAPIKey;

        $cusSeed = new CustomerSeed();
        $customer = $cusSeed->createCustomer();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $customer = array(
            "id" => $customer['id'],
            "description" => $faker->text
        );

        $result = $PG->updateCustomer($customer);
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

    public function testDeleteCustomer() {
        global $TestMerchantAPIKey;

        $cusSeed = new CustomerSeed();
        $customer = $cusSeed->createCustomer();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->deleteCustomer($customer['id']);
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

    public function testCreateCustomerAddressToken() {
        global $faker;
        global $TestMerchantAPIKey;
        $cusSeed = new CustomerSeed();
        $customer = $cusSeed->createCustomer();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $address = array(
            "first_name" => $faker->firstName(),
            "last_name" => $faker->lastName,
            "company" => $faker->company,
            "address_line_1" => $faker->streetAddress,
            "city" => $faker->city,
            "state" => $faker->stateAbbr,
            "postal_code" => $faker->postcode,
            "country" => 'US',
            "email" => $faker->email,
            "phone" => substr(preg_replace('/\D/', '', $faker->phoneNumber), 0, 10),
            "fax" => substr(preg_replace('/\D/', '', $faker->phoneNumber), 0, 10)
        );
        $result = $PG->createCustomerAddressToken($customer['id'], $address);
        if ($result['status'] != 'success') {
            print_r($result);
        }
        $this->assertEquals(
            'success',
            $result['status']
        );

        return $result['data'];
    }

    public function testGetCustomerAddress() {
        global $faker;
        global $TestMerchantAPIKey;

        $cusSeed = new CustomerSeed();
        $customer = $cusSeed->createCustomer();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $address = array(
            "first_name" => $faker->firstName(),
            "last_name" => $faker->lastName,
            "company" => $faker->company,
            "address_line_1" => $faker->streetAddress,
            "city" => $faker->city,
            "state" => $faker->stateAbbr,
            "postal_code" => $faker->postcode,
            "country" => 'US',
            "email" => $faker->email,
            "phone" => substr(preg_replace('/\D/', '', $faker->phoneNumber), 0, 10),
            "fax" => substr(preg_replace('/\D/', '', $faker->phoneNumber), 0, 10)
        );
        $addressResult = $PG->createCustomerAddressToken($customer['id'], $address);
        if ($addressResult['status'] != 'success') {
            print_r($addressResult);
        }
        $this->assertEquals(
            'success',
            $addressResult['status']
        );

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->getCustomerAddress($customer['id'], $addressResult['data']['id']);
        if ($result['status'] != 'success') {
            print_r($result);
        }
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

    public function testGetCustomerAllAddresses() {
        global $TestMerchantAPIKey;

        $cusSeed = new CustomerSeed();
        $customer = $cusSeed->createCustomer();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->getCustomerAllAddresses($customer['id']);
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

    public function testUpdateCustomerAddress() {
        global $faker;
        global $TestMerchantAPIKey;

        $cusSeed = new CustomerSeed();
        $customer = $cusSeed->createCustomer();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->getCustomerAllAddresses($customer['id']);
        $addressID = $result['data'][0]['id'];

        $address = array(
            "first_name" => $faker->firstName(),
            "last_name" => $faker->lastName,
            "company" => $faker->company,
            "address_line_1" => $faker->streetAddress,
            "city" => $faker->city,
            "state" => $faker->stateAbbr,
            "postal_code" => $faker->postcode,
            "country" => 'US',
            "email" => $faker->email,
            "phone" => substr(preg_replace('/\D/', '', $faker->phoneNumber), 0, 10),
            "fax" => substr(preg_replace('/\D/', '', $faker->phoneNumber), 0, 10)
        );

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->updateCustomerAddress($customer['id'], $addressID, $address);
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

//    public function testDeleteCustomerAddress() {
//        global $TestMerchantAPIKey;
//
//        $cusSeed = new CustomerSeed();
//        $customer = $cusSeed->createCustomer();
//
//        $PG = new PaymentGateway();
//        $PG->environment = 'local';
//        $PG->apiKey = $TestMerchantAPIKey;
//        $result = $PG->getCustomerAllAddresses($customer['id']);
//        $addressID = $result['data'][0]['id'];
//
//        $PG = new PaymentGateway();
//        $PG->environment = 'local';
//        $PG->apiKey = $TestMerchantAPIKey;
//        $result = $PG->deleteCustomerAddress($customer['id'], $addressID);
//        if ($result['status'] != 'success') {
//            print_r($result);
//        }
//        $this->assertEquals(
//            'success',
//            $result['status']
//        );
//    }

//    public function testCreateCustomerPaymentToken() {
//        global $TestMerchantAPIKey;
//        $cusSeed = new CustomerSeed();
//        $customer = $cusSeed->createCustomer();
//
//        $PG = new PaymentGateway();
//        $PG->environment = 'local';
//        $PG->apiKey = $TestMerchantAPIKey;
//        $card = array(
//            "card_number" => "4111111111111111",
//            "expiration_date" => "1220"
//        );
//        $result = $PG->createCustomerPaymentToken($customer['id'], 'card', $card);
//        if ($result['status'] != 'success') {
//            print_r($result);
//        }
//        $this->assertEquals(
//            'success',
//            $result['status']
//        );
//
//        return $result['data'];
//    }

}
