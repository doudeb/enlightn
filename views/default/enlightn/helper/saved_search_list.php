<?php if ($vars['show_invite']) {?>
<p class="inviteHeadLine"><?php echo elgg_echo('enlightn:folderinvitelist');?></p>
<ul id="invited-list"></ul>
<?php } ?>
<ul id="<?php echo $vars['elm'];?>"></ul>
<script>
$(document).ready(function(){
<?php if ($vars['show_invite']) {?>
    loadTagTree("#invited-list",'invited',false,false);
<?php } ?>
    loadTagTree("#<?php echo $vars['elm'];?>",'followed',false,<?php echo $vars['navcallback'];?>);
});
</script>