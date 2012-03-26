    <ul id="saved-search-list">
    <?php
    $saved_search = $vars['list'];
    foreach ($saved_search as $search) {
        $params = $search->getMetadata(ENLIGHTN_FILTER_CRITERIA);
        $params = unserialize($params);
        $params = json_encode($params);
        echo "<li data-params='" . $params . "' data-name='" . $search->title . "' data-guid='" . $search->guid . "'><span class='saved-items'>" . $search->title . "<span class='ico " . ($search->access_id==0?'private':'public') . "-ico'></span></span>" . ($search->owner_guid==elgg_get_logged_in_user_guid()?'<span class="close">&times;</span>':'') . "</li>";
    }
    ?>
    </ul>
