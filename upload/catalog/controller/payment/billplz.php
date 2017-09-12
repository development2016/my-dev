<?php

/**
 * Billplz OpenCart Plugin
 * 
 * @package Payment Gateway
 * @author Wanzul-Hosting.com <sales@wanzul-hosting.com>
 * @version 2.0
 */
class ControllerPaymentBillplz extends Controller {

    private function get_domain_forwebmaster() {
        return substr($_SERVER['HTTP_HOST'], 0, 3) == 'www' ? substr($_SERVER['HTTP_HOST'], 4) : $_SERVER['HTTP_HOST'];
    }

    public function index() {
        $this->load->language('payment/billplz');
        $data['button_confirm'] = $this->language->get('button_confirm');
        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        //$data['country'] = $order_info['payment_iso_code_2'];
        //$data['currency'] = $order_info['currency_code'];
        $products = $this->cart->getProducts();
        foreach ($products as $product) {
            $data['prod_desc'][] = $product['name'] . " x " . $product['quantity'];
        }
        //$data['lang'] = $this->session->data['language'];


        $amount = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
        $data['name'] = $order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'];
        $data['email'] = empty($order_info['email']) ? '' : $order_info['email'];
        $data['description'] = "Order " . $this->session->data['order_id'] . " - " . implode($data['prod_desc']);
        $data['mobile'] = empty($order_info['telephone']) ? '' : $order_info['telephone'];
        $data['reference_1_label'] = "ID";


        $data['reference_1'] = $this->session->data['order_id'];
        $data['amount'] = $amount;
        $data['redirect_url'] = $this->url->link('payment/billplz/return_ipn', '', true);
        $data['callback_url'] = $this->url->link('payment/billplz/callback_ipn', '', true);
        $data['delivery'] = $this->config->get('billplz_delivery'); //0-4
        $data['action'] = $this->url->link('payment/billplz/proceed', '', true);

        /*
         *  Prepare Data for Validation SHA256
         *  Data arranged: name + amount + email + delivery + callback url + redirect url + reference 1 + description
         *  Rules: All Lower-Case
         */

        $preparedString = strtolower($data['name'] . $data['amount'] .
                $data['email'] . $data['delivery'] . $data['callback_url'] . $data['redirect_url'] . $data['reference_1'] . $data['description']);
        $data['sha256'] = hash_hmac('sha256', $preparedString, $this->config->get('billplz_vkey'));

        return $this->load->view('payment/billplz', $data);
    }

    public function proceed() {

        /*
         * Get All Data
         */
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'description' => $_POST['description'],
            'mobile' => $_POST['mobile'],
            'reference_1_label' => $_POST['reference_1_label'],
            'reference_1' => $_POST['reference_1'],
            'amount' => $_POST['amount'],
            'redirect_url' => $_POST['redirect_url'],
            'callback_url' => $_POST['callback_url'],
            'delivery' => $_POST['delivery'],
            'sha256' => $_POST['sha256'],
            'collection_id' => $this->config->get('billplz_vkey'),
            'api_key' => $this->config->get('billplz_mid')
        ];

        /*
         *  Prepare Data for Validation SHA256
         *  Data arranged: name + amount + email + delivery + callback url + redirect url + reference 1 + description
         *  Rules: All Lower-Case
         */
        $preparedString = strtolower($data['name'] . $data['amount'] . $data['email'] . $data['delivery'] . $data['callback_url'] . $data['redirect_url'] . $data['reference_1'] . $data['description']);
        $generatedSHA = hash_hmac('sha256', $preparedString, $this->config->get('billplz_vkey'));

        if ($data['sha256'] !== $generatedSHA)
            exit('Input has been tempered');

        /*
         * Create Billplz Class Instance.
         * Please refer below for the classes.
         */
        $billplz = new billplzCURL;

        $billplz
                ->setAmount($data['amount'])
                ->setCollection($data['collection_id'])
                ->setDeliver($data['delivery'])
                ->setMobile($data['mobile'])
                ->setEmail($data['email'])
                ->setDescription($data['description'])
                ->setName($data['name'])
                ->setPassbackURL($data['redirect_url'], $data['callback_url'])
                ->setReference_1($data['reference_1'])
                ->setReference_1_Label($data['reference_1_label'])
                ->create_bill($data['api_key'], $this->config->get('billplz_sandbox'));
        header('Location: ' . $billplz->getURL());
    }

    public function return_ipn() {
        $this->load->model('checkout/order');

        /*
         * Get Data. Die if input is tempered or X Signature not enabled
         */
        $data = billplzCURL::getRedirectData($this->config->get('billplz_xsign'));
        $tranID = $data['id'];

        /*
         * Create Billplz Class Instance.
         * Please refer below for the classes.
         */
        $billplz = new billplzCURL;
        $moreData = $billplz->check_bill($this->config->get('billplz_mid'), $tranID, $this->config->get('billplz_sandbox'));

        $orderid = $moreData['reference_1'];
        $status = $moreData['paid'];
        $amount = $moreData['amount'];
        $paydate = $data['paid_at'];
        $order_info = $this->model_checkout_order->getOrder($orderid); // orderid
        $order_status_id = $this->config->get('config_order_status_id');
        if ($status) {
            $order_status_id = $this->config->get('billplz_completed_status_id');
        } elseif (!$status) {
            $order_status_id = $this->config->get('billplz_failed_status_id');
        }
        //else {
        //	$order_status_id = $this->config->get('billplz_pending_status_id');
        //}

        if (!$order_info['order_status_id'])
            $this->model_checkout_order->addOrderHistory($orderid, $order_status_id, "Redirect: " . $paydate . " URL:" . $moreData['url'], false);
        else {
            /*
             * Prevent same order status id from adding more than 1 update
             */
            if ($order_status_id != $order_info['order_status_id'])
                $this->model_checkout_order->addOrderHistory($orderid, $order_status_id, "Redirect: " . $paydate . " URL:" . $moreData['url'], false);
        }

        /*
         * Determine which page the buyer should go based on
         * payment status
         */

        if ($status)
            $goTo = $this->url->link('checkout/success');
        else
            $goTo = $this->url->link('checkout/checkout');

        if (!headers_sent()) {
            header('Location: ' . $goTo);
        } else {
            echo "If you are not redirected, please click <a href=" . '"' . $goTo . '"' . " target='_self'>Here</a><br />"
            . "<script>location.href = '" . $goTo . "'</script>";
        }

        exit();
    }

    /*     * ***************************************************
     * Callback with IPN(Instant Payment Notification)
     * **************************************************** */

    public function callback_ipn() {
        $this->load->model('checkout/order');

        /*
         * Get Data. Die if input is tempered or X Signature not enabled
         */
        $data = billplzCURL::getCallbackData($this->config->get('billplz_xsign'));
        $tranID = $data['id'];

        /*
         * Create Billplz Class Instance.
         * Please refer below for the classes.
         */
        $billplz = new billplzCURL;
        $moreData = $billplz->check_bill($this->config->get('billplz_mid'), $tranID, $this->config->get('billplz_sandbox'));

        $orderid = $moreData['reference_1'];
        $status = $moreData['paid'];
        $amount = $moreData['amount'];
        $paydate = $data['paid_at'];
        $order_info = $this->model_checkout_order->getOrder($orderid); // orderid
        $order_status_id = $this->config->get('config_order_status_id');
        if ($status) {
            $order_status_id = $this->config->get('billplz_completed_status_id');
        } elseif (!$status) {
            $order_status_id = $this->config->get('billplz_failed_status_id');
        }
        //else {
        //	$order_status_id = $this->config->get('billplz_pending_status_id');
        //}
        if (!$order_info['order_status_id']) {
            $this->model_checkout_order->addOrderHistory($orderid, $order_status_id, "Callback: " . $paydate . " URL:" . $moreData['url'], false);
        } else {
            /*
             * Prevent same order status id from adding more than 1 update
             */
            if ($order_status_id != $order_info['order_status_id'])
                $this->model_checkout_order->addOrderHistory($orderid, $order_status_id, "Callback: " . $paydate . " URL:" . $moreData['url'], false);
        }
        exit('Callback Success');
    }

}

class billplzCURL {

    var $array, $obj, $auto_submit, $url, $id, $deliverLevel, $errorMessage;

    public function __construct() {
        $this->array = array();
        $this->obj = new Billplzcurlaction;
    }

    public function getCollectionIndex($api_key, $mode = 'Production', $status = null, $page = '1') {
        $this->obj->setAPI($api_key);
        $this->obj->setAction('GETCOLLECTIONINDEX');
        $this->obj->setURL($mode);
        $array = [
            'page' => $page,
            'status' => $status,
        ];
        $data = $this->obj->curl_action($array);

        return $data;
    }

    public static function getRedirectData($signkey) {
        $data = [
            'id' => $_GET['billplz']['id'],
            'paid_at' => isset($_GET['billplz']['paid_at']) ? $_GET['billplz']['paid_at'] : exit('Please enable Billplz XSignature Payment Completion'),
            'paid' => isset($_GET['billplz']['paid']) ? $_GET['billplz']['paid'] : exit('Please enable Billplz XSignature Payment Completion'),
            'x_signature' => isset($_GET['billplz']['x_signature']) ? $_GET['billplz']['x_signature'] : exit('Please enable Billplz XSignature Payment Completion'),
        ];
        $preparedString = '';
        foreach ($data as $key => $value) {
            $preparedString .= 'billplz' . $key . $value;
            if ($key === 'paid') {
                break;
            } else {
                $preparedString .= '|';
            }
        }
        $generatedSHA = hash_hmac('sha256', $preparedString, $signkey);
        if ($data['x_signature'] === $generatedSHA) {
            return $data;
        } else {
            exit('Data has been tempered');
        }
    }

    public static function getCallbackData($signkey) {
        $data = [
            'amount' => $_POST['amount'],
            'collection_id' => $_POST['collection_id'],
            'due_at' => $_POST['due_at'],
            'email' => $_POST['email'],
            'id' => $_POST['id'],
            'mobile' => $_POST['mobile'],
            'name' => $_POST['name'],
            'paid_amount' => $_POST['paid_amount'],
            'paid_at' => $_POST['paid_at'],
            'paid' => $_POST['paid'],
            'state' => $_POST['state'],
            'url' => $_POST['url'],
            'x_signature' => $_POST['x_signature'],
        ];
        $preparedString = '';
        foreach ($data as $key => $value) {
            $preparedString .= $key . $value;
            if ($key === 'url') {
                break;
            } else {
                $preparedString .= '|';
            }
        }
        $generatedSHA = hash_hmac('sha256', $preparedString, $signkey);
        if ($data['x_signature'] === $generatedSHA) {
            return $data;
        } else {
            exit('Data has been tempered');
        }
    }

//--------------------------------------------------------------------------
// Direct Use
    public function check_apikey_collectionid($api_key, $collection_id, $mode) {
        $array = array(
            'collection_id' => $collection_id,
            'email' => 'aa@gmail.com',
            'description' => 'test',
            'mobile' => '60145356443',
            'name' => "Jone Doe",
            'amount' => 150, // RM20
            'callback_url' => "http://yourwebsite.com/return_url"
        );
        $this->obj->setAPI($api_key);
        $this->obj->setAction('CREATE');
        $this->obj->setURL($mode);
        $data = $this->obj->curl_action($array);
        if (isset($data['error']['type'])) {
            return false;
        } elseif (isset($data['url'])) {
            $this->obj->setAction('DELETE');
            $this->obj->setURL($mode, $data['id']);
            $this->obj->curl_action();
            return true;
        }
    }

//------------------------------------------------------------------------//
// Indirect Use
    public function checkMobileNumber($mobile) {
        $mobile = preg_replace("/[^0-9]/", "", $mobile);
        $custTel = $mobile;
        $custTel2 = substr($mobile, 0, 1);
        if ($custTel2 == '+') {
            $custTel3 = substr($mobile, 1, 1);
            if ($custTel3 != '6') {
                $custTel = "+6" . $mobile;
            }
        } else if ($custTel2 == '6') {
            
        } else {
            if ($custTel != '') {
                $custTel = "+6" . $mobile;
            }
        } return $custTel;
    }

//------------------------------------------------------------------------//
// Direct Use
    public function setCollection($collection_id) {
        $this->array['collection_id'] = $collection_id;
        return $this;
    }

    public function setName($name) {
        $this->array['name'] = $name;
        return $this;
    }

    public function setEmail($email) {
        $this->array['email'] = $email;
        return $this;
    }

    public function setMobile($mobile) {
        $this->array['mobile'] = $this->checkMobileNumber($mobile);
        return $this;
    }

    public function setAmount($amount) {
        $this->array['amount'] = $amount * 100;
        return $this;
    }

    public function setDeliver($deliver) {
        /*
         * '0' => No Notification
         * '1' => Email Notification
         * '2' => SMS Notification
         * '3' => Email & SMS Notification
         * 
         * However, if the setting is SMS and mobile phone is not given,
         * the Email value should be used and set the delivery to false.
         */
        $this->deliverLevel = $deliver;
        $this->array['deliver'] = $deliver != '0' ? true : false;
        return $this;
    }

    public function setReference_1($reference_1) {
        $this->array['reference_1'] = substr($reference_1, 0, 119);
        return $this;
    }

    public function setDescription($description) {
        $this->array['description'] = substr($description, 0, 199);
        return $this;
    }

    public function setPassbackURL($redirect_url, $callback_url) {
        $this->array['redirect_url'] = $redirect_url;
        $this->array['callback_url'] = $callback_url;
        return $this;
    }

    public function setReference_1_Label($label) {
        $this->array['reference_1_label'] = substr($label, 0, 19);
        return $this;
    }

    public function create_bill($api_key, $mode) {
        $this->obj->setAPI($api_key);
        $this->obj->setAction('CREATE');
        $this->obj->setURL($mode);

        /*
         * 1. Check deliverLevel. If 1 (Email only), unset mobile
         * 2. Check deliverLevel. If 2 (SMS only), unset Email
         * 3. Create Bills.
         * 4. If the bills failed to be created:
         * 5. Check if 0 (No Notification), unset Mobile
         * 5. Check if 1(Email only), unset Email, set Mobile, deliver to false
         * 6. Check if 2(SMS only), unset Mobile, set Email deliver to false
         * 7. Check if 3, unset Mobile.
         * 8. Still failed? Return false.
         * 9. Ok. Return $this.
         */

        if ($this->deliverLevel == '1') {
            $mobile = $this->array['mobile'];
            unset($this->array['mobile']);
        } else if ($this->deliverLevel == '2') {
            $email = $this->array['email'];
            unset($this->array['email']);
        }

        $data = $this->obj->curl_action($this->array);

        if (isset($data['error'])) {
            if ($this->deliverLevel == '1') {
                unset($this->array['email']);
                $this->array['mobile'] = $mobile;
                $this->array['deliver'] = false;
            } else if ($this->deliverLevel == '2') {
                unset($this->array['mobile']);
                $this->array['email'] = $email;
                $this->array['deliver'] = false;
            } else {
                unset($this->array['mobile']);
            }
            $data = $this->obj->curl_action($this->array);
        }

        if (isset($data['error'])) {
            $this->errorMessage = $data['error']['type'] . ' ' . $data['error']['message'];
            return false;
        }
        $this->url = $data['url'];
        $this->id = $data['id'];
        return $this;
    }

    public function getURL() {
        return $this->url;
    }

    public function getErrorMessage() {
        return $this->errorMessage;
    }

    public function getID() {
        return $this->id;
    }

//------------------------------------------------------------------------//
// Direct Use
    public function check_bill($api_key, $bill_id, $mode) {
        $this->obj->setAPI($api_key);
        $this->obj->setAction('CHECK');
        $this->obj->setURL($mode, $bill_id);
        $data = $this->obj->curl_action();
        return $data;
    }

}

class Billplzcurlaction {
    /*
     * How to use?
     *  Create Object: $obj = new curlaction;
     *  Set API Key:   $obj->setAPI('apikey');
     *  Set  Action:   $obj->setAction('CREATE');
     *  Set    Mode:   $obj->setURL('Production','');
     *  Create Bill:   $obj->curl_action(array());
     *  Remove Bill:   $obj->setAction('DELETE');
     *                 $obj->setURL('Production','billid');
     *                 $obj->curl_action('');
     *  Destruct:      unset($obj);
     */

    var $url, $action, $curldata, $api_key;
    public static $production = 'https://www.billplz.com/api/v3/';
    public static $staging = 'https://billplz-staging.herokuapp.com/api/v3/';

    public function setAPI($api_key) {
        $this->api_key = $api_key;
        return $this;
    }

    public function setAction($action) {
        $this->action = $action;
        return $this;
    }

    public function setURL($mode, $id = '') {
        if ($mode == 'Staging') {
            $this->url = self::$staging;
        } else {
            $this->url = self::$production;
        }
        if ($this->action == 'DELETE' || $this->action == 'CHECK') {
            $this->url .= 'bills/' . $id;
        } elseif ($this->action == 'CREATE') {
            $this->url .= 'bills/';
        } else if ($this->action == 'GETCOLLECTIONINDEX') {
            $this->url .= 'collections';
        } else { //COLLECTIONS
            $this->url .= 'collections/';
        }
        return $this;
    }

    public function curl_action($data = '') {
// Use wp_safe_remote_post for Windows Server Compatibility
        if (function_exists('wp_safe_remote_post')) {
            $curl_url = $this->url;
// Send this payload to Billplz for processing
            $response = wp_safe_remote_post($curl_url, $this->prepareWP($data));
            return json_decode(wp_remote_retrieve_body($response), true);
        } else {
            $process = curl_init();
            if ($this->action == 'GETCOLLECTIONINDEX')
                $this->url .= '?page=' . $data['page'] . '&status=' . $data['status'];
            curl_setopt($process, CURLOPT_URL, $this->url);
            curl_setopt($process, CURLOPT_HEADER, 0);
            curl_setopt($process, CURLOPT_USERPWD, $this->api_key . ":");
            if ($this->action == 'DELETE') {
                curl_setopt($process, CURLOPT_CUSTOMREQUEST, "DELETE");
            }
            curl_setopt($process, CURLOPT_TIMEOUT, 10);
            curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
            if ($this->action == 'CREATE' || $this->action == 'COLLECTIONS') {
                curl_setopt($process, CURLOPT_POSTFIELDS, http_build_query($data));
            }
            $return = curl_exec($process);
            curl_close($process);
            $this->curldata = json_decode($return, true);
            return $this->curldata;
        }
    }

    private function prepareWP($data) {
        $args = array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode($this->api_key . ':')
            )
        );
        if ($this->action == 'DELETE') {
            $args['method'] = 'DELETE';
        } elseif ($this->action == 'CHECK') {
            $args['method'] = 'GET';
        } else {
            $args['method'] = 'POST';
        }
        if ($this->action == 'CREATE' || $this->action == 'COLLECTIONS') {
            $args['body'] = http_build_query($data);
        }
        return $args;
    }

}
