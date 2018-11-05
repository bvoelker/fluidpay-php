<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__.'/Data.php');
require_once(__DIR__.'/../PaymentGateway.php');
require_once( __DIR__.'/../vendor/fzaninotto/faker/src/autoload.php');
$faker = Faker\Factory::create();

class TerminalTest extends TestCase {

    public function testGetApiKeys() {
        global $TestMerchantAPIKey;

        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $PG->apiKey = $TestMerchantAPIKey;
        $result = $PG->getAllTerminals();
        $this->assertEquals(
            'success',
            $result['status']
        );
    }
}
