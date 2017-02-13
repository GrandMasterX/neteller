<?php
namespace grandmasterx\neteller\api;

/**
 * Class CreateOrder
 * @package grandmasterx\neteller\api
 */
class CreateOrder extends NetellerApi
{

    /**
     * @var
     */
    public $orderMerchantRefId;

    /**
     * @var
     */
    public $orderTotalAmount;

    /**
     * @var
     */
    public $orderCurrency;

    /**
     * @var
     */
    public $orderLang;

    /**
     * @var
     */
    public $orderCustomerIp;

    /**
     * @var array
     */
    public $items = [];

    /**
     * @var array
     */
    public $fees = [];

    /**
     * @var array
     */
    public $taxes = [];

    /**
     * @var array
     */
    public $redirects = [];

    /**
     * @var array
     */
    public $paymentMethods = [];

    /**
     * @var string
     */
    public $billingDetailsEmail = "";

    /**
     * @var string
     */
    public $billingDetailsCountry = "";

    /**
     * @var
     */
    public $billingDetailsFirstName;

    /**
     * @var string
     */
    public $billingDetailsLastName = "";

    /**
     * @var string
     */
    public $billingDetailsAddress1 = "";

    /**
     * @var string
     */
    public $billingDetailsAddress2 = "";

    /**
     * @var string
     */
    public $billingDetailsAddress3 = "";

    /**
     * @var string
     */
    public $billingDetailsCity = "";

    /**
     * @var
     */
    public $billingDetailsCountrySubdivisionCode;

    /**
     * @var
     */
    public $billingDetailsPostCode;

    /**
     * @var
     */
    public $billingDetailsLang;

    /**
     * @var array
     */
    public $attributes = [];

    /**
     * @var
     */
    public $redirectUrl;

    /**
     * @var array
     */
    public $executionErrors = [];

    /**
     * @param $orderMerchantRefId
     * @return $this
     */
    public function setOrderMerchantRefId($orderMerchantRefId) {
        $this->orderMerchantRefId = $orderMerchantRefId;
        return $this;
    }

    /**
     * @param $orderTotalAmount
     * @return $this
     */
    public function setOrderTotalAmount($orderTotalAmount) {
        $this->orderTotalAmount = $orderTotalAmount;
        return $this;
    }

    /**
     * @param $orderCurrency
     * @return $this
     */
    public function setOrderCurrency($orderCurrency) {
        $this->orderCurrency = $orderCurrency;
        return $this;
    }

    /**
     * @param $orderLang
     * @return $this
     */
    public function setOrderLang($orderLang) {
        $this->orderLang = $orderLang;
        return $this;
    }

    /**
     * @param $orderCustomerIp
     * @return $this
     */
    public function setOrderCustomerIp($orderCustomerIp) {
        $this->orderCustomerIp = $orderCustomerIp;
        return $this;
    }

    /**
     * @param $item
     * @return $this
     */
    public function setItems($item) {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @param $fee
     * @return $this
     */
    public function setFees($fee) {
        $this->fees[] = $fee;
        return $this;
    }

    /**
     * @param $tax
     * @return $this
     */
    public function setTaxes($tax) {
        $this->taxes[] = $tax;
        return $this;
    }

    /**
     * @param $paymentMethod
     * @return $this
     */
    public function setPaymentMethods($paymentMethod) {
        $this->paymentMethods[] = $paymentMethod;
        return $this;
    }

    /**
     * @param $url
     * @return $this
     */
    public function setRedirectOnSuccess($url) {
        $redirect = [
            "rel"        => "on_success",
            "returnKeys" => [
                "id"
            ],
            "uri"        => $url
        ];
        $this->redirects[] = $redirect;
        return $this;
    }

    /**
     * @param $url
     * @return $this
     */
    public function setRedirectOnCancel($url) {
        $redirect = [
            "rel"        => "on_cancel",
            "returnKeys" => [
                "id"
            ],
            "uri"        => $url
        ];
        $this->redirects[] = $redirect;
        return $this;
    }

    /**
     * @param $billingDetailsEmail
     * @return $this
     */
    public function setBillingDetailsEmail($billingDetailsEmail) {
        $this->billingDetailsEmail = $billingDetailsEmail;
        return $this;
    }

    /**
     * @param $billingDetailsFirstName
     * @return $this
     */
    public function setBillingDetailsFirstName($billingDetailsFirstName) {
        $this->billingDetailsFirstName = $billingDetailsFirstName;
        return $this;
    }

    /**
     * @param $billingDetailsLastName
     * @return $this
     */
    public function setBillingDetailsLastName($billingDetailsLastName) {
        $this->billingDetailsLastName = $billingDetailsLastName;
        return $this;
    }

    /**
     * @param $billingDetailsCountry
     * @return $this
     */
    public function setBillingDetailsCountry($billingDetailsCountry) {
        $this->billingDetailsCountry = $billingDetailsCountry;
        return $this;
    }

    /**
     * @param $billingDetailsCity
     * @return $this
     */
    public function setBillingDetailsCity($billingDetailsCity) {
        $this->billingDetailsCity = $billingDetailsCity;
        return $this;
    }

    /**
     * @param $billingDetailsAddress1
     * @return $this
     */
    public function setBillingDetailsAddress1($billingDetailsAddress1) {
        $this->billingDetailsAddress1 = $billingDetailsAddress1;
        return $this;
    }

    /**
     * @param $billingDetailsAddress2
     * @return $this
     */
    public function setBillingDetailsAddress2($billingDetailsAddress2) {
        $this->billingDetailsAddress2 = $billingDetailsAddress2;
        return $this;
    }

    /**
     * @param $billingDetailsAddress3
     * @return $this
     */
    public function setBillingDetailsAddress3($billingDetailsAddress3) {
        $this->billingDetailsAddress3 = $billingDetailsAddress3;
        return $this;
    }

    /**
     * @param $countrySubDivisionCode
     * @return $this
     */
    public function setBillingDetailsCountrySubDivisionCode($countrySubDivisionCode) {
        $this->countrySubDivisionCode = $countrySubDivisionCode;
        return $this;
    }

    /**
     * @param $billingDetailsPostCode
     * @return $this
     */
    public function setBillingDetailsPostCode($billingDetailsPostCode) {
        $this->billingDetailsPostCode = $billingDetailsPostCode;
        return $this;
    }

    /**
     * @param $billingDetailsLang
     * @return $this
     */
    public function setBillingDetailsLang($billingDetailsLang) {
        $this->billingDetailsLang = $billingDetailsLang;
        return $this;
    }

    /**
     * @param $attribute
     * @return $this
     */
    public function setAttributes($attribute) {
        $this->attributes[] = $attribute;
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

        $requestParams = [
            "order"          => [
                "merchantRefId"  => $this->orderMerchantRefId,
                "totalAmount"    => $this->orderTotalAmount,
                "currency"       => $this->orderCurrency,
                "lang"           => $this->orderLang,
                "items"          => $this->items,
                "fees"           => $this->fees,
                "taxes"          => $this->taxes,
                "paymentMethods" => $this->paymentMethods,
                "redirects"      => $this->redirects,
            ],
            "billingDetails" => [[]],
            "attributes"     => $this->attributes
        ];

        if ($this->orderCustomerIp != null) {
            $requestParams['order']['customerIp'] = $this->orderCustomerIp;
        }

        if ($this->billingDetailsEmail != null) {
            $requestParams['billingDetails'][0]['email'] = $this->billingDetailsEmail;
        }

        if ($this->billingDetailsCountry != null) {
            $requestParams['billingDetails'][0]['country'] = $this->billingDetailsCountry;
        }

        if ($this->billingDetailsFirstName != null) {
            $requestParams['billingDetails'][0]['firstName'] = $this->billingDetailsFirstName;
        }

        if ($this->billingDetailsLastName != null) {
            $requestParams['billingDetails'][0]['lastName'] = $this->billingDetailsLastName;
        }

        if ($this->billingDetailsCity != null) {
            $requestParams['billingDetails'][0]['city'] = $this->billingDetailsCity;
        }

        if ($this->billingDetailsAddress1 != null) {
            $requestParams['billingDetails'][0]['address1'] = $this->billingDetailsAddress1;
        }

        if ($this->billingDetailsAddress2 != null) {
            $requestParams['billingDetails'][0]['address2'] = $this->billingDetailsAddress2;
        }

        if ($this->billingDetailsAddress3 != null) {
            $requestParams['billingDetails'][0]['address3'] = $this->billingDetailsAddress3;
        }

        if ($this->billingDetailsCountrySubdivisionCode != null) {
            $requestParams['billingDetails'][0]['countrySubDivisionCode'] = $this->billingDetailsCountrySubdivisionCode;
        }

        if ($this->billingDetailsPostCode != null) {
            $requestParams['billingDetails'][0]['postCode'] = $this->billingDetailsPostCode;
        }

        if ($this->billingDetailsLang != null) {
            $requestParams['billingDetails'][0]['lang'] = $this->billingDetailsLang;
        }

        $response = $this->post("/v1/orders", $queryParams, $headers, $requestParams);
        $responseInfo = $response['info'];
        $responseBody = json_decode($response['body']);

        if ($responseInfo['http_code'] == 200) {

            foreach ($responseBody->links as $struct) {
                if ($struct->rel == "hosted_payment") {
                    $this->redirectUrl = $struct->url;
                    break;
                }
            }
            return $responseBody;
        } elseif ($responseInfo['http_code'] >= 400) {
            $this->executionErrors = [
                'http_status_code'  => $responseInfo['http_code'],
                'api_error_code'    => $responseBody->error->code,
                'api_error_message' => $responseBody->error->message,
                'api_resource_used' => 'POST v1/orders'
            ];
            return false;
        } else {
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getRedirectUrl() {
        return $this->redirectUrl;
    }

    /**
     * @return array
     */
    public function getExecutionErrors() {
        return $this->executionErrors;
    }
}
