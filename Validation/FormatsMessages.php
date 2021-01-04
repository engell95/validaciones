<?php

trait FormatsMessages
{

    /**
    * @var array $errors
    **/
    protected static $errors = array();

    /**
     * arreglo con errores
     *
     * @access public
     * @return array
     * @version 1.0
     *
    **/
    public static function GetErrors(){
        return self::$errors;
    }

    /**
     * reiniciar arreglo con errores
     *
     * @access public
     * @return array
     * @version 1.0
     *
    **/
    public static function DeltErrors(){
        self::$errors = [];
        return;
    }

    /**
     * Lista de errores en html
     *
     * @access public
     * @return @html
     * @version 1.0
     *
    **/
    public static function DisplayErrors(){
        $html = '';
        $list = FormatsMessages::GetErrors();
        if(!empty($list))
       {
            $html = '<ul class="ul_error">';
            foreach($list as $error){
                $html .= '<li>'.$error.'</li>';
            }
            $html .= '</ul>';
            FormatsMessages::DeltErrors();
       }
        return $html;
    }

    /**
     * Mensaje de errores
     *
     * @access public
     * @param  string   $Atrribute [Nombre del campo]
     * @param  integer  $Type [Tipo de error]
     * @param  integer  $PersonalMessage [Mensaje Personalizado - ValidatesAttribute]
     * @return
     * @version 1.0
     *
    **/
    public static function MessageErrors($Attribute,$Type,$parameters = '',$PersonalMessage = ''){
        switch ($Type) {
            case 0:
                self::$errors[] = 'El campo '.$Attribute.' es requerido.';
                break;
            case 1:
                self::$errors[] = $PersonalMessage;
                break;
            case 2:
                self::$errors[] = "El campo $Attribute requiere un maximo de $parameters parametros.";
                break;
            case 3:
                self::$errors[] = "El campo $Attribute requiere un minimo de $parameters parametros.";
                break;
            case 4:
                self::$errors[] = "El formato del campo $Attribute no es valido.";
                break;
            case 5:
                self::$errors[] = "El campo $Attribute no es número entero.";
                break;
            case 6:
                self::$errors[] = "El campo $Attribute no es número float.";
                break;
        }
    }

}