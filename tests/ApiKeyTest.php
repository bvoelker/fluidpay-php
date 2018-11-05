<?php
//use PHPUnit\Framework\TestCase;
//require_once(__DIR__.'/Data.php');
//require_once(__DIR__.'/../PaymentGateway.php');
//require_once( __DIR__.'/../vendor/fzaninotto/faker/src/autoload.php');
//$faker = Faker\Factory::create();
//
//class ApiKeyTest extends TestCase {
//    public function testCreateApiKey() {
//        global $TestMerchantAPIKey;
//
//        $PG = new PaymentGateway();
//        $PG->environment = 'local';
//        $PG->apiKey = $TestMerchantAPIKey;
//        $result = $PG->createApiKey();
//        print_r($result);
//        $this->assertEquals(
//            'success',
//            $result['status']
//        );
//    }

//    public function testGetApiKeys() {
//        global $TestMerchantAPIKey;
//
//        $PG = new PaymentGateway();
//        $PG->environment = 'local';
//        $PG->apiKey = $TestMerchantAPIKey;
//        $result = $PG->getApiKeys();
//        print('get api keys');
//        print_r($result);
//        $this->assertEquals(
//            'success',
//            $result['status']
//        );
//    }
//}
