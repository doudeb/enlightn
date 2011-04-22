<script type="text/javascript" src="<?php echo $vars['url']; ?>/mod/enlightn/media/js/jquery.popin.js"></script>
<script language="javascript">
function loadContent (divId,dataTo) {
	javascript:$(divId).prepend('<img src="<?php echo $vars['url'] ?>/mod/enlightn/media/graphics/loading.gif" alt="loading">');
	javascript:$(divId).load(dataTo);
}
</script>
<style>
#activity_container { 
	background:#eee999;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	padding:5px 10px 5px 10px;
	margin:4px 0 4px 0;
	border : 2px solid  #cccccc;
}
#left_container { 
	width: 38%;
	float:left;
}
#discussion_list_container {
	#border-bottom: 2px solid #cccccc;
	#border-left: 2px solid #cccccc;
	border-right: 2px solid #cccccc;
}

#short_post_view { 
	padding:5px 10px 5px 10px;
	#margin:4px 4px 4px 4px;
	border-bottom: 2px solid #cccccc;
}
#discussion { 
	background:#cccccc;
	#-webkit-border-radius: 8px;
	#-moz-border-radius: 8px;
	#padding:5px 10px 5px 10px;
	margin:4px 4px 4px 4px;
	border-right: 2px solid #cccccc;
	width: 60%;
	float:left;
}
#topic_header { 
	background:#FFFFFF;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	#padding:5px 10px 5px 10px;
	margin:4px 4px 4px 4px;
	border: 1px solid #000000;
}
</style>
<div id="left_container">
	<div id="activity_container"></div>
	<script language="javascript">
	javascript:loadContent('#activity_container','<?php echo $vars['url'] ?>/mod/enlightn/ajax/activity.php');
	</script>