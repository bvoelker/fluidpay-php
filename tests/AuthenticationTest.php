<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__.'/Data.php');
require_once(__DIR__.'/../PaymentGateway.php');

class AuthenticationTest extends TestCase
{
    public function testObtainJWT()
    {
        global $TestMerchantUsername;
        global $TestMerchantPassword;
        $PG = new PaymentGateway();
        $PG->environment = 'local';
        $result = $PG->obtainJWT($TestMerchantUsername, $TestMerchantPassword);
        $this->assertEquals(
            'success',
            $result['status']
        );
    }
}
