<?php

/**
 * Utilitaria
 *  
 * @author DAG 
 * @version 23042015
 */

class Model_DBTable_Utilitaria{

	public function traerDatos($parOpc, $parDatos=null){
		$conexion = Cla_Conexion::getInstancia();
		$sql = "BEGIN"; 
        $stmt = $conexion -> db -> prepare($sql);
        $stmt -> execute();

        if($parDatos == null){
        	
        	$arreglo = "NULL";
        
        }else{
        	
        	$arreglo = 'ARRAY[';
        	foreach ($parDatos as $dato) {
        		
        		$arreglo .= "'$dato', ";
        	}
			$arreglo = substr($arreglo, 0, -2); 
			$arreglo .= ']';       	
        }
        // Small Fix to correctly set Character SET
        $sql = "SET CLIENT_ENCODING TO 'LATIN1'";
        $stmt = $conexion -> db->prepare($sql);
        $stmt->execute();
        
        //SELECCIONAMOS EL PROCEDIMIENTO ALMACENADO
        $sql = 'SELECT "SCA"."FN_SCA__SELECCIONAR_PARTICULAR"'."('datos', '" . $parOpc. "', " . $arreglo . ")"; //EJECUTAR FUNCION          
	    //die($sql);
        
        $stmt = $conexion -> db -> prepare($sql);
        $stmt -> setFetchMode(Zend_Db::FETCH_OBJ);            
        $stmt -> execute();          
        $cadenaTmp = $stmt -> fetchAll();
        
        //LLAMAMOS EL CURSOR FORMULARIO
        $sql = 'FETCH ALL IN "datos"'; 
        $stmt = $conexion -> db -> prepare($sql);
        $stmt -> setFetchMode(Zend_Db::FETCH_ASSOC);
        $stmt -> execute();
        $datos = $stmt -> fetchAll(); 
               
        //COMMIT
        $sql = "COMMIT"; 
        $stmt = $conexion->db->prepare($sql);            
        $stmt->execute();            

        //clear the statement
        $stmt = null;
        return $datos;
	}
	
		
	
}