<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH.'/libraries/REST_Controller.php');
use Restserver\libraries\REST_Controller;


class Clientes extends REST_Controller {

 
    public function __construct(){
      header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
      header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
      header("Access-Control-Allow-Origin: *");
      parent::__construct();
      $this->load->database();
  
    }

   
    public function index_get(){
        $query = $this->db->query('SELECT * FROM clientes');
        $respuesta = array(
                    'error'=>FALSE,
                    'clientes'=> $query->result_array()
                     );       
        
        $this->response( $respuesta );
        
 
     }


    public function registrar_post(){
        $data = $this->post();



        
        $insertar = array('documento'=>$data[0],'nombre' => $data[1],'apellidos'=>$data[2],'telefono'=>$data[3],'direccion'=>$data[4],'email'=>$data[5]);
        $this->db->insert('clientes', $insertar);
        $respuesta = array(
            'error' => FALSE,
          );


        $this->response( $respuesta );


    }


}
