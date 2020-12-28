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

        function filterArticles($article) {
            if(isset($article['attachments'])
            and isset($article['attachments'][0]['title'])
            and isset($article['attachments'][0]['image_url'])
            and isset($article['attachments'][0]['from_url'])) return true;
        }

        $filteredList = array_filter($json,"filterArticles");

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
    <div id="articles-container">
        <?php 
       $headerArr = get_headers($articles[3]->image);
        $string = $headerArr[0];
        if(strpos($string,"200"))
  {
    print 'url exists';
  }
  else
  {
    print 'url does not exist';
  }
        ?>
    <!-- <a href=<?php echo($article->link)?>> <h3 class="article-title"><?php print($article->title); ?> </h3></a>
            <img id=<?php echo($article->title)?> class="article-image" src=<?php echo($article->image)?> alt=<?php echo($article->service . " image")?>> -->
        <?php
        $index = 0;
        foreach($articles as $article) { ?>
            <a href=<?php echo($article->link)?>> <h3 class="article-title"><?php print($article->title); ?> </h3></a>
            <img id=<?php echo($article->title)?> class="article-image" src=<?php echo($article->image)?> alt=<?php echo($article->service . " image")?>>
       <?php } ?>
        </div>
</body>
</html>