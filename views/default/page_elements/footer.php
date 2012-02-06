<?php
if (elgg_is_logged_in()) {
    echo elgg_view('enlightn/discussion_edit');
    echo elgg_view('input/uploadForm');
    //echo elgg_view('input/media_autocomplete');
}
$en_plugin          = elgg_get_calling_plugin_entity();
?>
    <div class="dialog-overlay"></div>
    <div id="footer">
        <?php echo elgg_view('expages/footer_menu');?>
        <div class="copyright">Enlightn - <?php /*echo $en_plugin->getManifest()*/?></div>
    </div>
    <?php if(elgg_is_logged_in()) { ?>
     <div id="debug"></div>
    <?php } ?>
</body>
</html>
