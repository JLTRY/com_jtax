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
use JLTRY\Component\Jtax\Site\Helper\JtaxHelper;

// No direct access to this file
defined('_JEXEC') or die;

?>
<?php echo $this->toolbar->render(); ?>

<!--[JCBGUI.site_view.default.30.$$$$]-->
<?php 
switch  ($this->getLayout()) {
    case 'default':
        Html::_('bootstrap.tooltip');
        Html::_('behavior.core');
        Html::_('behavior.formvalidator');
        break;
    case 'json':
                  $app = Factory::getApplication();
                 $jinput = $app->getInput();
                  $this->id =  $jinput->getString('id', -1);
                  if ($this->id !== -1) {
                $model = new \JLTRY\Component\Jtax\Site\Model\PublicimpotModel;
                $this->setModel($model);
                $this->item = $model->getItem((int)$this->id);
                       ob_end_clean();
                        header('Content-Type: application/json');
                        header('Cache-Control: max-age=120, private, must-revalidate');
                        header('Content-Disposition: attachment; filename="jcoaching.json"');
                       ob_end_clean();
                       echo json_encode(["name" => $this->item->name, "year" => $this->item->year ]);
                        Factory::getApplication()->close();
                 }
               break;
     }

?>

<form  name="adminForm" id="adminForm" method="post"  class="form-validate">
<div class="main-card">
    <?php echo \Joomla\CMS\Layout\LayoutHelper::render('impot.details_left', $this); 
      ?>
    <input type="hidden" name="task" value="impot.edit" />
</div>
</form><!--[/JCBGUI$$$$]-->

