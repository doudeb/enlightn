<?php
$collection_id = $vars['collection_id'];
?>
                </div>
            </div>
        </div>
        <div id="sidebar" class="directory">
            <ol class="folders">
                <li class="<?php echo !$collection_id?' current':''?>"><span class="arrow"></span><a class="cat" href="<?php echo $vars['url']?>pg/enlightn/directory"><?php echo elgg_echo("enlightn:taball"); ?></a></li>
                <li id="area0" class="dropable addform"><a class="cat" href="#"><span class="count"></span><?php echo elgg_echo("enlightn:createanewlist"); ?></a>
                    <div class="form"><label for="list_name"><?php echo elgg_echo("enlightn:listname"); ?></label><input id="list_name" type="text"><span class="ico private-ico" title="<?php echo elgg_echo("enlightn:privatepublic"); ?>"></span></div>
                </li>
        <?php

        		if (is_array($vars['collections'])) {
					foreach ($vars['collections'] as $key=>$collection) {
						$count_member = count(get_members_of_access_collection($collection->id));
						echo '<li id="area' . $collection->id . '" class="dropable' . (!empty($collection_id) && $collection_id==$collection->id?' current':'') . '" data-listId="' . $collection->id . '" data-listName="' . $collection->name . '"><span class="arrow"></span><a class="cat" href="' . $vars['url'] . 'pg/enlightn/directory/' .$collection->id . '"><span class="count">' . $count_member . '</span>' . $collection->name . '<span class="ico ' . ('0'==$collection->owner_guid?'public':'private') . '-ico"></span></a></li>';
					}
        		}
        ?>
            </ol>
        </div>
    </div>
