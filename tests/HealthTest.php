<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__.'/../PaymentGateway.php');

class HealthTest extends TestCase
{
    public function testHealthCheck()
    {
        $PG = new PaymentGateway();
        $result = $PG->statusCheck();
        $PG->environment = 'local';
        $this->assertEquals(
            'success',
            $result['status']
        );
    }
}
