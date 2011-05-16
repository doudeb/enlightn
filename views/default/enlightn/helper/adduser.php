<select id="<?php echo $vars['internalname']; ?>" name="<?php echo $vars['internalname']; ?>"></select>
<script type="text/javascript">
    $(document).ready(function(){                
        $("#<?php echo $vars['internalname']; ?>").fcbkcomplete({
            json_url: "<?php echo $vars['url']; ?>mod/enlightn/ajax/members.php",
            addontab: true,                   
            height: 5                  
        });
    });
</script>