<?php
$data = file_get_contents("http://vnexpress.net/tin-tuc/giao-duc");
$pattern = '#class="block_image_news width_common">(.*)</div>\s*</li>#imusU';
preg_match_all($pattern, $data, $matches);
array_shift($matches);

$array = $matches[0];
$ketqua = array();
$top = '#class="block_news_big">.*<a href="(.*)" .*src="(.*)" .*"txt_link">(.*)<.*class="news_lead" .*>(.*)</h4>#imusU';
preg_match($top, $data, $item);
array_shift($item);
if (!empty($item)) {
    $topitem['link'] = $item[0];
    $topitem['title'] = trim($item[2]);
    $topitem['img'] = $item[1];
    $topitem['detail'] = trim($item[3]);
}
array_push($ketqua, $topitem);

foreach ($array as $key => $value) {
    $pattern = '#<h3 class="title_news"><a href="(.*)" .*>(.*)<.*<img src="(.*)" .*<div class="news_lead" .*>(.*)</div>#imusU';
    preg_match($pattern, $value, $item);
    array_shift($item);
    if (!empty($item)) array_push($ketqua, array('link' => $item[0], 'title' => trim($item[1]), 'img' => $item[2], 'detail' => trim($item[3])));
}

?>
<html>
<head>
    <title>Vũ Trọng Phương</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            border: 0;
        }

        body {
            background: #add5ff;
        }

        .tintuc {
            width: 900px;
            margin: 80px auto;
            max-width: 1500px;
            background: url("images/trans-white-bg-20.png");
            padding: 8px;
        }

        #list-tintuc {
            list-style-type: none;
            font-family: Arial, sans-serif;
        }

        #list-tintuc li {
            height: auto;
            border-bottom: 1px darkgray solid;
            padding: 25px 0;
        }

        #list-tintuc img {
            float: left;
            margin-right: 20px;
        }

        h3.title {
            padding: 4px;
            margin-bottom: 20px;
        }

        .detail {
            font-size: 0.8em;
            color: dimgray;
        }

        .tintuc a {
            text-decoration: none;
            color:black;
        }

    </style>
</head>
<body>
<div class="tintuc">
    <ul id="list-tintuc">
        <?php
        function createItem($link, $title, $img, $detail)
        {
            $xhtml = "";
            $xhtml .= '<li>';
            $xhtml .= '<a href=' . $link . '><img src=' . $img . '></a>';
            $xhtml .= '<a href=' . $link . '><h3 class="title">' . $title . '</h3></a>';
            $xhtml .= '<div class="detail">' . $detail . '</div>';
            $xhtml .= '<div style="clear:both;"></div>';
            $xhtml .= '</li>';
            return $xhtml;
        }

        foreach ($ketqua as $key => $value) {
            echo createItem($value['link'], $value['title'], $value['img'], $value['detail']);
        }
        ?>
    </ul>

</div>
</body>
</html>

