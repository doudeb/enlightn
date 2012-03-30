<script>
$(".embeder").click(function(){
        content = $('#embeder_content' + $(this).attr('id')).val();
        window.parent.updateRte(content);
        window.parent.$.facebox.close();
        return false;
});
$(".embederToNew").click(function(){
        content = $('#embeder_content' + $(this).attr('id')).val();
        if (content) {
            showNewDiscussionBox();
            window.parent.updateRte(content);
        }
        return false;
});
$('.expand').click( function() {
    $(this).parent().find('.tag').toggle();
});
</script>
<?php
	$context    = elgg_get_context();
	$entities   = $vars['entities'];
	if (is_array($entities) && !empty($entities)) {

		foreach($entities as $entity) {
			if ($entity instanceof ElggEntity) {
				$mime = $entity->mimetype;
				$enttype = $entity->getType();
				$entsubtype = $entity->getSubtype();

				$content = elgg_view('enlightn/new_link', array('type' => $entity->simpletype, 'link' => $entity->filename . '?fetched=1', 'guid' => $entity->guid, 'title'=>$entity->title));
				$content = str_replace("\n","", $content);
				$content = str_replace("\r","", $content);
				//$content = htmlentities($content,null,'utf-8');
				$content = htmlentities($content, ENT_COMPAT, "UTF-8");

				if ($entity instanceof ElggObject) { $title = $entity->title; $mime = $entity->mimetype; } else { $title = $entity->name; $mime = ''; }
				$entview = elgg_view("enlightn/cloud/embedlist",array('entity' => $entity, 'embeder_content'=>$content));
				echo $entview;

			}
		}
	}

?>