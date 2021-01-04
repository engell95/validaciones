# VALIDACIONES

Clase con validaciones basicas para PHP

## Comenzando 🚀

_Estas instrucciones te permitirán obtener una copia del proyecto en funcionamiento en tu máquina local para propósitos de desarrollo y pruebas._

- Descargar repositorio
- Alojar en carpeta de apache o nginx
- Abrir index.php

### Pre-requisitos 📋

- Servidor apache o nginx
- PHP 7 o superior

## Despliegue 📦

-raiz
  - Validation
    - FormatsMessages.php / Formato de mensajes
    - ValidatesAttributes.php / Funciones de validacion
    - Validator.php / Proceso de validaciones y mensajes

## Autor ✒️

* **Engell Lopez**

***********************************************************************************************************************************************************************************
Ejemplo de uso 

    //1 - Importamos el archivo con las funciones
    require_once('Validation/Validator.php');

    //2 - Iniciamos la clase
    $validate = new Validator();

    /*
    * 3 - Especificamos las variables y las reglas a evaluar
    * Ejemplo de uso
    * Nombre [Nombre de la variable recibida en POST o GET]
    * required|min:2|max:255|pattern:text [Reglas de validación separadas por | con : para los atributos]
    * --- Reglas Disponibles ---
    * 1) required       [Variable requerida y no vacía]
    * 2) min:2          [Carácter mínimo con : para definir atributo]
    * 3) max:255        [Carácter Maximo con : para definir atributo]
    * 4) pattern:text   [Tipo de valor : para definir atributo]
    *   - text      - file
    *   - url       - email
    *   - int       - address
    * 5) int            [Carácter tipo entero]
    * 6) float          [Carácter tipo float]
    */
    $validatedData = $validate->validators([
        'Nombre'        => 'required|min:2|max:255|pattern:text',
        'Action'        => 'required'
    ]);

    // 3 - Validamos si existen Mensajes de error e imprimimos
    if(!empty($validatedData)){
        echo $validatedData;
    }

    /*
    * Ejemplo de mensajes de error (La clase tomara el nombre de la variable como parte de los mensajes de errores)
    * El campo Nombre requiere un minimo de 2 parametros.
    * El campo Action es requerido
    * URL DE ACCESO
    * - http://localhost/validaciones/?Nombre=ss / envio de variable mediante metodo get (nombre)
    * - Respuesta
    * - El campo Action es requerido.
    */
