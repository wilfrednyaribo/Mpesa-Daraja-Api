<?php

// Your Mpesa API keys
$consumerKey = "r7QVnvA67E21Dy17eFQ8bYpB9VePIM84l30MB70IUw6sCcBh";
$consumerSecret = "ncdk8YppvHJhujj5xj8YGrqWuuI3LXDW630E00ZhW7DrC6irj2PEiVGv3URHRGja";

// Access token URL
$access_token_url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";

// Set up headers and initialize cURL
$headers = ['Content-Type:application/json; charset=utf8'];
$curl = curl_init($access_token_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);

// Execute cURL request
$result = curl_exec($curl);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

// Check if the request was successful
if ($status == 200) {
    $result = json_decode($result);
    if (isset($result->access_token) && isset($result->expires_in)) {
        echo "Access Token: " . $result->access_token . "<br>";
        echo "Expires In: " . $result->expires_in . " seconds";
    } elseif (isset($result->access_token)) {
        echo "Access Token: " . $result->access_token;
        echo "Warning: Expiry information not found in response.";
    } else {
        echo "Error: Access token not found in response.";
    }
} else {
    echo "Error: Unable to fetch access token. HTTP Status Code: " . $status;
}

// Close the cURL session
curl_close($curl);
