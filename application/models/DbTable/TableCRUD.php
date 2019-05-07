<?php

use Symfony\Component\Yaml\Dumper;

/**
 * Clase que controla los CRUD de base de datos.
 *
 * @author Daniel Escamilla <descamilla at recaudos integrados dot com>
 * @author Julian Raigosa <julianr at recaudosintegrados dot com>
 * 
 */
class Model_DBTable_TableCRUD
{
    /**
     * Contiene la conexión a la base de datos.
     * @var Object
     */
    public $conexion;

    /**
     * Contiene el esquema en el que se encuentra la función a llamar
     * @var String
     */
    public $esquema;

    /**
     * Contiene el resultado del llamado a la función
     * @var Array
     */
    public $retorno;


    function __construct($esquema) 
    {
       $this->conexion = Cla_Conexion::getInstancia();
       $this->esquema = $esquema;
       $this->retorno = [];
    }

    /**
     * Inicia una transacción en base de datos
     * 
     * @return void
     */
    public function begin()
    {
        $sql = "BEGIN"; 
        $stmt = $this->conexion->db->prepare($sql);
        $stmt -> execute();
        $stmt = NULL;
    }

    /**
     * Termina una transacción en base de datos
     * 
     * @return void
     */
    public function commit()
    {
        $sql = "COMMIT"; 
        $stmt = $this->conexion->db->prepare($sql);            
        $stmt->execute();
        $stmt = NULL;
    }

    /**
     * Gestiona el proceso de inserción de un registro a la base de datos.
     * 
     * @param  String $parChaModelo, la opcion que corresponde al nombre de la tabla a la cual insertar.
     * @param  Array $parArrDatos, corresponde al array de datos que se va insertar.
     * 
     * @return Array [par_int_error, part_int_msg]
     */
    public function insertar($parChaModelo, $parArrDatos)
    {
        //$parChaDatos = "ARRAY['" . implode("','", $parArrDatos) . "']";

        $parChaModelo = "'{$parChaModelo}'"; 
        $funcion = "FN_" . $this->esquema . "__INSERTAR_GEN";
        $this->begin();
        
        $sql = 'SELECT "' . $this->esquema . '"."'. $funcion. '"(' . $parChaModelo . ',' . $parArrDatos .')'; 
        
        // DESCOMENTAR PARA HACER DEBUG
        
        /*echo "<pre>";
        var_dump($sql);
        echo "</pre>";
        exit;*/
        
        $stmt = $this->conexion->db->prepare($sql);
        $stmt->setFetchMode(Zend_Db::FETCH_ASSOC);            
        $stmt->execute();          
        $retornoTMP = $stmt->fetchAll();
        
        $this->commit();

        foreach ($retornoTMP as $cad)
            foreach ($cad as $ret)
                $retorno = $ret;
        
        $this->retorno = explode(',', substr($retorno, 1, strlen($retorno)-2));
    }

    /**
     * Gestiona el proceso de inserción de un registro a la base de datos.
     * 
     * @param  String $parChaModelo, la opcion que corresponde al nombre de la tabla a la cual insertar.
     * @param  Array $parArrDatos, corresponde al array de datos que se va a insertar.
     * @param  Array $parrArrDataCom, corresponde al array de datos complementarios que se van a insertar.
     * @param  Array $prepararArrayCom, si se debe preparar el array de datos complementarios o no (sino es porque llega
     * desde el controlador listo para el envio).
     * 
     * @return Array [par_int_error, part_int_msg]
     */
    public function insertarParticular($parChaModelo, $parArrDatos, $parrArrDataCom, $prepararArrayCom = TRUE)
    {
        if ($prepararArrayCom) {
            $parrArrDataCom = "ARRAY['" . implode("','", $parrArrDataCom) . "']";
        }

        $parChaModelo = "'{$parChaModelo}'"; 
        $funcion = "FN_" . $this->esquema . "__INSERTAR_PARTICULAR";
        $this->begin();
        
        $sql = 'SELECT "' . $this->esquema . '"."'. $funcion. '"(' . $parChaModelo . ',NULL,' . $parArrDatos .',' . $parrArrDataCom .')'; 
        
        // DESCOMENTAR PARA HACER DEBUG
        
        /*echo "<pre>";
        var_dump($sql);
        echo "</pre>";
        exit;*/
        
        $stmt = $this->conexion->db->prepare($sql);
        $stmt->setFetchMode(Zend_Db::FETCH_ASSOC);            
        $stmt->execute();          
        $retornoTMP = $stmt->fetchAll();
        
        $this->commit();

        foreach ($retornoTMP as $cad)
            foreach ($cad as $ret)
                $retorno = $ret;
        
        $this->retorno = explode(',', substr($retorno, 1, strlen($retorno)-2));
    }   

        /**
     * Gestiona el proceso de inserción de un registro a la base de datos.
     * 
     * @param  String $parChaModelo, la opcion que corresponde al nombre de la tabla a la cual insertar.
     * @param  Array $parArrDatos, corresponde al array de datos que se va a insertar.
     * @param  Array $parrArrDataCom1, corresponde al array1 de datos complementarios que se van a insertar.
     * @param  Array $parrArrDataCom2, corresponde al array2 de datos complementarios que se van a insertar.
     * 
     * @return Array [par_int_error, part_int_msg]
     */
    public function insertarParticular2($parChaModelo, $parArrDatos, $parrArrDataCom1, $parrArrDataCom2 = 'NULL')
    {

        $parChaModelo = "'{$parChaModelo}'"; 
        $funcion = "FN_" . $this->esquema . "__INSERTAR_PARTICULAR2";
        $this->begin();
        
        $sql = 'SELECT "' . $this->esquema . '"."'. $funcion. '"(' . $parChaModelo . ',NULL,' . $parArrDatos . ',' . $parrArrDataCom1 . ',' . $parrArrDataCom2 .')'; 
        
        // DESCOMENTAR PARA HACER DEBUG
        
        /*echo "<pre>";
        var_dump($sql);
        echo "</pre>";
        exit;*/
        

        $stmt = $this->conexion->db->prepare($sql);
        $stmt->setFetchMode(Zend_Db::FETCH_ASSOC);            
        $stmt->execute();          
        $retornoTMP = $stmt->fetchAll();
        
        $this->commit();

        foreach ($retornoTMP as $cad)
            foreach ($cad as $ret)
                $retorno = $ret;
        
        $this->retorno = explode(',', substr($retorno, 1, strlen($retorno)-2));
    }  


        /**
     * Gestiona el proceso de inserción de un registro a la base de datos.
     * 
     * @param  String $parChaModelo, la opcion que corresponde al nombre de la tabla a la cual insertar.
     * @param  Array $parArrDatos, corresponde al array de datos que se va a insertar.
     * @param  Array $parrArrDataCom1, corresponde al array1 de datos complementarios que se van a insertar.
     * @param  Array $parrArrDataCom2, corresponde al array2 de datos complementarios que se van a insertar.
     * 
     * @return Array [par_int_error, part_int_msg]
     */
    public function insertarParticular3($parChaModelo, $parArrDatos, $parrArrDataCom1, $parrArrDataCom2 = 'NULL', $parrArrDataCom3 = 'NULL')
    {

        $parChaModelo = "'{$parChaModelo}'"; 
        $funcion = "FN_" . $this->esquema . "__INSERTAR_PARTICULAR3";
        $this->begin();
        
        $sql = 'SELECT "' . $this->esquema . '"."'. $funcion. '"(' . $parChaModelo . ',NULL,' . $parArrDatos . ',' . $parrArrDataCom1 . ',' . $parrArrDataCom2 . ',' . $parrArrDataCom3 .')'; 
        
        // DESCOMENTAR PARA HACER DEBUG
        
        /*echo "<pre>";
        var_dump($sql);
        echo "</pre>";
        exit;*/
        

        $stmt = $this->conexion->db->prepare($sql);
        $stmt->setFetchMode(Zend_Db::FETCH_ASSOC);            
        $stmt->execute();          
        $retornoTMP = $stmt->fetchAll();
        
        $this->commit();

        foreach ($retornoTMP as $cad)
            foreach ($cad as $ret)
                $retorno = $ret;
        
        $this->retorno = explode(',', substr($retorno, 1, strlen($retorno)-2));
    }     

    /**
     * Gestiona el proceso de inserción masivo (varios registros) a una tabla de la base de datos.
     * 
     * @param  String $parChaOpcion, la opcion que corresponde al nombre de la tabla a la cual insertar.
     * @param  Array $cadenaInsercion, corresponde al sting de datos que se va insertar masivamente.
     * 
     * @return Array [par_int_error, part_int_msg]
     */
    public function insertarMasivo($parChaOpcion, $parChaElimClave, $usuario, $cadenaInsercion)
    {
        $parChaOpcion = "'{$parChaOpcion}'"; 
        $parChaElimClave = "'{$parChaElimClave}'";
        $usuario = "'{$usuario}'";
        $funcion = "FN_" . $this->esquema . "__INSERTAR_MASIVO";
        $this->begin();
        
        $sql = 'SELECT "' . $this->esquema . '"."'. $funcion. '"(' . $parChaOpcion . ','. $parChaElimClave . ',' . $usuario . ', ARRAY['. $cadenaInsercion . '])'; 
        
        // DESCOMENTAR PARA HACER DEBUG
        /*echo "<pre>";
        var_dump($sql);
        echo "</pre>";
        exit;*/

        $stmt = $this->conexion->db->prepare($sql);
        $stmt->setFetchMode(Zend_Db::FETCH_ASSOC);            
        $stmt->execute();          
        $retornoTMP = $stmt->fetchAll();
        
        $this->commit();

        foreach ($retornoTMP as $cad)
            foreach ($cad as $ret)
                $retorno = $ret;
        
        $this->retorno = explode(',', substr($retorno, 1, strlen($retorno)-2));
    }

    public function insertarMasivoArchivo($parChaOpcion, $cadena, $usuario)
	{
        $parChaOpcion = "'{$parChaOpcion}'"; 
        $usuario = "'{$usuario}'";
        $funcion = "FN_" . $this->esquema . "__INSERTAR_MASIVO_ARCHIVO";
        $datos1 = "'noprocesados'";
        $datos2 = "'procesados'";
        $this->begin();
        

		$sql = 'SELECT "' . $this->esquema . '"."'. $funcion. '"(' . $parChaOpcion . ',' . $cadena . ','. $usuario. ','. $datos1 . ','. $datos2.')'; 	
        //die($sql);
        
        $stmt = $this->conexion->db->prepare($sql);
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ);
		$stmt->execute();
		$cadenaTmp = $stmt->fetchAll();

				
		$sql = 'FETCH ALL IN "noprocesados"';
        $stmt = $this->conexion->db->prepare($sql);
		$stmt->setFetchMode(Zend_Db::FETCH_ASSOC);
		$stmt->execute();
		$noprocesados = $stmt->fetchAll();
			
		$sql = 'FETCH ALL IN "procesados"';
		$stmt = $this->conexion->db->prepare($sql);
		$stmt->setFetchMode(Zend_Db::FETCH_ASSOC);
		$stmt->execute();
		$procesados = $stmt->fetchAll();
	
        $this->retorno = ARRAY($noprocesados, $procesados);
        
        $this->commit();
        
		return $this->retorno;
    }
    
    /**
     * Gestiona el proceso de actualización de un registro de la base de datos.
     * 
     * @param  String $parChaModelo, la opcion que corresponde al nombre de la tabla a la cual actualizar.
     * @param  Array $parArrLlaves, array que contiene la(s) llaves primarias del registro a actualizar.
     * @param  Array $parArrDatos, corresponde al array de datos que se va actualizar.
     * 
     * @return Array [par_int_error, part_int_msg]
     */
    public function actualizar($parChaModelo, $parArrDatos, $parArrLlaves)
    {
        $parChaModelo = "'{$parChaModelo}'"; 
        $funcion = "FN_" . $this->esquema . "__ACTUALIZAR_GEN";
        $cadenaId = "";
        $this->begin();

    	foreach ($parArrLlaves as $id){
        	$cadenaId .="'".$id."', ";
        }
        
        $cadenaId = substr($cadenaId, 0,-2);
        $cadenaId = 'ARRAY['.$cadenaId.']';
    	        
        //SELECCIONAMOS EL PROCEDIMIENTO ALMACENADO
        $sql = 'SELECT "' . $this->esquema . '"."'. $funcion. '"(' . $parChaModelo . "," . $parArrDatos . ", NULL, $cadenaId)"; //EJECUTAR FUNCION 
        
        // DESCOMENTAR PARA HACER DEBUG
        
        /*echo "<pre>";
        var_dump($sql);
        echo "</pre>";
        exit;*/
        
        $stmt = $this->conexion->db->prepare($sql);
        $stmt->setFetchMode(Zend_Db::FETCH_ASSOC);            
        $stmt->execute();          
        $retornoTMP = $stmt->fetchAll();
        
        $this->commit();

        foreach ($retornoTMP as $cad)
            foreach ($cad as $ret)
                $retorno = $ret;
        
        $this->retorno = explode(',', substr($retorno, 1, strlen($retorno)-2));
    }

    /**
     * Gestiona el proceso de actualización de un registro de la base de datos.
     * 
     * @param  String $parChaModelo, la opcion que corresponde al nombre de la tabla a la cual actualizar.
     * @param  Array $parArrLlaves, array que contiene la(s) llaves primarias del registro a actualizar.
     * @param  Array $parArrDatos, corresponde al array de datos que se va actualizar.
     * 
     * @return Array [par_int_error, part_int_msg]
     */
    public function actualizarParticular($parChaModelo, $parArrDatos, $parArrLlaves, $parrArrDataCom, $prepararArrayCom = TRUE)
    {
        if ($prepararArrayCom) {
            $parrArrDataCom = "ARRAY['" . implode("','", $parrArrDataCom) . "']";
        }

        $parChaModelo = "'{$parChaModelo}'"; 
        $funcion = "FN_" . $this->esquema . "__ACTUALIZAR_PARTICULAR";
        $cadenaId = "";
        $this->begin();

    	foreach ($parArrLlaves as $id){
        	$cadenaId .="'".$id."', ";
        }
        
        $cadenaId = substr($cadenaId, 0,-2);
        $cadenaId = 'ARRAY['.$cadenaId.']';
    	        
        //SELECCIONAMOS EL PROCEDIMIENTO ALMACENADO
        $sql = 'SELECT "' . $this->esquema . '"."'. $funcion. '"(' . $parChaModelo . "," . $parArrDatos . ", NULL, $cadenaId, $parrArrDataCom)"; //EJECUTAR FUNCION 
        
        // DESCOMENTAR PARA HACER DEBUG
        /*
        echo "<pre>";
        var_dump($sql);
        echo "</pre>";
        exit;
        */

        $stmt = $this->conexion->db->prepare($sql);
        $stmt->setFetchMode(Zend_Db::FETCH_ASSOC);            
        $stmt->execute();          
        $retornoTMP = $stmt->fetchAll();
        
        $this->commit();

        foreach ($retornoTMP as $cad)
            foreach ($cad as $ret)
                $retorno = $ret;
        
        $this->retorno = explode(',', substr($retorno, 1, strlen($retorno)-2));
    }

    /**
     * Gestiona el proceso de actualización de un registro de la base de datos.
     * 
     * @param  String $parChaModelo, la opcion que corresponde al nombre de la tabla a la cual actualizar.
     * @param  Array $parArrLlaves, array que contiene la(s) llaves primarias del registro a actualizar.
     * @param  Array $parArrDatos, corresponde al array de datos que se va actualizar.
     * @param  Array $parrArrDataCom1, corresponde al array1 de datos complementarios que se va actualizar.
     * @param  Array $parrArrDataCom2, corresponde al array2 de datos complementarios que se va actualizar.
     * 
     * @return Array [par_int_error, part_int_msg]
     */
    public function actualizarParticular2($parChaModelo, $parArrDatos, $parArrLlaves, $parrArrDataCom1, $parrArrDataCom2)
    {
        $parChaModelo = "'{$parChaModelo}'"; 
        $funcion = "FN_" . $this->esquema . "__ACTUALIZAR_PARTICULAR2";
        $cadenaId = "";
        $this->begin();

    	foreach ($parArrLlaves as $id){
        	$cadenaId .="'".$id."', ";
        }
        
        $cadenaId = substr($cadenaId, 0,-2);
        $cadenaId = 'ARRAY['.$cadenaId.']';
    	        
        //SELECCIONAMOS EL PROCEDIMIENTO ALMACENADO
        $sql = 'SELECT "' . $this->esquema . '"."'. $funcion. '"(' . $parChaModelo . "," . $parArrDatos . ", NULL, $cadenaId, $parrArrDataCom1, $parrArrDataCom2)"; //EJECUTAR FUNCION 
        
        // DESCOMENTAR PARA HACER DEBUG
        
        /*echo "<pre>";
        var_dump($sql);
        echo "</pre>";
        exit;*/
        

        $stmt = $this->conexion->db->prepare($sql);
        $stmt->setFetchMode(Zend_Db::FETCH_ASSOC);            
        $stmt->execute();          
        $retornoTMP = $stmt->fetchAll();
        
        $this->commit();

        foreach ($retornoTMP as $cad)
            foreach ($cad as $ret)
                $retorno = $ret;
        
        $this->retorno = explode(',', substr($retorno, 1, strlen($retorno)-2));
    }    

    /**
     * Gestiona el proceso de Eliminación de un registro de la base de datos.
     * 
     * @param  String $parChaModelo, la opcion que corresponde al nombre de la tabla a la cual eliminar un registro.
     * @param  Array $parArrLlaves, array que contiene la(s) llaves primarias del registro a eliminar
     * 
     * @return Array [par_int_error, part_int_msg]
     */
    public function eliminar($parChaModelo, $parArrDatos, $parArrLlaves)
    {
        $parChaDatos = count($parArrDatos) ? "ARRAY['" . implode("','", $parArrDatos) . "']" : "ARRAY['']";
        $parChaModelo = "'{$parChaModelo}'"; 
        $funcion = "FN_" . $this->esquema . "__ELIMINAR_GEN";
        $cadenaId = "";
        $this->begin();

    	foreach ($parArrLlaves as $id){
        	$cadenaId .="'".$id."', ";
        }
        
        $cadenaId = substr($cadenaId, 0,-2);
        $cadenaId = 'ARRAY['.$cadenaId.']';
    	        
        //SELECCIONAMOS EL PROCEDIMIENTO ALMACENADO
        $sql = 'SELECT "' . $this->esquema . '"."'. $funcion. '"(' . $parChaModelo . "," . $parChaDatos . ", $cadenaId)"; //EJECUTAR FUNCION 
        
        // DESCOMENTAR PARA HACER DEBUG
        
       /* echo "<pre>";
        var_dump($sql);
        echo "</pre>";
        exit;*/
        

        $stmt = $this->conexion->db->prepare($sql);
        $stmt->setFetchMode(Zend_Db::FETCH_ASSOC);            
        $stmt->execute();          
        $retornoTMP = $stmt->fetchAll();
        
        $this->commit();

        foreach ($retornoTMP as $cad)
            foreach ($cad as $ret)
                $retorno = $ret;
        
        $this->retorno = explode(',', substr($retorno, 1, strlen($retorno)-2));
    }

    /**
     * Gestiona el proceso de seleccion de un registro o todos de la base de datos.
     * 
     * @param  String $parChaModeloModo, la opcion que corresponde al nombre de la tabla a la cual consultar y el modo 
     * (_UNO ó _TODOS).
     * @param  Array $parArrDatos, corresponde al array de datos con los cuales consultar, solo si el modo es UNO (traera 
     * la llave primaria)
     * @param  Array $parArrFiltroDatos, corresponde al array de datos con los cuales se filtrara la consulta, por ejemplo traer los datos solo de cierta regional o empresa)
     * 
     * @return Array [par_cur_datos, par_int_error, part_int_msg]
     */
    public function seleccionar($parChaModeloModo, $parArrDatos, $parArrFiltroDatos = 'NULL', $print=false)
    {
        $parChaDatos = count($parArrDatos) ? "ARRAY['" . implode("','", $parArrDatos) . "']" : "ARRAY['']";
        
        if ($parArrFiltroDatos != 'NULL'){   
            if (count($parArrFiltroDatos)) {
                if (is_array($parArrFiltroDatos) && reset($parArrFiltroDatos) != 'NULL') {
                    $parArrFiltroDatos = "ARRAY['" . implode("','", $parArrFiltroDatos) . "']";
                } else {
                    $parArrFiltroDatos = 'NULL';
                }
            } else {
                $parArrFiltroDatos = "ARRAY['']";
            }
        }

        $parChaModeloModo = "'{$parChaModeloModo}'"; 

        $datos = "'datos'";
        $funcion = "FN_" .$this->esquema . "__SELECCIONAR";

        $sql = "BEGIN"; 
        $stmt = $this->conexion->db->prepare($sql);
        $stmt->execute();

        if(in_array($this->esquema , array('ADM', 'FOR'))){
            $sql = 'SELECT "' . $this->esquema . '"."'. $funcion. '"(' . $parChaModeloModo .', ' . $parChaDatos . ',' .$datos . ')'; 
        }else{
            $sql = 'SELECT "' . $this->esquema . '"."'. $funcion. '"(' . $parChaModeloModo .', ' . $parChaDatos . ', '  . $parArrFiltroDatos . ', ' .$datos . ')'; 
        }
        
       

        // DESCOMENTAR PARA HACER DEBUG
       if ($print) {
            echo "<pre>";
            var_dump($sql);
            echo "</pre>";
            exit;
       }
         

    	$stmt = $this->conexion->db->prepare($sql);
    	$stmt->setFetchMode(Zend_Db::FETCH_OBJ);
    	$stmt->execute();
    	$cadenaTmp = $stmt->fetchAll();
    	
    	//LLAMAMOS EL CURSOR CAMPOS
        $sql = 'FETCH ALL IN "datos"'; 
        $stmt = $this->conexion->db->prepare($sql);
        $stmt->setFetchMode(Zend_Db::FETCH_ASSOC);
        $stmt->execute();
        $this->retorno = $stmt->fetchAll(); 
    	
    	//COMMIT
        $this->commit();

    	//clear the statement
        $stmt = null;
    	return $this->retorno;
    }

    /**
     * Gestiona el proceso de seleccionar registros especiales a la base de datos.
     * 
     * @param  String $parChaOpcion, la opcion que corresponde al caso deseado que se encuentre en la sencia IF del PL
     * @param  Array $parArrDatos, corresponde al array de datos que contiene los parametros necesarios para ejecutar la
     * consulta.
     * 
     * @return Array [par_cur_datos, par_int_error, part_int_msg]
     */
    public function seleccionarParticular($parChaModeloModo, $parArrDatos)
    {
        $parChaDatos = count($parArrDatos) ? "ARRAY['" . implode("','", $parArrDatos) . "']" : "ARRAY['']";
        $parChaModeloModo = "'{$parChaModeloModo}'"; 
        $datos = "'datos'";
        $funcion = "FN_" .$this->esquema . "__SELECCIONAR_PARTICULAR";

        $sql = "BEGIN"; 
        $stmt = $this->conexion->db->prepare($sql);
        $stmt->execute();
        
        $sql = 'SELECT "' . $this->esquema . '"."'. $funcion. '"('. $datos . ',' . $parChaModeloModo .', ' . $parChaDatos . ')'; 

        // DESCOMENTAR PARA HACER DEBUG
        
       /* echo "<pre>";
        var_dump($sql);
        echo "</pre>";
        exit;*/
         

    	$stmt = $this->conexion->db->prepare($sql);
    	$stmt->setFetchMode(Zend_Db::FETCH_OBJ);
    	$stmt->execute();
        $cadenaTmp = $stmt->fetchAll();
        
        
    	//LLAMAMOS EL CURSOR CAMPOS
        $sql = 'FETCH ALL IN "datos"'; 
        $stmt = $this->conexion->db->prepare($sql);
        $stmt->setFetchMode(Zend_Db::FETCH_ASSOC);
        $stmt->execute();
        $this->retorno = $stmt->fetchAll(); 
    	
    	//COMMIT
        $this->commit();
    
    	//clear the statement
        $stmt = null;
    	return $this->retorno;
    }

    /**
     * Gestiona el proceso de seleccion de un registro o todos de la base de datos.
     * 
     * @param  String $parChaModeloModo, la opcion que corresponde al nombre de la tabla a la cual consultar y el modo 
     * (_UNO ó _TODOS).
     * @param  Array $parArrDatos, corresponde al array de datos con los cuales consultar, solo si el modo es UNO (traera 
     * la llave primaria)
     * 
     * @return Array [par_cur_datos, par_int_error, part_int_msg]
     */
    public function functionParticular($nombreFuncion, $opcion, $parArrDatos, $paramsOrder, $parSalida = 'datos')
    {
        $parArrDatos = count($parArrDatos) ? "ARRAY['" . implode("','", $parArrDatos) . "']" : "ARRAY['']";
        $opcion = "'{$opcion}'";
        
        $funcion = "FN_" .$this->esquema . "__" . $nombreFuncion;

        $sql = "BEGIN"; 
        $stmt = $this->conexion->db->prepare($sql);
        $stmt->execute();
        
        $cantParameters = count($paramsOrder);
        $parametros = '';
        foreach($paramsOrder as $key => $variable) {
            if (isset($$variable)) { // SI EXISTE LA VARIABLE VARIABLE, ASIGNAMOS SU VALOR
                $parametros .= !empty($$variable) ? $$variable . ($key == $cantParameters-1 ? '' : ', ') : '';
            } else {// SI NO EXISTE LA VARIABLE VARIABLE, ASIGNAMOS SU LA ETIQUETA DADA
                $parametros .= "'{$variable}'" . ($key == $cantParameters-1 ? '' : ', ');
            }
        }

        $sql = 'SELECT "' . $this->esquema . '"."'. $funcion. '"(' . $parametros . ')'; 

        // DESCOMENTAR PARA HACER DEBUG
        /*
        echo "<pre>";
        var_dump($sql);
        echo "</pre>";
        exit;
        */
        
    	$stmt = $this->conexion->db->prepare($sql);
    	$stmt->setFetchMode(Zend_Db::FETCH_OBJ);
    	$stmt->execute();
    	$cadenaTmp = $stmt->fetchAll();
        
    	//LLAMAMOS EL CURSOR CAMPOS
        $sql = 'FETCH ALL IN "' . $parSalida . '"'; 
        $stmt = $this->conexion->db->prepare($sql);
        $stmt->setFetchMode(Zend_Db::FETCH_ASSOC);
        $stmt->execute();
        $this->retorno = $stmt->fetchAll(); 
    	
    	//COMMIT
        $this->commit();
    
    	//clear the statement
        $stmt = null;
    	return $this->retorno;
    }


        /**
     * Gestiona el proceso de seleccionar registros especiales a la base de datos.
     * 
     * @param  String $parChaOpcion, la opcion que corresponde al caso deseado que se encuentre en la sencia IF del PL
     * @param  Array $parArrDatos, corresponde al array de datos que contiene los parametros necesarios para ejecutar la
     * consulta.
     * 
     * @return Array [par_cur_datos, par_int_error, part_int_msg]
     */
    public function LiquidarNomina($parArrDatos, $parArrNomina)
    {
        $parChaDatos = count($parArrDatos) ? "ARRAY['" . implode("','", $parArrDatos) . "']" : "ARRAY['']";
        $funcion = "FN_" .$this->esquema . "__LIQUIDAR_NOMINA";

        $sql = "BEGIN"; 
        $stmt = $this->conexion->db->prepare($sql);
        $stmt->execute();
        
        $sql = 'SELECT "' . $this->esquema . '"."'. $funcion. '"('. $parChaDatos . ',' . $parArrNomina . ')'; 

        // DESCOMENTAR PARA HACER DEBUG
        
        /*echo "<pre>";
        var_dump($sql);
        echo "</pre>";
        exit;*/
         
        $stmt = $this->conexion->db->prepare($sql);
        $stmt->setFetchMode(Zend_Db::FETCH_ASSOC);            
        $stmt->execute();          
        $retornoTMP = $stmt->fetchAll();
        
        $this->commit();

        foreach ($retornoTMP as $cad)
            foreach ($cad as $ret)
                $retorno = $ret;
        
        $this->retorno = explode(',', substr($retorno, 1, strlen($retorno)-2));
    }

    public function DMStoDEC($deg,$min,$sec)
        {

        //Converts DMS ( Degrees /minutes /seconds ) 
        //to decimal format longitude /latitude

            return $deg+((($min*60)+($sec))/3600);
        }
}

