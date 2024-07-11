<?php

if(!isset($_GET['id'])) {
    return "Not Found";
}

callPlatform($_GET['id']);

function callPlatform($id) {
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, "https://platform.indospacegroup.com/v1_products_det/$id/");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Token 09633df1426fce26fc53de676e8bb65f47a0dcf1'));
    $output = curl_exec($ch); 
    curl_close($ch);      


    $parseToJson = json_decode($output, true);

    print_r($parseToJson);
}