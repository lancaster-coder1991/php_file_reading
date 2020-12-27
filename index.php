<?php  
    $jsondata = file_get_contents("2020-01-02.json");
    $json = json_decode($jsondata, true);
    // print_r($json);
    // print_r($json[0]['files'][0]['title']);
    $allButFirst = array_slice($json,1);
    print_r($allButFirst[0]);
?>