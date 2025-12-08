<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.7
	@build			8th December, 2025
	@created		4th March, 2025
	@package		JTax
	@subpackage		default_body.php
	@author			Jean-Luc Tryoen <http://www.jltryoen.fr>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use JCB\Component\Jtax\Administrator\Helper\JtaxHelper;
use JCB\Joomla\Jtax\Utilities\Permitted\Actions;
use Joomla\CMS\User\UserFactoryInterface;

// No direct access to this file
defined('_JEXEC') or die;

$edit = "index.php?option=com_jtax&view=impots&task=impot.edit";

?>
<?php foreach ($this->items as $i => $item): ?>
    <?php
        $canCheckin = $this->user->authorise('core.manage', 'com_checkin') || $item->checked_out == $this->user->id || $item->checked_out == 0;
        $userChkOut = Factory::getContainer()->
            get(UserFactoryInterface::class)->
                loadUserById((int) ($item->checked_out ?? 0));
        $canDo = Actions::get('impot', $item, 'impots');
    ?>
    <tr class="row<?php echo $i % 2; ?>">
        <td class="order nowrap center hidden-phone">
        <?php if (!$this->isModal && $canDo->get('core.edit.state')): ?>
            <?php
                $iconClass = '';
                if (!$this->saveOrder)
                {
                    $iconClass = ' inactive tip-top" hasTooltip" title="' . Html::tooltipText('JORDERINGDISABLED');
                }
            ?>
            <span class="sortable-handler<?php echo $iconClass; ?>">
                <i class="icon-menu"></i>
            </span>
            <?php if ($this->saveOrder) : ?>
                <input type="text" style="display:none" name="order[]" size="5"
                value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
            <?php endif; ?>
        <?php else: ?>
            &#8942;
        <?php endif; ?>
        </td>
        <td class="nowrap center">
        <?php if (!$this->isModal && $canDo->get('core.edit')): ?>
                <?php if ($item->checked_out) : ?>
                    <?php if ($canCheckin) : ?>
                        <?php echo Html::_('grid.id', $i, $item->id); ?>
                    <?php else: ?>
                        &#9633;
                    <?php endif; ?>
                <?php else: ?>
                    <?php echo Html::_('grid.id', $i, $item->id); ?>
                <?php endif; ?>
        <?php else: ?>
            &#9633;
        <?php endif; ?>
        </td>
        <td class="nowrap">
            <div class="name">
                <?php if (!$this->isModal && $canDo->get('core.edit')): ?>
                    <a href="<?php echo $edit; ?>&id=<?php echo $item->id; ?>"><?php echo $this->escape($item->name); ?></a>
                    <?php if ($item->checked_out): ?>
                        <?php echo Html::_('jgrid.checkedout', $i, $userChkOut->name, $item->checked_out_time, 'impots.', $canCheckin); ?>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if (!$this->isModal): ?>
                        <?php echo $this->escape($item->name); ?>
                    <?php else: ?>
                        <?php
                            $link = "{$edit}&id={$item->id}";
                            $dataId = $item->{$this->getModalTitleKey()} ?? 0;
                            $itemHtml = '<a href="' . $this->escape($link, false) . '">' . $this->escape($item->name, false) . '</a>';
                            $attribs = 'data-content-select data-content-type="com_jtax.impot"'
                                . ' data-id="' . $dataId . '"'
                                . ' data-title="' . $this->escape($item->name, false) . '"'
                                . ' data-uri="' . $this->escape($link, false) . '"'
                                . ' data-html="' . $this->escape($itemHtml, false) . '"';
                        ?>
                        <a class="select-link" href="javascript:void(0)" <?php echo $attribs; ?>>
                            <?php echo $this->escape($item->name); ?>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </td>
        <td class="hidden-phone">
            <?php echo $this->escape($item->year); ?>
        </td>
        <td class="hidden-phone">
            <?php echo $this->escape($item->revenu); ?>
        </td>
        <td class="hidden-phone">
            <?php echo $this->escape($item->nbparts); ?>
        </td>
        <td class="hidden-phone">
            <?php echo Text::_($item->deduction); ?>
        </td>
        <td class="center">
        <?php if (!$this->isModal && $canDo->get('core.edit.state')) : ?>
                <?php if ($item->checked_out) : ?>
                    <?php if ($canCheckin) : ?>
                        <?php echo Html::_('jgrid.published', $item->published, $i, 'impots.', true, 'cb'); ?>
                    <?php else: ?>
                        <?php echo Html::_('jgrid.published', $item->published, $i, 'impots.', false, 'cb'); ?>
                    <?php endif; ?>
                <?php else: ?>
                    <?php echo Html::_('jgrid.published', $item->published, $i, 'impots.', true, 'cb'); ?>
                <?php endif; ?>
        <?php else: ?>
            <?php echo Html::_('jgrid.published', $item->published, $i, 'impots.', false, 'cb'); ?>
        <?php endif; ?>
        </td>
        <td class="nowrap center hidden-phone">
            <?php echo $item->id; ?>
        </td>
    </tr>
<?php endforeach; ?>