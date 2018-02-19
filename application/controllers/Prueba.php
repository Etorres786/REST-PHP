<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH.'/libraries/REST_Controller.php');
use Restserver\libraries\REST_Controller;


class Prueba extends REST_Controller {
    public function __construct(){
        header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header("Access-Control-Allow-Origin: *");


            parent::__construct();
            $this->load->database();
     }


    public function index(){
        echo "Hi Word";
    }


   public function obtener_arreglo_get( $index=0){
       $arreglo = array("Manzana","Pera","Piña");
       //echo json_encode( $arreglo[$index]);

       $this->response( $arreglo[$index] );

   } 
    
    public function obtener_producto_get($codigo){
        $query = $this->db->query("SELECT * FROM productos where codigo='".$codigo."'");
        $this->response( $query->result() );

    }
}
