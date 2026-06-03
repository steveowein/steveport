<?php
function send_brevo_email(string $to_email, string $to_name, string $subject, string $html_content) {
    // WARNING: Use environment variables or secure config for API keys in production
    $api_key = getenv('BREVO_API_KEY') ?: 'YOUR_API_KEY_HERE';
    
    $data = array(
        "sender" => array(
            "name" => "Steve Owein Presidente",
            "email" => "steveoweinpresidente@gmail.com"
        ),
        "to" => array(
            array(
                "email" => $to_email,
                "name" => $to_name
            )
        ),
        "subject" => $subject,
        "htmlContent" => $html_content
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.brevo.com/v3/smtp/email');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    
    $headers = array(
        'accept: application/json',
        'api-key: ' . $api_key,
        'content-type: application/json'
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $result = curl_exec($ch);
    curl_close($ch);
    
    return $result;
}
?>
