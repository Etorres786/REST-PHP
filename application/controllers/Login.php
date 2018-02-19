<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php');
use Restserver\libraries\REST_Controller;


class Login extends REST_Controller {

    public function __construct(){

        header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header("Access-Control-Allow-Origin: *");

        parent::__construct();
        $this->load->database();

     }


     public function index_post(){
         //OBTENGO LOS DATOS ENVIADOS POR POST
        $data = $this->post(); 

        if( !isset( $data['correo']) OR !isset($data['contrasena'])  ){
            $respuesta= array(
                        'error' => TRUE,
                        'mensae'=>'La informacion enviada no es valida'
                        );
            $this->response( $respuesta,REST_Controller::HTTP_BAD_REQUEST);                
            return;
        }

        
        //TENEMOS CORREO Y CONTRASEÑA
        $condiciones = array('correo' => $data['correo'],
                            'contrasena'=>$data['contrasena']);

       
       
        $query = $this->db->get_where('login',$condiciones);
        $usuario = $query->row();

        if(!isset( $usuario ) ){
            $respuesta = array(
                'error'=>TRUE,
                'mensaje'=>' Usuario o Contraseña Invalido'
                 );     
            $this->response( $respuesta); 
            return;
        }

        //ACÁ TENEMOS USUARIO Y CONTRASEÑA CORRECTOS
        
        //GENERATE TOKE OF USSER
         // $token = bin2hex( openssl_random_pseudo_bytes(20)  );
        $token = hash( 'ripemd160', $data['correo'] );

        //GUARDAR EN BASE DE DATOS EL TOKEN
        
        //RESETEAMOS EL QUERY
        $this->db->reset_query();
        $update_token=array('token'=>$token);
        $this->db->where('id', $usuario->id );

        $hecho = $this->db->update( 'login', $update_token );

        $respuesta = array(
                        'error' => FALSE,
                        'token' => $token,
                        'id_usuario' =>$usuario->id
                    );

        $this->response($respuesta);
        
        
     }

    }