<?php

class Model_DBTable_InsertarGeneralAdm
{
    public function insertar($parOpcion,$parDatos)
    {   	
        $conexion = Cla_Conexion::getInstancia();
		
		$sql = "BEGIN"; 
        $stmt = $conexion -> db -> prepare($sql);
        $stmt -> execute();
        
        // Small Fix to correctly set Character SET
        $sql = "SET CLIENT_ENCODING TO 'LATIN1'";
        $stmt = $conexion -> db -> prepare($sql);
        $stmt->execute();

        //SELECCIONAMOS EL PROCEDIMIENTO ALMACENADO
        $sql = 'SELECT "ADM"."FN_ADM__INSERTAR_GEN"'.
        		"('$parOpcion', NULL, $parDatos)"; //EJECUTAR FUNCION
        //print_r($sql);die();
        $stmt = $conexion -> db -> prepare($sql);
        $stmt -> setFetchMode(Zend_Db::FETCH_ASSOC);            
        $stmt -> execute();          
        $cadenaTmp = $stmt -> fetchAll();
        
    	foreach ($cadenaTmp as $cad) {
        	foreach ($cad as $ret) {
	        	$retorno = $ret;
        	}
        }
        
        $retorno = explode(',', substr($retorno, 1,strlen($retorno)-2));          
        
        //COMMIT
        $sql = "COMMIT"; 
        $stmt = $conexion->db->prepare($sql);            
        $stmt->execute();            

        //clear the statement
        $stmt = null;             
        return $retorno;    	
    }
        
}
