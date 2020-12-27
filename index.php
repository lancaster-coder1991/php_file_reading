<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
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
            $attachments = $obj['attachments'][0];

            $strippedInfo = new Article();
            $strippedInfo->title = $attachments['title'];
            $strippedInfo->image = $attachments['image_url'];
            $strippedInfo->link = $attachments['from_url'];
            $strippedInfo->service = $attachments['service_name'];
            
            return $strippedInfo;
        }

        $articles = array_map("stripInfo", $allButFirst);
    ?>
    <div id="articles-container">
        <?php
        foreach($articles as $article) { echo($article->service . " image")?>
            <a href=<?php echo($article->link)?>> <h3 class="article-title"><?php print($article->title); ?> </h3></a>
            <img class="article-image" src=<?php echo($article->image)?> alt=<?php echo($article->service . " image")?>>
       <?php } ?>
        </div>
</body>
</html>