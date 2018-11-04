<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__.'/Data.php');
require_once(__DIR__.'/../PaymentGateway.php');
require_once( __DIR__.'/../vendor/fzaninotto/faker/src/autoload.php');
$faker = Faker\Factory::create();

class CustomerTest extends TestCase {
    public function testCustomerCreate() {
        global $faker;
        global $TestMerchantAPIKey;
        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $customer = array(
            "description" => $faker->text,
            "payment_method" => array(
                "card" => array(
                    "card_number" => "4111111111111111",
                    "expiration_date" => '12/30'
                )
            ),
            "billing_address" => array(
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
            ),
            "shipping_address" => array(
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
            )
        );

        $result = $PG->createCustomer($customer);
        $this->assertEquals(
            'success',
            $result['status']
        );

        return $result['data'];
    }

    public function testCustomerGet() {
        global $TestMerchantAPIKey;

        $customer = $this->testCustomerCreate();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->getCustomer($customer['id']);
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

    public function testCustomerUpdate() {
        global $faker;
        global $TestMerchantAPIKey;

        $customer = $this->testCustomerCreate();

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

    public function testCustomerDelete() {
        global $TestMerchantAPIKey;

        $customer = $this->testCustomerCreate();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->deleteCustomer($customer['id']);
        $this->assertEquals(
            'success',
            $result['status']
        );
    }
}
