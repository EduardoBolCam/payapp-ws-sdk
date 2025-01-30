<?php

namespace DevDizs\PayappWs\PayappHandlers;

use DevDizs\PayappWs\Connection\SoapService;
use DevDizs\PayappWs\Exceptions\BadResponseException;

final class PayappServices
{

    private $user;
    private $password;
    private $dongle;
    private $clientId;

    private $env;

    /**
     * @param string user User Provided by Payapp
     * @param string password Password provided by Payapp
     * @param string dongle Dongle provided by Payapp
     * @param string clientId Builded Client ID like "PRO00012SS"
     * 
     */
    public function __construct( string $user, string $password, string $dongle, string $clientId )
    {
        $this->user     = $user;
        $this->password = $password;
        $this->dongle   = $dongle;
        $this->clientId = $clientId;

        $config = new Config();
        $this->env = $config->getConfig( 'env' );
    }

    /**
     * Build and send a service request (Services and Pines)
     * @param amount (n,2) Product Amount
     * @param string sku Product code
     * @param string phone Phone to be recharge
     * 
     * @return array result
     */
    public function makeServicePay( $amount, string $sku, string $reference )
    {
        $uri = 'http://wsservicios.payapp.mx/tmpagoventaws/status/soap.php?wsdl';

        if( $this->env !== 'production' ){
            $uri = 'http://testwsservicios.payapp.mx/tmpagoventaws/status/soap.php?wsdl';
        }

        $client = new SoapService( $uri, $this->clientId );

        $data = [
            'usuario'  => $this->user,
            'password' => $this->password,
            'dongle'   => $this->dongle,
            'monto'    => $amount,
            'compania' => $sku,
            'telefono' => $reference,
        ];

        $result = $client->call( 'venderServicio', $data );

        if( empty( $result ) ){
            throw new BadResponseException( 'Error fetching' );
        }

        return $client->sanitizeResponse( $result );
    }

    /**
     * Build and send a service consult balance request (Services and Pines)
     * @param string sku Product code
     * @param string phone Phone to be recharge
     * 
     * @return array result
     */
    public function checkServiceBalance( string $sku, string $reference )
    {

        $uri = 'http://wsservicios.payapp.mx/tmpagoventaws/status/soap.php?wsdl';

        if( $this->env !== 'production' ){
            $uri = 'http://testwsservicios.payapp.mx/tmpagoventaws/status/soap.php?wsdl';
        }

        $client = new SoapService( $uri, $this->clientId );

        $data = [
            'usuario'  => $this->user,
            'password' => $this->password,
            'dongle'   => $this->dongle,
            'compania' => $sku,
            'telefono' => $reference,
            'monto'    => 0
        ];

        $result = $client->call( 'consultaServicio', $data );

        if( empty( $result ) ){
            throw new BadResponseException( 'Error fetching' );
        }

        return $client->sanitizeResponse( $result );
    }
}