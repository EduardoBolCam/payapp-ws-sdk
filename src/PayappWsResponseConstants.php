<?php

namespace DevDizs\PayappWs;

class PayappWsResponseConstants
{
    const WRONG_REF = '01';
    const NOT_AVAILABLE = '03';
    const NOT_PROCESSED_NOW = '04';
    const NOT_AVAILABLE_SECOND = '05';
    const TIME_OUT = '08';
    const NOT_BALANCE = '22';
    const BAD_BUILDED = '99';

    const MESSAGES = [
        self::WRONG_REF => 'El número de teléfono o referencia no corresponde a la compañia, verifique e intente de nuevo.',
        self::NOT_AVAILABLE => 'Producto no disponible temporalmente, intente de nuevo mas tarde.',
        self::NOT_PROCESSED_NOW => 'El producto no puede ser procesado en este momento, intente de nuevo mas tarde.',
        self::NOT_AVAILABLE_SECOND => 'Producto no disponible temporalmente, intente de nuevo mas tarde.',
        self::TIME_OUT => 'Timeout, el tiempo de respuesta ha superado lo esperado, intente de nuevo mas tarde.',
        self::NOT_BALANCE => 'No pudimos procesar tu solicitud en este momento intente de nuevo mas tarde, favor de reportar este error a soporte: Código 22.',
        self::BAD_BUILDED => 'No pudimos procesar tu solicitud en este momento intente de nuevo mas tarde, favor de reportar este error a soporte: Código 99.',
    ];

    public static function getMessage( string $code )
    {
        return self::MESSAGES[$code] ?? 'Acción no procesada, ocurrio un error inesperado, intente de nuevo. Si el problema persiste contacte a soporte.';
    }
}