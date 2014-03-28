#Tipo de Cambio BCCR

##Introducción
Libreria para obtener el tipo de cambio del BCCR (Banco Central de Costa Rica) y realizar conversiones.

##Instalación
#### Composer

Puedes instalar esta libreria usando [composer](http://getcomposer.org/).  Solamente agrega `arielcr/tipocambio-bccr` a tu archivo composer.json.

    {
        "require": {
            "arielcr/tipocambio-bccr": "dev-master"
        }
    }
    
##Uso
- Obtener el tipo de cambio del día:
 
        $tipo_cambio = IndicadoresBccr\Indicador::obtenerTipoCambio();

    Esta funcion recibe como parámetro el tipo de cambio deseado, para compra es `IndicadoresBccr\Indicador::COMPRA` y      para venta `IndicadoresBccr\Indicador::VENTA`. Por defecto es `COMPRA`. También puede recibir un segundo parametro      indicando la fecha del tipo de cambio, por defecto se utiliza el dia actual.

- Convertir de colones a dolares:

        $conversion = IndicadoresBccr\Indicador::convertirColonesDolares($monto);
    
- Convertir de dolares a colones:

        $conversion = IndicadoresBccr\Indicador::convertirDolaresColones($monto);
    
Si utilizas esta librería adentro de una clase puedes incluir `use IndicadoresBccr\Indicador;` para evitar tener que poner `IndicadoresBccr\` y asi usar las funciones así `Indicador::obtenerTipoCambio();`
