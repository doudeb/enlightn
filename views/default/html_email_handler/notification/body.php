<?php
// we won't trust server configuration but specify utf-8
header('Content-type: text/html; charset=utf-8');

$version = get_version();
$release = get_version(true);
$user    = elgg_get_logged_in_user_guid();
$title = $vars["title"];
$message = nl2br($vars["message"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="ElggRelease" content="<?php echo $release; ?>" />
        <meta name="ElggVersion" content="<?php echo $version; ?>" />
        <?php
        if(!empty($title)){
            echo "<title>" . $title . "</title>\n";
        }
        ?>
    </head>
    <body>
        <style type="text/css">
        /*@charset "utf-8";*/
        /* CSS Document */

        * {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
        }

        body, #body {
            background-color: #f7f7f7;
            color: #333;
            font-size: 13px;
        }

        a, a:link, a:hover, a:visited {
            color: #656c6e;
            outline:none;
        }

        a:hover {
            text-decoration: none;
        }

        a {
            text-decoration: none;
        }

        img {
            border:none;
        }

        li {
            list-style-type: none;
        }

        /** HEADER */
        #header {
            border-left:1px solid #ddd;
            border-right:1px solid #ddd;
        }

        #header .nav {
            height:40px;
            border-bottom:1px solid #000;
            margin:0 auto;
            position: relative;
            width:600px;
            background-color: #656c6e;
        }

        #header .logo {
            float:left;
            height:40px;
            margin: 0 25px 0 20px;
            text-indent:-999px;
            width:117px;
        }

        /** PAGE */
        #page {
            background-position:100% 0;
            border-left:1px solid #ddd;
            border-right:1px solid #ddd;
            margin: 0 auto;
            overflow: hidden;
            width: 600px;
        }

        /** MAIN */
        #main {
            background-color:#fff;
            float:left;
            min-height:150px;
            padding: 30px 10px 30px 20px;
            width: 600px;
        }
        /** FOOTER */
        #footer {
            background-color: #656c6e;
            clear:both;
            padding: 20px 0;
            margin: 0 auto;
            width: 600px;
        }

        #footer, #footer a {
            color:#fff;
        }

        #footer .copyright {
            float : right;
        }
        .tag {
            background-color: #CFE965;
            border: 1px solid #8EAC15;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            color: #43520A;
            cursor:default;
            display: inline-block;
            font-size: 85%;
            margin: 3px 6px 0 0;
            padding: 2px 4px;
        }
        .footer-right {
            float : right;
            margin-right : 150px;
        }
        .footer-left {
            margin-left : 150px;
        }
        /** Discussion extract **/
        .message_content {
            border-left: 1px solid #ccc;
            padding:0px 35px 15px 15px;
            text-align: justify;
        }
        </style>
        <div id="header">
            <div class="nav">
                <a href="<?php echo $vars['url']; ?>/enlightn/" alt="<?php echo elgg_echo('PUBLIC')?>"><img src="<?php echo $vars['url'] ?>mod/enlightn/media/graphics/logo.png" title="<?php echo $CONFIG->sitename ?>" class="logo"></a>
            </div>
        </div>
        <div id="page">
            <div id="main">
                <?php if(!empty($title)) //echo elgg_view_title($title); ?>
                <?php echo $message; ?>
            </div>
        </div>
    </body>
</html>
