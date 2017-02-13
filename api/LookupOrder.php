<?php
namespace grandmasterx\neteller\api;

/**
 * Class LookupOrder
 * @package grandmasterx\neteller\api
 */
class LookupOrder extends NetellerApi
{
    /**
     * @var
     */
    public $orderId;

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

        $queryParams = [];

        $response = $this->get("v1/orders/" . $this->orderId, $queryParams, $headers, []);

        $responseInfo = $response['info'];
        $responseBody = json_decode($response['body']);

        if ($responseInfo['http_code'] == 200) {
            return $responseBody;
        } elseif ($responseInfo['http_code'] >= 400) {
            $this->executionErrors = [
                'http_status_code'  => $responseInfo['http_code'],
                'api_error_code'    => $responseBody->error->code,
                'api_error_message' => $responseBody->error->message,
                'api_resource_used' => 'GET /v1/orders/{}'
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
