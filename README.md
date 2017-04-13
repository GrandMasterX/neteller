NETELLER REST API PHP Library
=============================

Introduction
------------

The NETELLER PHP Library provides PHP developers an easy way to integrate the NETELLER REST API. It is a client library which provides PHP classes that correspond to resources in the NETELLER REST API.

- [Installation](#Installation)
- [Configuration](#Configuration)
- [NetellerAPI Class](#NetellerAPI)
- [RequestPayment Class](#requestPayment)
- [CreatePayment Class](#CreatePayment)
- [LookupPayment Class](#LookupPayment)
- [CreateOrder Class](#CreateOrder)
- [LookupOrder Class](#LookupOrder)
- [LookupOrderInvoice Class](#LookupOrderInvoice)
- [CreateCustomer Class](#CreateCustomer)
- [LookupCustomer Class](#LookupCustomer)
- [CreatePlan Class](#CreatePlan)
- [LookupPlan Class](#LookupPlan)
- [CancelPlan Class](#CancelPlan)
- [DeletePlan Class](#DeletePlan)
- [ListPlans Class](#ListPlans)
- [CreateSubscription Class](#CreateSubscription)
- [LookupSubscription Class](#LookupSubscription)
- [CancelSubscription Class](#CancelSubscription)
- [ListSubscriptions Class](#ListSubscriptions)
- [LookupSubscriptionInvoice Class](#LookupSubscriptionInvoice)
- [LookupAllSubscriptionInvoices Class](#LookupAllSubscriptionInvoices)
- [WebhookHandler Class](#WebhookHandler)
- [Test Account](#TestAccount)
- [Ips for whitelist](#IpsForWhitelist)

Installation <a name="Installation"></a>
========================================

Simply download and include the "NetellerAPI.php" file in your script.


    include_once("NetellerAPI.php");


Configuration <a name="Configuration"></a>
==========================================

You need to define the configuration details using the following PHP constants:

- **NETELLER\_BASE\_URL** - should contain the relevant REST API endpoint depending on whether you are using the sandbox or live environment.
- **NETELLER\_CLIENT\_ID** - should contain the Client ID from the merchant account App.
- **NETELLER\_CLIENT\_SECRET** - should contain the Client Secret from the merchant account App.

Example:


    define('NETELLER_BASE_URL', 'https://test.api.neteller.com/');
    define('NETELLER_CLIENT_ID', 'AAABTAiQ9pKruN2Z');
    define('NETELLER_CLIENT_SECRET', '0.iSLQ7zzMinac6SbI62onxTdqEYFES1LXoI4paRFFz74.4yFz4Pr3BMIccXgQOb3Ea_FNG2Y');

Alternatively, you may pass these required parameters to the constructor of each method instead:

    $deposit = new NetellerAPI\RequestPayment(array(
     'NETELLER_BASE_URL' => 'https://test.api.neteller.com/',
     'NETELLER_CLIENT_ID' => 'AAABTAiQ9pKruN2Z',
     'NETELLER_CLIENT_SECRET' => '0.iSLQ7zzMinac6SbI62onxTdqEYFES1LXoI4paRFFz74.4yFz4Pr3BMIccXgQOb3Ea_FNG2Y'
     ));
    .. etc etc

NetellerAPI Class <a name="NetellerAPI"></a>
============================================

A parent class which all classes below extend.

Methods
-------

- **getIP()** - Returns the outgoing IP address of the server where the script is hosted using an external service. Useful for debugging the "invalid\_client" API error.
- **getUrl(string $url)** - Executes a GET request to a URL from the NETELLER API and returns the result. Useful when implementing webhooks.
- **getToken\_ClientCredentials()** - Returns a new access token - "client\_credentials" grant type.
- **getToken\_AuthCode(string $authCode, string $redirectUri)** - Returns a new access token - "auth\_code" grant type.
- **getToken\_RefreshToken(string $refreshToken)** - Returns a new access token using a refresh token.
- **getExecutionErrors()** - Returns an array with the error(s) returned by the NETELLER REST API.

Example
-------


    $api = new NetellerAPI\NetellerAPI();
    $ip = $api->getIP();
    var_dump($ip);


It can also be used in the context of a child class:


    $deposit = new NetellerAPI\RequestPayment();
    $deposit->setPaymentMethodValue('netellertest_USD@neteller.com')
            ->setVerificationCode(270955)
            ->setTransactionMerchantRefId('adfiu1i23478172349a')
            ->setTransactionAmount(1234)
            ->setTransactionCurrency('USD');
    $result = $deposit->doRequest();
    $ip = $deposit->getIP();

    var_dump($result);
    var_dump($ip);


RequestPayment Class <a name="requestPayment"></a>
==================================================

Creates a new incoming transfer payment.

Methods
-------

- **setPaymentMethodValue(string $paymentMethod)** - Sets the member's email or 12 digit NETELLER Account ID.
- **setVerificationCode(string $verificationCode)** - Sets the member's Secure ID or Google Authenticator OTP.
- **setTransactionMerchantRefId(string $merchantRefId)** - Sets the merchant reference ID.
- **setTransactionAmount(int $transactionAmount)** - Sets the amount for the transaction.
- **setTransactionCurrency(string $transactionCurrency)** - Sets the currency for the transaction.
- **setExpand(string $expandObjects)** - A list of comma-separated names of objects to be expanded in the NETELLER REST API response.
- **doRequest()** - Executes the API request. Returns the JSON-decoded object of the NETELLER REST API response, or "(bool)false" if an error has occurred.
- **getExecutionErrors()** - Returns an array with the error(s) returned by the NETELLER REST API.

Example
-------


    $deposit = new NetellerAPI\RequestPayment();
    $deposit->setPaymentMethodValue('netellertest_USD@neteller.com')
            ->setVerificationCode(270955)
            ->setTransactionMerchantRefId('adfiu1i23478172349a')
            ->setTransactionAmount(1234)
            ->setTransactionCurrency('USD');
    $result = $deposit->doRequest();
    var_dump($result);


CreatePayment Class <a name="CreatePayment"></a>
================================================

Creates a new outgoing payment.

Methods
-------

- **setPayeeProfileEmail(string $payeeProfileEmail)** - Sets the email of the member receiving the payment.
- **setTransactionAmount(int $transactionAmount)** - Sets the amount for the transaction.
- **setTransactionCurrency(string $transactionCurrency)** - Sets the currency for the transaction.
- **setTransactionMerchantRefId(string $transactionMerchantRefId)** - Sets the merchant reference ID.
- **setMessage(string $message)** - Sets the message that will be shown to the member notifying them of the pending transfer.
- **setExpand(string $expandObjects)** - A list of comma-separated names of objects to be expanded in the NETELLER REST API response.
- **doRequest()** - Executes the API request. Returns the JSON-decoded object of the NETELLER REST API response, or "(bool)false" if an error has occurred.
- **getExecutionErrors()** - Returns an array with the error(s) returned by the NETELLER REST API.

Example
-------


    $withdrawal = new NetellerAPI\CreatePayment();
    $withdrawal->setPayeeProfileEmail('netellertest_USD@neteller.com')
               ->setTransactionAmount(1234)
               ->setTransactionCurrency('USD')
               ->setTransactionMerchantRefId('adfiu1i23478172349W2')
               ->setMessage('sample message');
    $result = $withdrawal->doRequest();
    var_dump($result);


LookupPayment Class <a name="LookupPayment"></a>
================================================

Returns details about a previous payment request.

Methods
-------

- **setTransactionId(string $transactionId)** - Sets the NETELLER transaction ID of the transaction you want to look up. You can either use this method or use "setMerchantRefId".
- **setMerchantRefId(string $merchantRefId)** - Sets the merchant reference ID of the transaction you want to look up. You can either use this method or use "setTransactionId".
- **setExpand(string $expandObjects)** - A list of comma-separated names of objects to be expanded in the NETELLER REST API response.
- **doRequest()** - Executes the API request. Returns the JSON-decoded object of the NETELLER REST API response, or "(bool)false" if an error has occurred.
- **getExecutionErrors()** - Returns an array with the error(s) returned by the NETELLER REST API.

Example
-------


    $lookup = new NetellerAPI\LookupPayment();
    $lookup->setTransactionId('850430740226289')
           ->setExpand('customer');
    $result = $lookup->doRequest();
    var_dump($result);


CreateOrder Class <a name="CreateOrder"></a>
============================================

Creates a payment order for NETELLERgo! You will need to redirect your customer to the returned URL to initiate the hosted Quick Checkout flow and collect the payment.

Methods
-------

- **setOrderMerchantRefId(string $orderMerchantRefId)** - Sets the merchant reference ID.
- **setOrderTotalAmount(int $orderTotalAmount)** - Sets the total amount for the order.
- **setOrderCurrency(string $orderCurrency)** - Sets the currency for the order.
- **setOrderLang(string $orderLang)** - Sets the language of the hosted payment page.
- **setOrderCustomerIp(string $orderCustomerIp)** - Sets the IP address of the customer.
- **setItems(array $item)** - Sets the item you are requesting payment for.
- **setFees(array $fee)** - Sets the fee for this order.
- **setTaxes(array $tax)** - Sets the tax for this order.
- **setPaymentMethods(array $paymentMethod)** - sets the allowed payment methods for this order.
- **setRedirectOnSuccess(string $url)** - Sets the success redirect URL.
- **setRedirectOnCancel(string $url)** - Sets the cancel redirect URL.
- **setBillingDetailsEmail(string $billingDetailsEmail)** - Sets the email address of the customer.
- **setBillingDetailsCountry(string $billingDetailsCountry)** - Sets the country of residence of the customer (ISO 3166-1 Alpha 2-code)
- **setBillingDetailsFirstName(string $billingDetailsFirstName)** - Sets the First Name of the customer.
- **setBillingDetailsLastName(string $billingDetailsLastName)** - Sets the Last Name of the customer.
- **setBillingDetailsCity(string $billingDetailsCity)** - Sets the city of residence of the customer.
- **setBillingDetailsAddress1(string $billingDetailsAddress1)** - Sets the address (line 1) of the customer.
- **setBillingDetailsAddress2(string $billingDetailsAddress2)** - Sets the address (line 2) of the customer.
- **setBillingDetailsAddress3(string $billingDetailsAddress3)** - Sets the address (line 3) of the customer.
- **setBillingDetailsCountrySubDivisionCode(string $countrySubDivisionCode)** - Sets the country subdivision code of the customer. The ISO 3166-2 code indicating the state/province/district or other value denoting the clients country subdivision
- **setBillingDetailsPostCode(string $billingDetailsPostCode)** - Sets the post code of the customer.
- **setBillingDetailsLang(string $billingDetailsLang)** - Sets the preferred language of communication of the customer.
- **setAttributes(array $attribute)** - Sets additional attributes for this order.
- **doRequest()** - Executes the API request. Returns the JSON-decoded object of the NETELLER REST API response, or "(bool)false" if an error has occurred.
- **getOrderId()** - Returns the NETELLER order id or null (in case doRequest() not called yet, or error occurred)
- **getRedirectUrl()** - Returns the URL where the client needs to be redirected to complete the payment.
- **getExecutionErrors()** - Returns an array with the error(s) returned by the NETELLER REST API.

Example
-------


    $order = new NetellerAPI\CreateOrder();
    $order->setOrderMerchantRefId('adfiu1i23478172349o1')
          ->setOrderTotalAmount(2099)
          ->setOrderCurrency('USD')
          ->setOrderLang('en_US')
          ->setItems(array
                        (
                            "quantity" => 1,
                            "name" => "Item A",
                            "description" => "Lorem ipsum dolor sit amet",
                            "sku" => "XYZPART1",
                            "amount" => 1000
                        )
                    )
          ->setItems(array
                        (
                            "quantity" => 2,
                            "name" => "Item B",
                            "description" => "Consectetur adipiscing elit",
                            "sku" => "XYZPART2",
                            "amount" => 200
                        )
                    )
          ->setFees(array
                        (
                            "feeName" => "Setup Fee",
                            "feeAmount" => 500
                        )
                    )
          ->setTaxes(array
                        (
                            "taxName" => "VAT",
                            "taxAmount" => 199
                        )
                    )
          ->setPaymentMethods(array
                    (
                        "type" => "onlinebanking",
                        "value" => "sofortbanking"
                    )
                )
          ->setRedirectOnSuccess("https://example.com/success.html")
          ->setRedirectOnCancel("https://example.com/cancel.html")
          ->setBillingDetailsEmail("netellertest_USD@neteller.com")
          ->setBillingDetailsCountry("DE")
          ->setBillingDetailsFirstName("John")
          ->setBillingDetailsLastName("Smith")
          ->setBillingDetailsCity("Calgary")
          ->setBillingDetailsAddress1("address line 1")
          ->setBillingDetailsAddress2("address line 2")
          ->setBillingDetailsAddress3("address line 3")
          ->setBillingDetailsCountrySubDivisionCode("AB")
          ->setBillingDetailsPostCode("T8A22J")
          ->setBillingDetailsLang("en");
    $result = $order->doRequest();
    $redirectUrl = $order->getRedirectUrl();
    var_dump($result);
    var_dump($redirectUrl);


LookupOrder Class <a name="LookupOrder"></a>
============================================

Returns details about a previous order request.

Methods
-------

- **setOrderId(string $orderId)** - Sets the order ID.
- **doRequest()** - Executes the API request. Returns the JSON-decoded object of the NETELLER REST API response, or "(bool)false" if an error has occurred.
- **getExecutionErrors()** - Returns an array with the error(s) returned by the NETELLER REST API.

Example
-------


    $lookup = new NetellerAPI\LookupOrder();
    $lookup->setOrderId("ORD_1f21ca9d-e647-46bc-9dde-91c70632e587");
    $result = $lookup->doRequest();
    var_dump($result);


LookupOrderInvoice Class <a name="LookupOrderInvoice"></a>
==========================================================

Returns details about an invoice for an order.

Methods
-------

- **setOrderId(string $orderId)** - Sets the order ID.
- **setExpand(string $expandObjects)** - A list of comma-separated names of objects to be expanded in the NETELLER REST API response.
- **doRequest()** - Executes the API request. Returns the JSON-decoded object of the NETELLER REST API response, or "(bool)false" if an error has occurred.
- **getExecutionErrors()** - Returns an array with the error(s) returned by the NETELLER REST API.

Example
-------


    $lookup = new NetellerAPI\LookupOrderInvoice();
    $lookup->setOrderId("ORD_5c0023d3-c928-4771-9016-1fc169283b0f")
           ->setExpand("customer,order");
    $result = $lookup->doRequest();
    var_dump($result);


CreateCustomer Class <a name="CreateCustomer"></a>
==================================================

Pre-populate the NETELLER sign-up page with information from your database, so you can speed up the registration process.

Methods
-------

- **setEmail(string $email)** - Sets the email of the customer.
- **setFirstName(string $firstName)** - Sets the first name of the customer.
- **setLastName(string $lastName)** - Sets the last name of the customer.
- **setAddress1(string $address1)** - Sets the address line 1 of the customer.
- **setAddress2(string $address2)** - Sets the address line 2 of the customer.
- **setAddress3(string $address3)** - Sets the address line 3 of the customer.
- **setCity(string $city)** - Sets the city of the customer.
- **setCountry(string $country)** - Sets the country of the customer. ISO 3166-1 Alpha 2-code.
- **setCountrySubDivisionCode(string $countrySubDivisionCode)** - Sets the state/province of the customer. ISO 3166-2 code.
- **setPostCode(string $postCode)** - Sets the post code of the customer.
- **setGender(string $gender)** - Sets the gender of the customer.
- **setDobDay(string $dobDay)** - Sets the date of birth day of the customer.
- **setDobMonth(string $dobMonth)** - Sets the date of birth month of the customer.
- **setDobYear(string $dobYear)** - Sets the date of birth year of the customer.
- **setLanguage(string $language)** - Sets the preferred language of the customer.
- **setCurrency(string $currency)** - Sets the preferred currency of the customer.
- **setMobile(string $mobile)** - Sets the mobile phone of the customer.
- **setLandLine(string $landLine)** - Sets the land line phone of the customer.
- **setBtag(string $btag)** - sets the btag, used for affiliate tracking.
- **doRequest()** - Executes the API request. Returns the JSON-decoded object of the NETELLER REST API response, or "(bool)false" if an error has occurred.
- **getRedirectUrl()** - Returns the URL where the client needs to be redirected to complete the sign-up.
- **getExecutionErrors()** - Returns an array with the error(s) returned by the NETELLER REST API.

Example
-------


    $signup = new NetellerAPI\CreateCustomer();
    $signup->setEmail("john.smith@example.com")
           ->setFirstName("John")
           ->setLastName("Smith")
           ->setAddress1("address line 1")
           ->setAddress2("address line 2")
           ->setAddress3("address line 3")
           ->setCity("Calgary")
           ->setCountry("CA")
           ->setCountrySubDivisionCode("AB")
           ->setPostCode("T8A22J")
           ->setGender("m")
           ->setDobDay("31")
           ->setDobMonth("01")
           ->setDobYear("1975")
           ->setLanguage("en_US")
           ->setCurrency("EUR")
           ->setMobile("14035552333")
           ->setLandLine("14032332333")
           ->setLinkBackUrl("https://example.com/")
           ->setBtag("A_234B_345C_");
    $response = $signup->doRequest();
    $redirectUrl = $signup->getRedirectUrl();
    var_dump($response);
    var_dump($redirectUrl);


LookupCustomer Class <a name="LookupCustomer"></a>
==================================================

Lookup details for a specific customer.

Methods
-------

- **setAccountId(string $accountId)** - Sets the account ID of the customer. You can either use this method or "setCustomerId" and "setEmail".
- **setCustomerId(string $customerId)** - Sets the customer ID of the customer. You can either use this method or "setAccountId" and "setEmail".
- **setEmail(string $email)** - Sets the email of the customer. You can either use this method or "setAccountId" and "setCustomerId".
- **setRefreshToken(string $refreshToken)** - Sets the refresh token to be used in order to obtain an access token. You can either use this method or use "setAuthCode". This method is used only when you want to receive customer data outside of the default scope.
- **setAuthCode(string $authCode)** - Sets the authentication code to be used in order to obtain an access token. You can either use this method or use "setRefreshToken". This method is used only when you want to receive customer data outside of the default scope.
- **doRequest()** - Executes the API request. Returns the JSON-decoded object of the NETELLER REST API response, or "(bool)false" if an error has occurred.
- **getExecutionErrors()** - Returns an array with the error(s) returned by the NETELLER REST API.

Example
-------


    $lookup = new NetellerAPI\LookupCustomer();
    $lookup->setCustomerId("453523712313")
           ->setRefreshToken("0.AgAAAU0yy4sHAAAAB1jwsOC9J7TBAYynTble-g2fdC-d.7xIAyXxQWsDaiLzjY4qimsqfyYU");
    $result = $lookup->doRequest();
    var_dump($result);


CreatePlan Class <a name="CreatePlan"></a>
==========================================

Creates a subscription plan.

Methods
-------

- **setPlanId(string $planId)** - Sets the unique ID for the plan.
- **setPlanName(string $planName)** - Sets the name of the plan.
- **setInterval(int $interval)** - Sets the number of intervals between each billing attempt.
- **setIntervalType(string $intervalType)** - Sets the frequency at which the plan subscriber will be billed (daily, weekly, monthly, yearly).
- **setIntervalCount(int $intervalCount)** - Sets the length of the contract in intervals.
- **setAmount(int $amount)** - Sets the amount to bill for each recurring payment.
- **setCurrency(string $currency)** - Sets the currency in which the customer will be billed.
- **doRequest()** - Executes the API request. Returns the JSON-decoded object of the NETELLER REST API response, or "(bool)false" if an error has occurred.
- **getExecutionErrors()** - Returns an array with the error(s) returned by the NETELLER REST API.

Example
-------


    $plan = new NetellerAPI\CreatePlan();
    $plan->setPlanId("MONTHLYGREENPLAN")
         ->setPlanName("Sample Premier Monthly Membership")
         ->setInterval(3)
         ->setIntervalType("monthly")
         ->setIntervalCount(4)
         ->setAmount(2995)
         ->setCurrency("USD");
    $result = $plan->doRequest();
    var_dump($result);


LookupPlan Class <a name="LookupPlan"></a>
==========================================

Returns details about a previously created subscription plan.

Methods
-------

- **setPlanId(string $planId)** - Sets the plan ID.
- **doRequest()** - Executes the API request. Returns the JSON-decoded object of the NETELLER REST API response, or "(bool)false" if an error has occurred.
- **getExecutionErrors()** - Returns an array with the error(s) returned by the NETELLER REST API.

Example
-------


    $lookup = new NetellerAPI\LookupPlan();
    $lookup->setPlanId("MONTHLYGREENPLAN");
    $result = $lookup->doRequest();
    var_dump($result);


CancelPlan Class <a name="CancelPlan"></a>
==========================================

Cancels a previously created subscription plan.

Methods
-------

- **setPlanId(string $planId)** - Sets the plan ID.
- **doRequest()** - Executes the API request. Returns the JSON-decoded object of the NETELLER REST API response, or "(bool)false" if an error has occurred.
- **getExecutionErrors()** - Returns an array with the error(s) returned by the NETELLER REST API.

Example
-------


    $plan = new NetellerAPI\CancelPlan();
    $plan->setPlanId("MONTHLYGREENPLAN");
    $result = $plan->doRequest();
    var_dump($result);


Delete Plan <a name="DeletePlan"></a>
=====================================

Deletes a previously created subscription plan.

Methods
-------

- **setPlanId(string $planId)** - Sets the plan ID.
- **doRequest()** - Executes the API request. Returns the JSON-decoded object of the NETELLER REST API response, or "(bool)false" if an error has occurred.
- **getExecutionErrors()** - Returns an array with the error(s) returned by the NETELLER REST API.

Example
-------


    $plan = new NetellerAPI\DeletePlan();
    $plan->setPlanId("MONTHLYGREENPLAN");
    $result = $plan->doRequest();
    var_dump($result);


ListPlans Class <a name="ListPlans"></a>
========================================

Returns a list of all plans.

Methods
-------

- **setLimit(int $limit)** - Sets the number of records to be returned.
- **setOffset(int $offset)** - Sets the results offset.
- **doRequest()** - Executes the API request. Returns the JSON-decoded object of the NETELLER REST API response, or "(bool)false" if an error has occurred.
- **getExecutionErrors()** - Returns an array with the error(s) returned by the NETELLER REST API.

Example
-------


    $plans = new NetellerAPI\ListPlans();
    $plans->setLimit(10)
          ->setOffset(0);
    $result = $plans->doRequest();
    var_dump($result);


CreateSubscription Class <a name="CreateSubscription"></a>
==========================================================

Enrolls an existing NETELLER account holder in one of your subscription plans.

Methods
-------

- **setPlanId(string $planId)** - Sets the plan ID.
- **setCustomerId(string $customerId)** - Sets the Customer ID of the customer to be subscribed.
- **setStartDate(string $startDate)** - Sets the start date for the subscription. The date needs to be in ISO 8601 format (UTC).
- **setRefreshToken(string $refreshToken)** - Sets the refresh token to be used in order to obtain an access token. You can either use this method or use "setAuthCode".
- **setAuthCode(string $authCode)** - Sets the authentication code to be used in order to obtain an access token. You can either use this method or use "setRefreshToken".
- **setRedirectUri(string $redirectUri)** - Sets the redirect URI.
- **setExpand(string $expandObjects)** - A list of comma-separated names of objects to be expanded in the NETELLER REST API response.
- **doRequest()** - Executes the API request. Returns the JSON-decoded object of the NETELLER REST API response, or "(bool)false" if an error has occurred.
- **getExecutionErrors()** - Returns an array with the error(s) returned by the NETELLER REST API.

Examples
--------

### Using Authorization code


    $subscription = new NetellerAPI\CreateSubscription();
    $subscription->setPlanId("MONTHLYGREENPLAN")
                 ->setAccountProfileEmail("netellertest_USD@neteller.com")
                 ->setStartDate("2015-05-09T00:00:00Z")
                 ->setAuthCode("0.AAAAAU0yjMR5AAAAAAAEk-B1A0yk5HA7RZkwz9zQYRFN.eNw8W12CqB06b2Qc2rvr3vUyc-g")
                 ->setRedirectUri("https://example.com/")
                 ->setExpand("plan,customer");
    $result = $subscription->doRequest();
    var_dump($result);


### Using Refresh token


    $subscription = new NetellerAPI\CreateSubscription();
    $subscription->setPlanId("MONTHLYGREENPLAN")
                 ->setAccountProfileEmail("netellertest_USD@neteller.com")
                 ->setStartDate("2015-05-09T00:00:00Z")
                 ->setRefreshToken("0.AgAAAU0yy4sHAAAAB1jwsOC9J7TBAYynTble-g2fdC-d.7xIAyXxQWsDaiLzjY4qimsqfyYU")
                 ->setRedirectUri("https://example.com/")
                 ->setExpand("plan,customer");
    $result = $subscription->doRequest();
    var_dump($result);


LookupSubscription Class <a name="LookupSubscription"></a>
==========================================================

Returns details about a previously created subscription.

Methods
-------

- **setSubscriptionId(string $subscriptionId)** - Sets the subscription ID.
- **setExpand(string $expandObjects)** - A list of comma-separated names of objects to be expanded in the NETELLER REST API response.
- **doRequest()** - Executes the API request. Returns the JSON-decoded object of the NETELLER REST API response, or "(bool)false" if an error has occurred.
- **getExecutionErrors()** - Returns an array with the error(s) returned by the NETELLER REST API.

Example
-------


    $lookup = new NetellerAPI\LookupSubscription();
    $lookup->setSubscriptionId("180")
           ->setExpand("plan,customer");
    $result = $lookup->doRequest();
    var_dump($result);


CancelSubscription Class <a name="CancelSubscription"></a>
==========================================================

Cancels a previously created subscription.

Methods
-------

- **setSubscriptionId(string $subscriptionId)** - Sets the subscription ID.
- **doRequest()** - Executes the API request. Returns the JSON-decoded object of the NETELLER REST API response, or "(bool)false" if an error has occurred.
- **getExecutionErrors()** - Returns an array with the error(s) returned by the NETELLER REST API.

Example
-------


    $subscription = new NetellerAPI\CancelSubscription();
    $subscription->setSubscriptionId("181");
    $result = $subscription->doRequest();
    var_dump($result);


ListSubscriptions Class <a name="ListSubscriptions"></a>
========================================================

Lists all previously created subscriptions.

Methods
-------

- **setLimit(int $limit)** - Sets the number of records to be returned.
- **setOffset(int $offset)** - Sets the results offset.
- **doRequest()** - Executes the API request. Returns the JSON-decoded object of the NETELLER REST API response, or "(bool)false" if an error has occurred.
- **getExecutionErrors()** - Returns an array with the error(s) returned by the NETELLER REST API.

Example
-------


    $subscriptions = new NetellerAPI\ListSubscriptions();
    $subscriptions->setLimit(10)
                  ->setOffset(0);
    $result = $subscriptions->doRequest();
    var_dump($result);


LookupSubscriptionInvoice Class <a name="LookupSubscriptionInvoice"></a>
========================================================================

Looks up a subscription invoice.

Methods
-------

- **setSubscriptionId(string $subscriptionId)** - Sets the subscription ID.
- **setInvoiceNumber(int $invoiceNumber)** - Sets the invoice number.
- **setExpand(string $expandObjects)** - A list of comma-separated names of objects to be expanded in the NETELLER REST API response.
- **doRequest()** - Executes the API request. Returns the JSON-decoded object of the NETELLER REST API response, or "(bool)false" if an error has occurred.
- **getExecutionErrors()** - Returns an array with the error(s) returned by the NETELLER REST API.

Example
-------


    $lookup = new NetellerAPI\LookupSubscriptionInvoice();
    $lookup->setSubscriptionId(166)
           ->setInvoiceNumber(42)
           ->setExpand("customer, subscription");
    $result = $lookup->doRequest();
    var_dump($result);


LookupAllSubscriptionInvoices Class <a name="LookupAllSubscriptionInvoices"></a>
================================================================================

Looks up all subscription invoices.

Methods
-------

- **setSubscriptionId(string $subscriptionId)** - Sets the subscription ID.
- **setLimit(int $limit)** - Sets the number of records to be returned.
- **setOffset(int $offset)** - Sets the results offset.
- **doRequest()** - Executes the API request. Returns the JSON-decoded object of the NETELLER REST API response, or "(bool)false" if an error has occurred.
- **getExecutionErrors()** - Returns an array with the error(s) returned by the NETELLER REST API.

Example
-------


    $lookup = new NetellerAPI\LookupAllSubscriptionInvoices();
    $lookup->setSubscriptionId(166)
           ->setLimit(10)
           ->setOffset(0);
    $result = $lookup->doRequest();
    var_dump($result);


WebhookHandler Class <a name="WebhookHandler"></a>
==================================================

Handles incoming webhook requests.

Methods
-------

- **handleRequest()** - Receives the webhook request and calls a callback function passing through the webhook data. You need to give the callback function(s) the same name as the webhook(s) you are subscribed to. Please refer to the REST API Guide for a list of all webhook names.

Example
-------


    $webhook = new NetellerAPI\WebhookHandler();
    $webhook->handleRequest();

    function payment_succeeded($data){
        $api = new NetellerAPI\NetellerAPI();
        $result = $api->getUrl($data->links[0]->url);
        //do something with the response here
    }



Test Accounts <a name="TestAccounts"></a>
------------

<table>
<thead>
<tr>
<th>Currency</th>
<th>Account ID</th>
<th>Email Address</th>
<th>Secure ID</th>
<th>Password</th>
</tr>
</thead>
<tbody>
<tr>
<td>AED</td>
<td>451323763077</td>
<td>netellertest_AED@neteller.com</td>
<td>315508</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>AUD</td>
<td>451823760529</td>
<td>netellertest_AUD@neteller.com</td>
<td>521652</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>BGN</td>
<td>450424149137</td>
<td>netellertest_BGN@neteller.com</td>
<td>354380</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>BRL</td>
<td>452124231445</td>
<td>netellertest_BRL@neteller.com</td>
<td>907916</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>CAD</td>
<td>455781454840</td>
<td>netellertest_CAD@neteller.com</td>
<td>755608</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>CHF</td>
<td>452324249609</td>
<td>netellertest_CHF@neteller.com</td>
<td>372993</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>DKK</td>
<td>459734233011</td>
<td>netellertest_DKK@neteller.com</td>
<td>856751</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>EUR</td>
<td>453501020503</td>
<td>netellertest_EUR@neteller.com</td>
<td>908379</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>GBP</td>
<td>458591047553</td>
<td>netellertest_GBP@neteller.com</td>
<td>411392</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>HUF</td>
<td>450824149649</td>
<td>netellertest_HUF@neteller.com</td>
<td>363552</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>INR</td>
<td>450824016049</td>
<td>netellertest_INR@neteller.com</td>
<td>332880</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>JPY</td>
<td>452604251512</td>
<td>netellertest_JPY@neteller.com</td>
<td>490055</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>MAD</td>
<td>453123727913</td>
<td>netellertest_MAD@neteller.com</td>
<td>796289</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>MXN</td>
<td>456444237546</td>
<td>netellertest_MXN@neteller.com</td>
<td>878408</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>MYR</td>
<td>452724116521</td>
<td>netellertest_MYR@neteller.com</td>
<td>108145</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>NGN</td>
<td>450924006321</td>
<td>netellertest_NGN@neteller.com</td>
<td>205750</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>NOK</td>
<td>455394172769</td>
<td>netellertest_NOK@neteller.com</td>
<td>418852</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>PLN</td>
<td>451823629489</td>
<td>netellertest_PLN@neteller.com</td>
<td>654091</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>RON</td>
<td>450424018097</td>
<td>netellertest_RON@neteller.com</td>
<td>860647</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>RUB</td>
<td>455121038904</td>
<td>netellertest_RUB@neteller.com</td>
<td>888470</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>SEK</td>
<td>453313818311</td>
<td>netellertest_SEK@neteller.com</td>
<td>173419</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>SGD</td>
<td>451523741861</td>
<td>netellertest_SGD@neteller.com</td>
<td>316938</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>TND</td>
<td>453523858985</td>
<td>netellertest_TND@neteller.com</td>
<td>588931</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>TWD</td>
<td>451723748785</td>
<td>netellertest_TWD@neteller.com</td>
<td>711009</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>USD</td>
<td>454651018446</td>
<td>netellertest_USD@neteller.com</td>
<td>270955</td>
<td>NTt3st1!</td>
</tr>
<tr>
<td>ZAR</td>
<td>453523842837</td>
<td>netellertest_ZAR@neteller.com</td>
<td>708904</td>
<td>NTt3st1!</td>
</tr>
</tbody>
</table>


Ips for whitelist <a name="IpsForWhitelist"></a>
------------------------------------------------

5.62.88.97 – webhooks production
5.62.88.64/27 – whole production IP range
206.172.46.138 – webhooks Sandbox
