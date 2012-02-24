<div class="box_wrapper">
<?php echo elgg_echo('enlightn:followers');
$members = get_discussion_members($vars['entity']->guid,12);
foreach($members as $mem) {
    echo "<div class=\"member_icon\"><a href=\"".$mem->getURL()."\">" . elgg_view("profile/icon",array('entity' => $mem, 'size' => 'tiny', 'override' => 'true')) . "</a>" . $mem->name ."</div>";

}
echo "<div class=\"clearfloat\"></div>";
?>
</div>