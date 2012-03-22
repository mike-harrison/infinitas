<?php
	/* 
	 * Short Description / title.
	 * 
	 * Overview of what the file does. About a paragraph or two
	 * 
	 * Copyright (c) 2010 Carl Sutton ( dogmatic69 )
	 * 
	 * @filesource
	 * @copyright Copyright (c) 2010 Carl Sutton ( dogmatic69 )
	 * @link http://www.infinitas-cms.org
	 * @package {see_below}
	 * @subpackage {see_below}
	 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
	 * @since {check_current_milestone_in_lighthouse}
	 * 
	 * @author {your_name}
	 * 
	 * Licensed under The MIT License
	 * Redistributions of files must retain the above copyright notice.
	 */

	$parts = $this->Event->trigger('userProfile');
?>
<h3><?php echo $user['User']['username']; ?></h3>
<?php
	foreach($parts['userProfile'] as $plugin => $profile){
		echo sprintf('<div class="profile %s">%s</div>', $plugin, $this->element($profile['element'], array('plugin' => $plugin)));
	}
?>
