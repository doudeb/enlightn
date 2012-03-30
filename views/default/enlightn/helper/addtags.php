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
$js_function =  <<<EOT
function (item) {
    if(item.id.indexOf('tag_') == -1) {
        return false;
    } else {

    }
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
                 , onAdd: <?php echo $js_function ?>
            }
        );
	});
</script>