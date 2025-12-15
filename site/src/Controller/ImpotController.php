<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
                JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

    @version		1.0.8
    @build			15th December, 2025
    @created		4th March, 2025
    @package		JTax
    @subpackage		ImpotController.php
    @author			Jean-Luc Tryoen <http://www.jltryoen.fr>	
    @copyright		Copyright (C) 2015. All Rights Reserved
    @license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/
namespace JCB\Component\Jtax\Site\Controller;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Versioning\VersionableControllerTrait;
use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;
use JCB\Component\Jtax\Administrator\Helper\JtaxHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Impot Form Controller
 *
 * @since  1.6
 */
class ImpotController extends FormController
{
    use VersionableControllerTrait;

    /**
     * The prefix to use with controller messages.
     *
     * @var    string
     * @since  1.6
     */
    protected $text_prefix = 'COM_JTAX_IMPOT';

    /**
     * Current or most recently performed task.
     *
     * @var    string
     * @since  12.2
     * @note   Replaces _task.
     */
    protected $task;

    /**
     * The context for storing internal data, e.g. record.
     *
     * @var    string
     * @since  1.6
     */
    protected $context = 'impot';

    /**
     * The URL view item variable.
     *
     * @var    string
     * @since  1.6
     */
    protected $view_item = 'impot';

    /**
     * The URL view list variable.
     *
     * @var    string
     * @since  1.6
     */
    protected $view_list = 'impots';

    /**
     * Referral value
     *
     * @var    string
     * @since  5.0
     */
    protected string $ref;

    /**
     * Referral ID value
     *
     * @var    int
     * @since  5.0
     */
    protected int $refid;


/***[JCBGUI.admin_view.php_controller.288.$$$$]***/
function calculate()
{
    $application = Factory::getApplication();
    $jinput = $application->input;
    $data = $jinput->get('jform', array(), 'array'); 
    $id =  (int)$data["year"];
    $yearModel = \JCB\Component\Jtax\Administrator\Helper\JtaxHelper::GetModel('Years');
    //workarround to set filter
    $jinput->set('filter', ['search' => "id:" . $id]);
    $items = $yearModel->getItems();
    if (count($items) == 1) {
        $item = (array)$items[0];
        $item["taux0"] = 0;
        $revenu = (int)$data["revenu"];
        $nbparts = (int)$data["nbparts"];
        $deduction = (int)$data["deduction"];
        $fraisreels = (int)$data["fraisreels"];
        $dons = (int)$data["dons"];
        $pel =(int)$data["pel"];
        if ($deduction ==1 ) {
            $revenu = (90 * $revenu) / 100;
              } else {
            $revenu = $revenu - $fraisreels;
             }
        $revenu -= $pel;
        $impot = 0;
        $deduction = 0;
        for ($i = 0;$i < 5; $i++)
        {
            if (($revenu / $nbparts) > $item["tranche".$i]) {
                $notranche = $i;
            }
        }
        $taux = $item["taux".$notranche];
        for ($i = 1; $i <= $notranche;  $i++)
        {
            $deduction = $deduction + ($item["tranche".$i] * ($item["taux".$i]- $item["taux". ($i-1)]));
        }
        $impot = ($revenu * $taux) - ($nbparts *  $deduction);
        $impotfinal = $impot - $dons;
        printf("revenu net\t\t=%d * %0.2f (tranche %d)\nimpots brut\t\t=%d\ndeduction\t\t -%d \nimpot\t\t\t=%d\nimpot après dons\t=%d\ntaux d'imposition\t=%2.2f%%",
                    $revenu,
                    $taux,
                    $notranche,
                    $revenu * $taux,
                    $deduction * $nbparts,
                    $impot,
                    $impotfinal,
                    (100*$impot)/max(1,$data["revenu"]));
            Factory::getApplication()->close();
    }
}/***[/JCBGUI$$$$]***/


    /**
     * Method override to check if you can add a new record.
     *
     * @param   array  $data  An array of input data.
     *
     * @return  boolean
     *
     * @since   1.6
     */
    protected function allowAdd($data = [])
    {
        // Get user object.
        $user = $this->app->getIdentity();
        // Access check.
        $access = $user->authorise('impot.access', 'com_jtax');
        if (!$access)
        {
            return false;
        }

        // In the absence of better information, revert to the component permissions.
        return parent::allowAdd($data);
    }

    /**
     * Method override to check if you can edit an existing record.
     *
     * @param   array   $data  An array of input data.
     * @param   string  $key   The name of the key for the primary key.
     *
     * @return  boolean
     *
     * @since   1.6
     */
    protected function allowEdit($data = [], $key = 'id')
    {
        // get user object.
        $user = $this->app->getIdentity();
        // get record id.
        $recordId = (int) isset($data[$key]) ? $data[$key] : 0;


        if ($recordId)
        {
            // The record has been set. Check the record permissions.
            $permission = $user->authorise('core.edit', 'com_jtax.impot.' . (int) $recordId);
            if (!$permission)
            {
                if ($user->authorise('core.edit.own', 'com_jtax.impot.' . $recordId))
                {
                    // Now test the owner is the user.
                    $ownerId = (int) isset($data['created_by']) ? $data['created_by'] : 0;
                    if (empty($ownerId))
                    {
                        // Need to do a lookup from the model.
                        $record = $this->getModel()->getItem($recordId);

                        if (empty($record))
                        {
                            return false;
                        }
                        $ownerId = $record->created_by;
                    }

                    // If the owner matches 'me' then allow.
                    if ($ownerId == $user->id)
                    {
                        if ($user->authorise('core.edit.own', 'com_jtax'))
                        {
                            return true;
                        }
                    }
                }
                return false;
            }
        }
        // Since there is no permission, revert to the component permissions.
        return parent::allowEdit($data, $key);
    }

    /**
     * Gets the URL arguments to append to an item redirect.
     *
     * @param   integer  $recordId  The primary key id for the item.
     * @param   string   $urlVar    The name of the URL variable for the id.
     *
     * @return  string  The arguments to append to the redirect URL.
     *
     * @since   1.6
     */
    protected function getRedirectToItemAppend($recordId = null, $urlVar = 'id')
    {
        // get int-defaults (to int new items with default values dynamically)
        $init_defaults = $this->input->get('init_defaults', null, 'STRING');

        // get the referral options (old method use init_defaults or return instead see parent)
        $ref = $this->input->get('ref', 0, 'string');
        $refid = $this->input->get('refid', 0, 'int');

        // get redirect info.
        $append = parent::getRedirectToItemAppend($recordId, $urlVar);

        // set int-defaults
        if (!empty($init_defaults))
        {
            $append = '&init_defaults='. (string) $init_defaults . $append;
        }

        // set the referral options
        if ($refid && $ref)
        {
            $append = '&ref=' . (string) $ref . '&refid='. (int) $refid . $append;
        }
        elseif ($ref)
        {
            $append = '&ref='. (string) $ref . $append;
        }

        return $append;
    }

    /**
     * Method to cancel an edit.
     *
     * @param   string  $key  The name of the primary key of the URL variable.
     *
     * @return  boolean  True if access level checks pass, false otherwise.
     *
     * @since   12.2
     */
    public function cancel($key = null)
    {
        // get the referral options
        $this->ref = $this->input->get('ref', 0, 'word');
        $this->refid = $this->input->get('refid', 0, 'int');

        // Check if there is a return value
        $return = $this->input->get('return', null, 'base64');

        $cancel = parent::cancel($key);

        if (!is_null($return) && Uri::isInternal(base64_decode($return)))
        {
            $redirect = base64_decode($return);

            // Redirect to the return value.
            $this->setRedirect(
                Route::_(
                    $redirect, false
                )
            );
        }
        elseif ($this->refid && $this->ref)
        {
            $redirect = '&view=' . (string) $this->ref . '&layout=edit&id=' . (int) $this->refid;

            // Redirect to the item screen.
            $this->setRedirect(
                Route::_(
                    'index.php?option=' . $this->option . $redirect, false
                )
            );
        }
        elseif ($this->ref)
        {
            $redirect = '&view=' . (string) $this->ref;

            // Redirect to the list screen.
            $this->setRedirect(
                Route::_(
                    'index.php?option=' . $this->option . $redirect, false
                )
            );
        }
        return $cancel;
    }

    /**
     * Method to save a record.
     *
     * @param   string  $key     The name of the primary key of the URL variable.
     * @param   string  $urlVar  The name of the URL variable if different from the primary key (sometimes required to avoid router collisions).
     *
     * @return  boolean  True if successful, false otherwise.
     *
     * @since   12.2
     */
    public function save($key = null, $urlVar = null)
    {
        // get the referral options
        $this->ref = $this->input->get('ref', 0, 'word');
        $this->refid = $this->input->get('refid', 0, 'int');

        // Check if there is a return value
        $return = $this->input->get('return', null, 'base64');
        $canReturn = (!is_null($return) && Uri::isInternal(base64_decode($return)));

        if ($this->ref || $this->refid || $canReturn)
        {
            // to make sure the item is checkedin on redirect
            $this->task = 'save';
        }

        $saved = parent::save($key, $urlVar);

        // This is not needed since parent save already does this
        // Due to the ref and refid implementation we need to add this
        if ($canReturn)
        {
            $redirect = base64_decode($return);

            // Redirect to the return value.
            $this->setRedirect(
                Route::_(
                    $redirect, false
                )
            );
        }
        elseif ($this->refid && $this->ref)
        {
            $redirect = '&view=' . (string) $this->ref . '&layout=edit&id=' . (int) $this->refid;

            // Redirect to the item screen.
            $this->setRedirect(
                Route::_(
                    'index.php?option=' . $this->option . $redirect, false
                )
            );
        }
        elseif ($this->ref)
        {
            $redirect = '&view=' . (string) $this->ref;

            // Redirect to the list screen.
            $this->setRedirect(
                Route::_(
                    'index.php?option=' . $this->option . $redirect, false
                )
            );
        }
        return $saved;
    }

    /**
     * Function that allows child controller access to model data
     * after the data has been saved.
     *
     * @param   BaseDatabaseModel  $model     The data model object.
     * @param   array              $validData  The validated data.
     *
     * @return  void
     *
     * @since   11.1
     */
    protected function postSaveHook(BaseDatabaseModel $model, $validData = [])
    {
        return;
    }

}
