<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
                JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

    @version		1.0.8
    @build			15th December, 2025
    @created		4th March, 2025
    @package		JTax
    @subpackage		ImpotsModel.php
    @author			Jean-Luc Tryoen <http://www.jltryoen.fr>	
    @copyright		Copyright (C) 2015. All Rights Reserved
    @license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/
namespace JCB\Component\Jtax\Site\Model;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Application\CMSApplicationInterface;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\User\User;
use Joomla\Utilities\ArrayHelper;
use Joomla\Input\Input;
use JCB\Component\Jtax\Site\Helper\JtaxHelper;
use JCB\Component\Jtax\Site\Helper\RouteHelper;
use Joomla\CMS\Helper\TagsHelper;
use JCB\Joomla\Utilities\ArrayHelper as UtilitiesArrayHelper;
use Joomla\CMS\Uri\Uri;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Jtax List Model for Impots
 *
 * @since  1.6
 */
class ImpotsModel extends ListModel
{
    /**
     * Represents the current user object.
     *
     * @var   User  The user object representing the current user.
     * @since 3.2.0
     */
    protected User $user;

    /**
     * The unique identifier of the current user.
     *
     * @var   int|null  The ID of the current user.
     * @since 3.2.0
     */
    protected ?int $userId;

    /**
     * Flag indicating whether the current user is a guest.
     *
     * @var   int  1 if the user is a guest, 0 otherwise.
     * @since 3.2.0
     */
    protected int $guest;

    /**
     * An array of groups that the current user belongs to.
     *
     * @var   array|null  An array of user group IDs.
     * @since 3.2.0
     */
    protected ?array $groups;

    /**
     * An array of view access levels for the current user.
     *
     * @var   array|null  An array of access level IDs.
     * @since 3.2.0
     */
    protected ?array $levels;

    /**
     * The application object.
     *
     * @var   CMSApplicationInterface  The application instance.
     * @since 3.2.0
     */
    protected CMSApplicationInterface $app;

    /**
     * The input object, providing access to the request data.
     *
     * @var   Input  The input object.
     * @since 3.2.0
     */
    protected Input $input;

    /**
     * The styles array.
     *
     * @var    array
     * @since  4.3
     */
    protected array $styles = [
        'components/com_jtax/assets/css/site.css',
        'components/com_jtax/assets/css/impots.css'
    ];

    /**
     * The scripts array.
     *
     * @var    array
     * @since  4.3
     */
    protected array $scripts = [
        'components/com_jtax/assets/js/site.js'
    ];

    /**
     * A custom property for UIKit components. (not used unless you load v2)
     */
    protected $uikitComp;

    /**
     * Constructor
     *
     * @param   array                 $config   An array of configuration options (name, state, dbo, table_path, ignore_request).
     * @param   ?MVCFactoryInterface  $factory  The factory.
     *
     * @since   1.6
     * @throws  \Exception
     */
    public function __construct($config = [], ?MVCFactoryInterface $factory = null)
    {
        parent::__construct($config, $factory);

        $this->app ??= Factory::getApplication();
        $this->input ??= $this->app->getInput();

        // Set the current user for authorisation checks (for those calling this model directly)
        $this->user ??= $this->getCurrentUser();
        $this->userId = $this->user->get('id');
        $this->guest = $this->user->get('guest');
        $this->groups = $this->user->get('groups');
        $this->authorisedGroups = $this->user->getAuthorisedGroups();
        $this->levels = $this->user->getAuthorisedViewLevels();

        // will be removed
        $this->initSet = true;
    }

    /**
     * Method to build an SQL query to load the list data.
     *
     * @return   string  An SQL query
     * @since    1.6
     */
    protected function getListQuery()
    {
        // Get a db connection.
        $db = $this->getDatabase();

        // Create a new query object.
        $query = $db->getQuery(true);

        // Get from #__jtax_impot as a
        $query->select('a.*');
        $query->from($db->quoteName('#__jtax_impot', 'a'));

        // Get from #__jtax_year as b
        $query->select($db->quoteName(
            array('b.name'),
            array('year_name')));
        $query->join('LEFT', ($db->quoteName('#__jtax_year', 'b')) . ' ON (' . $db->quoteName('a.year') . ' = ' . $db->quoteName('b.id') . ')');
        // Get where a.published is 1
        $query->where('a.published = 1');
        $query->order('a.ordering ASC');

        // return the query object
        return $query;
    }

    /**
     * Method to get an array of data items.
     *
     * @return  mixed  An array of data items on success, false on failure.
     * @since   1.6
     */
    public function getItems()
    {
        $user = $this->user;
        // check if this user has permission to access item
        if (!$user->authorise('site.impots.access', 'com_jtax'))
        {
            $app = Factory::getApplication();
            $app->enqueueMessage(Text::_('COM_JTAX_NOT_AUTHORISED_TO_VIEW_IMPOTS'), 'error');
            // redirect away to the home page if no access allowed.
            $app->redirect(Uri::root());
            return false;
        }
        // load parent items
        $items = parent::getItems();

        // Get the global params
        $globalParams = ComponentHelper::getParams('com_jtax', true);

        // Insure all item fields are adapted where needed.
        if (UtilitiesArrayHelper::check($items))
        {
            foreach ($items as $nr => &$item)
            {
                // Always create a slug for sef URL's
                $item->slug = ($item->id ?? '0') . (isset($item->alias) ? ':' . $item->alias : '');
            }
        }

        // return items
        return $items;
    }

    /**
     * Method to get the styles that have to be included on the view
     *
     * @return  array    styles files
     * @since   4.3
     */
    public function getStyles(): array
    {
        return $this->styles;
    }

    /**
     * Method to set the styles that have to be included on the view
     *
     * @return  void
     * @since   4.3
     */
    public function setStyles(string $path): void
    {
        $this->styles[] = $path;
    }

    /**
     * Method to get the script that have to be included on the view
     *
     * @return  array    script files
     * @since   4.3
     */
    public function getScripts(): array
    {
        return $this->scripts;
    }

    /**
     * Method to set the script that have to be included on the view
     *
     * @return  void
     * @since   4.3
     */
    public function setScript(string $path): void
    {
        $this->scripts[] = $path;
    }
}
