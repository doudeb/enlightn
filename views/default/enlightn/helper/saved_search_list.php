    <ul id="saved-search-list">
    <?php
    $saved_search = $vars['list'];
    foreach ($saved_search as $search) {
        $params = $search->getMetadata(ENLIGHTN_FILTER_CRITERIA);
        $params = unserialize($params);
        $params = json_encode($params);
        echo "<li data-params='" . $params . "' data-name='" . $search->title . "' data-guid='" . $search->guid . "'><span class='saved-items'>" . $search->title . "</span><span class='close'>&times;</span></li>";
    }
    ?>
    </ul>
