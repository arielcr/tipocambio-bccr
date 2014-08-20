<?php

namespace IndicadoresBccr;

class Indicador
{
    // Constantes de tipo de cambio
    const COMPRA = 317;
    const VENTA = 318;
    const EURO = 333;

    // URL del WebService
    const IND_ECONOM_WS = "http://indicadoreseconomicos.bccr.fi.cr/indicadoreseconomicos/WebServices/wsIndicadoresEconomicos.asmx";

    // Metodo que se va a utilizar del WebService
    const IND_ECONOM_METH = "ObtenerIndicadoresEconomicosXML";

    /**
     * Obtiene el tipo de cambio del dia
     *
     * @param string $tipo Tipo de cambio deseado (COMPRA/VENTA/EURO)
     * @param string $fecha Fecha del tipo de cambio deseado
     * @return float Valor del tipo de cambio
     */
    public static function obtenerTipoCambio($tipo = "", $fecha = "")
    {
        date_default_timezone_set('America/Costa_Rica');
        $fecha_tc = empty($fecha) ? date("d/m/Y") : $fecha;
        $tipo_tc = empty($tipo) ? self::COMPRA : $tipo;

        $urlWS = self::IND_ECONOM_WS . "/" . self::IND_ECONOM_METH . "?tcIndicador=" . $tipo_tc . "&tcFechaInicio=" . $fecha_tc . "&tcFechaFinal=" . $fecha_tc . "&tcNombre=tq&tnSubNiveles=N";
        $tipoCambio = 0;

        if (self::url_get_contents($urlWS) != false) {
            $indWS = self::url_get_contents($urlWS);
            $xml = simplexml_load_string($indWS);
            $tipo_cambio = trim(strip_tags(substr($xml, strpos($xml, "<NUM_VALOR>"), strripos($xml, "</NUM_VALOR>"))));
            $tipoCambio = number_format($tipo_cambio, 2);
        }

        return (float)$tipoCambio;
    }

    /**
     * Convierte un monto de colones a dolares
     *
     * @param $monto El monto a convertir
     * @return float El monto convertido
     */
    public static function convertirColonesDolares($monto)
    {
        $tipo_cambio = self::obtenerTipoCambio(self::COMPRA);
        return ($tipo_cambio > 0) ? number_format(($monto / $tipo_cambio), 2, '.', '') : 0;
    }

    /**
     * Convierte un monto de dolares a colones
     *
     * @param $monto El monto a convertir
     * @return float El monto convertido
     */
    public static function convertirDolaresColones($monto)
    {
        $tipo_cambio = self::obtenerTipoCambio(self::COMPRA);
        return ($tipo_cambio > 0) ? number_format(($monto * $tipo_cambio), 2, '.', '') : 0;
    }

    /**
     * Convierte un monto de dolares a Euros
     *
     * @param $monto El monto a convertir
     * @return float El monto convertido
     */
    public static function convertirDolaresEuros(){
        $monto = self::obtenerTipoCambio(self::VENTA);
        $tipo_cambio = self::obtenerTipoCambio(self::EURO);
        return ($tipo_cambio > 0) ? number_format(($monto * $tipo_cambio), 2, '.', '') : 0;
    }

    /**
     * Obtiene datos por CURL
     * @param  string $Url Url del webservice
     * @return $output Respuesta del webservice
     */
    public static function url_get_contents($Url) {
        if (!function_exists('curl_init')){ 
            die('CURL is not installed!');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $Url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

} 