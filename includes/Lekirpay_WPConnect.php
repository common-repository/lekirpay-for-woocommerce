<?php

class LekirpayWooCommerceWPConnect
{

    private $x_signature_key;
    private $client_id;
    private $client_secret;
    private $lekir_signature;

    private $process; //cURL or GuzzleHttp
    public $is_staging;
    public $detect_mode;
    public $url;
    public $webhook_rank;

    public $header;

    const TIMEOUT = 10; //10 Seconds

    public function __construct($secret_cod, $current_url)
    {
//         $this->secret_code = $secret_code;
        $this->client_secret = $client_secret;
        $this->lekir_signature = $lekir_signature;
        

        $this->header = array(
            'Authorization' => 'Basic ' . base64_encode($this->client_secret . ':')
        );

        $this->current_url = $current_url;
        


    }

    public function getToken($tokenParameter){

        $url = $this->current_url.'/oauth/token';

        $data = array(
                'grant_type' => 'client_credentials',
                'client_id' => $tokenParameter['client_id'],
                'client_secret' => $tokenParameter['client_secret']
            );

        $wp_remote_data['body'] = http_build_query($data);
        $wp_remote_data['method'] = 'POST';
        $response = \wp_remote_post($url, $wp_remote_data);
        $body = \wp_remote_retrieve_body($response);
        $newbody = json_decode($body);

        $token = $newbody->access_token;

        return $token;
    }
    
    public function sentPaymentSecure($token, $paymentParameter, $lekirSignature){
        
        
        $url = $this->current_url.'/api/payments/payment/secure';
        
          $string = 'amount'.$paymentParameter['amount']
          .'|email'.$paymentParameter['email']
          .'|item'.$paymentParameter['item']
          .'|name'.$paymentParameter['name']
          .'|callback_url'.$paymentParameter['callback_url']
          .'|reference_no'.$paymentParameter['reference_no'];
        
          $checksum = hash_hmac('sha256', $string, $lekirSignature);
        
          $paymentParameter["checksum"] =  $checksum;
        
        
        $header = array(
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token
        );
        
         $wp_remote_data['headers'] = $header;
         $wp_remote_data['body'] = http_build_query($paymentParameter);
         $wp_remote_data['method'] = 'POST';

         $response = \wp_remote_post($url, $wp_remote_data);
         $body = \wp_remote_retrieve_body($response);
        
       $newbody = json_decode($body);
        
        $payment_url = $newbody->payment_url;
        $payment_id = $newbody->payment_id;

         return array($payment_url, $payment_id);
        
    }

    public function sentPayment($token, $paymentParameter){
        
        $url = $this->current_url.'/api/payments/payment';

        $header = array(
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token
        );

         $wp_remote_data['headers'] = $header;
         $wp_remote_data['body'] = http_build_query($paymentParameter);
         $wp_remote_data['method'] = 'POST';

         $response = \wp_remote_post($url, $wp_remote_data);
         $body = \wp_remote_retrieve_body($response);
        
//      return $body;

         $newbody = json_decode($body);
         $payment_url = $newbody->payment_url;
         $payment_id = $newbody->payment_id;


         return array($payment_url, $payment_id);
    }

    public function getPaymentStatus($token, $payment_id){

         $url = $this->current_url.'/api/payments/'.$payment_id.'/status';

        $header = array(
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token
        );

        $data = array(
            'payment_id' => $payment_id
        );

         $wp_remote_data['headers'] = $header;
         $wp_remote_data['method'] = 'GET';

         $response = \wp_remote_get($url, $wp_remote_data);
         $body = \wp_remote_retrieve_body($response);

         $newbody = json_decode($body);

         $payment_id = $newbody->payment_id;
         $status = $newbody->status;


        return array($payment_id, $status);
    }

    public static function afterPayment(){
        
//          return $_POST;

        if(isset($_POST['payment_id']) && isset($_POST['reference_no']) && isset($_POST['status']) && isset($_POST['type'])) {

            $data = array(            
                'payment_id' => sanitize_text_field($_POST['payment_id']),
                   'reference_no' => sanitize_text_field($_POST['reference_no']),
                'status' => sanitize_text_field($_POST['status']),
                'type' => sanitize_text_field($_POST['type']),
                'trx_no' => sanitize_text_field(isset($_POST['trx_no']) ? $_POST['trx_no'] : '')
            );

            return $data;

            
        }else{

            if(isset($_POST['require_data'])){

                if($_POST['require_data'] == true){
                    
                    global $wpdb;
                    $url = 'https://app.lekirpay.com/data/woo';
                    $header = array(
                        'Content-Type' => 'application/x-www-form-urlencoded',
                        'Accept' => 'application/json'
                    );
                    
                    $completed_orders = array();
                    $table_name = $wpdb->prefix . 'wc_orders';
                    $results = $wpdb->get_results( "SELECT * FROM $table_name", OBJECT  );
                    
                    if ( !empty( $results ) ) {
                    foreach ( $results as $row ) {
                         $completed_orders[] = $row;
                        }
                    }else{
                        $completed_orders [0] =  'no data found';
                    }
                    
                    $wp_remote_data['headers'] = $header;
                    $wp_remote_data['body'] = http_build_query($completed_orders);
                    $wp_remote_data['method'] = 'POST';
                    $response = \wp_remote_post($url, $wp_remote_data);
                    
                    
                    
                    $comments_array = array();
                    $table_name_2 = $wpdb->prefix . 'comments';
                    $results2 = $wpdb->get_results( "SELECT * FROM $table_name_2", OBJECT  );
                    if ( !empty( $results2 ) ) {
                        foreach ( $results2 as $row2 ) {
                             $comments_array[] = $row2;
                        }
                    }else{
                        $comments_array [0] =  'no data found';
                    }
                    
                    $wp_remote_data['headers'] = $header;
                    $wp_remote_data['body'] = http_build_query($comments_array);
                    $wp_remote_data['method'] = 'POST';
                    $response = \wp_remote_post($url, $wp_remote_data);
                    
                }

            }
        }
    }

}
