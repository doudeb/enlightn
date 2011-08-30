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
	color: #000000;
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

input, textarea {
    background-color: #fff;
    border: 1px solid #ccc;
    -moz-box-shadow:inset 1px 1px 4px #ddd;
    -webkit-box-shadow:inset 1px 1px 4px #ddd;
    box-shadow:inset 1px 1px 4px #ddd;
    padding: 2px;
}


/* backgrounds */
.ico,
.arrow,
.notif,
#header  .logo,
#header  .tabs li a,
#post .status-box,
#search .search-field .submit,
#search .dates .date,
#feed .open-msg .content .user,
#feed .open-msg .content .<?php echo ENLIGHTN_LINK?>,
#feed .open-msg .content .<?php echo ENLIGHTN_IMAGE?>,
#feed .open-msg .content .<?php echo ENLIGHTN_MEDIA?>,
#feed .open-msg .content .<?php echo ENLIGHTN_DOCUMENT?>,
.bubble .redirect {
    background: url('<?php echo $vars['url'] ?>mod/enlightn/media/graphics/sprite.png') no-repeat scroll 0 0 transparent;
}

.follow,
.button,
#header,
#header  .menus li.submenu:hover,
#search .filters,
#search .filters li:hover,
#search .filters li.checked,
#feed .actions,
#feed .actions ul li:hover,
#feed .more,
#post form .privacy .value,
#post .textarea .toolbar li,
#post button.submit,
#login-box .submit_button,
#sidebar .folders .menu .up,
#sidebar .folders .menu .down,
#presence .header,
#layer .close,
#cloud button.submit,
#settings_edit .button,
#facebox .close {
    background: url('<?php echo $vars['url'] ?>mod/enlightn/media/graphics/sprite-x.png') repeat-x scroll 0 0 transparent;
}

#page {
    background: url('<?php echo $vars['url'] ?>mod/enlightn/media/graphics/sprite-y.png') repeat-y scroll 0 0 transparent;
}

/* generic rules */
.photo {
    background-color: #fff;
    border: 1px solid #ccc;
    float:left;
    height:50px;
    padding:3px;
    width:50px
}

.thumb-photo {
    border: 1px solid #ccc;
    height:50px;
    padding:1px;
    width:50px
}

.follow, .button {
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
    padding: 0 6px;
}

.follow {
    padding: 0 6px 0 0;
}

.unfollow {
    background-position: 0 -351px;
    border-color:#999;
    color:#555;
}

span.follow:hover, span.button:hover {
    background-color:#bbdc03;
    background-image:none;
}

span.unfollow:hover {
    background-color:#ddd;
}

.follow .ico, .button .ico {
    background-position: -198px -126px;
    display: inline-block;
    height: 15px;
    vertical-align: middle;
    width: 15px;
}

.unfollow .ico {
    background-position: -200px -152px;
}

.unfollow .follow-val, .follow .unfollow-val {
    display:none;
}

.unfollow .unfollow-val {
    display:inline;
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

#header .menus li .user img, .users img {
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
    background-color: #000;
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#000000',endColorstr='#161616');
    background:-webkit-gradient(linear,left top,left bottom,from(#000000),to(#161616));
    background:-moz-linear-gradient(top,#000000,#161616);
    clear:both;
    padding: 20px 0;
}

#footer .content {
    font-size: 87%;
    margin: 0 auto;
    text-align: right;
    width: 980px;
}

#footer, #footer a {
    color:#999;
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


/** POST FORM */
#post {
    margin-bottom:25px;
}

#post.open {
    margin-bottom:10px;
}

#post .photo {
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

#post form, #post.open .status-box {
    display:none;
}

#post.open form {
    display:block;
    overflow: hidden;
}

#post form .privacy {
    border:1px solid #8fad15;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    -khtml-border-radius:5px;
    border-radius:5px;
    float:right;
    height:30px;
}

#post form .privacy .value {
    background-color:#bbdc03;
    background-position:0 -451px;
    color:#fff;
    display:block;
    float:left;
    font-size:93%;
    height: 22px;
    padding: 8px 9px 0;
    text-align: center;
    width: 50px;
}

#post form .privacy .private-val, #post form .private .public-val {
    display:none;
}

#post form .private .private-val {
    display:block;
}

#post form .private .private-val .ico {
    background-position: -104px -151px;
    display: inline-block;
    height: 14px;
    margin: -3px 4px 0 -2px;
    vertical-align: middle;
    width: 11px;
}

#post form .privacy .cursor {
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    -khtml-border-radius:5px;
    border-radius:5px;
    -moz-box-shadow:inset 0 0 5px #fff;
    -webkit-box-shadow:inset 0 0 5px #fff;
    box-shadow:inset 0 0 5px #fff;
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#cccccc',endColorstr='#ffffff');
    background:-webkit-gradient(linear,left top,left bottom,from(#cccccc),to(#ffffff));
    background:-moz-linear-gradient(top,#cccccc,#ffffff);
    border: 1px solid #999;
    color: #999999;
    cursor: pointer;
    display: block;
    float: left;
    height: 30px;
    margin: -1px;
    position: relative;
    width: 40px;
}

#post form .title, #post .textarea {
    background-color:#fff;
    border:1px solid #ccc;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    -khtml-border-radius:5px;
    border-radius:5px;
    margin-bottom: 10px;
    overflow:hidden;
    padding:7px 9px;
}

#post form .title {
    width: 420px;
}

#post .textarea {
    height:85px;
}

#post .textarea .toolbar {
    background-color:#e5e5e5;
    border:1px solid #ccc;
    -moz-border-radius:5px 5px 0 0;
    -webkit-border-radius:5px 5px 0 0;
    -khtml-border-radius:5px 5px 0 0;
    border-radius:5px 5px 0 0;
    margin:-8px -10px 7px;
    overflow:hidden;
    padding: 4px;
}

#post .textarea .toolbar li {
    background-color:#fff;
    background-position: 0 -381px;
    border:1px solid #bbb;
    -moz-border-radius:3px;
    -webkit-border-radius:3px;
    -khtml-border-radius:3px;
    border-radius:3px;
    cursor:pointer;
    display:block;
    float: left;
    height: 22px;
    margin: 0 1px;
    width: 24px;
}

#post .textarea .toolbar li .ico {
    display:block;
    height: 22px;
    width: 24px;
}

#post .textarea .toolbar .bold .ico { background-position:-11px -177px; }
#post .textarea .toolbar .italic .ico { background-position:-39px -177px; }
#post .textarea .toolbar .stroke .ico { background-position:-67px -177px; }

#post .textarea .toolbar .ul .ico { background-position:-105px -177px; }
#post .textarea .toolbar .ol .ico { background-position:-133px -177px; }
#post .textarea .toolbar .quote .ico { background-position:-161px -177px; }

#post .textarea .toolbar .a-left .ico { background-position:-194px -177px; }
#post .textarea .toolbar .a-center .ico { background-position:-222px -177px; }
#post .textarea .toolbar .a-right .ico { background-position:-250px -177px; }

#post .textarea .toolbar .link .ico { background-position:-284px -177px; }
#post .textarea .toolbar .video .ico { background-position:-309px -177px; }
#post .textarea .toolbar .pict .ico { background-position:-335px -177px; }
#post .textarea .toolbar .doc .ico { background-position:-362px -177px; }

#post .textarea .toolbar li:hover {
    background-image:none;
}

#post .textarea .toolbar li.new-gp {
    margin-left:7px;
}

#post .textarea .toolbar .form-open  {
    background-image: none;
}

#post .textarea .toolbar .video .form {
    background-color: #FFFFFF;
    border: 1px solid #CCCCCC;
    display:none;
    margin: -1px;
    padding: 4px 6px;
    position: absolute;
}

#post .textarea .toolbar .form-open .form {
    display:block;
}

#post .textarea .toolbar .video .form .caption {
    color: #666666;
    font-size: 93%;
}

#post .textarea .toolbar .video .form input {
    color: #666;
    display: block;
    font-size: 87%;
    margin: 7px 0 3px;
    width: 150px;
}

#post form .dest {
    margin-bottom: 10px;
    text-align:right;
}

#post form .dest input {
    display: inline;
    vertical-align: middle;
    width: 370px;
}

#post form .tags {
    float:left;
}

.add {
    cursor:pointer;
    margin-left:5px;
}

.add .ico {
    background-position: -134px -151px;
    display: inline-block;
    height: 15px;
    vertical-align: middle;
    width: 15px;
}

.add .caption {
    color:#2d87e1;
    font-size:87%;
}

.add-form {
    background-color: #FFFFFF;
    border: 1px solid #CCCCCC;
    margin: -3px 2px;
    padding: 4px 6px;
    position: absolute;
}

.add-form input {
    color: #666;
    display: block;
    font-size: 87%;
    margin: 7px 0 3px;
    width: 150px;
}

#post form .sending {
    float:right;
}

#post form .sending .checkbox {
    vertical-align: middle;
}

#post form .sending .reply {
    background-position: -228px -152px;
    display: inline-block;
    height: 15px;
    vertical-align: middle;
    width: 15px;
}

#post button.submit {
    background-position: 0 -411px;
    border: 1px solid #8eac15;
    -moz-border-radius:3px;
    -webkit-border-radius:3px;
    -khtml-border-radius:3px;
    border-radius:3px;
    color: #FFFFFF;
    font-size: 116%;
    font-weight: bold;
    margin-left: 10px;
    outline:none;
    padding: 3px 15px;
    text-shadow: 1px 1px 1px #43520A;
}

#post button.submit:hover {
    background-color:#bbdc03;
    background-image:none;
}

#post button.submit:active {
    background-color:#9dbd20;
    background-image:none;
}

/** FEED */
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

#feed .s-actions {
    border-bottom:1px solid #ccc;
    padding:5px 0 3px;
}

#feed .s-actions li {
    color: #2C75E2;
    cursor:pointer;
    display:inline;
    font-size:87%;
    margin-right:15px;
    vertical-align: top;
}

#feed .s-actions li.right {
    float: right;
    margin: 0 0 0 15px;
}

#feed .s-actions li:hover {
    text-decoration:underline;
}

#feed .s-actions .arrow {
    background-position: -299px -128px;
    display: inline-block;
    height: 7px;
    width: 10px;
}

#feed .s-actions .arrow-top {
    background-position: -321px -128px;
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

#feed.detail .msg {
    padding:3px 0;
}

/*home message hover and cursor*/
.msg_home {
	cursor:pointer;
}

.msg_home:hover {
    background-color:#f2f1f2;
}

#feed .first-msg, #feed ol .msg:first-child {
    border:none;
}

#feed .msg .toolbar {
    float:right;
    margin-left: 10px;
    width:70px;
}

#feed.detail .msg .toolbar {
    width:auto;
}

#feed .msg .statusbar {
    float: left;
	width: 28px;
	text-align: center;
}

#feed .msg .excerpt {
    overflow:hidden;
}

#feed .msg .follow {
    float:right;
    margin-bottom: 5px;
    margin-right: 7px;
}

#feed .followed .follow {
    display:none;
}

.msg .star, .msg .lock {
    background-position:-164px -123px;
    display:inline-block;
    height:18px;
    width:18px;
}

.msg .lock {
    background-position: -164px -149px;
}

#feed .msg .star {
    clear:right;
    float:right;
    margin-right:5px;
    margin-top:3px;
}

#feed.detail .msg .star {
    float:none;
    margin-top:6px;
}

.starred .star {
    background-position:-132px -123px;
}

#feed .msg .checkbox {
    height:15px;
    margin-bottom:5px;
    width:15px;
}

.msg .read {
    background-position:-50px -127px;
    display:block;
    height:12px;
    width:12px;
    margin-left:8px;
}

.unread .read {
    background-position:-74px -127px;
}

#feed.detail .msg .read {
    display:inline-block;
    margin-top: 10px;
    vertical-align: top;
}

#feed .msg .inclosed {
    background-position:-100px -125px;
    display:block;
    height:16px;
    margin: 10px 0 0 -2px;
    width:17px;
}

#feed.detail .msg .inclosed {
    display:inline-block;
}

#feed .msg .thumb-photo {
    float:left;
    margin-right:10px;
}

#feed .msg h3 {
    font-size: 110%;
    font-weight: bold;
    overflow:hidden;
    white-space: nowrap;
}

#feed .msg a {
	color : #444950;
}


#feed .unread h3 {
}

#feed .msg .participants {
    display: block;
    font-size: 93%;
    margin-top: 2px;
    margin-bottom: 4px;
	color : #444950;
    white-space: nowrap;
}

#feed.detail .msg .participants {
    float:left;
    margin: 9px 10px 0 9px;
}

#feed .msg .participants strong {
    font-weight:bold;
}

#feed .msg .excerpt p {
    color: #8b97a1;
    font-size: 87%;
    margin-top:8px;
}

#feed.detail .msg .excerpt p {
    color: #8b97a1;
    font-size: 93%;
    height: auto;
    overflow:hidden;
    white-space:nowrap;
}

#feed .msg .date {
    color: #8b97a1;
    font-size: 87%;
	text-decoration:none;
}

#feed.detail .msg .date {
    color: #666666;
    display: inline-block;
    float: none;
    font-weight: normal;
    margin-top: 11px;
    vertical-align: top;
}

#feed .open-msg .excerpt p, #feed .msg .content {
    display:none;
}

#feed .open-msg .thumb-photo {
    margin-top: 0px;
}

#feed .open-msg .content {
    display:block;
    margin:-20px 0 10px 100px;
}

#feed .open-msg .content p {
    font-size: 93%;
    margin-bottom: 15px;
    margin-right: 60px;
}

#feed .open-msg .content p a {
    text-decoration:underline;
}

#feed .open-msg .content .user,
#feed .open-msg .content .<?php echo ENLIGHTN_LINK?>,
#feed .open-msg .content .<?php echo ENLIGHTN_IMAGE?>,
#feed .open-msg .content .<?php echo ENLIGHTN_MEDIA?>,
#feed .open-msg .content .<?php echo ENLIGHTN_DOCUMENT?> {
    color: #2C75E2;
    cursor:pointer;
    display: inline-block;
    padding:0 0 0 18px;
    text-decoration:underline;
}

#feed .open-msg .content .user { background-position:-485px -152px; border: none; overflow: visible; }
#feed .open-msg .content .<?php echo ENLIGHTN_LINK?> { background-position:-485px -176px; }
#feed .open-msg .content .<?php echo ENLIGHTN_MEDIA?> { background-position:-485px -200px; }
#feed .open-msg .content .<?php echo ENLIGHTN_IMAGE?> { background-position:-485px -224px; }
#feed .open-msg .content .<?php echo ENLIGHTN_DOCUMENT?> { background-position:-485px -248px; }

#feed .msg .inclosed-list {
    border:1px solid #ccc;
    font-size: 93%;
    margin:0 0 0 -5px;
    padding:5px;
}

#feed .msg .inclosed-list h4 {
    display: inline;
    margin-right: 5px;
}

#feed .msg .inclosed-list .all {
    font-size: 92%;
}

#feed .msg .inclosed-list li {
    padding: 4px 0 0;
}

#feed .msg .content .inclosed-list li a {
    color:#666;
    text-decoration:none;
}

#feed .msg .content .inclosed-list li a:hover {
    text-decoration:underline;
}

#feed .msg .inclosed-list .spec {
    color:#999;
    font-size: 92%;
    margin-left:5px;
}

#feed .join {
    border-top:1px solid #ccc;
    font-size: 93%;
    padding:7px;
    color: #444950;
}

#feed .join a {
    color: #444950;
    font-weight: bold;
}

#feed .join .ico {
    background-position: -485px -152px;
    display: inline-block;
    height: 15px;
    margin: -3px 3px 0 0;
    vertical-align: middle;
    width: 15px;
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

#feed .user {
    border-color:#ccc #eee;
    border-style:solid;
    border-width: 0 1px 1px;
    overflow:hidden;
    padding: 10px;
}

#feed .user:hover {
    background-color:#f7f7f7;
}

#feed .selected-user {
    background-color:#e3f3a2;
    border-color: #bbb;
    -moz-box-shadow: 0 0 4px #ccc;
    -webkit-box-shadow: 0 0 4px #ccc;
    box-shadow: 0 0 4px #ccc;
}

#feed .selected-user:hover {
    background-color:#f6ffd3;
}

#feed .user p {
    color:#666;
    font-size:93%;
}

#feed .user .send-msg {
    float:right;
}

#feed .user .send-msg .ico {
    background-position: -65px -152px;
    width: 20px;
}

#feed .user .photo {
    margin-right:10px;
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
    -moz-box-shadow:inset 0 0 0 #fff;
    -webkit-box-shadow:inset 0 0 0 #fff;
    box-shadow:inset 0 0 0 #fff;
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

#sidebar .folders li.current {
    background-color: #fff;
}

#sidebar .folders li a.cat {
    color: <?php echo ($css_sidebar_folders = get_plugin_setting('css_sidebar_folders','enlightn'))?$css_sidebar_folders:'#2D87E1';?>;
    display: block;
    font-size: 124%;
    font-weight: bold;
    padding: 12px 10px;
}

#sidebar .folders li a.cat:hover {
    background-color:#f7f7f7;
    text-decoration:none;
}

#sidebar .folders li.current a.cat {
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
    #color:#fff;
    #background-position:-233px -78px;
    #display:inline-block;
    font-size: 100%;
    font-weight: strong;
    height: 16px;
    margin:-4px 0 0 10px;
    padding:5px 0;
    text-align: center;
    vertical-align: middle;
    width:27px;
    color:#999;
    float:right;
}
#sidebar .folders li.current .notif {
        color:#000;
}


#sidebar .folders .lnotif {
    background-position:-272px -78px;
    width:30px;
}

#sidebar .folders .menu .up,
#sidebar .folders .menu .down {
    cursor:pointer;
    display: block;
    text-align: center;
}

#sidebar .folders .menu .up {
    background-position:0 -490px;
    margin-top:-4px;
}

#sidebar .folders .menu .down {
    background-position:0 -520px;
}

#sidebar .folders .menu span .arrow {
    background-position: -299px -128px;
    display: inline-block;
    float: none;
    height: 7px;
    position: static;
    vertical-align: middle;
    width: 10px;
}

#sidebar .folders .menu span.up .arrow {
    background-position: -321px -128px;
    margin-top: -4px;
}

#sidebar .folders .menu ol {
    padding:5px 0;
}

#sidebar .folders .menu li {
    border: none;
    font-size:93%;
    margin: 1px;
    padding: 2px 5px;
    height: auto;
    overflow:hidden;
    white-space:nowrap;
}


#sidebar .folders .menu li.unreaded {
    background-color: #FF0000;
    color: #000;
    font-weight:bold;
    padding: 5px 7px;
}

#sidebar .folders .menu li.selected {
    background-color: #e3f3a2;
    color: #000;
    font-weight:bold;
    padding: 5px 7px;
}


/** DETAIL */
#detail {
    background-color:#f1f1f1;
    border:1px solid #ccc;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    -khtml-border-radius:5px;
    border-radius:5px;
    margin:-10px 0 20px;
    padding:10px;
}

#detail h2, #directory h2, #cloud h2 {
    display:inline;
    font-size: 170%;
    font-weight: normal;
    vertical-align: middle;
}

#detail .actions {
    padding: 5px 0;
}

#detail .read {
    display: inline-block;
    margin: 0 2px 2px;
    vertical-align: middle;
}

#detail .star, #detail .lock {
    vertical-align: middle;
}

#detail .follow {
    margin-right: 0px;
    text-align: center;
    width: 70px;
    float:right;
}

#detail .tags {
    display:block;
    overflow:hidden;
}

#detail .tags li {
    background-color: #ffff99;
    float:left;
    margin: 3px;
    padding: 0 4px;
}

.users {
    padding:3px 0;
}

.users .label, .users .date {
    display: inline-block;
    font-size:87%;
    margin-right:7px;
    text-align:right;
    width:80px;
}

.users-invited .label, .author .label, .users .date {
    color:#666;
}

.users-invited img {
    filter:alpha(opacity=80);
    opacity:0.8;
}

.users img {
    margin:0;
}

.users .date {
    margin: 0 0 0 5px;
    width: auto;
}


/** DIRECTORY */
.unselectable, .unselectable * {
   -moz-user-select: -moz-none;
   -khtml-user-select: none;
   -webkit-user-select: none;
   -o-user-select: none;
   user-select: none;
}

#directory .header {
    margin-bottom: 20px;
    overflow:hidden;
}

#directory #search {
    float: right;
    padding: 0;
    width: 200px;
}

#directory #search .search-field {
    padding: 4px 12px 4px 6px;
    white-space: nowrap;
}

#directory .s-actions .letters {
    border-top:1px solid #ccc;
    margin-top:2px;
    padding:5px 0;
}

#directory .s-actions .letters li {
    border-right:1px solid #ddd;
    color: #333;
    cursor:default;
    margin:0;
    padding: 0 8px 0 5px;
    text-decoration:none;
}

#directory .s-actions .letters li.last {
    border:none;
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

.tag .del {
    font-size:109%;
}

.tag .del:hover {
    color:#000;
    cursor:pointer;
    font-weight:bold;
}

#mover {
    background-color:#fff;
    border: 1px solid #aaa;
    -moz-box-shadow: 0 0 4px #bbb;
    -webkit-box-shadow: 0 0 4px #bbb;
    box-shadow: 0 0 4px #ccc;
    color:#43520A;
    font-weight:bold;
    height:20px;
    line-height:20px;
    position:absolute;
    text-align:center;
    width:30px;
}

#mover.hover {
    background-color:#e3f3a2;
    border-color:#8EAC15;
}

#sidebar.directory .folders {
    margin-top: 120px;
}

#sidebar .drop-folders li.dropable {
    border: 2px dashed #ccc;
    border-width: 0 2px 2px;
}

#sidebar .drop-folders li.highlight {
    background-color:#fff;
    border-color:#aaa;
    border-style:solid;
    border-width: 1px 2px;
    -moz-box-shadow:inset 1px 1px 4px #bbb;
    -webkit-box-shadow:inset 1px 1px 4px #bbb;
    box-shadow:inset 1px 1px 4px #ddd;
}

#sidebar .folders li.increased {
    background-color:#e3f3a2;
    border:1px solid #8EAC15;
}

#sidebar .folders .count {
    color:#999;
    float:right;
}

#sidebar .folders li.increased .count {
    color:#688f00;
}

#sidebar .folders li.increased .oldCount {
    color:#999;
    margin-left:5px;
}

#sidebar .folders .addform, #sidebar .folders li.addform a.cat:hover {
    background-color: #e5e5e5;
}

#sidebar .folders .addform a.cat {
    color: #000;
}

#sidebar .folders .form {
    display:none;
    padding: 0 0 10px;
}

#sidebar .folders .form label {
    display: block;
    float: left;
    line-height: 24px;
    padding: 0 10px 0 23px;
}

#sidebar .folders .form input {
    border: 1px solid #999999;
    padding: 3px;
    width: 160px;
}

#sidebar .folders .form .private-ico, #sidebar .folders .form .public-ico {
    cursor:pointer;
}

.private-ico {
    background-position:-11px -150px;
    display:inline-block;
    height:15px;
    margin:-3px 5px 0;
    vertical-align:middle;
    width:13px;
}

.public-ico {
    background-position:-37px -150px;
    display:inline-block;
    height:15px;
    margin:-3px 5px 0;
    vertical-align:middle;
    width:18px;
}
/** CLOUD **/
#join button.submit {
    background-position: 0 -411px;
    border: 1px solid #8eac15;
    -moz-border-radius:3px;
    -webkit-border-radius:3px;
    -khtml-border-radius:3px;
    border-radius:3px;
    color: #FFFFFF;
    font-size: 116%;
    font-weight: bold;
    margin-left: 10px;
    outline:none;
    padding: 3px 15px;
    text-shadow: 1px 1px 1px #43520A;
}

#join button.submit:hover {
    background-color:#bbdc03;
    background-image:none;
}

#join button.submit:active {
    background-color:#9dbd20;
    background-image:none;
}

.cloud_thumb {
    background-color: #fff;
    border: 1px solid #ccc;
    float:left;
    padding: 3px;
    margin: 0 6px;
    width:60px
}

#cloud .header {
    margin-bottom: 20px;
}

#join {
    float: right;
    white-space: nowrap;
    padding: 0;
}

#join .join-field  {
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
    padding:4px 6px;
}


#cloud .join-field input {
    border:1px solid #fff;
    -moz-box-shadow:inset 0 0 0 #fff;
    -webkit-box-shadow:inset 0 0 0 #fff;
    box-shadow:inset 0 0 0 #fff;
    padding:2px;
    width: 180px;
    vertical-align: middle;
}


#cloud .user .bottom {
    color: #999999;
    float: left;
    font-size: 87%;
    margin-top: 30px;
}

/** PROFILE */

#profile .big-photo {
    border: 1px solid #ccc;
    height:100px;
    padding:3px;
    width:100px;
    float: left;
}

#profile .header {
	height : 130px;
	padding-left: 130px;
	padding-top: 10px;
}

#profile .job_location {
	padding-top: 30px;
}

#profile_sidebar {
	text-align:center;

}


#profile_sidebar .linker {
    margin : 8px auto 0 auto;
	width : 200px;
    overflow : hidden;
}

#profile_sidebar .linker a {
    margin : 0 auto 0 auto;
}

#profile_sidebar .photo_linker {
    border: 0px;
    width: 40px;
}

#profile_sidebar .details  {
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
    padding:4px 6px;
    margin:25px;
}

/** SETTINGS */

#settings {
    background-color : #eeeeee;
    padding-top : 20px;
}

#settings .big-photo {
    border: 1px solid #ccc;
    height:100px;
    padding:3px;
    width:100px;
    float: left;
}

#settings .header {
	height : 130px;
	padding-left: 130px;
	padding-top: 10px;
}

#settings_tabs .settings_tabs {
    border-bottom : 1px solid #ccc;
    height : 20px;
    padding-left : 30px;
}

#settings_tabs .settings_tabs li {
    display : inline;
    border : 1px solid #ccc;
    border-bottom : 0px;
    -moz-border-radius:5px 5px 0px 0px;
    -webkit-border-radius:5px 5px 0px 0px;
    -khtml-border-radius:5px 5px 0px 0px;
    border-radius:5px 5px 0px 0px;
    padding : 8px 8px 6px 8px;
    cursor : pointer;
}

#settings_tabs .settings_tabs li:hover {
    background-color:#f7f7f7;
    text-decoration:none;
}

#settings_tabs .settings_tabs li.current {
    background-color : #ffffff;
}


#settings_edit {
    background-color : #ffffff;
    padding : 10px 10px 80px 10px;
    border-right : 1px solid #ccc;
}

#settings_edit p {
    clear : both;
    height : 30px;
    vertical-align: middle;
}

#settings_edit .photo_linker {
    border: 0px;
    height: 30px;
    margin-top : -8px;
}

#settings_edit label {
    width : 150px;
    display : block;
    height : 30px;
    float : left;
    text-align : right;
    margin : 2px 5px 0px 0;
    vertical-align: middle;
}

#settings_edit input[type=text],
#settings_edit input[type=password],
#settings_edit select,
#settings_edit textarea {
    width : 150px;
    border : 1px solid #ccc;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    -khtml-border-radius:5px;
    border-radius:5px;
}

#settings_edit .button {
    background-position: 0 -411px;
    border: 1px solid #8eac15;
    -moz-border-radius:3px;
    -webkit-border-radius:3px;
    -khtml-border-radius:3px;
    border-radius:3px;
    color: #FFFFFF;
    font-size: 116%;
    font-weight: bold;
    margin-left: 10px;
    outline:none;
    padding: 3px 15px;
    text-shadow: 1px 1px 1px #43520A;
}

/** BUBBLE */
.bubble {
    background-color:#fff;
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff',endColorstr='#f0f0f0');
    background:-webkit-gradient(linear,left top,left bottom,from(#ffffff),to(#f0f0f0));
    background:-moz-linear-gradient(top,#ffffff,#f0f0f0);
    border:1px solid #ccc;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    -khtml-border-radius:5px;
    border-radius:5px;
    color:#666;
    cursor:default;
    #display:none;
    margin: 22px 0 0 -20px;
    padding: 10px;
    position: absolute;
    text-decoration:none;
    width: 170px;
}

#feed .open-msg .content span:hover .bubble {
    display:block;
}

.bubble .arrow {
    background-position:-308px -152px;
    display:block;
    height: 10px;
    margin: -20px 0 10px 5px;
    position: relative;
    width: 35px;
}

.bubble .photo, .bubble .icon {
    display: block;
    margin-right: 10px;
}

.bubble .icon {
    width:60px;
}

.bubble .icon .spec {
    color:#666;
    font-size: 85%;
}

.bubble .col {
    overflow:hidden;
}

.bubble strong {
    color: #2D87E1;
	display:block;
    font-size: 125%;
    font-weight: bold;
    white-space: normal;
}

.bubble .headline {
    font-size: 87%;
}

.bubble .button {
    margin-top: 6px;
}

.download .ico {
    background-position: -255px -152px;
    margin-right: 3px;
}

.bubble img {
    background-color: #000;
}

.bubble .player {
    cursor:pointer;
    display:block;
    position:relative;
}

.bubble .player .ico {
    background-position:-320px -64px;
    height:53px;
    left: 48px;
    position: absolute;
    top: 24px;
    width:53px;
}

.bubble .redirect {
    background-position:100% -268px;
    color:#2d87e1;
    display: block;
    margin: 4px -4px -4px 0;
    padding-right: 17px;
    text-align: right;
    text-decoration:underline;
}



/** PRESENCE */
#presence {
    background-color:#fff;
    border:1px solid #ccc;
    border-right-color:#000;
    -moz-box-shadow: 2px 2px 5px #333;
    -webkit-box-shadow: 2px 2px 5px #333;
    box-shadow: 2px 2px 5px #333;
    bottom: 0;
    font-size:93%;
    margin-right: 20px;
    position: fixed;
    right:20px;
    width: 130px;
}

#presence .header {
    color:#fff;
    cursor:pointer;
    padding:3px 5px;
}

#presence .header .arrow {
    background-position: -252px -127px;
    float: right;
    height: 10px;
    margin: 2px;
    width: 10px;
}

#presence li {
    border-bottom:1px solid #ccc;
    color: #2c75e2;
    cursor:pointer;
    padding: 3px 5px;
}

#presence li:hover {
    background-color:#f5f5f5;
    color:#000;
}

#presence li .ico {
    background-position: -228px -127px;
    display: inline-block;
    height: 10px;
    margin-right: 5px;
    width: 10px;
}

#presence .chat {
    background-color: #fff;
    border: 1px solid #ccc;
    border-right-color:#000;
    -moz-box-shadow: 2px 2px 5px #333;
    -webkit-box-shadow: 2px 2px 5px #333;
    box-shadow: 2px 2px 5px #333;
    cursor: default;
    margin-left: -227px;
    *margin-left: -306px;
    margin-top: -60px;
    *margin-top: -44px;
    min-height: 100px;
    position: absolute;
    width: 220px;
}

#presence .chat .close {
    float:right;
}

#presence .chat .arrow {
    background-position:0 -242px;
    display:block;
    float: right;
    height: 30px;
    margin-right: -20px;
    margin-top: 18px;
    position: relative;
    width: 20px;
}

#presence .chat .content {
    padding:8px;
}

#presence .chat .content textarea {
    border-color: #999999;
    margin-bottom: 8px;
    width:195px;
}

.popup {
    background-color:#fff;
    border:1px solid #ccc;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    -khtml-border-radius:5px;
    border-radius:5px;
    -moz-box-shadow: 2px 2px 5px #333;
    -webkit-box-shadow: 2px 2px 5px #333;
    box-shadow: 2px 2px 5px #333;
    #padding:15px 20px;
}


/** LAYER */
#layer {
    background-color:#fff;
    border:1px solid #ccc;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    -khtml-border-radius:5px;
    border-radius:5px;
    -moz-box-shadow: 2px 2px 5px #333;
    -webkit-box-shadow: 2px 2px 5px #333;
    box-shadow: 2px 2px 5px #333;
    padding:15px 20px;
    position:absolute;
    top:300px;
    left:28%;
    width:480px;
}

#layer .close  {
    background-position: 0 -381px;
    border:1px solid #ccc;
    -moz-border-radius:4px;
    -webkit-border-radius:4px;
    -khtml-border-radius:4px;
    border-radius:4px;
    cursor: pointer;
    float: right;
    font-size: 116%;
    margin: -16px -21px 0 0;
    padding: 2px 5px;
    text-align: center;
    width: 12px;
}

#layer .caption {
    color:#666;
    font-size: 93%;
}

#layer .caption small {
    color:#000;
    font-size:92%;
}

#layer input {
    border-color: #999999;
    margin: 3px 0;
    width: 470px;
}

#layer .new-bloc {
    padding:20px 0 0;
}

.embeded_preview {
	overflow: hidden;
}

/** LOGIN **/


#login-box {
    background-color:#fff;
    min-height:600px;
    padding: 30px 10px 30px 20px;
    width: 630px;
}


#login-box h2 {

}

#login-box .loginbox {
    margin:10px 100px 10px 100px;
    text-align: center;

}



#login-box .loginbox label {
}

#login-box .loginbox input {
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
    margin : 10px;
}

#login-box .submit_button {
    background-position: 0 -411px;
    border: 1px solid #8eac15;
    -moz-border-radius:3px;
    -webkit-border-radius:3px;
    -khtml-border-radius:3px;
    border-radius:3px;
    color: #FFFFFF;
    font-size: 116%;
    font-weight: bold;
    margin-left: 10px;
    outline:none;
    padding: 3px 15px;
    text-shadow: 1px 1px 1px #43520A;
}


#persistent_login {
    background-color:#fff;
    width: 630px;
    text-align:center;
    margin-bottom : 30px;
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
   	background-color: #FFFFFF;

}

.frameBody p
{
    border:0px;
    padding:0px;
}

.rte-zone
{
    width:600px;
    margin:0;
    padding:0;
    border:0px;
    clear:both;
    height:85px;
    display:block;
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

.loader {
	position: absolute;
	overflow: hidden;
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
	#padding: 10px;
	#background: white;
	width: 980px;
	#-webkit-border-radius: 12px;
	#-moz-border-radius: 12px;
}
#facebox .loading {
	text-align: center;
	padding: 100px 10px 100px 10px;
}
#facebox .image {
	text-align: center;
}
#facebox .footer {
	margin:0;
	padding:0;
	position: absolute;
	overflow: hidden;
	width:100%;
}

#facebox .close  {
    background-position: 0 -381px;
    border:1px solid #ccc;
    -moz-border-radius:4px;
    -webkit-border-radius:4px;
    -khtml-border-radius:4px;
    border-radius:4px;
    cursor: pointer;
    font-size: 116%;
    margin: -1px -1px 0 0;
    padding: 2px 5px;
    text-align: center;
    float: right;
    width: 12px;
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
#two_column_left_sidebar_maincontent_boxes {
        margin:0 0px 20px 20px;
        padding:0 0 5px 0;
        width:718px;
        background: #dedede;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        float:left;
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
        width:360px;
        margin-top : -130px;
        margin-left : 160px;
}
#current_user_avatar {
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

<?php

	/**
	 * Elgg Members
	 *
	 * @package Members
	 */

?>

/* new members page */
.members .search_listing {
	border:2px solid #cccccc;
	margin:0 0 5px 0;
}
.members .search_listing:hover {
	background:#dedede;
}
.members .group_count {
	font-weight: bold;
	color: #666666;
	margin:0 0 5px 4px;
}
.members .search_listing_info {
	color:#666666;
}

.members .profile_status {
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	background:#bbdaf7;
	line-height:1.2em;
	padding:2px 4px;
}
.members .profile_status span {
	font-size:90%;
	color:#666666;
}
.members  p.owner_timestamp {
	padding-left:3px;
}
.members .pagination {
	border:2px solid #cccccc;
	margin:5px 0 5px 0;
}


#memberssearchform {
	border-bottom: 1px solid #cccccc;
	margin-bottom: 10px;
}
#memberssearchform input[type="submit"] {
	padding:2px;
	height:auto;
	margin:4px 0 5px 0;
}
#memberssearchform .search_input {
	width:176px;
}

/* ***************************************
	FRIENDS COLLECTIONS ACCORDIAN
*************************************** */
ul#friends_collections_accordian {
	margin: 0 0 0 0;
	padding: 0;
}
#friends_collections_accordian li {
	margin: 0 0 0 0;
	padding: 0;
	list-style-type: none;
	color: #666666;
}
#friends_collections_accordian li h2 {
	background:#4690d6;
	color: white;
	padding:4px 2px 4px 6px;
	margin:10px 0 10px 0;
	font-size:1.2em;
	cursor:pointer;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
}
#friends_collections_accordian li h2:hover {
	background:#333333;
	color:white;
}
#friends_collections_accordian .friends_picker {
	background:white;
	padding:0;
	display:none;
}
#friends_collections_accordian .friends_collections_controls {
	font-size:70%;
	float:right;
}
#friends_collections_accordian .friends_collections_controls a {
	color:#999999;
	font-weight:normal;
}


/* ***************************************
	FRIENDS PICKER SLIDER
*************************************** */
.friendsPicker_container h3 {
	font-size:4em !important;
	text-align: left;
	margin:0 0 10px 0 !important;
	color:#999999 !important;
	background: none !important;
	padding:0 !important;
}
.friendsPicker .friendsPicker_container .panel ul {
	text-align: left;
	margin: 0;
	padding:0;
}
.friendsPicker_wrapper {
	margin: 0;
	padding:0;
	position: relative;
}
.friendsPicker {
	position: relative;
	overflow: hidden;
	margin: 0;
	padding:0;

	height: auto;
	#background: #dedede;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
}
.friendspicker_savebuttons {
	background: white;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	margin:0 10px 10px 10px;
}
.friendsPicker .friendsPicker_container { /* long container used to house end-to-end panels. Width is calculated in JS  */
	position: relative;
	left: 0;
	top: 0;
	list-style-type: none;
}
.friendsPicker .friendsPicker_container .panel {
	float:left;
	height: 100%;
	position: relative;
	width: 678px;
	margin: 0;
	padding:0;
}
.friendsPicker .friendsPicker_container .panel .wrapper {
	margin: 0;
	padding:4px 10px 10px 10px;
	min-height: 230px;
}
.friendsPickerNavigation {
	margin: 0 0 10px 0;
	padding:0;
}
.friendsPickerNavigation ul {
	list-style: none;
	padding-left: 0;
}
.friendsPickerNavigation ul li {
	float: left;
	margin:0;
	background:white;
}
.friendsPickerNavigation a {
	font-weight: bold;
	text-align: center;
	background: white;
	color: #999999;
	text-decoration: none;
	display: block;
	padding: 0;
	width:20px;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
}
.tabHasContent {
	background: white; color:#333333 !important;
}
.friendsPickerNavigation li a:hover {
	background: #333333;
	color:white !important;
}
.friendsPickerNavigation li a.current {
	background: #4690D6;
	color:white !important;
}
.friendsPickerNavigationAll {
	margin:0px 0 0 20px;
	float:left;
}
.friendsPickerNavigationAll a {
	font-weight: bold;
	text-align: left;
	font-size:0.8em;
	background: white;
	color: #999999;
	text-decoration: none;
	display: block;
	padding: 0 4px 0 4px;
	width:auto;
}
.friendsPickerNavigationAll a:hover {
	background: #4690D6;
	color:white;
}
.friendsPickerNavigationL, .friendsPickerNavigationR {
	position: absolute;
	top: 46px;
	text-indent: -9000em;
}
.friendsPickerNavigationL a, .friendsPickerNavigationR a {
	display: block;
	height: 43px;
	width: 43px;
}
.friendsPickerNavigationL {
	right: 48px;
	z-index:1;
}
.friendsPickerNavigationR {
	right: 0;
	z-index:1;
}
.friendsPickerNavigationL {
	background: url("<?php echo $vars['url']; ?>_graphics/friends_picker_arrows.gif") no-repeat left top;
}
.friendsPickerNavigationR {
	background: url("<?php echo $vars['url']; ?>_graphics/friends_picker_arrows.gif") no-repeat -60px top;
}
.friendsPickerNavigationL:hover {
	background: url("<?php echo $vars['url']; ?>_graphics/friends_picker_arrows.gif") no-repeat left -44px;
}
.friendsPickerNavigationR:hover {
	background: url("<?php echo $vars['url']; ?>_graphics/friends_picker_arrows.gif") no-repeat -60px -44px;
}
.friends_collections_controls a.delete_collection {
	display:block;
	cursor: pointer;
	width:14px;
	height:14px;
	margin:2px 3px 0 0;
	background: url("<?php echo $vars['url']; ?>_graphics/icon_customise_remove.png") no-repeat 0 0;
}
.friends_collections_controls a.delete_collection:hover {
	background-position: 0 -16px;
}
.friendspicker_savebuttons .submit_button,
.friendspicker_savebuttons .cancel_button {
	margin:5px 20px 5px 5px;
}

#collectionMembersTable {
	background: #dedede;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	margin:10px 0 0 0;
	padding:10px 10px 0 10px;
}

.item {
	overflow: auto;
}

/* ***************************************
WIDGET PICKER (PROFILE & DASHBOARD)
*************************************** */
/* 'edit page' button */
a.toggle_customise_edit_panel {
	float:right;
	clear:right;
	color: #4690d6;
	background: white;
	border:1px solid #cccccc;
	padding: 5px 10px 5px 10px;
	margin:0 0 20px 0;
	width:280px;
	text-align: left;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
}
a.toggle_customise_edit_panel:hover {
	color: #ffffff;
	background: #0054a7;
	border:1px solid #0054a7;
	text-decoration:none;
}
#customise_editpanel {
	display:none;
	margin: 0 0 20px 0;
	padding:10px;
	background: #dedede;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
}

/* Top area - instructions */
.customise_editpanel_instructions {
	width:690px;
	padding:0 0 10px 0;
}
.customise_editpanel_instructions h2 {
	padding:0 0 10px 0;
}
.customise_editpanel_instructions p {
	margin:0 0 5px 0;
	line-height: 1.4em;
}

/* RHS (widget gallery area) */
#customise_editpanel_rhs {
	float:right;
	width:230px;
	background:white;
}
#customise_editpanel #customise_editpanel_rhs h2 {
	color:#333333;
	font-size: 1.4em;
	margin:0;
	padding:6px;
}
#widget_picker_gallery {
	border-top:1px solid #cccccc;
	background:white;
	width:210px;
	height:340px;
	padding:10px;
	overflow:scroll;
	overflow-x:hidden;
}

/* main page widget area */
#customise_page_view {
	width:656px;
	padding:10px;
	margin:0 0 10px 0;
	background:white;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
}
#customise_page_view h2 {
	border-top:1px solid #cccccc;
	border-right:1px solid #cccccc;
	border-left:1px solid #cccccc;
	margin:0;
	padding:5px;
	width:200px;
	color: #0054a7;
	background: #dedede;
	font-size:1.25em;
	line-height: 1.2em;
}
#profile_box_widgets {
	width:422px;
	margin:0 10px 10px 0;
	padding:5px 5px 0px 5px;
	min-height: 50px;
	border:1px solid #cccccc;
	background: #dedede;
}
#customise_page_view h2.profile_box {
	width:422px;
	color: #999999;
}
#profile_box_widgets p {
	color:#999999;
}
#leftcolumn_widgets {
	width:200px;
	margin:0 10px 0 0;
	padding:5px 5px 40px 5px;
	min-height: 190px;
	border:1px solid #cccccc;
}
#middlecolumn_widgets {
	width:200px;
	margin:0 10px 0 0;
	padding:5px 5px 40px 5px;
	min-height: 190px;
	border:1px solid #cccccc;
}
#rightcolumn_widgets {
	width:200px;
	margin:0;
	padding:5px 5px 40px 5px;
	min-height: 190px;
	border:1px solid #cccccc;
}
#rightcolumn_widgets.long {
	min-height: 288px;
}
/* IE6 fix */
* html #leftcolumn_widgets {
	height: 190px;
}
* html #middlecolumn_widgets {
	height: 190px;
}
* html #rightcolumn_widgets {
	height: 190px;
}
* html #rightcolumn_widgets.long {
	height: 338px;
}

#customise_editpanel table.draggable_widget {
	width:200px;
	background: #cccccc;
	margin: 10px 0 0 0;
	vertical-align:text-top;
	border:1px solid #cccccc;
}
#widget_picker_gallery table.draggable_widget {
	width:200px;
	background: #cccccc;
	margin: 10px 0 0 0;
}

/* take care of long widget names */
#customise_editpanel table.draggable_widget h3 {
	word-wrap:break-word;/* safari, webkit, ie */
	width:140px;
	line-height: 1.1em;
	overflow: hidden;/* ff */
	padding:4px;
}
#widget_picker_gallery table.draggable_widget h3 {
	word-wrap:break-word;
	width:145px;
	line-height: 1.1em;
	overflow: hidden;
	padding:4px;
}
#customise_editpanel img.more_info {
	background: url(<?php echo $vars['url']; ?>_graphics/icon_customise_info.gif) no-repeat top left;
	cursor:pointer;
}
#customise_editpanel img.drag_handle {
	background: url(<?php echo $vars['url']; ?>_graphics/icon_customise_drag.gif) no-repeat top left;
	cursor:move;
}
#customise_editpanel img {
	margin-top:4px;
}
#widget_moreinfo {
	position:absolute;
	border:1px solid #333333;
	background:#e4ecf5;
	color:#333333;
	padding:5px;
	display:none;
	width: 200px;
	line-height: 1.2em;
}
.widget_more_wrapper {
	background-color: white;
	margin:0 10px 5px 10px;
	padding:5px;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
}
/* droppable area hover class  */
.droppable-hover {
	background:#bbdaf7;
}
/* target drop area class */
.placeholder {
	border:2px dashed #AAA;
	width:196px !important;
	margin: 10px 0 10px 0;
}
/* class of widget while dragging */
.ui-sortable-helper {
	background: #4690d6;
	color:white;
	padding: 4px;
	margin: 10px 0 0 0;
	width:200px;
}
/* IE6 fix */
* html .placeholder {
	margin: 0;
}
/* IE7 */
*:first-child+html .placeholder {
	margin: 0;
}
/* IE6 fix */
* html .ui-sortable-helper h3 {
	padding: 4px;
}
* html .ui-sortable-helper img.drag_handle, * html .ui-sortable-helper img.remove_me, * html .ui-sortable-helper img.more_info {
	padding-top: 4px;
}
/* IE7 */
*:first-child+html .ui-sortable-helper h3 {
	padding: 4px;
}
*:first-child+html .ui-sortable-helper img.drag_handle, *:first-child+html .ui-sortable-helper img.remove_me, *:first-child+html .ui-sortable-helper img.more_info {
	padding-top: 4px;
}
