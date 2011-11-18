<?php
if (isloggedin()) {
    echo elgg_view('enlightn/discussion_edit');
    echo elgg_view('input/uploadForm');
    //echo elgg_view('input/media_autocomplete');
}
$plugin_elements = load_plugin_manifest('enlightn');
?>
    <div class="dialog-overlay"></div>
    <div id="footer">
        <?php echo elgg_view('expages/footer_menu');?>
        <div class="copyright"><?php echo $plugin_elements['copyright']?> - <?php echo $plugin_elements['version']?></div>
    </div>
    <?php if(isadminloggedin()) { ?>
     <div id="debug"></div>
    <?php } ?>
</body>
</html>