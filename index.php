<?php
require 'vendor/autoload.php';
if (isset($_POST['authKey']) && ($_POST['authKey'] == "abc")) {
//if (1) {
    $stripe = new \Stripe\StripeClient('sk_test_51NeD8dKOmnZTt71uroc70Zw2bGbxoKCgCiStIo1xMldRfCrAPrbEHkMitQSmi7nHuJT7y4BSVxNvxI4nUWrO2YnO00uCvmGiKX');

// Use an existing Customer ID if this is a returning customer.
    $customer = $stripe->customers->create(
        [
            'name' => 'Lincon',
            'address' => [
                'line1' => 'Demo',
                'postal_code' => '6100',
                'city' => 'City',
                'state' => 'State',
                'country' => 'Country',
            ]
        ]
    );
    $ephemeralKey = $stripe->ephemeralKeys->create([
        'customer' => $customer->id,
    ], [
        'stripe_version' => '2022-08-01',
    ]);
    $paymentIntent = $stripe->paymentIntents->create([
        'amount' => 1099,
        'currency' => 'eur',
        'description' => 'Test',
        'customer' => $customer->id,
        'automatic_payment_methods' => [
            'enabled' => 'true',
        ],
    ]);

    echo json_encode(
        [
            'paymentIntent' => $paymentIntent->client_secret,
            'ephemeralKey' => $ephemeralKey->secret,
            'customer' => $customer->id,
            'publishableKey' => 'pk_test_51NeD8dKOmnZTt71uaP7AcB8sDQAR7Pg6Nxdu8BLYj2p7sd4eotve9TDmdKOkQ2ZcCAwKSxaB9UTsWm7vVfCMznjB00EyXsQkx6'
        ]
    );
    http_response_code(200);
}echo "Not authorized";