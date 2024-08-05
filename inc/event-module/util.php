<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class EventUtil
{
    // public static $endpoint = 'http://127.0.0.1:3000/';
    // public static $endpoint = 'https://hanil.liara.run/';
    public static $endpoint = 'http://events.services.hanil.life/';
    private static $privateKey;

    // Initialize the private key in a static block or static method
    public static function init()
    {
        // error_log(get_stylesheet_directory() . '/inc/event-module/RSA/private.key');
        self::$privateKey = file_get_contents(get_stylesheet_directory() . '/inc/event-module/RSA/private.key');
    }

    // Method to verify JWT token
    public static function verifyToken($jwt)
    {
        try {
            $decoded = JWT::decode($jwt, new Key(self::$privateKey, 'RS256'));
            return (array) $decoded;
        } catch (Exception $e) {
            // Handle the error appropriately in your application
            return null;
        }
    }

    // Method to get JWT token for demonstration purposes
    public static function getToken($payload)
    {
        try {
            $issuedAt = time();
            $expirationTime = $issuedAt + 3600; // jwt valid for 1 hour from the issued time
            $payload['iat'] = $issuedAt;
            $payload['exp'] = $expirationTime;
            // TODO set USERID here
            $payload['USERID'] = get_current_user_id();
            // $payload['USERID'] =5;
            $jwt = JWT::encode($payload, self::$privateKey, 'RS256');
            return $jwt;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public static function callApi($endpnt, $data = [], $method = 'POST')
    {
        try {
            // Initialize cURL session
            $ch = curl_init(self::$endpoint . $endpnt);

            
            // Convert data array to JSON format
            $jsonData = json_encode($data);
            
            //log $data
            // error_log(print_r($jsonData, true));

            // return  EventUtil::getToken(['role' => 'superAdmin']);
            // Set common cURL options

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    

            switch (strtoupper($method)) {
                case 'POST':
                case 'PUT':
                    $headers = [
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($jsonData),
                        'Authorization: Bearer ' . EventUtil::getToken(['role' => 'teacher'])
                    ];
                    break;
                case 'DELETE':
                case 'GET':
                    $headers = [
                        'Authorization: Bearer ' . EventUtil::getToken(['role' => 'teacher'])
                    ];
                    break;
                default:
                    throw new Exception("Unsupported HTTP method: $method");
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
           
            // Set the HTTP method and attach data if needed
            switch (strtoupper($method)) {
                case 'POST':
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                    break;
                case 'PUT':
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                    break;
                case 'DELETE':
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                    break;
                case 'GET':
                    curl_setopt($ch, CURLOPT_HTTPGET, 1);
                    break;
                default:
                    throw new Exception("Unsupported HTTP method: $method");
            }


            // Execute the request
            $response = curl_exec($ch);
      
            // Check for errors
            if ($response === false) {
                $error = curl_error($ch);
                curl_close($ch);
                return "cURL Error: $error";
            }

            // Close the cURL session
            curl_close($ch);

            // Return the response
            return $response;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}

// Initialize the static properties
EventUtil::init();

// Usage example
// Generate a token
// $token = EventUtil::getToken(['user_id' => 123]);

// Verify the token
// $decodedToken = EventUtil::verifyToken($token);

// if ($decodedToken) {
//     echo "Token is valid. User ID: " . $decodedToken['user_id'];
// } else {
//     echo "Token is invalid.";
// }
