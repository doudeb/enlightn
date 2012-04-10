<?php
if (!isset($vars['unique_id'])) {
    $unique_id = md5($vars['name'] . time());
} else {
    $unique_id = $vars['unique_id'];
}

if (isset($vars['container']) && isset($vars['values'])) {
    $container = $vars['container'];
    $value = $vars['values'];
    $js_function =  <<<EOT
function (item) {
                    $('#$container').append('<span class="tag" data-keyword="' + item.name + '">' + item.name + ' <span class="del">&times;</span></span>').fadeIn(1000);
                    if ($('#$value').val().length == 0) {
                        $('#$value').val(item.name);
                    } else {
                       $('#$value').val($('#$value').val() + ',' + item.name);
                    }
                    this.tokenInput("clear");
}
EOT;
} else if ('q' === $vars['name']) {
    $context        = elgg_get_context();
    $page           = strstr($context, 'cloud')?'get_my_cloud':'search';
    $container      = strstr($context, 'cloud')?'cloud_content':'discussion_list_container';
    $search_memo    = elgg_echo('enlightn:searchmemo');

    $js_function =  <<<EOT
function (item) {
    $(".search-memo").html('<span class="star ico"></span>$search_memo');
    $(".search-memo").parent().removeClass('starred');
    $(".search-memo").css('display','block');
    console.log(item);
    $("#see_more_discussion_list_offset").val(0);
    loadContent("#$container",'{$vars['url']}mod/enlightn/ajax/$page.php' + get_search_criteria() + '&context=$context');
    return true;
}
EOT;

} else {
    $js_function = "function (item) {return true}";
}

?>

<input type="text" id="<?php echo $unique_id; ?>" name="<?php echo $vars['name']; ?>" placeholder="<?php echo $vars['placeholder']; ?>"/>
<script type="text/javascript">
	$(document).ready(function() {
		$("#<?php echo $unique_id; ?>").tokenInput("<?php echo $vars['url']; ?>mod/enlightn/ajax/tags.php"
            ,{
                 hintText : " "
                 , searchingText : " "
                 , preventDuplicates: true
                 , theme: 'facebook'
                 , placeholder: '<?php echo $vars['placeholder']; ?>'
                 , resultsFormatter: function(item) {
                     return "<li><span class='" + item.class + "'>" + item.name + "</span><span class='complete-count'>" +  item.count + "</span></li>";
                 }
                 , tokenFormatter: function(item) {
                     return "<li class='" + item.class + "'><span class='" + item.class + "'>" + item.name + "</span></li>";
                 }
                 , onAdd: <?php echo $js_function ?>
            }
        );
	});
</script>