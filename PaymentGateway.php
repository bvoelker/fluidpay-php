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

    //////////////
    // Api Keys //
    //////////////
    public function createApiKey() {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'POST',
            'url' => '/user/apikey'
        ));
    }
    public function getApiKeys() {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'GET',
            'url' => '/user/apikey'
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

    public function createCustomerAddressToken($customerID, $address) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'POST',
            'url' => '/customer/'.$customerID.'/address',
            'fields' => $address
        ));
    }

    public function getCustomerAddress($customerID, $addressID) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'GET',
            'url' => '/customer/'.$customerID.'/address/'.$addressID
        ));
    }

    public function getCustomerAllAddresses($customerID) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'GET',
            'url' => '/customer/'.$customerID.'/addresses'
        ));
    }

    public function updateCustomerAddress($customerID, $addressID, $address) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'POST',
            'url' => '/customer/'.$customerID.'/address/'.$addressID,
            'fields' => $address
        ));
    }

    public function deleteCustomerAddress($customerID, $addressID) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'DELETE',
            'url' => '/customer/'.$customerID.'/address/'.$addressID
        ));
    }

    public function createCustomerPaymentToken($customerID, $paymentType, $paymentData) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'POST',
            'url' => '/customer/'.$customerID.'/paymentmethod/'.$paymentType,
            'fields' => $paymentData
        ));
    }

    public function getCustomerPayment($customerID, $paymentType, $paymentTypeID) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'GET',
            'url' => '/customer/'.$customerID.'/paymentmethod/'.$paymentType.'/'.$paymentTypeID
        ));
    }

    public function getCustomerAllPayments($customerID, $paymentType) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'GET',
            'url' => '/customer/'.$customerID.'/paymentmethod/'.$paymentType
        ));
    }

    public function updateCustomerPayment($customerID, $paymentType, $paymentTypeID, $data) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'POST',
            'url' => '/customer/'.$customerID.'/paymentmethod/'.$paymentType.'/'.$paymentTypeID,
            'fields' => $data
        ));
    }

    public function deleteCustomerPayment($customerID, $paymentType, $paymentTypeID) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'DELETE',
            'url' => '/customer/'.$customerID.'/paymentmethod/'.$paymentType.'/'.$paymentTypeID
        ));
    }

    //////////////////
    // Transactions //
    //////////////////
    public function processTransaction($transaction) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'POST',
            'url' => '/transaction',
            'fields' => $transaction
        ));
    }

    public function getTransaction($transactionID) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'GET',
            'url' => '/transaction/'.$transactionID
        ));
    }

    public function captureTransaction($transactionID, $capture) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'POST',
            'url' => '/transaction/'.$transactionID.'/capture',
            'fields' => $capture
        ));
    }

    public function voidTransaction($transactionID) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'POST',
            'url' => '/transaction/'.$transactionID.'/void'
        ));
    }

    public function refundTransaction($transactionID, $refund) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'POST',
            'url' => '/transaction/'.$transactionID.'/refund',
            'fields' => $refund
        ));
    }

    ///////////////
    // Recurring //
    ///////////////
    public function createAddOn($addOn) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'POST',
            'url' => '/recurring/addon',
            'fields' => $addOn
        ));
    }

    public function getAddOn($addOnID) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'GET',
            'url' => '/recurring/addon/'.$addOnID
        ));
    }

    public function getAllAddOns() {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'GET',
            'url' => '/recurring/addons'
        ));
    }

    public function deleteAddOn($addonID) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'DELETE',
            'url' => '/recurring/addon/'.$addonID
        ));
    }

    public function createDiscount($discount) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'POST',
            'url' => '/recurring/discount',
            'fields' => $discount
        ));
    }

    public function getDiscount($discountID) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'GET',
            'url' => '/recurring/discount/'.$discountID
        ));
    }

    public function getAllDiscounts() {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'GET',
            'url' => '/recurring/discounts'
        ));
    }

    public function deleteDiscount($discountID) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'DELETE',
            'url' => '/recurring/discount/'.$discountID
        ));
    }

    public function createPlan($plan) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'POST',
            'url' => '/recurring/plan',
            'fields' => $plan
        ));
    }

    public function updatePlan($planID, $plan) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'POST',
            'url' => '/recurring/plan/'.$planID,
            'fields' => $plan
        ));
    }

    public function getPlan($planID) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'GET',
            'url' => '/recurring/plan/'.$planID
        ));
    }

    public function getAllPlans() {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'GET',
            'url' => '/recurring/plans'
        ));
    }

    public function deletePlan($planID) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'DELETE',
            'url' => '/recurring/plan/'.$planID
        ));
    }

    public function createSubscription($subscription) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'POST',
            'url' => '/recurring/subscription',
            'fields' => $subscription
        ));
    }

    public function updateSubscription($subscriptionID, $subscription) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'POST',
            'url' => '/recurring/subscription/'.$subscriptionID,
            'fields' => $subscription
        ));
    }

    public function getSubscription($subscriptionID) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'GET',
            'url' => '/recurring/subscription/'.$subscriptionID
        ));
    }

    public function deleteSubscription($subscriptionID) {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'DELETE',
            'url' => '/recurring/subscription/'.$subscriptionID
        ));
    }

    ///////////////
    // Terminals //
    ///////////////
    public function getAllTerminals() {
        return $this->request(array(
            'apiKey' => $this->apiKey,
            'method' => 'GET',
            'url' => '/terminals'
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
