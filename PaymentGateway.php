<?php

class PaymentGateway {
    public $environment = 'production';
    public $urlSandbox = 'https://sandbox.fluidpay.com/api';
    public $urlProduction = 'https://app.fluidpay.com/api';
    public $urlLocalDev = 'http://localhost:8001/api';
    public $apiKey = '';

    public function statusCheck() {return $this->request(array('url' => '/fphc'));}

    ////////////////////
    // Authentication //
    ////////////////////
    public function obtainJWT($username, $password) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'POST',
            'url' => '/token-auth',
            'fields' => array('username' => $username, 'password' => $password)
        ));
    }

    ///////////
    // Users //
    ///////////
    public function getCurrentUser() {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'GET',
            'url' => '/user'
        ));
    }

    public function createUser($user) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'POST',
            'url' => '/user',
            'fields' => $user
        ));
    }

    public function getAllUsers() {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'GET',
            'url' => '/users'
        ));
    }

    public function getUser($userID) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'GET',
            'url' => '/user/'.$userID
        ));
    }

    public function updateUser($user) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'POST',
            'url' => '/user/'.$user['id'],
            'fields' => $user
        ));
    }

    public function deleteUSer($userID) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'DELETE',
            'url' => '/user/'.$userID
        ));
    }

    ///////////////
    // Customers //
    ///////////////
    public function createCustomer(array $customer) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'POST',
            'url' => '/customer',
            'fields' => $customer
        ));
    }

    public function getCustomer($customerID) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'GET',
            'url' => '/customer/'.$customerID
        ));
    }

    public function updateCustomer(array $customer) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'POST',
            'url' => '/customer/'.$customer['id'],
            'fields' => $customer
        ));
    }

    public function deleteCustomer($customerID) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'DELETE',
            'url' => '/customer/'.$customerID
        ));
    }

    private function request(array $options) {
        $url = $this->urlProduction;
        if ($this->environment == 'sandbox') {$url = $this->urlSandbox;}
        if ($this->environment == 'local') {$url = $this->urlLocalDev;}

        $ch = curl_init();
        $header = array('Content-Type: application/json');
        if (array_key_exists('apiKey', $options)) {array_push($header, 'Authorization: '.$options['apiKey']);}
        $curlConfig = array(
            CURLOPT_HTTPHEADER     => $header,
            CURLOPT_URL            => $url.$options['url'],
            CURLOPT_RETURNTRANSFER => true
        );
        if (array_key_exists('method', $options)) {
            if (strtolower($options['method']) == 'post') {
                $curlConfig[CURLOPT_POST] = true;
            }
            if (strtolower($options['method']) == 'delete') {
                $curlConfig[CURLOPT_CUSTOMREQUEST] = "DELETE";
            }
        }
        if (array_key_exists('fields', $options) && count($options['fields']) > 0) {
            $curlConfig[CURLOPT_POSTFIELDS] = json_encode($options['fields']);
        }
        curl_setopt_array($ch, $curlConfig);
        $result = curl_exec($ch);
        curl_close($ch);

        if (!$result) { return $result; }

        return json_decode($result, true);
    }
}
