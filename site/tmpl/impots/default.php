<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
                JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

    @version		1.0.8
    @build			15th December, 2025
    @created		4th March, 2025
    @package		JTax
    @subpackage		default.php
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
use Joomla\CMS\Router\Route;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\HTML\HTMLHelper as Html;
use JCB\Component\Jtax\Site\Helper\JtaxHelper;

// No direct access to this file
defined('_JEXEC') or die;

?>
<form action="<?php echo Route::_('index.php?option=com_jtax'); ?>" method="post" name="adminForm" id="adminForm">
<?php echo $this->toolbar->render(); ?>
<!--[JCBGUI.site_view.default.26.$$$$]-->
<?php $edit = "index.php?option=com_jtax&view=impots&task=impot.edit";?>

<?php
// Build a filtered list of items based on asset permissions.
// We check 'core.view' on the asset "com_jtax.impot.{id}".
// We also allow full component managers to see everything.
$filteredItems = [];
$componentManageAllowed = $this->user->authorise('core.manage', 'com_jtax');

if (!empty($this->items) && is_array($this->items)) {
    foreach ($this->items as $item) {
        $asset = 'com_jtax.impot.' . ($item->id ?? 0);
        if ( $componentManageAllowed || $this->user->authorise('core.edit', $asset)) {
            $filteredItems[] = $item;
        }
    }
}
?>

<table class="table table-striped">
<?php if (empty($filteredItems)): ?>
    <tr>
        <td colspan="2">
            <?php echo Text::_('COM_JTAX_NO_ITEMS_AVAILABLE'); ?>
        </td>
    </tr>
<?php else: ?>
    <?php foreach ($filteredItems as $i => $item): ?>
        <tr class="row<?php echo $i % 2; ?>">
            <td class="hidden-phone">
                <a href="<?php echo $edit; ?>&id=<?php echo $item->id; ?>"><?php echo $this->escape($item->name); ?></a>
            </td>
            <td class="hidden-phone">
                <?php echo $this->escape($item->year_name); ?>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>
</table>
<div style="display:none;">
<?php echo LayoutHelper::render('input', []); ?> <!--[/JCBGUI$$$$]-->


<?php if (isset($this->items) && isset($this->pagination) && isset($this->pagination->pagesTotal) && $this->pagination->pagesTotal > 1): ?>
    <div class="pagination">
        <?php if ($this->params->def('show_pagination_results', 1)) : ?>
            <p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> <?php echo $this->pagination->getLimitBox(); ?></p>
        <?php endif; ?>
        <?php echo $this->pagination->getPagesLinks(); ?>
    </div>
<?php endif; ?>
<input type="hidden" name="task" value="" />
<?php echo Html::_('form.token'); ?>
</form>
