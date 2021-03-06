<?php
/**
 * @copyright 2012-2016 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 * @param array $this->actions
 */
use Application\Models\Person;
?>
<section>
    <header>
        <h1><?= $this->_(['action', 'actions', count($this->actions)]); ?></h1>
        <div class="tools">
        <?php
			if (Person::isAllowed('actions', 'add')) {
				$helper = $this->template->getHelper('buttonLink');
				echo $helper->buttonLink(
					BASE_URI.'/actions/update',
					$this->_('add'),
					'add'
				);
			}
		?>
		</div>
    </header>
	<table>
		<thead>
			<tr><th><?= $this->_('action'); ?></th>
				<th><?= $this->_('description'); ?></th>
				<th><?= $this->_('type'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php

			foreach ($this->actions as $action) {
                $uri         = BASE_URI.'/actions/view?action_id='.$action->getId();
				$name        = self::escape($action->getName());
				$description = self::escape($action->getDescription());
				$type        = self::escape($action->getType());
				echo "
				<tr><td><a href=\"$uri\">$name</a></td>
					<td>$description</td>
					<td>$type</td>
				</tr>
				";
			}
		?>
		</tbody>
	</table>
</section>
