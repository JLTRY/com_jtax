<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
                JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

    @version		1.0.7
    @build			8th December, 2025
    @created		4th March, 2025
    @package		JTax
    @subpackage		RouteHelper.php
    @author			Jean-Luc Tryoen <http://www.jltryoen.fr>	
    @copyright		Copyright (C) 2015. All Rights Reserved
    @license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/
namespace JCB\Component\Jtax\Site\Helper;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\Registry\Registry;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Jtax Component Route Helper
 *
 * @since       1.5
 */
abstract class RouteHelper
{
    /**
     * Registry to hold the jtax params
     *
     * @var    Registry
     * @since  5.1.3
     */
    protected static Registry $params;

    /**
     * Get the URL route for impots
     *
     * @param   integer  $id     The id of the impots
     *
     * @return  string  The link to the impots
     *
     * @since   1.5
     */
    public static function getImpotsRoute($id = 0): string
    {
        if ($id > 0)
        {
            // Create the link
            $link = 'index.php?option=com_jtax&view=impots&id='. $id;
        }
        else
        {
            // Create the link but don't add the id.
            $link = 'index.php?option=com_jtax&view=impots';
        }

        return $link;
    }

    /**
     * Retrieve a legacy-configured menu item override.
     *
     * This method is preserved for backward compatibility with older
     * JCB-generated components where menu item overrides could be defined
     * in the component's **global Options** panel. Administrators were able
     * to add menu-item selector fields under the same tab name as the
     * related entity/view type, using the naming convention:
     *
     *     {type}_menu
     *
     * Example:
     *   - A field named `tag_menu` allowed administrators to force all tag
     *     routing to use a specific menu item.
     *
     * These overrides served as a convenience mechanism for redirecting
     * routing behaviour *without* modifying the router code.
     *
     * Joomla 5's recommended pattern now is to implement all routing
     * decisions directly inside the router class. This method therefore
     * remains solely as a **legacy fallback**, ensuring older sites continue
     * functioning during migrations or long-term upgrade paths.
     *
     * If a matching `{type}_menu` parameter exists and contains a valid
     * menu item ID (>0), that ID is returned. Otherwise, `null` is returned.
     *
     * @param  string  $type  The entity/view type whose `{type}_menu`
     *                        override should be checked.
     *
     * @return int|null  The overridden menu item ID if available, otherwise null.
     * @since   5.1.3
     */
    protected static function _findItem(string $type): ?int
    {
        // Lazy-load the component parameters only once.
        self::$params ??= ComponentHelper::getParams('com_jtax');

        // Read the legacy override (0 means "not set").
        $override = (int) self::$params->get($type . '_menu', 0);

        return $override > 0 ? $override : null;
    }
}
