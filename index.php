<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php  
        $jsondata = file_get_contents("2020-01-02.json");
        $json = json_decode($jsondata, true);
        $allButFirst = array_slice($json,1);

        class Article {
            public $title;
            public $image;
            public $link;
        }

        function stripInfo($obj) {
            $strippedInfo = new Article();
            $strippedInfo->title = $obj['attachments'][0]['title'];
            $strippedInfo->image = $obj['attachments'][0]['image_url'];
            $strippedInfo->link = $obj['attachments'][0]['from_url'];
            return $strippedInfo;
        }

        $articles = array_map("stripInfo", $allButFirst);
        print_r($articles[1]->image);

        
    ?>
</body>
</html>