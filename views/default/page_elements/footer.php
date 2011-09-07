<?php
echo elgg_view('input/uploadForm');
$plugin_elements = load_plugin_manifest('enlightn');
?>
    <div id="footer">
        <?php echo elgg_view('expages/footer_menu');?>
        <div class="copyright"><?php echo $plugin_elements['copyright']?> - <?php echo $plugin_elements['version']?></div>
    </div>

</body>
</html>