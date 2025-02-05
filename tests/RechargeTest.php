<?php declare(strict_types=1);

use DevDizs\PayappWs\PayappHandlers\PayappBalance;
use DevDizs\PayappWs\PayappHandlers\PayappRecharge;
use PHPUnit\Framework\TestCase;

final class RechargeTest extends TestCase
{
    private $validUserTest     = '5555555555';
    private $validPasswordTest = 'password';
    private $validDongleTest   = 'dongle';

    private $validPhoneTest = '5510101010';
    private $wrongPhoneTest = '3310101010';

    public function testFetchCorrectRechargeBalance()
    {
        $payAppBalance = new PayappBalance( $this->validUserTest, $this->validPasswordTest, $this->validDongleTest );
        $balance = $payAppBalance->getRechargesBalance();

        $this->assertNotEmpty($balance);
        $this->assertEqualsIgnoringCase( 500, $balance );
    }

    public function testWrongUserInformationInFetchRechargeBalance()
    {
        $user     = '333333333';
        $password = 'qwer.987';
        $dongle   = 'donglww';

        $payAppBalance = new PayappBalance( $user, $password, $dongle );
        $balance = $payAppBalance->getRechargesBalance();

        $this->assertNotEmpty($balance);
        $this->assertEqualsIgnoringCase( 'XXX', $balance );
    }

    public function testMakeValidRecharge()
    {
        $amount = 10;
        $sku = 'TELCEL';
        $clientId = 'UTES' . rand( 0, 9999999 );

        $payAppRecharge = new PayappRecharge( $this->validUserTest, $this->validPasswordTest, $this->validDongleTest, $clientId );
        $response = $payAppRecharge->makeRecharge( $amount, $sku, $this->validPhoneTest );

        $this->assertEquals( 1, $response['status'] );
        $this->assertNotEmpty( $response['folio'] );
        $this->assertNotEmpty( $response['fecha'] );
        $this->assertEquals( '00', $response['descripcion'] );
    }

    public function testMakeWrongPhoneRecharge()
    {
        $amount = 10;
        $sku = 'TELCEL';
        $clientId = 'UTES' . rand( 0, 9999999 );

        $payAppRecharge = new PayappRecharge( $this->validUserTest, $this->validPasswordTest, $this->validDongleTest, $clientId );
        $response = $payAppRecharge->makeRecharge( $amount, $sku, $this->wrongPhoneTest );

        $this->assertEquals( 2, $response['status'] );
        $this->assertEmpty( $response['folio'] );
        $this->assertNotEmpty( $response['fecha'] );
        $this->assertEquals( '01', $response['descripcion'] );
    }
}