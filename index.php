<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/main.css">
    <title>Document</title>
</head>
<body>

    <?php 
        // Read data from file, parse and save to array variable
        $jsondata = file_get_contents("./data/2020-01-02.json");
        $json = json_decode($jsondata, true);

        //Create a function to filter out the articles that don't have titles, images or links
        function filterArticles($article) {
            if(isset($article['attachments'])
            and isset($article['attachments'][0]['title'])
            and isset($article['attachments'][0]['image_url'])
            and isset($article['attachments'][0]['from_url'])) return true;
        }

        //Create filtered array using above function
        $filteredList = array_filter($json,"filterArticles");

        //Create new class for article objects with only the required information (include service for alt attribute for img elements)
        class Article {
            public $title;
            public $image;
            public $link;
            public $service;

            function __construct($title, $image, $link, $service)
            {
                $this->title = $title;
                $this->image = $image;
                $this->link = $link;
                $this->service = $service;
            }
        }

        function stripInfo($obj) {
            $attachments = $obj['attachments'][0];
            $strippedInfo = new Article($attachments['title'], $attachments['image_url'], $attachments['from_url'], $attachments['service_name']);
            return $strippedInfo;
        }

        $articles = array_map("stripInfo", $filteredList);
    ?>
    <div id="site-header">
        <h1 id="site-title">Geddit</h1>
        <img id="site-image" src="/images/alien.png" alt="">
    </div>
    <div id="articles-list">

        <?php
        $index = 0;
        foreach($articles as $article) { 
            $headerArr = get_headers($article->image);
            $string = $headerArr[0];
        ?>
        <div class="article-container">
             <h3 class="article-title"><a class="article-link" href=<?php echo($article->link)?>><?php print($article->title); ?> </a></h3>
           <?php  if(strpos($string,"200")) { ?>
            <img class="article-image" src=<?php echo($article->image)?> alt=<?php echo("$article->service . image")?>>
           <?php } ?>
        </div>
        <hr>
       <?php } ?>
        </div>
</body>
</html>