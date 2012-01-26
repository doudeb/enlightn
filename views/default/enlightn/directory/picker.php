<?php
/**
 * Elgg friends picker
 * Lists the friends picker
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['entities'] The array of ElggUser objects
 */

// Let the system know that the friends picker is in use
global $pickerinuse, $enlightn;
$pickerinuse = true;
$chararray = '*';
$chararray .= elgg_echo('friendspicker:chararray');

// Initialise internalname
if (!isset($vars['internalname'])) {
	$internalname = "friend";
} else {
	$internalname = $vars['internalname'];
}

// Are we highlighting default or all?
if (empty($vars['highlight'])) $vars['highlight'] = 'default';
if ($vars['highlight'] != 'all') $vars['highlight'] = 'default';

// Initialise values
if (!isset($vars['value'])) {
	$vars['value'] = array();
} else {
	if (!is_array($vars['value'])) {
		$vars['value'] = (int) $vars['value'];
		$vars['value'] = array($vars['value']);
	}
}

// Initialise whether we're calling back or not
if (isset($vars['callback'])) {
	$callback = $vars['callback'];
} else {
	$callback = false;
}

// We need to count the number of friends pickers on the page.
if (!isset($vars['friendspicker'])) {
	global $friendspicker;
	if (!isset($friendspicker)) $friendspicker = 0;
	$friendspicker++;
} else {
	$friendspicker = $vars['friendspicker'];
}

$users = array();
$activeletters = array();

// Are we displaying form tags and submit buttons?
// (If we've been given a target, then yes! Otherwise, no.)
if (isset($vars['formtarget'])) {
	$formtarget = $vars['formtarget'];
} else {
	$formtarget = false;
}
$users['*'] = $vars['entities'];
// Sort users by letter
if (is_array($vars['entities']) && sizeof($vars['entities'])) {
	foreach($vars['entities'] as $user) {
		if (is_callable('mb_substr')) {
			$letter = strtoupper(mb_substr($user->name,0,1));
		} else {
			$letter = strtoupper(substr($user->name,0,1));
		}

		if (!substr_count($chararray,$letter)) {
			$letter = "*";
		}
		if (!isset($users[$letter])) {
			$users[$letter] = array();
		}
		$users[$letter][$user->guid] = $user;
	}
}
// sort users in letters alphabetically
foreach ($users as $letter => $letter_users) {
	usort($letter_users, create_function('$a, $b', '
		return strcasecmp($a->name, $b->name);
	'));
	$users[$letter] = $letter_users;
}

$my_collection_members = array();
if (is_array($vars['collections'])) {
	foreach ($vars['collections'] as $collection) {
		$members = array();
		foreach (get_members_of_access_collection($collection->id) as $user) {
			$members[] = $user->guid;
		}
		$my_collection_members[$collection->id] = $members;
	}
}


if (!$callback) {
	?>

	<div class="friends-picker">

	<?php

	if (isset($vars['content'])) {
		echo $vars['content'];
	}
	?>

	<div id="friends_picker_placeholder<?php echo $friendspicker; ?>">

	<?php
}

if (!isset($vars['replacement'])) {
	if ($formtarget) {
?>

<script language="text/javascript">
		$(function() { // onload...do
		$('#collectionMembersForm<?php echo $friendspicker; ?>').submit(function() {
			var inputs = [];
			$(':input', this).each(function() {
				if (this.type != 'checkbox' || (this.type == 'checkbox' && this.checked != false)) {
					inputs.push(this.name + '=' + escape(this.value));
				}
			});
			jQuery.ajax({
				type: "POST",
				data: inputs.join('&'),
				url: this.action,
				success: function(){
					$('a.collectionmembers<?php echo $friendspicker; ?>').click();
				}

			});
			return false;
		})
	})
	</script>

<!-- Collection members form -->
<form id="collectionMembersForm<?php echo $friendspicker; ?>" action="<?php echo $formtarget; ?>" method="post"> <!-- action="" method=""> -->

<?php
	}
?>

<div class="friends-picker-wrapper">

<div id="friends-picker<?php echo $friendspicker; ?>">
	<div class="friends-picker-container">
<?php

// Initialise letters

	if (is_callable('mb_substr')) {
		$letter = mb_substr($chararray,0,1);
	} else {
		$letter = substr($chararray,0,1);
	}
	$letpos = 0;
	while (1 == 1) {
		?>
		<div class="panel" title="<?php	echo elgg_echo($letter); ?>">
			<div class="wrapper">
				<h3><?php echo elgg_echo($letter); ?></h3>
		<?php

		if (isset($users[$letter])) {
			ksort($users[$letter]);

			echo "<ol>";
			foreach($users[$letter] as $friend) {
                $user_settings          = get_profile_settings($friend->getGUID());
 				echo '<li id="user' . $friend->getGUID() . '" class="user" data-userId="' . $friend->getGUID() . '">
                             <a href="' . $vars['url'] . 'pg/profile/' . $friend->username .'">
                                 <span class="follow send-msg">' . elgg_echo('enlightn:seehisprofil') . '</span>
                            </a>
                            ' . elgg_view('input/user_photo',array('user_ent'=>$friend, 'class'=>'photo')) . '
                            <a href="' . $vars['url'] . 'pg/profile/' . $friend->username .'">' . $friend->name . '</a>
                            <p>' . $user_settings['jobtitle'] .'</p>
                            ';
				$member_collection = array();
				if (is_array($my_collection_members)) {
					foreach ($my_collection_members as $collection_id=>$collection_members) {
						if (in_array($friend->getGUID(),$collection_members)) {
							$collection = get_access_collection($collection_id);
							echo '<span class="tag mlList tag' . $collection->id .'" data-tagId="' . $collection->id .'">' . $collection->name . ' <span class="del">&times;</span></span>';
						}
					}
				}
                $user_active_tags = $enlightn->get_tags($friend->getGUID());
				if (is_array($user_active_tags)) {
                    echo "<p>";
					foreach ($user_active_tags as $key=>$tag) {
						echo '<span class="tag" data-keyword="' . $tag->tag .'">' . $tag->tag . '</span>';
					}
                    echo "</p>";

				}
                echo '</li>';
				if ($vars['highlight'] == 'all'
					&& !in_array($letter,$activeletters)) {

					$activeletters[] = $letter;
				}
			}
			echo "</ol>";
		}
?>
			</div>
		</div>
<?php
			//if ($letter == 'Z') break;

			if (is_callable('mb_substr')) {
				$substr = mb_substr($chararray,strlen($chararray) - 1,1);
			} else {
				$substr = substr($chararray,strlen($chararray) - 1,1);
			}
			if ($letter == $substr) {
				break;
			}
			//$letter++;
			$letpos++;
			if (is_callable('mb_substr')) {
				$letter = mb_substr($chararray,$letpos,1);
			} else {
				$letter = substr($chararray,$letpos,1);
			}
		}

?>
	</div>

<?php

if ($formtarget) {

	echo elgg_view('input/securitytoken');

	if (isset($vars['formcontents']))
		echo $vars['formcontents'];

?>
	<div class="clearfloat"></div>
	<div class="friendspicker_savebuttons">
		<input type="submit" class="submit_button" value="<?php echo elgg_echo('save'); ?>" />
		<input type="button" class="cancel_button" value="<?php echo elgg_echo('cancel'); ?>" onclick="$('a.collectionmembers<?php echo $friendspicker; ?>').click();" />
	<br /></div>
	</form>

<?php

}

?>

</div>
</div>

<?php
} else {
	echo $vars['replacement'];
}
if (!$callback) {

?>

</div>
</div>


<?php

}

if (!isset($vars['replacement'])) {
?>

<script type="text/javascript">
	// initialise picker
	$("div#friends-picker<?php echo $friendspicker; ?>").friendsPicker(<?php echo $friendspicker; ?>);
</script>
<script>
$(document).ready(function () {
// manually add class to corresponding tab for panels that have content
<?php
if (sizeof($activeletters) > 0)
	//$chararray = elgg_echo('friendspicker:chararray');
	foreach($activeletters as $letter) {
		$tab = strpos($chararray, $letter) + 1;
?>
$("div#friends-picker-navigation<?php echo $friendspicker; ?> li.tab<?php echo $tab; ?> a").addClass("tabHasContent");
<?php
	}

?>
});
</script>

<?php

}