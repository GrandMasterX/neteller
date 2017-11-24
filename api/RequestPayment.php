<?php
namespace grandmasterx\neteller\api;

/**
 * Class RequestPayment
 * @package grandmasterx\neteller\api
 */
class RequestPayment extends NetellerApi
{

    /**
     * @var
     */
    public $paymentMethodValue;

    /**
     * @var
     */
    public $transactionMerchantRefId;

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
    public $verificationCode;

    /**
     * @var
     */
    public $expandObjects;

    /**
     * @param $paymentMethodValue
     * @return $this
     */
    public function setPaymentMethodValue($paymentMethodValue) {
        $this->paymentMethodValue = $paymentMethodValue;
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
     * @param $verificationCode
     * @return $this
     */
    public function setVerificationCode($verificationCode) {
        $this->verificationCode = $verificationCode;
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
            "paymentMethod"    => [
                "type"  => "neteller",
                "value" => $this->paymentMethodValue
            ],
            "transaction"      => [
                "merchantRefId" => $this->transactionMerchantRefId,
                "amount"        => $this->transactionAmount,
                "currency"      => $this->transactionCurrency
            ],
            "verificationCode" => $this->verificationCode
        ];

        if (isset($this->expandObjects)) {
            $queryParams = ['expand' => $this->expandObjects];
        } else {
            $queryParams = [];
        }

        $response = $this->post("v1/transferIn", $queryParams, $headers, $requestParams);
        $responseInfo = $response['info'];
        $responseBody = json_decode($response['body']);

        if ($responseInfo['http_code'] == 200) {
            return $responseBody;
        } elseif ($responseInfo['http_code'] >= 400) {
            $this->executionErrors = [
                'http_status_code'  => $responseInfo['http_code'],
                'api_error_code'    => $responseBody->error->code,
                'api_error_message' => $responseBody->error->message,
                'api_resource_used' => 'POST /v1/transferIn'
            ];
            return false;
        } else {
            return false;
        }
    }
}
