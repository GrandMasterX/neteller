<?php
namespace grandmasterx\neteller\api;

/**
 * Class LookupPayment
 * @package grandmasterx\neteller\api
 */
class LookupPayment extends NetellerAPI
{

    /**
     * @var
     */
    public $transactionId;

    /**
     * @var
     */
    public $merchantRefId;

    /**
     * @var
     */
    public $expandObjects;

    /**
     * @var
     */
    public $executionErrors;

    /**
     * @param $transactionId
     * @return $this
     */
    public function setTransactionId($transactionId) {
        $this->transactionId = "$transactionId";
        return $this;
    }

    /**
     * @param $merchantRefId
     * @return $this
     */
    public function setMerchantRefId($merchantRefId) {
        $this->merchantRefId = $merchantRefId;
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

        if (isset($this->transactionId)) {
            $response = $this->get("v1/payments/" . $this->transactionId, $queryParams, $headers, []);
        }

        if (isset($this->merchantRefId)) {
            $queryParams['refType'] = 'merchantRefId';
            $response = $this->get("v1/payments/" . $this->merchantRefId, $queryParams, $headers, []);
        }
        $responseInfo = $response['info'];
        $responseBody = json_decode($response['body']);

        if ($responseInfo['http_code'] == 200) {
            return $responseBody;
        } elseif ($responseInfo['http_code'] >= 400) {
            $this->executionErrors = [
                'http_status_code'  => $responseInfo['http_code'],
                'api_error_code'    => $responseBody->error->code,
                'api_error_message' => $responseBody->error->message,
                'api_resource_used' => 'GET /v1/payments/{}'
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
