<?php

namespace DevDizs\PayappWs\PayappHandlers;

use DevDizs\PayappWs\Connection\SoapService;

final class PayappBalance
{
    const CHECK_BALANCE_ACTION = 'saldo2';

    private $user;
    private $password;
    private $dongle;

    private $env;

    /**
     * @param string user User Provided by Payapp
     * @param string password Password provided by Payapp
     * @param string dongle Dongle provided by Payapp
     * @param string clientId Builded Client ID like "PRO00012SS"
     * 
     */
     public function __construct( string $user, string $password, string $dongle )
     {
         $this->user     = $user;
         $this->password = $password;
         $this->dongle   = $dongle;
 
         $config = new Config();
         $this->env = $config->getConfig( 'env' );
     }

    public function getRechargesBalance()
    {
        $action = self::CHECK_BALANCE_ACTION;

        $data = [
            'usuario'  => $this->user,
            'password' => $this->password,
            'dongle'   => $this->dongle,
        ];

        $uri = 'http://wsrecargas.payapp.mx/tmpagoventaws/status/soap.php?wsdl';

        if( $this->env !== 'production' ){
            $uri = 'http://testwsrecargas.payapp.mx/tmpagoventaws/status/soap.php?wsdl';
        }

        $client = new SoapService( $uri, '' );
        return $client->call( $action, $data );
    }

    public function getServicesBalance()
    {
        $action = self::CHECK_BALANCE_ACTION;

        $data = [
            'usuario'  => $this->user,
            'password' => $this->password,
            'dongle'   => $this->dongle,
        ];

        $uri = 'http://wsservicios.payapp.mx/tmpagoventaws/status/soap.php?wsdl';

        if( $this->env !== 'production' ){
            $uri = 'http://testwsservicios.payapp.mx/tmpagoventaws/status/soap.php?wsdl';
        }

        $client = new SoapService( $uri, '' );
        return $client->call( $action, $data );
    }
}