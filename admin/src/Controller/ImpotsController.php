<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.5
	@build			2nd April, 2025
	@created		4th March, 2025
	@package		JTax
	@subpackage		ImpotsController.php
	@author			Jean-Luc Tryoen <http://www.jltryoen.fr>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/
namespace JCB\Component\Jtax\Administrator\Controller;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use JCB\Component\Jtax\Administrator\Helper\JtaxHelper;
use JCB\Joomla\Utilities\ArrayHelper as UtilitiesArrayHelper;
use JCB\Joomla\Utilities\ObjectHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Impots Admin Controller
 *
 * @since  1.6
 */
class ImpotsController extends AdminController
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_JTAX_IMPOTS';

	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  \Joomla\CMS\MVC\Model\BaseDatabaseModel
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'Impot', $prefix = 'Administrator', $config = ['ignore_request' => true])
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function exportData()
	{
		// Check for request forgeries
		Session::checkToken() or die(Text::_('JINVALID_TOKEN'));
		// check if export is allowed for this user.
		$user = Factory::getApplication()->getIdentity();
		if ($user->authorise('impot.export', 'com_jtax') && $user->authorise('core.export', 'com_jtax'))
		{
			// Get the input
			$input = Factory::getApplication()->input;
			$pks = $input->post->get('cid', array(), 'array');
			// Sanitize the input
			$pks = ArrayHelper::toInteger($pks);
			// Get the model
			$model = $this->getModel('Impots');
			// get the data to export
			$data = $model->getExportData($pks);
			if (UtilitiesArrayHelper::check($data))
			{
				// now set the data to the spreadsheet
				$date = Factory::getDate();
				JtaxHelper::xls($data,'Impots_'.$date->format('jS_F_Y'),'Impots exported ('.$date->format('jS F, Y').')','impots');
			}
		}
		// Redirect to the list screen with error.
		$message = Text::_('COM_JTAX_EXPORT_FAILED');
		$this->setRedirect(Route::_('index.php?option=com_jtax&view=impots', false), $message, 'error');
		return;
	}


	public function importData()
	{
		// Check for request forgeries
		Session::checkToken() or die(Text::_('JINVALID_TOKEN'));
		// check if import is allowed for this user.
		$user = Factory::getApplication()->getIdentity();
		if ($user->authorise('impot.import', 'com_jtax') && $user->authorise('core.import', 'com_jtax'))
		{
			// Get the import model
			$model = $this->getModel('Impots');
			// get the headers to import
			$headers = $model->getExImPortHeaders();
			if (ObjectHelper::check($headers))
			{
				// Load headers to session.
				$session = Factory::getSession();
				$headers = json_encode($headers);
				$session->set('impot_VDM_IMPORTHEADERS', $headers);
				$session->set('backto_VDM_IMPORT', 'impots');
				$session->set('dataType_VDM_IMPORTINTO', 'impot');
				// Redirect to import view.
				$message = Text::_('COM_JTAX_IMPORT_SELECT_FILE_FOR_IMPOTS');
				$this->setRedirect(Route::_('index.php?option=com_jtax&view=import', false), $message);
				return;
			}
		}
		// Redirect to the list screen with error.
		$message = Text::_('COM_JTAX_IMPORT_FAILED');
		$this->setRedirect(Route::_('index.php?option=com_jtax&view=impots', false), $message, 'error');
		return;
	}
}