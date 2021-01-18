<?php

//require_once('config/Validation/FormatsMessages.php');
require_once(__DIR__ .'/FormatsMessages.php');

trait ValidatesAttributes{

    use FormatsMessages;

    /**
     * Lista de Mensaje de errores
     *
     * @access public
     * @return @html
     * @version 1.0
     *
    **/
    public static function ShowErrorMessage(){
        return  FormatsMessages::DisplayErrors();
    }

    /**
    * Valor del campo
    *
    * @return @value
    * @version 1.0
    *
    **/
    public static function Value($Atrribute){
        $value = '';
        if(isset($_REQUEST[$Atrribute])){
            $value =  $_REQUEST[$Atrribute];
        }
        return $value;
    }

    /**
    * @var array $patterns
    **/
    protected static $patterns = array(
        'uri'           => '[A-Za-z0-9-\/_?&=]+',
        'url'           => '[A-Za-z0-9-:.\/_?&=#]+',
        'alpha'         => '[\p{L}]+',
        'words'         => '[\p{L}\s]+',
        'alphanum'      => '[\p{L}0-9]+',
        'int'           => '[0-9]+',
        'float'         => '[0-9\.,]+',
        'tel'           => '[0-9+\s()-]+',
        'text'          => '[\p{L}0-9\s-.,;:!"%&()?+\'°#\/@]+',
        'file'          => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+\.[A-Za-z0-9]{2,4}',
        'folder'        => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+',
        'address'       => '[\p{L}0-9\s.,()°-]+',
        'date_dmy'      => '[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4}',
        'date_ymd'      => '[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}',
        'email'         => '[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+[.]+[a-z-A-Z]'
    );

    /**
     * Campo requerido
     *
     * @access public
     * @param  string   $Atrribute [Nombre del campo]
     * @return
     * @version 1.0
     *
    **/
    public static function required($Attribute){

        $value = ValidatesAttributes::Value($Attribute);

        if (is_null($value)) {
            FormatsMessages::MessageErrors($Attribute,0);
            return true;
        } elseif (is_string($value) && trim($value) === '') {
            FormatsMessages::MessageErrors($Attribute,0);
            return true;
        } elseif ((is_array($value) || $value instanceof Countable) && count($value) < 1) {
            FormatsMessages::MessageErrors($Attribute,0);
            return true;
        } elseif ($value instanceof File) {
            FormatsMessages::MessageErrors($Attribute,0);
            return true;
        }
        return;
    }

    /**
    * Validar formato
    *
    * @param string $pattern
    * @return this
    *
    */
    public static function pattern($Attribute,$pattern){
        $regex = '/^('.self::$patterns[$pattern].')$/u';
        $value = ValidatesAttributes::Value($Attribute);
        if(!preg_match($regex, $value)){
            FormatsMessages::MessageErrors($Attribute,4);
            return true;
        }
        return;
    }

    /**
     * Validar que el tamaño de un atributo sea menor que un valor máximo.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @param  array   $parameters
     * @return bool
     */
    public static function max($Attribute, $Parameters)
    {
        $value = ValidatesAttributes::Value($Attribute);
        ValidatesAttributes::requireParameterCount(1, $value, 'max');
        $size = mb_strlen($value);
        if($size > $Parameters){
            FormatsMessages::MessageErrors($Attribute,2,$Parameters);
            return true;
        }

        return;
    }

    /**
     * Validar que el tamaño de un atributo sea menor que un valor minimo.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @param  array   $parameters
     * @return bool
     */
    public static function min($Attribute, $Parameters)
    {
        $value = ValidatesAttributes::Value($Attribute);
        ValidatesAttributes::requireParameterCount(1, $value, 'max');
        $size = mb_strlen($value);
        if($size < $Parameters){
            FormatsMessages::MessageErrors($Attribute,2,$Parameters);
            return true;
        }

        return;
    }

     /**
     * Validar que el valor este entre un rango
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @param  array   $parameters
     * @return bool
     */
    public static function between($Attribute, $ParametersStart,$ParametersFinish)
    {
        if (!is_numeric($Attribute)) {
            return true;
        }

        $value = ValidatesAttributes::Value($Attribute);
        ValidatesAttributes::requireParameterCount(1, $value, 'min');
        $size = ValidatesAttributes::getSize('', $value);

        if($size > $ParametersStart or $size < $ParametersFinish){
            FormatsMessages::MessageErrors($Attribute,1,$Parameters,"El campo $Attribute requiere un valor entre $ParametersStart y $ParametersFinish.");
            return true;
        }

        return;
    }

    /**
    * Verifica se el valor en entero
    * un numero intero
    *
    * @param mixed $value
    * @return boolean
    */
    public static function int($Attribute){
        $value = ValidatesAttributes::Value($Attribute);
        if(filter_var($value, FILTER_VALIDATE_INT)){
            FormatsMessages::MessageErrors($Attribute,5);
            return true;
        }
        return;
    }

    /**
    * Verifica se el valor en float
    * un numero float
    *
    * @param mixed $value
    * @return boolean
    *
    */
    public static function float($Attribute){
        $value = ValidatesAttributes::Value($Attribute);
        if(filter_var($value, FILTER_VALIDATE_FLOAT)){
            FormatsMessages::MessageErrors($Attribute,6);
            return true;
        }
        return;
    }

    /**
     * Requiere que esté presente un cierto número de parámetros.
     *
     * @param  int    $count
     * @param  array  $parameters
     * @param  string  $rule
     * @return void
     *
    */
    protected static function requireParameterCount($count, $parameters, $rule)
    {
        if (is_array($parameters) ) {
            if (count($parameters) < $count) {
                //FormatsMessages::MessageErrors('',1,'',"Validation rule $rule requires at least $count parameters.");
                return true;
            }
        }
        else{
            if (strlen($parameters) < $count) {
                //FormatsMessages::MessageErrors('',1,"Validation rule $rule requires at least $count parameters.");
                return true;
            }
        }
    }

    /**
     * Obtenga el tamaño de un atributo.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @return mixed
     */
    protected static function getSize($Attribute, $value)
    {

        // This method will determine if the attribute is a number, string, or file and
        // return the proper size accordingly. If it is a number, then number itself
        // is the size. If it is a file, we take kilobytes, and for a string the
        // entire length of the string will be considered the attribute size.
        if (is_numeric($value)) {
            return $value;
        } elseif (is_array($value)) {
            return count($value);
        } elseif ($value instanceof File) {
            return $value->getSize() / 1024;
        }

        return mb_strlen($value);
    }

}