<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__.'/Data.php');
require_once(__DIR__.'/../PaymentGateway.php');
require_once( __DIR__.'/../vendor/fzaninotto/faker/src/autoload.php');
$faker = Faker\Factory::create();

class TransactionTest extends TestCase {
    public function testProcessCardSaleTransaction() {
        global $TestMerchantAPIKey;

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $transaction = array(
            "type" => "sale",
            "amount" => 1112,
            "tax_amount" => 100,
            "shipping_amount" => 100,
            "currency" => "USD",
            "description" => "test transaction",
            "order_id" => "someOrderID",
            "po_number" => "somePONumber",
            "ip_address" => "4.2.2.2",
            "email_receipt" => false,
            "email_address" => "user@home.com",
            "create_vault_record" => true,
            "payment_method" => array(
                "card" => array(
                    "entry_type" => "keyed",
                    "number" => "4012000098765439",
                    "expiration_date" => "12/20",
                    "cvc" => "999"
                )
            ),
            "billing_address"  => array(
                "first_name" => "John",
                "last_name" => "Smith",
                "company" => "Test Company",
                "address_line_1" => "123 Some St",
                "city" => "Wheaton",
                "state" => "IL",
                "postal_code" => "60187",
                "country" => "US",
                "phone" => "5555555555",
                "fax" => "5555555555",
                "email" => "help@website.com"
            ),
            "shipping_address"  => array(
                "first_name" => "John",
                "last_name" => "Smith",
                "company" => "Test Company",
                "address_line_1" => "123 Some St",
                "city" => "Wheaton",
                "state" => "IL",
                "postal_code" => "60187",
                "country" => "US",
                "phone" => "5555555555",
                "fax" => "5555555555",
                "email" => "help@website.com"
            )
        );
        $result = $PG->processTransaction($transaction);
        if ($result['status'] != 'success') {
            print_r($result);
        }
        $this->assertEquals(
            'success',
            $result['status']
        );

        return $result['data'];
    }

    public function testGetTransaction() {
        global $TestMerchantAPIKey;

        $transaction = $this->testProcessCardSaleTransaction();

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;

        $result = $PG->getTransaction($transaction['id']);
        $this->assertEquals(
            'success',
            $result['status']
        );
    }

//    public function testCaptureTransaction() {
//        global $TestMerchantAPIKey;
//
//        $transaction = $this->testProcessCardSaleTransaction();
//
//        $PG = new PaymentGateway();
//        $PG->environment = 'local';
//        $PG->apiKey = $TestMerchantAPIKey;
//        $capture = array(
//            "amount" => 1000,
//            "tax_amount" => 100,
//            "tax_exempt" => false,
//            "shipping_amount" => 0
//        );
//        $result = $PG->captureTransaction($transaction['id'], $capture);
//        if ($result['status'] != 'success') {
//            print_r($result);
//        }
//        $this->assertEquals(
//            'success',
//            $result['status']
//        );
//    }

//    public function testVoidTransaction() {
//        global $TestMerchantAPIKey;
//
//        $transaction = $this->testProcessCardSaleTransaction();
//
//        $PG = new PaymentGateway();
//        $PG->environment = 'local';
//        $PG->apiKey = $TestMerchantAPIKey;
//        $result = $PG->voidTransaction($transaction['id']);
//        if ($result['status'] != 'success') {
//            print_r($result);
//        }
//        $this->assertEquals(
//            'success',
//            $result['status']
//        );
//    }

//    public function testRefundTransaction() {
//        global $TestMerchantAPIKey;
//
//        $transaction = $this->testProcessCardSaleTransaction();
//
//        $PG = new PaymentGateway();
//        $PG->environment = 'local';
//        $PG->apiKey = $TestMerchantAPIKey;
//        $result = $PG->refundTransaction($transaction['id'], array(
//            "amount" => 1000
//        ));
//        if ($result['status'] != 'success') {
//            print_r($result);
//        }
//        $this->assertEquals(
//            'success',
//            $result['status']
//        );
//    }
}
