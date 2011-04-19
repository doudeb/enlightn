<link rel="stylesheet" href="<?php echo $vars['url']; ?>mod/enlightn/media/css/style.css" type="text/css" media="screen" charset="utf-8" />
<script src="<?php echo $vars['url']; ?>mod/enlightn/media/js/jquery.fcbkcomplete.js" type="text/javascript" charset="utf-8"></script>
<select id="<?php echo $vars['internalname']; ?>" name="<?php echo $vars['internalname']; ?>"></select>
<script type="text/javascript">
    $(document).ready(function(){                
        $("#<?php echo $vars['internalname']; ?>").fcbkcomplete({
            json_url: "<?php echo $vars['url']; ?>mod/enlightn/ajax/members.php",
            addontab: true,                   
            height: 2                    
        });
    });
</script>