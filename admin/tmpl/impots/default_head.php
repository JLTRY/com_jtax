<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
                JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

    @version		1.0.7
    @build			8th December, 2025
    @created		4th March, 2025
    @package		JTax
    @subpackage		default_head.php
    @author			Jean-Luc Tryoen <http://www.jltryoen.fr>	
    @copyright		Copyright (C) 2015. All Rights Reserved
    @license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;

// No direct access to this file
defined('_JEXEC') or die;

?>
<tr>
    <?php if (!$this->isModal && $this->canEdit && $this->canState): ?>
        <th width="1%" class="nowrap center hidden-phone">
            <?php echo Html::_('searchtools.sort', '', 'a.ordering', $this->listDirn, $this->listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
        </th>
        <th width="20" class="nowrap center">
            <?php echo Html::_('grid.checkall'); ?>
        </th>
    <?php else: ?>
        <th width="20" class="nowrap center hidden-phone">
            &#9662;
        </th>
        <th width="20" class="nowrap center">
            &#9632;
        </th>
    <?php endif; ?>
    <th class="nowrap" >
            <?php echo Text::_('COM_JTAX_IMPOT_NAME_LABEL'); ?>
    </th>
    <th class="nowrap hidden-phone" >
            <?php echo Text::_('COM_JTAX_IMPOT_YEAR_LABEL'); ?>
    </th>
    <th class="nowrap hidden-phone" >
            <?php echo Text::_('Revenu net imposable'); ?>
    </th>
    <th class="nowrap hidden-phone" >
            <?php echo Text::_('COM_JTAX_IMPOT_NBPARTS_LABEL'); ?>
    </th>
    <th class="nowrap hidden-phone" >
            <?php echo Text::_('COM_JTAX_IMPOT_DEDUCTION_LABEL'); ?>
    </th>
    <?php if ($this->canState): ?>
        <th width="10" class="nowrap center" >
            <?php echo Html::_('searchtools.sort', 'COM_JTAX_IMPOT_STATUS', 'a.published', $this->listDirn, $this->listOrder); ?>
        </th>
    <?php else: ?>
        <th width="10" class="nowrap center" >
            <?php echo Text::_('COM_JTAX_IMPOT_STATUS'); ?>
        </th>
    <?php endif; ?>
    <th width="5" class="nowrap center hidden-phone" >
            <?php echo Html::_('searchtools.sort', 'COM_JTAX_IMPOT_ID', 'a.id', $this->listDirn, $this->listOrder); ?>
    </th>
</tr>