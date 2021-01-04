<?php
/**
* Validation
*
* Clase de valiaciones.
*
* @author Engell Lopez
* @copyright (c) 2020, Engell Lopez
*
**/

require_once('ValidatesAttributes.php');
class Validator
{
    use ValidatesAttributes;

    /**
     * Recorrer validaciones
     *
     * @access public
     * @return
     * @version 1.0
     *
    **/
    public function validators($array)
    {
        $functionv = '';
        foreach ($array as $atribute => $valor) {
            $tags = explode('|' , $valor);
            foreach($tags as $i =>$key) {
                $length = explode(':' , $key);
                if(!empty($length[1])){
                    $functionv = $length[0];
                    $lengthv   = $length[1];
                    $exists = ValidatesAttributes::$functionv($atribute,$lengthv);
                    if($exists == 1){
                        break;
                    }
                }
                else{
                    $functionv = $key;
                    $exists = ValidatesAttributes::$functionv($atribute);
                    if($exists == 1){
                        break;
                    }
                }
            }
        }
        return Validator::Success();
    }

    /**
     * Mensaje con errores
     *
     * @access public
     * @return string
     * @version 1.0
     *
    **/
    public static function Success(){
        return ValidatesAttributes::ShowErrorMessage();
    }

}