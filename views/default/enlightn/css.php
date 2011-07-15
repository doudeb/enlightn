/*@charset "utf-8";*/
/* CSS Document */

* {
	font-family: Arial, Helvetica, sans-serif;
	margin: 0;
	padding: 0;
}

body, #body {
	color: #333;
	font-size: 13px;
}

a, a:link, a:hover, a:visited {
	color: #2c75e2;
	outline:none;
}

a:hover {
	text-decoration: underline;
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

/* backgrounds */
.ico,
.arrow,
.notif,
#header  .logo,
#header  .tabs li a,
#post .status-box,
#search .search-field .submit,
#search .dates .date {
    background: url('<?php echo $vars['url'] ?>mod/enlightn/media/graphics/sprite.png') no-repeat scroll 0 0 transparent;
}

.follow,
#header,
#header  .menus li.submenu:hover,
#search .filters,
#search .filters li:hover,
#search .filters li.checked,
#feed .actions,
#feed .actions ul li:hover,
#feed .more {
    background: url('<?php echo $vars['url'] ?>mod/enlightn/media/graphics/sprite-x.png') repeat-x scroll 0 0 transparent;
}

#page {
    background: url('<?php echo $vars['url'] ?>mod/enlightn/media/graphics/sprite-y.png') repeat-y scroll 0 0 transparent;
}

/* generic rules */
.photo {
    border: 1px solid #ccc;
    height:50px;
    padding:3px;
    width:50px
}

.thumb-photo {
    border: 1px solid #ccc;
    height:30px;
    padding:1px;
    width:30px
}

.follow {
    background-position:0 -321px;
    border:1px solid #8eac15;
    -moz-border-radius:2px;
    -webkit-border-radius:2px;
    -khtml-border-radius:2px;
    border-radius:2px;
    color:#43520a;
    cursor:pointer;
    display:inline-block;
    font-size: 87%;
    height: 18px;
    line-height: 18px;
    padding: 0 6px 0 0;
}

span.follow:hover {
    background-color:#bbdc03;
    background-image:none;
}

.follow .ico {
    background-position: -198px -126px;
    display: inline-block;
    height: 15px;
    vertical-align: middle;
    width: 15px;
}


/** HEADER */
#header {
    border-bottom:1px solid #000;
}

#header .nav {
    height:40px;
    margin:0 auto;
    position: relative;
    width:980px;
}

#header .logo {
    background-position:-16px -16px;
    float:left;
    height:40px;
    margin: 0 25px 0 20px;
    text-indent:-999px;
    width:117px;
}

#header .menus, #header .tabs {
    border-left:1px solid #999;
    border-right:1px solid #000;
    *border-left:none;
    *border-right:1px solid #999;
}

#header .menus li, #header .tabs li {
    border-left:1px solid #000;
    border-right:1px solid #999;
    *border-left:1px solid #999;
    *border-right:none;
}

#header .menus {
    float: right;
    height: 40px;
    position: absolute;
    right: 5px;
}

#header .menus li {
    float:right;
}

#header .menus li .link, #header  .menus li .user {
    color:#fff;
    display:block;
    height:40px;
    line-height:40px;
    padding:0 10px;
}

#header .menus li.directory .ico {
    background-position:-392px -30px;
    display:inline-block;
    height:15px;
    margin:-3px 7px 0 0;
    vertical-align:middle;
    width:15px;
}

#header .menus li.account {
    cursor:default;
    padding:0 7px;
}

#header .menus li.account .arrow {
    background-position:-358px -30px;
    display:inline-block;
    height:5px;
    margin:0 2px 0 0;
    vertical-align:middle;
    width:10px;
}

#header .menus li .user {
    padding:0;
}

#header .menus li .user img {
    border: 1px solid #ccc;
    display: inline-block;
    margin: -3px 5px 0 0;
    height:20px;
    vertical-align: middle;
    width:20px;
}

#header .menus li.submenu:hover {
    background-color:#000;
    background-position:0 -50px;
    border-bottom:1px solid #000;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    -khtml-border-radius:5px;
    border-radius:5px;
}

#header .menus .submenu ul {
    display:none;
    padding:0 0 3px;
}

#header .menus li.submenu:hover ul {
    display:block;
}

#header .menus .submenu ul li {
    border:none;
    border-top:1px solid #999;
    float:none;
    font-size:93%;
}

#header .menus .submenu ul li  a{
    color:#fff;
    display:block;
    padding:3px 0;
}

#header .tabs {
    float:left;
}

#header .tabs li {
    float:left;
}

#header .tabs li.current {
    background-color:#666;
}

#header .tabs li:hover {
    background-color:#444;
}

#header .tabs li a {
    display:block;
    height:40px;
    text-indent:-999px;
    width:50px
}

#header .tabs li.current a, #header  .tabs li:hover a{
    border-color:#494949;
    border-style:solid;
    border-width:0 1px 1px 0;
    height:39px;
    width:49px
}

#header .tabs li.home a {
    background-position:-147px -16px;
}

#header .tabs li.alert a {
    background-position:-196px -16px;
}

#header .tabs li.favorites a {
    background-position:-242px -16px;
}

#header .tabs li.replies a {
    background-position:-292px -16px;
}

/** FOOTER */
#footer {
    border-top:1px solid #ddd;
    clear:both;
    margin-top:-1px;
}

/** PAGE */
#page {
    background-position:100% 0;
    border-left:1px solid #ddd;
    margin: 0 auto;
    overflow: hidden;
    width: 980px;
}

/** MAIN */
#main {
    background-color:#fff;
    float:left;
    min-height:600px;
    padding: 30px 10px 30px 20px;
    width: 630px;
}

#post {
    margin-bottom:25px;
}

#post .photo {
    float:left;
    margin-right:10px;
}

#post .status-box {
    background-position:-460px -17px;
    border:1px solid #bbb;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    -khtml-border-radius:5px;
    border-radius:5px;
    -moz-box-shadow:inset 1px 1px 4px #ccc;
    -webkit-box-shadow:inset 1px 1px 4px #ccc;
    box-shadow:inset 1px 1px 4px #ccc;
    height: 36px;
    overflow:hidden;
    padding:10px 10px 10px 40px;
}

#feed .actions {
    background-position:0 -241px;
    border:1px solid #ccc;
    height:22px;
}

#feed .actions ul {
    border-right:1px solid #ccc;
    float: left;
    margin-left:-1px;
}

#feed .actions ul li {
    border-left:1px solid #ccc;
    border-right:1px solid #fff;
    cursor:default;
    float:left;
    font-size:93%;
    height:22px;
    line-height:22px;
    padding:0 5px;
	*position:relative;
	*z-index: 2;
}

#feed .actions ul.right {
    border-left:1px solid #fff;
    *border-left:none;
    border-right:none;
    float:right;
    margin:0;
}

#feed .actions ul.right li {
    float:right;
}

#feed .actions ul li:hover {
    background-color:#e2e2e2;
    background-position:0 -280px;
}

#feed .actions ul li ul {
	background-color:#e2e2e2;
    border-bottom: 1px solid #ccc;
    display:none;
    float:none;
	*left:5px;
    margin: 0 -7px 0 -6px;
    position: absolute;
	*top:20px;
    z-index: 2;
}

#feed .actions ul li:hover ul {
    display:block;
}

#feed .actions ul li ul li {
    border-bottom: 1px solid #fff;
	*border:none;
    float:none;
}

#feed .actions ul li ul li:hover {
    background:none;
    background-color:#eee;
}

#feed .actions .arrow {
    background-position:-358px -41px;
    display:inline-block;
    height:6px;
    margin: -2px 0 0 4px;
    vertical-align: middle;
    width:10px
}

#feed .actions .checkbox {
    height:15px;
    margin-top: -3px;
    vertical-align: middle;
    width:15px;
}

#feed h2 {
    border-bottom:1px solid #666;
    font-size:87%;
    font-weight:normal;
    margin:5px 0 10px;
    text-transform:uppercase;
}

#feed h2 span {
    background-color:#fff;
    display:inline-block;
    padding-right: 5px;
    position: relative;
    top: 7px;
}

#feed .msg {
    border-top:1px solid #ccc;
    padding:10px 0;
}

#feed .first-msg, #feed ol .msg:first-child {
    border:none;
}

#feed .msg .toolbar {
    float:right;
    margin-left: 10px;
    width:70px;
}

#feed .msg .statusbar {
    float:left;
    margin-right: 10px;
}

#feed .msg .excerpt {
    overflow:hidden;
}

#feed .msg .follow {
    float:right;
    margin-bottom: 5px;
}

#feed .followed .follow {
    display:none;
}

#feed .msg .star {
    background-position:-164px -123px;
    clear:right;
    display:inline-block;
    float:right;
    height:18px;
    width:18px;
}

#feed .starred .star {
    background-position:-132px -123px;
}

#feed .msg .checkbox {
    height:15px;
    margin-bottom:5px;
    width:15px;
}

#feed .msg .read {
    background-position:-50px -127px;
    display:block;
    height:12px;
    width:12px;
}

#feed .unread .read {
    background-position:-74px -127px;
}

#feed .msg .inclosed {
    background-position:-100px -125px;
    display:block;
    height:16px;
    margin: 10px 0 0 -2px;
    width:17px;
}

#feed .msg .thumb-photo {
    float:left;
    margin-right:10px;
}

#feed .msg h3 {
    font-size: 108%;
    font-weight: normal;
    overflow:hidden;
    white-space: nowrap;
}

#feed .unread h3 {
    font-weight: bold;
}

#feed .msg .participants {
    display: block;
    font-size: 93%;
    margin-top: 2px;
    white-space: nowrap;
}

#feed .msg .participants strong {
    font-weight:bold;
}

#feed .msg .excerpt p {
    color: #999;
    font-size: 87%;
    height: 30px;
    margin-top:5px;
}

#feed .msg .date {
    color: #999999;
    float: right;
    font-size: 87%;
    font-weight: bold;
    margin-top: -15px;
}

#feed .more {
    background-position:0 -241px;
    border:1px solid #ccc;
    color:#666;
    cursor:pointer;
    font-weight:bold;
    height:25px;
    line-height:25px;
    margin-top: 15px;
    text-align: center;
}

#feed div.more:hover {
    background-color:#e2e2e2;
    background-position:0 -280px;
    border-color:#aaa;
}

#feed .more .ico {
    background-position:-273px -128px;
    display:inline-block;
    height:8px;
    vertical-align:middle;
    width:10px;
}


/** SEARCH */
#search {
    overflow: hidden;
    padding:20px 15px;
}

#search .search-field {
    background-color:#fff;
    border:1px solid #bbb;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    -khtml-border-radius:5px;
    border-radius:5px;
    -moz-box-shadow:inset 1px 1px 4px #ccc;
    -webkit-box-shadow:inset 1px 1px 4px #ccc;
    box-shadow:inset 1px 1px 4px #ccc;
    font-size:108%;
    overflow:hidden;
    padding:4px 6px;
}

#search .search-field input {
    border:1px solid #fff;
    padding:2px;
    vertical-align: middle;
    width:88%;
}

#search .search-field .submit {
    background-color:transparent;
    background-position:-14px -81px;
    border:none;
    cursor:pointer;
    height:20px;
    vertical-align: middle;
    width:20px;
}

#search .filters {
    background-position:0 -191px;
    border:1px solid #ccc;
    -moz-border-radius:4px;
    -webkit-border-radius:4px;
    -khtml-border-radius:4px;
    border-radius:4px;
    float: right;
    margin-top: 8px;
    overflow: hidden;
}

#search .filters li {
    border-right:1px solid #ccc;
    cursor:pointer;
    float:left;
    height:32px;
    width:35px;
}

#search .filters li input {
    display:none;
}

#search .filters li label {
    cursor:pointer;
    display:block;
    padding: 8px 10px 0;
}

#search .filters li .ico {
    height: 23px;
    margin: 5px 3px;
    padding: 0;
    text-indent: -999px;
    width: 30px;
}

#search .filters li .text {
    background-position:-43px -81px;
}

#search .filters li .link {
    background-position:-80px -81px;
}

#search .filters li .video {
    background-position:-115px -81px;
}

#search .filters li .pict {
    background-position:-152px -81px;
}

#search .filters li .doc {
    background-position:-192px -81px;
}

#search .filters li:hover, #search .filters li.checked {
    background-color:#e2e2e2;
    background-position:0 -280px;
}

#search .dates, #search .author  {
    clear:both;
    float: right;
    margin: 12px 0 0;
    white-space:nowrap;
}

#search .dates label, #search .author label  {
    display:inline;
    font-size: 87%;
    padding: 5px 3px;
    vertical-align: middle;
}

#search .dates .date {
    background-color: #fff;
    background-position: 46px -122px;
    border:1px solid #999;
    display:inline;
    margin: 0 5px;
    padding:3px 23px 3px 3px;
    vertical-align: middle;
    width:56px;
}

#search .author input {
    background-color: #fff;
    border:1px solid #999;
    display:inline;
    margin: 0 5px;
    padding:3px;
    vertical-align: middle;
    width:185px;
}


/** SIDEBAR */
#sidebar {
    overflow: hidden;
    padding: 0 7px 0 16px;
}

#sidebar .folders {
    border-bottom:1px solid #fff;
    border-top:1px solid #ccc;
}

#sidebar .folders li {
    border-bottom:1px solid #ccc;
    border-top:1px solid #fff;
}

#sidebar .folders li a {
    color: #2D87E1;
    display: block;
    font-size: 124%;
    font-weight: bold;
    padding: 12px 10px;
}

#sidebar .folders li a:hover {
    background-color:#f7f7f7;
    text-decoration:none;
}

#sidebar .folders li.current a {
    background-color:#fff;
    color:#000;
}

#sidebar .folders li.current .arrow {
    background-position:-490px -73px;
    display:block;
    float: left;
    height:40px;
    width:10px;
    left:-10px;
    position:relative;
}

#sidebar .folders .notif {
    color:#fff;
    background-position:-233px -78px;
    display:inline-block;
    font-size: 75%;
    font-weight: normal;
    height: 16px;
    margin:-4px 0 0 10px;
    padding:5px 0;
    text-align: center;
    vertical-align: middle;
    width:27px;
}

#sidebar .folders .lnotif {
    background-position:-272px -78px;
    width:30px;
}


/**
RTE EDITOR
**/
.frameBody
{
    font-family:sans-serif;
    font-size:12px;
    margin:0;
    width:100%;
    height:100%;
}

.frameBody p
{
    border:1px #bbb solid;
    padding:2px;
}

.rte-zone
{
    width:500px;
    margin:0;
    padding:0;
    border:1px #999 solid;
    clear:both;
    height:200px;
    display:block;
}

.rte-toolbar{ overflow:hidden; }

.rte-toolbar a, .rte-toolbar a img {
	border:0;
}

.rte-toolbar p {
    float:left;
    margin:0;
    padding-right:5px;
}


#edit_discussion {
	display:none;
}
.view {
	display:none;
}

.floating .mini-close {
        margin-bottom: 0px;
        margin-left: 0px;
        margin-right: -3px;
        margin-top: -3px;
        position: relative;
}
.mini-close {
        background-image: url("<?php echo $vars['url'] ?>mod/enlightn/media/graphics/default.png");
        background-origin: padding-box;
        background-position: -40px -100px;
        background-repeat: no-repeat;
        background-size: auto;
        cursor: pointer;
        display: block;
        float: right;
        height: 16px;
        width: 16px;
}

/**
* Calendar
**/

.datepicker { border-collapse: collapse; border: 2px solid #999; position: absolute; }
.datepicker tr.controls th { height: 22px; font-size: 11px; }
.datepicker select { font-size: 11px; }
.datepicker tr.days th { height: 18px; }
.datepicker tfoot td { height: 18px; text-align: center; text-transform: capitalize; }
.datepicker th, .datepicker tfoot td { background: #eee; font: 10px/18px Verdana, Arial, Helvetica, sans-serif; }
.datepicker th span, .datepicker tfoot td span { font-weight: bold; }

.datepicker tbody td { width: 24px; height: 24px; border: 1px solid #ccc; font: 11px/22px Arial, Helvetica, sans-serif; text-align: center; background: #fff; }
.datepicker tbody td.date { cursor: pointer; }
.datepicker tbody td.date.over { background-color: #99ffff; }
.datepicker tbody td.date.chosen { font-weight: bold; background-color: #ccffcc; }

<?php

	/**
	 * Elgg embed CSS - standard across all themes
	 *
	 * @package embed
	 */

?>

#facebox {
	position: absolute;
	top: 0;
	left: 0;
	z-index: 10000;
	text-align: left;
}
#facebox .popup {
	position: relative;
}
#facebox .body {
	padding: 10px;
	background: white;
	width: 730px;
	-webkit-border-radius: 12px;
	-moz-border-radius: 12px;
}
#facebox .loading {
	text-align: center;
	padding: 100px 10px 100px 10px;
}
#facebox .image {
	text-align: center;
}
#facebox .footer {
	float: right;
	width:22px;
	height:22px;
	margin:0;
	padding:0;
}
#facebox .footer img.close_image {
	background: url(<?php echo $vars['url']; ?>mod/embed/images/close_button.gif) no-repeat left top;
}
#facebox .footer img.close_image:hover {
	background: url(<?php echo $vars['url']; ?>mod/embed/images/close_button.gif) no-repeat left -31px;
}
#facebox .footer a {
	-moz-outline: none;
	outline: none;
}
#facebox_overlay {
	position: fixed;
	top: 0px;
	left: 0px;
	height:100%;
	width:100%;
}
.facebox_hide {
	z-index:-100;
}
.facebox_overlayBG {
	background-color: #000000;
	z-index: 9999;
}

* html #facebox_overlay { /* ie6 hack */
	position: absolute;
	height: expression(document.body.scrollHeight > document.body.offsetHeight ? document.body.scrollHeight : document.body.offsetHeight + 'px');
}


/* EMBED MEDIA TABS */
#embed_media_tabs {
	margin:10px 0 0 10px;
	padding:0;
}
#embed_media_tabs ul {
	list-style: none;
	padding-left: 0;
}
#embed_media_tabs ul li {
	float: left;
	margin:0;
	background:white;
}
#embed_media_tabs ul li a {
	font-weight: bold;
	font-size:1.35em;
	text-align: center;
	text-decoration: none;
	color:#b6b6b6;
	background: white;
	display: block;
	padding: 0 10px 0 10px;
	margin:0 10px 0 10px;
	height:25px;
	width:auto;
	border-top:2px solid #dedede;
	border-left:2px solid #dedede;
	border-right:2px solid #dedede;
	-moz-border-radius-topleft: 8px;
	-moz-border-radius-topright: 8px;
	-webkit-border-top-left-radius: 8px;
	-webkit-border-top-right-radius: 8px;
}
/* IE6 fix */
* html #embed_media_tabs ul li a { display: inline; }

#embed_media_tabs ul li a:hover {
	background:#b6b6b6;
	color:white;
	border-top:2px solid #b6b6b6;
	border-left:2px solid #b6b6b6;
	border-right:2px solid #b6b6b6;
}
#embed_media_tabs ul li a.embed_tab_selected {
	border-top:2px solid #dedede;
	border-left:2px solid #dedede;
	border-right:2px solid #dedede;
	-webkit-border-top-left-radius: 8px;
	-webkit-border-top-right-radius: 8px;
	-moz-border-radius-topleft: 8px;
	-moz-border-radius-topright: 8px;
	background: #dedede;
	color:#666666;
	position: relative;
	/* top: 2px; - only needed if selected tab needs to sit over a border */
}

#mediaUpload,
#mediaEmbed {
	margin:0 5px 10px 5px;
	padding:10px;
	border:2px solid #dedede;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	background: #dedede;
}
#mediaEmbed .search_listing {
	margin:0 0 5px 0;
	background: white;
}

h1.mediaModalTitle {
	/* color:#0054A7; */
	font-size:1.35em;
	line-height:1.2em;
	margin:0 0 0 8px;
	padding:5px;
}

#mediaEmbed .pagination,
#mediaUpload .pagination {
	float:right;
	padding:5px;
	background:white;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
}
#mediaUpload label {
	font-size:120%;
}
#mediaEmbed p.embedInstructions {
	margin:10px 0 5px 0;
}
a.embed_media {
	margin:0;
	float:right;
	display:block;
	text-align: right;
	font-size:1.0em;
	font-weight: normal;
}
label a.embed_media {
	font-size:0.8em;
}




/* ***************************************
	PAGINATION
*************************************** */
#mediaEmbed .pagination .pagination_number {
	border:1px solid #999999;
	color:#666666;
}
#mediaEmbed .pagination .pagination_number:hover {
	background:#aaaaaa;
	color:black;
}

#mediaEmbed .pagination .pagination_previous,
#mediaEmbed .pagination .pagination_next {
	border:1px solid #999999;
	color:#666666;
}
#mediaEmbed .pagination .pagination_previous:hover,
#mediaEmbed .pagination .pagination_next:hover {
	background:#aaaaaa;
	color:black;
}
#mediaEmbed .pagination .pagination_currentpage {
	background:#666666;
	border:1px solid #666666;
	color:white;
}

/* canvas layout: 2 column left sidebar */
#two_column_left_sidebar {
        width:210px;
        margin:0 20px 0 0;
        min-height:360px;
        float:left;
        background: #dedede;
        padding:0px;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-bottom:1px solid #cccccc;
        border-right:1px solid #cccccc;
}

#two_column_left_sidebar_maincontent {
        width:718px;
        margin:0;
        min-height: 360px;
        float:left;
        background: #dedede;
        padding:0 0 5px 0;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
}
#two_column_left_sidebar_boxes {
        width:210px;
        margin:0px 0 20px 0px;
        min-height:360px;
        float:left;
        padding:0;
}
#two_column_left_sidebar_boxes .sidebarBox {
        margin:0px 0 22px 0;
        background: #dedede;
        padding:4px 10px 10px 10px;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-bottom:1px solid #cccccc;
        border-right:1px solid #cccccc;
}
#two_column_left_sidebar_boxes .sidebarBox h3 {
        padding:0 0 5px 0;
        font-size:1.25em;
        line-height:1.2em;
        color:#0054A7;
}
.contentWrapper {
        background:white;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        padding:10px;
        margin:0 10px 10px 10px;
}


/* general page titles in main content area */
#content_area_user_title h2 {
        margin:0 0 0 8px;
        padding:5px;
        color:#0054A7;
        font-size:1.35em;
        line-height:1.2em;
}

/* ***************************************
PAGE-OWNER BLOCK
*************************************** */
#owner_block {
        padding:10px;
}
#owner_block_icon {
        float:left;
        margin:0 10px 0 0;
}
#owner_block_rss_feed,
#owner_block_odd_feed {
        padding:5px 0 0 0;
}
#owner_block_rss_feed a {
        font-size: 90%;
        color:#999999;
        padding:0 0 4px 20px;
        background: url(<?php echo $vars['url']; ?>_graphics/icon_rss.gif) no-repeat left top;
}
#owner_block_odd_feed a {
        font-size: 90%;
        color:#999999;
        padding:0 0 4px 20px;
        background: url(<?php echo $vars['url']; ?>_graphics/icon_odd.gif) no-repeat left top;
}
#owner_block_rss_feed a:hover,
#owner_block_odd_feed a:hover {
        color: #0054a7;
}
#owner_block_desc {
        padding:4px 0 4px 0;
        margin:0 0 0 0;
        line-height: 1.2em;
        border-bottom:1px solid #cccccc;
        color:#666666;
}
#owner_block_content {
        margin:0 0 4px 0;
        padding:3px 0 0 0;
        min-height:35px;
        font-weight: bold;
}
#owner_block_content {
        margin:0 0 4px 0;
        padding:3px 0 0 0;
        min-height:35px;
        font-weight: bold;
}
#owner_block_content a {
        line-height: 1em;
}
.ownerblockline {
        padding:0;
        margin:0;
        border-bottom:1px solid #cccccc;
        height:1px;
}
#owner_block_submenu {
        margin:20px 0 20px 0;
        padding: 0;
        width:100%;
}
#owner_block_submenu ul {
        list-style: none;
        padding: 0;
        margin: 0;
}
#owner_block_submenu ul li.selected a {
        background: #4690d6;
        color:white;
}
#owner_block_submenu ul li.selected a:hover {
        background: #4690d6;
        color:white;
}
#owner_block_submenu ul li a {
        text-decoration: none;
        display: block;
        margin: 2px 0 0 0;
        color:#4690d6;
        padding:4px 6px 4px 10px;
        font-weight: bold;
        line-height: 1.1em;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
}
#owner_block_submenu ul li a:hover {
        color:white;
        background: #0054a7;
}
/* ***************************************
        SETTINGS & ADMIN
*************************************** */
.admin_statistics,
.admin_users_online,
.usersettings_statistics,
.admin_adduser_link,
#add-box,
#search-box,
#logbrowser_search_area {
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        background:white;
        margin:0 10px 10px 10px;
        padding:10px;
}

.usersettings_statistics h3,
.admin_statistics h3,
.admin_users_online h3,
.user_settings h3,
.notification_methods h3 {
        background:#e4e4e4;
        color:#333333;
        font-size:1.1em;
        line-height:1em;
        margin:0 0 10px 0;
        padding:5px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
}
h3.settings {
        background:#e4e4e4;
        color:#333333;
        font-size:1.1em;
        line-height:1em;
        margin:10px 0 4px 0;
        padding:5px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
}
.admin_users_online .profile_status {
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        background:#bbdaf7;
        line-height:1.2em;
        padding:2px 4px;
}
.admin_users_online .profile_status span {
        font-size:90%;
        color:#666666;
}
.admin_users_online  p.owner_timestamp {
        padding-left:3px;
}


.admin_debug label,
.admin_usage label {
        color:#333333;
        font-size:100%;
        font-weight:normal;
}

.admin_usage {
        border-bottom:1px solid #cccccc;
        padding:0 0 20px 0;
}
.usersettings_statistics .odd,
.admin_statistics .odd {

}
.usersettings_statistics .even,
.admin_statistics .even {

}
.usersettings_statistics td,
.admin_statistics td {
        padding:2px 4px 2px 4px;
        border-bottom:1px solid #cccccc;
}
.usersettings_statistics td.column_one,
.admin_statistics td.column_one {
        width:200px;
}
.usersettings_statistics table,
.admin_statistics table {
        width:100%;
}
.usersettings_statistics table,
.admin_statistics table {
        border-top:1px solid #cccccc;
}
.usersettings_statistics table tr:hover,
.admin_statistics table tr:hover {
        background: #E4E4E4;
}
.admin_users_online .search_listing {
        margin:0 0 5px 0;
        padding:5px;
        border:2px solid #cccccc;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
}
/* ***************************************
        ADMIN AREA - PLUGIN SETTINGS
*************************************** */
.plugin_details {
        margin:0 10px 5px 10px;
        padding:0 7px 4px 10px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
}
.admin_plugin_reorder {
        float:right;
        width:200px;
        text-align: right;
}
.admin_plugin_reorder a {
        padding-left:10px;
        font-size:80%;
        color:#999999;
}
.plugin_details a.pluginsettings_link {
        cursor:pointer;
        font-size:80%;
}
.active {
        border:1px solid #999999;
        background:white;
}
.not-active {
        border:1px solid #999999;
        background:#dedede;
}
.plugin_details p {
        margin:0;
        padding:0;
}
.plugin_details a.manifest_details {
        cursor:pointer;
        font-size:80%;
}
.manifest_file {
        background:#dedede;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        padding:5px 10px 5px 10px;
        margin:4px 0 4px 0;
        display:none;
}
.admin_plugin_enable_disable {
        width:150px;
        margin:10px 0 0 0;
        float:right;
        text-align: right;
}
.contentIntro .enableallplugins,
.contentIntro .disableallplugins {
        float:right;
}
.contentIntro .enableallplugins {
        margin-left:10px;
}
.contentIntro .enableallplugins,
.not-active .admin_plugin_enable_disable a {
        font: 12px/100% Arial, Helvetica, sans-serif;
        font-weight: bold;
        color: #ffffff;
        background:#4690d6;
        border: 1px solid #4690d6;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        width: auto;
        padding: 4px;
        cursor: pointer;
}
.contentIntro .enableallplugins:hover,
.not-active .admin_plugin_enable_disable a:hover {
        background: #0054a7;
        border: 1px solid #0054a7;
        text-decoration: none;
}
.contentIntro .disableallplugins,
.active .admin_plugin_enable_disable a {
        font: 12px/100% Arial, Helvetica, sans-serif;
        font-weight: bold;
        color: #ffffff;
        background:#999999;
        border: 1px solid #999999;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        width: auto;
        padding: 4px;
        cursor: pointer;
}
.contentIntro .disableallplugins:hover,
.active .admin_plugin_enable_disable a:hover {
        background: #333333;
        border: 1px solid #333333;
        text-decoration: none;
}
.pluginsettings {
        margin:15px 0 5px 0;
        background:#bbdaf7;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        padding:10px;
        display:none;
}
.pluginsettings h3 {
        padding:0 0 5px 0;
        margin:0 0 5px 0;
        border-bottom:1px solid #999999;
}
#updateclient_settings h3 {
        padding:0;
        margin:0;
        border:none;
}
.input-access {
        margin:5px 0 0 0;
}
/* ***************************************
        MISC.
*************************************** */
/* general page titles in main content area */
#content_area_user_title h2 {
        margin:0 0 0 8px;
        padding:5px;
        color:#0054A7;
        font-size:1.35em;
        line-height:1.2em;
}
/* reusable generic collapsible box */
.collapsible_box {
        background:#dedede;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        padding:5px 10px 5px 10px;
        margin:4px 0 4px 0;
        display:none;
}
a.collapsibleboxlink {
        cursor:pointer;
}

/* tag icon */
.object_tag_string {
        background: url(<?php echo $vars['url']; ?>_graphics/icon_tag.gif) no-repeat left 2px;
        padding:0 0 0 14px;
        margin:0;
}

/* profile picture upload n crop page */
#profile_picture_form {
        height:145px;
}
#current_user_avatar {
        float:left;
        width:160px;
        height:130px;
        border-right:1px solid #cccccc;
        margin:0 20px 0 0;
}
#profile_picture_croppingtool {
        border-top: 1px solid #cccccc;
        margin:20px 0 0 0;
        padding:10px 0 0 0;
}
#profile_picture_croppingtool #user_avatar {
        float: left;
        margin-right: 20px;
}
#profile_picture_croppingtool #applycropping {

}
#profile_picture_croppingtool #user_avatar_preview {
        float: left;
        position: relative;
        overflow: hidden;
        width: 100px;
        height: 100px;
}
/* reusable elgg horizontal tabbed navigation
(used on friends collections, external pages, & riverdashboard mods)
*/
#elgg_horizontal_tabbed_nav {
        margin:0 0 5px 0;
        padding: 0;
        border-bottom: 2px solid #cccccc;
        display:table;
        width:100%;
}
#elgg_horizontal_tabbed_nav ul {
        list-style: none;
        padding: 0;
        margin: 0;
}
#elgg_horizontal_tabbed_nav li {
        float: left;
        border: 2px solid #cccccc;
        border-bottom-width: 0;
        background: #eeeeee;
        margin: 0 0 0 10px;
        -moz-border-radius-topleft:5px;
        -moz-border-radius-topright:5px;
        -webkit-border-top-left-radius:5px;
        -webkit-border-top-right-radius:5px;
}
#elgg_horizontal_tabbed_nav a {
        text-decoration: none;
        display: block;
        padding:3px 10px 0 10px;
        color: #999999;
        text-align: center;
        height:21px;
}


