<?php
require_once(__DIR__.'/Data.php');
require_once(__DIR__.'/../PaymentGateway.php');
require_once( __DIR__.'/../vendor/fzaninotto/faker/src/autoload.php');
$faker = Faker\Factory::create();

class CustomerSeed {
    public function createCustomer() {
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

        return $result['data'];
    }
}