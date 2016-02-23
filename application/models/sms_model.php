<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_model extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('ChikkaSMS');
    }

//    function sms_send(){
//        $fields = array();
////        $fields["api"] = "uyBCxqs8JWq8GZpVraqx"; //medix
//        $fields["api"] = "waS58kgswbhtrtYDXKxQ"; //activations
//        $fields["number"] = '639464187000'; //safe use 63
//        $fields["message"] = 'semaphore test message';
//        $fields["from"] = 'CWD';
//        $fields_string = http_build_query($fields);
//        $outbound_endpoint = "http://api.semaphore.co/api/sms";
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $outbound_endpoint);
//        curl_setopt($ch,CURLOPT_POST, count($fields));
//        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        $output = curl_exec($ch);
//        print_r($output);
//        curl_close($ch);
//    }

    function sms_send( $a ){
        /*chikka*/
        $clientId = '0ab14cd09ddc373cd766b072cc70dd551d99678d80a500c94926c9b4a2b9806a';
        $secretKey = 'e906530019b6a82a8e3aefeaad2bc5bd1d9a64491e72e812b7e8dd75c05382a8';
        $shortCode = '2929052621';
        $chikkaAPI = new ChikkaSMS($clientId,$secretKey,$shortCode);
        $response = $chikkaAPI->sendText('Activations', $a['phone_num'], $a['msg']);

        header("HTTP/1.1 " . $response->status . " " . $response->message);

        exit($response->message);
    }

}