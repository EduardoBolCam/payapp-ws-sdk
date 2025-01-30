<?php

namespace DevDizs\PayappWs\Connection;

use DevDizs\PayappWs\Exceptions\BadResponseException;
use DevDizs\PayappWs\Exceptions\ConnectionException;
use DevDizs\PayappWs\Exceptions\ErrorResponseException;
use nusoap_client;

class SoapService
{
    protected $client;
    protected $clientId;

    public function __construct( string $uri, string $clientId )
    {
        $this->client = new nusoap_client( $uri, true );
        $this->clientId = $clientId;

        $error = $this->client->getError();
        if( $error ){
            throw new ConnectionException( 'Error building connection' );
        }
    }

    public function call( $methodName, $params = [] )
    {
        $params = array_merge( $this->soapBaseSetup(), $params );
        $result = $this->client->call( $methodName, $params );

        if( $this->client->fault ){
            throw new BadResponseException();
        }else{
            $error = $this->client->getError();
            if( $error ){
                throw new ErrorResponseException( $error );
            }
        }

        return $result;
    }

    public function sanitizeResponse( string $text )
    {
        $xml = simplexml_load_string( $text, "SimpleXMLElement", LIBXML_NOCDATA );
        $json = json_encode( $xml );
        return json_decode( $json, true );
    }

    protected function soapBaseSetup()
    {
        return [
            'producto'   => '',
            'id_cliente' => $this->clientId
        ];
    }
}