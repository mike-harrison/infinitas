<?php
	/**
	 * Comment Template.
	 *
	 * @todo -c Implement .this needs to be sorted out.
	 *
	 * Copyright (c) 2009 Carl Sutton ( dogmatic69 )
	 *
	 * Licensed under The MIT License
	 * Redistributions of files must retain the above copyright notice.
	 *
	 * @filesource
	 * @copyright	 Copyright (c) 2009 Carl Sutton ( dogmatic69 )
	 * @link		  http://infinitas-cms.org
	 * @package	   sort
	 * @subpackage	sort.comments
	 * @license	   http://www.opensource.org/licenses/mit-license.php The MIT License
	 * @since		 0.5a
	 */

	echo $this->Form->create('Trash', array('url' => array('controller' => 'trash', 'action' => 'mass')));

		$massActions = $this->Infinitas->massActionButtons(array('restore', 'delete'));
		echo $this->Infinitas->adminIndexHead($filterOptions, $massActions);
?>
<div class="table">
	<table class="listing" cellpadding="0" cellspacing="0">
		<?php
			echo $this->Infinitas->adminTableHeader(
				array(
					$this->Form->checkbox('all') => array(
						'class' => 'first',
						'style' => 'width:25px;'
					),
					$this->Paginator->sort('name'),
					$this->Paginator->sort('model', __d('trash', 'Type')) => array(
						'style' => 'width:100px;'
					),
					$this->Paginator->sort('deleted') => array(
						'style' => 'width:100px;'
					),
					$this->Paginator->sort('Deleter.name', __d('trash', 'Deleted By')) => array(
						'style' => 'width:100px;'
					)
				)
			);

			foreach ($trashed as $trash) {
				?>
					<tr class="<?php echo $this->Infinitas->rowClass(); ?>">
						<td><?php echo $this->Infinitas->massActionCheckBox($trash); ?>&nbsp;</td>
						<td>
							<?php echo Inflector::humanize($trash['Trash']['name']); ?>&nbsp;
						</td>
						<td>
							<?php $type = pluginSplit($trash['Trash']['model']); echo $type[0] . (isset($type[1]) ? ' ' . prettyName($type[1]) : ''); ?>&nbsp;
						</td>
						<td>
							<?php echo $this->Time->timeAgoInWords($trash['Trash']['deleted']); ?>&nbsp;
						</td>
						<td>
							<?php echo $trash['User']['username']; ?>&nbsp;
						</td>
					</tr>
				<?php
			}
		?>
	</table>
	<?php echo $this->Form->end(); ?>
</div>
<?php echo $this->element('pagination/admin/navigation'); ?>