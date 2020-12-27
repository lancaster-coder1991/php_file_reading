<?php  
    $jsondata = file_get_contents("2020-01-02.json");
    $json = json_decode($jsondata, true);
    echo $json['test'][0]->type;
?>