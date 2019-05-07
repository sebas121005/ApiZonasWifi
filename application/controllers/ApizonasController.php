<?php

class ApizonasController extends Zend_Rest_Controller {

    public function init()
    {
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction()
    {
        /*$this->view->message = 'indexAction has been called.';
        $this->getResponse()->setBody('indexAction has been called.');
        $this->_response->ok();*/


    }

    /**
     * The head action handles HEAD requests; it should respond with an
     * identical response to the one that would correspond to a GET request,
     * but without the response body.
     */
    public function headAction()
    {
        //$this->view->message = 'headAction has been called';
        //$this->_response->ok();
    }

    /**
     * The get action handles GET requests and receives an 'id' parameter; it
     * should respond with the server resource state of the resource identified
     * by the 'id' value.
     */
    public function getAction()
    {
        date_default_timezone_set('America/Bogota');

        $params = $this->_request->getParams();
        $respuesta = ['estado' => 'ok', 'mensaje' => ''];

        

        if (strpos($params['id'], 'zonas') !== false ) {

            $client = new Zend_Http_Client('https://www.datos.gov.co/api/views/naxn-r5z4/rows.json?accessType=DOWNLOAD');
            
            $response = $client->request();
            $datos = $response->getBody();
            $json = json_decode($datos, true); 
            $arrayJson = $json['data'];
            //print_r($json['data']);

            foreach($arrayJson as $valor) {
                foreach($valor as $clave => $valor) {                
                    $posicion = array($clave => $valor);                    
                    $array = array($posicion['14']);
                    foreach($array as $dato) {
                        $latitud= substr($dato, 1, 17);
                        $longitud = substr($dato, 18, 25);                        
                        $gradosLatitud = substr($latitud, 1, 1);
                        $minutosLatitud = substr($latitud, 4, 4);
                        $segundosLatitud = substr($latitud, 8, 13);

                        $gradosLongitud = substr($longitud, 1, 2);
                        $minutosLongitud = substr($longitud, 4, 4);
                        $segundosLongitud = substr($latitud, 8, 13);
                        

                        $minutosLatitud = str_replace('\'', '', $minutosLatitud);
                        $segundosLatitud = str_replace('\'', '', $segundosLatitud);

                        $minutosLongitud = str_replace('\'', '', $minutosLongitud);
                        $segundosLongitud = str_replace('\'', '', $segundosLongitud);



                        //$dec =  $Modelo->DMStoDEC($grados, $minutosConvertidos, $segundosConvertidos);
                        $latitud = $gradosLatitud+((($minutosLatitud*60)+($segundosLatitud))/3600);
                        $longitud = $gradosLongitud+((($minutosLongitud*60)+($segundosLongitud))/3600);
                        
                        if($latitud !== 0 && $longitud!== 0) {
                            echo('Latitud: '.$latitud . '  ' .'Longitud: ' . $longitud. "  ");
                        }

                        
                        
                  }
                    
                    
                    
                }
            }


        } else {
            $respuesta['estado'] = 'error';
            $respuesta['mensaje'] = 'Solicitud Incorrecta';
        }

        header('Content-type: application/json; charset=utf-8');

        //print_r(json_encode($respuesta, JSON_UNESCAPED_UNICODE));
        exit;
    }


     /**
     * The post action handles POST requests; it should accept and digest a
     * POSTed resource representation and persist the resource state.
     */
    public function postAction()
    {
                
        
    }

    /**
     * The put action handles PUT requests and receives an 'id' parameter; it
     * should update the server resource state of the resource identified by
     * the 'id' value.
     */
    public function putAction()
    {
        
       
        
    }

    /**
     * The delete action handles DELETE requests and receives an 'id'
     * parameter; it should update the server resource state of the resource
     * identified by the 'id' value.
     */
    public function deleteAction()
    {

    }

    
} 