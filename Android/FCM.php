<?php
//메세지 발송

function Driver_Push($tokens, $message)
{
    $apiKey = "AAAA1sTifQ8:APA91bEbbE3NxvqMNZF79ptDCz1L07Pi9e40v6TWDqa8JAtTkwl2Fh81PhBOi0Ou4YllbRuOhQ04A8ByuaGzhm33xyMv0tBEW90CpTn_bPs-QcZUUzWi5gMx74uUH_O0YPPz-aKn7738";
    return Push($apiKey, $tokens, $message);
}


function Manager_Push($tokens, $message)
{
    $apiKey = "AAAABPeA66o:APA91bEijUtLi8WB0F4GefVOzjpaYHGaftQkfvnCKtzSdRGxQWw7GQFDJTwYDL2xjzsOxi1KGSMbiTaP9ty-sEjaN66O3fLKja-qOFThxxP0NMDBjBqkjR7HYTWjmVkBqY5WqO9V5_MB";
    return Push($apiKey, $tokens, $message);
}

function Normal_Push($tokens, $message)
{
    $apiKey = "AAAAjo6YgNo:APA91bGOO_-UJULbqWhS26gVOVOe11FaH1lfeVZ51GoRhpfbk7vKttMeGfYrzUpHumgO9dq9zbvZRSf7WT3bs4YAkmfgigXhdddC8sdQfOlfQY9lsk3p7SCVyrueHEy5nDZ2pJCuBe1Z";
    return Push($apiKey, $tokens, $message);
}

function Push($apiKey, $tokens, $message)
{
    $url = 'https://fcm.googleapis.com/fcm/send';

    $fields = array('registration_ids' => $tokens, 'data' => $message);
    $headers = array('Authorization:key=' . $apiKey, 'Content-Type: application/json');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }
    curl_close($ch);
    return $result;
}
