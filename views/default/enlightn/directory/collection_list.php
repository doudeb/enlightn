                </div>
            </div>
        </div>
        <div id="sidebar" class="directory">
            <ol class="folders">
        <?php

        		if (is_array($vars['collections'])) {
					foreach ($vars['collections'] as $key=>$collection) {
						$count_member = count(get_members_of_access_collection($collection->id));
						echo '<li id="area' . $collection->id . '" class="dropable" data-listId="' . $collection->id . '" data-listName="' . $collection->name . '"><a class="cat" href="' . $vars['url'] . 'pg/enlightn/directory/' .$collection->id . '"><span class="count">' . $count_member . '</span>' . $collection->name . '<span class="ico ' . ('0'==$collection->owner_guid?'public':'private') . '-ico"></span></a></li>';
					}
        		}
        ?>

                <li id="area0" class="dropable addform"><a class="cat" href="#"><span class="count"></span>+ create a new list</a>
                    <div class="form"><label for="list_name">List name</label><input id="list_name" type="text"><span class="ico private-ico" title="privée/publique"></span></div>
                </li>
            </ol>
        </div>
    </div>
