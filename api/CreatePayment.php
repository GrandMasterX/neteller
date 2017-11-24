<?php
namespace grandmasterx\neteller\api;

/**
 * Class CreatePayment
 * @package grandmasterx\neteller\api
 */
class CreatePayment extends NetellerApi
{

    /**
     * @var
     */
    public $payeeProfileEmail;

    /**
     * @var
     */
    public $transactionAmount;

    /**
     * @var
     */
    public $transactionCurrency;

    /**
     * @var
     */
    public $transactionMerchantRefId;

    /**
     * @var
     */
    public $message;

    /**
     * @var
     */
    public $expandObjects;

    /**
     * @param $payeeProfileEmail
     * @return $this
     */
    public function setPayeeProfileEmail($payeeProfileEmail) {
        $this->payeeProfileEmail = $payeeProfileEmail;
        return $this;
    }

    /**
     * @param $transactionAmount
     * @return $this
     */
    public function setTransactionAmount($transactionAmount) {
        $this->transactionAmount = $transactionAmount;
        return $this;
    }

    /**
     * @param $transactionCurrency
     * @return $this
     */
    public function setTransactionCurrency($transactionCurrency) {
        $this->transactionCurrency = $transactionCurrency;
        return $this;
    }

    /**
     * @param $transactionMerchantRefId
     * @return $this
     */
    public function setTransactionMerchantRefId($transactionMerchantRefId) {
        $this->transactionMerchantRefId = $transactionMerchantRefId;
        return $this;
    }

    /**
     * @param $message
     * @return $this
     */
    public function setMessage($message) {
        $this->message = $message;
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

        $requestParams = [
            "payeeProfile" => [
                "email" => $this->payeeProfileEmail
            ],
            "transaction"  => [
                "amount"        => $this->transactionAmount,
                "currency"      => $this->transactionCurrency,
                "merchantRefId" => $this->transactionMerchantRefId
            ],
            "message"      => $this->message
        ];

        if (isset($this->expandObjects)) {
            $queryParams = ['expand' => $this->expandObjects];
        } else {
            $queryParams = [];
        }
        $response = $this->post("v1/transferOut", $queryParams, $headers, $requestParams);
        $responseInfo = $response['info'];
        $responseBody = json_decode($response['body']);

        if ($responseInfo['http_code'] == 200) {
            return $responseBody;
        } elseif ($responseInfo['http_code'] >= 400) {
            $this->executionErrors = [
                'http_status_code'  => $responseInfo['http_code'],
                'api_error_code'    => $responseBody->error->code,
                'api_error_message' => $responseBody->error->message,
                'api_resource_used' => 'POST /v1/transferOut'
            ];
            return false;
        } else {
            return false;
        }
    }
}
