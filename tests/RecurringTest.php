<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__.'/Data.php');
require_once (__DIR__.'/CustomerSeed.php');
require_once(__DIR__.'/../PaymentGateway.php');
require_once( __DIR__.'/../vendor/fzaninotto/faker/src/autoload.php');
$faker = Faker\Factory::create();

class RecurringTest extends TestCase {

    public function testCreateAddOn() {
        global $TestMerchantAPIKey;
        global $faker;

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $addOn = array(
            'name' => $faker->name,
            'description' => $faker->text,
            'amount' => 100,
            'duration' => 0
        );
        $result = $PG->createAddOn($addOn);
        $this->assertEquals(
            'success',
            $result['status']
        );

        return $result['data'];
    }

    public function testGetAddOn() {
        global $TestMerchantAPIKey;

        $addOn = $this->testCreateAddOn();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->getAddOn($addOn['id']);
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

    public function testGetAllAddOns() {
        global $TestMerchantAPIKey;

        $this->testCreateAddOn();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->getAllAddOns();
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

    public function testDeleteAddOn() {
        global $TestMerchantAPIKey;

        $addon = $this->testCreateAddOn();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->deleteAddOn($addon['id']);
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

    public function testCreateDiscount() {
        global $TestMerchantAPIKey;
        global $faker;

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $discount = array(
            'name' => $faker->name,
            'description' => $faker->text,
            'amount' => 100,
            'duration' => 0
        );
        $result = $PG->createDiscount($discount);
        $this->assertEquals(
            'success',
            $result['status']
        );

        return $result['data'];
    }

    public function testGetDiscount() {
        global $TestMerchantAPIKey;

        $discount = $this->testCreateDiscount();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->getDiscount($discount['id']);
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

    public function testGetAllDiscounts() {
        global $TestMerchantAPIKey;

        $this->testCreateDiscount();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->getAllDiscounts();
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

    public function testDeleteDiscount() {
        global $TestMerchantAPIKey;

        $discount = $this->testCreateDiscount();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->deleteDiscount($discount['id']);
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

    public function testCreatePlan() {
        global $TestMerchantAPIKey;
        global $faker;

        $addon = $this->testCreateAddOn();
        $discount = $this->testCreateDiscount();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $plan = array(
            "name" => $faker->name,
            "description" => $faker->text,
            "amount" => 100,
            "billing_cycle_interval" => 1,
            "billing_frequency" => "twice_monthly",
            "billing_days" => "1,15",
            "duration" => 0,
            "add_ons" => array(
                array(
                    "id" => $addon['id'],
                    "description" => $faker->text,
                    "amount" => 100,
                    "duration" => 0
                )
            ),
            "discounts" => array(
                array(
                    "id" => $discount['id'],
                    "description" => $faker->text,
                    "amount" => 50,
                    "duration" => 0
                )
            )
        );
        $result = $PG->createPlan($plan);
        $this->assertEquals(
            'success',
            $result['status']
        );

        return $result['data'];
    }

    public function testUpdatePlan() {
        global $TestMerchantAPIKey;
        global $faker;

        $planOld = $this->testCreatePlan();
        $addon = $this->testCreateAddOn();
        $discount = $this->testCreateDiscount();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $plan = array(
            "name" => $faker->name,
            "description" => $faker->text,
            "amount" => 100,
            "billing_cycle_interval" => 1,
            "billing_frequency" => "twice_monthly",
            "billing_days" => "1,15",
            "duration" => 0,
            "add_ons" => array(
                array(
                    "id" => $addon['id'],
                    "description" => $faker->text,
                    "amount" => 100,
                    "duration" => 0
                )
            ),
            "discounts" => array(
                array(
                    "id" => $discount['id'],
                    "description" => $faker->text,
                    "amount" => 50,
                    "duration" => 0
                )
            )
        );
        $result = $PG->updatePlan($planOld['id'], $plan);
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

    public function testGetPlan() {
        global $TestMerchantAPIKey;

        $plan = $this->testCreatePlan();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->getPlan($plan['id']);
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

    public function testGetAllPlans() {
        global $TestMerchantAPIKey;

        $this->testCreatePlan();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->getAllPlans();
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

    public function testDeletePlan() {
        global $TestMerchantAPIKey;

        $plan = $this->testCreatePlan();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->deletePlan($plan['id']);
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

    public function testCreateSubscription() {
        global $TestMerchantAPIKey;
        global $faker;

        $plan = $this->testCreatePlan();
        $cusSeed = new CustomerSeed();
        $customer = $cusSeed->createCustomer();
        $discount = $this->testCreateDiscount();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $subscription = array(
            "plan_id" => $plan['id'],
            "description" => $faker->text,
            "customer" => array(
                "id" => $customer['id']
            ),
            "amount" => 100,
            "billing_cycle_interval" => 1,
            "billing_frequency" => "twice_monthly",
            "billing_days" => "1,15",
            "duration" => 0,
            "add_ons" => array(),
            "discounts" => array(
                array(
                    "id" => $discount['id'],
                    "name" => $faker->name,
                    "description" => $faker->text,
                    "amount" => 50,
                    "duration" => 0
                )
            )
        );
        $result = $PG->createSubscription($subscription);
        if ($result['status'] != 'success') {
            print_r($result);
        }
        $this->assertEquals(
            'success',
            $result['status']
        );

        return $result['data'];
    }

    public function testUpdateSubscription() {
        global $TestMerchantAPIKey;
        global $faker;

        $subscriptionOld = $this->testCreateSubscription();
        $cusSeed = new CustomerSeed();
        $customer = $cusSeed->createCustomer();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $subscription = array(
            "plan_id" => $subscriptionOld['plan_id'],
            "description" => $faker->text,
            "customer" => array(
                "id" => $customer['id']
            ),
            "amount" => 100,
            "billing_cycle_interval" => 1,
            "billing_frequency" => "twice_monthly",
            "billing_days" => "1,15",
            "duration" => 0
        );
        $result = $PG->updateSubscription($subscriptionOld['id'], $subscription);
        if ($result['status'] != 'success') {
            print_r($result);
        }
        $this->assertEquals(
            'success',
            $result['status']
        );

        return $result['data'];
    }

    public function testGetSubscription() {
        global $TestMerchantAPIKey;

        $subscription = $this->testCreateSubscription();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->getSubscription($subscription['id']);
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

    public function testDeleteSubscription() {
        global $TestMerchantAPIKey;

        $subscription = $this->testCreateSubscription();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->deleteSubscription($subscription['id']);
        $this->assertEquals(
            'success',
            $result['status']
        );
    }
}
