<?php
namespace grandmasterx\neteller\api;

/**
 * Class LookupOrderInvoice
 * @package grandmasterx\neteller\api
 */
class LookupOrderInvoice extends NetellerAPI
{
    /**
     * @var
     */
    public $orderId;

    /**
     * @var
     */
    public $expandObjects;

    /**
     * @var
     */
    public $executionErrors;

    /**
     * @param $orderId
     * @return $this
     */
    public function setOrderId($orderId) {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @param $expandObjects
     * @return $this
     */
    public function setExpand($expandObjects) {
        $this->expandObjects = $expandObjects;
        return $this;
    }

    /**
     * @return bool|mixed
     */
    public function doRequest() {
        $token = $this->getToken_ClientCredentials();

        if ($token == false) {
            return false;
        }

        $headers = [
            "Content-type"  => "application/json",
            "Authorization" => "Bearer " . $token
        ];

        if (isset($this->expandObjects)) {
            $queryParams = ['expand' => $this->expandObjects];
        } else {
            $queryParams = [];
        }

        $response = $this->get("v1/orders/" . $this->orderId . "/invoice", $queryParams, $headers, []);

        $responseInfo = $response['info'];
        $responseBody = json_decode($response['body']);

        if ($responseInfo['http_code'] == 200) {
            return $responseBody;
        } elseif ($responseInfo['http_code'] >= 400) {
            $this->executionErrors = [
                'http_status_code'  => $responseInfo['http_code'],
                'api_error_code'    => $responseBody->error->code,
                'api_error_message' => $responseBody->error->message,
                'api_resource_used' => 'GET /v1/order/{}/invoice'
            ];
            return false;
        } else {
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getExecutionErrors() {
        return $this->executionErrors;
    }
}
