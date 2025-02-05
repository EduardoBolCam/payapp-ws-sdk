<?php declare(strict_types=1);

use DevDizs\PayappWs\PayappHandlers\PayappBalance;
use DevDizs\PayappWs\PayappHandlers\PayappServices;
use PHPUnit\Framework\TestCase;

final class ServicesTest extends TestCase
{
    private $validUserTest     = '5555555555';
    private $validPasswordTest = 'password';
    private $validDongleTest   = 'dongle';


    public function testFetchCorrectServiceBalance()
    {
        $payAppBalance = new PayappBalance( $this->validUserTest, $this->validPasswordTest, $this->validDongleTest );
        $balance = $payAppBalance->getServicesBalance();

        $this->assertNotEmpty($balance);
        $this->assertEqualsIgnoringCase( 500, $balance );
    }

    public function testWrongUserInformationInFetchServicesBalance()
    {
        $user     = '333333333';
        $password = 'qwer.987';
        $dongle   = 'donglww';

        $payAppBalance = new PayappBalance( $user, $password, $dongle );
        $balance = $payAppBalance->getServicesBalance();

        $this->assertNotEmpty($balance);
        $this->assertEqualsIgnoringCase( 'XSERV', $balance );
    }

    public function testMakeValidService()
    {
        $amount = 100;
        $sku = 'Telmex';
        $clientId = 'UTES' . rand( 0, 9999999 );
        $ref = 'asdf9876';

        $payAppRecharge = new PayappServices( $this->validUserTest, $this->validPasswordTest, $this->validDongleTest, $clientId );
        $response = $payAppRecharge->makeServicePay( $amount, $sku, $ref );

        $this->assertEquals( 1, $response['status'] );
        $this->assertNotEmpty( $response['folio'] );
        $this->assertNotEmpty( $response['fecha'] );
        $this->assertEquals( '00', $response['descripcion'] );
    }

    public function testMakeValidConsultService()
    {
        $sku = 'Telmex';
        $clientId = 'UTES' . rand( 0, 9999999 );
        $ref = 'asdf9876';

        $payAppRecharge = new PayappServices( $this->validUserTest, $this->validPasswordTest, $this->validDongleTest, $clientId );
        $response = $payAppRecharge->checkServiceBalance( $sku, $ref );

        $this->assertEquals( 1, $response['status'] );
        $this->assertNotEmpty( $response['folio'] );
        $this->assertNotEmpty( $response['fecha'] );
        $this->assertEquals( '00', $response['descripcion'] );
    }
}