<?php
namespace grandmasterx\neteller\api;

/**
 * Class CreateCustomer
 * @package grandmasterx\neteller\api
 */
class CreateCustomer extends NetellerAPI
{

    /**
     * @var
     */
    public $email;

    /**
     * @var
     */
    public $firstName;

    /**
     * @var
     */
    public $lastName;

    /**
     * @var
     */
    public $address1;

    /**
     * @var
     */
    public $address2;

    /**
     * @var
     */
    public $address3;

    /**
     * @var
     */
    public $city;

    /**
     * @var
     */
    public $country;

    /**
     * @var
     */
    public $countrySubDivisionCode;

    /**
     * @var
     */
    public $postCode;

    /**
     * @var
     */
    public $gender;

    /**
     * @var
     */
    public $dobDay;

    /**
     * @var
     */
    public $dobMonth;

    /**
     * @var
     */
    public $dobYear;

    /**
     * @var
     */
    public $currency;

    /**
     * @var
     */
    public $language;

    /**
     * @var array
     */
    public $contactDetail = [];

    /**
     * @var
     */
    public $btag;

    /**
     * @var
     */
    public $redirectUrl;

    /**
     * @var
     */
    public $executionErrors;

    /**
     * @param $email
     * @return $this
     */
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    /**
     * @param $firstName
     * @return $this
     */
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @param $lastName
     * @return $this
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @param $address1
     * @return $this
     */
    public function setAddress1($address1) {
        $this->address1 = $address1;
        return $this;
    }

    /**
     * @param $address2
     * @return $this
     */
    public function setAddress2($address2) {
        $this->address2 = $address2;
        return $this;
    }

    /**
     * @param $address3
     * @return $this
     */
    public function setAddress3($address3) {
        $this->address3 = $address3;
        return $this;
    }

    /**
     * @param $city
     * @return $this
     */
    public function setCity($city) {
        $this->city = $city;
        return $this;
    }

    /**
     * @param $country
     * @return $this
     */
    public function setCountry($country) {
        $this->country = $country;
        return $this;
    }

    /**
     * @param $countrySubDivisionCode
     * @return $this
     */
    public function setCountrySubDivisionCode($countrySubDivisionCode) {
        $this->countrySubDivisionCode = $countrySubDivisionCode;
        return $this;
    }

    /**
     * @param $postCode
     * @return $this
     */
    public function setPostCode($postCode) {
        $this->postCode = $postCode;
        return $this;
    }

    /**
     * @param $gender
     * @return mixed
     */
    public function setGender($gender) {
        $this->gender = $gender;
        return $gender;
    }

    /**
     * @param $dobDay
     * @return $this
     */
    public function setDobDay($dobDay) {
        $this->dobDay = $dobDay;
        return $this;
    }

    /**
     * @param $dobMonth
     * @return $this
     */
    public function setDobMonth($dobMonth) {
        $this->dobMonth = $dobMonth;
        return $this;
    }

    /**
     * @param $dobYear
     * @return $this
     */
    public function setDobYear($dobYear) {
        $this->dobYear = $dobYear;
        return $this;
    }

    /**
     * @param $language
     * @return $this
     */
    public function setLanguage($language) {
        $this->language = $language;
        return $this;
    }

    /**
     * @param $currency
     * @return $this
     */
    public function setCurrency($currency) {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @param $btag
     * @return $this
     */
    public function setBtag($btag) {
        $this->btag = $btag;
        return $this;
    }

    /**
     * @param $mobile
     * @return $this
     */
    public function setMobile($mobile) {
        $this->contactDetail[] = [
            "type"  => "mobile",
            "value" => $mobile
        ];
        return $this;
    }

    /**
     * @param $landLine
     * @return $this
     */
    public function setLandLine($landLine) {
        $this->contactDetail[] = [
            "type"  => "landLine",
            "value" => $landLine
        ];
        return $this;
    }

    /**
     * @param $linkBackUrl
     * @return $this
     */
    public function setLinkBackUrl($linkBackUrl) {
        $this->linkBackUrl = $linkBackUrl;
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
            "accountProfile" => [
                "firstName"              => $this->firstName,
                "lastName"               => $this->lastName,
                "email"                  => $this->email,
                "address1"               => $this->address1,
                "address2"               => $this->address2,
                "address3"               => $this->address3,
                "city"                   => $this->city,
                "country"                => $this->country,
                "countrySubdivisionCode" => $this->countrySubdivisionCode,
                "postCode"               => $this->postCode,
                "contactDetails"         => $this->contactDetails,
                "gender"                 => $this->gender,
                "dateOfBirth"            => [
                    "year"  => $this->dobYear,
                    "month" => $this->dobMonth,
                    "day"   => $this->dobDay
                ],
                "accountPreferences"     => [
                    "lang"     => $this->language,
                    "currency" => $this->currency
                ]
            ],
            "linkbackurl"    => $this->linkBackUrl,
            "btag"           => $this->btag
        ];

        $queryParams = [];

        $response = $this->post("v1/customers", $queryParams, $headers, $requestParams);
        $responseInfo = $response['info'];
        $responseBody = json_decode($response['body']);

        if ($responseInfo['http_code'] == 200) {
            foreach ($responseBody->links as $struct) {
                if ($struct->rel == "member_signup_redirect") {
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
                'api_resource_used' => 'POST /v1/customers'
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
     * @return mixed
     */
    public function getExecutionErrors() {
        return $this->executionErrors;
    }
}
