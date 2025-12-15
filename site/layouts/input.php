<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
                JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

    @version		1.0.8
    @build			15th December, 2025
    @created		4th March, 2025
    @package		JTax
    @subpackage		input.php
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
use Joomla\CMS\Layout\LayoutHelper;
use JCB\Component\Jtax\Site\Helper\JtaxHelper;

// No direct access to this file
defined('JPATH_BASE') or die;


/***[JCBGUI.layout.php_view.101.$$$$]***/
// Extract all keys from $displayData as individual variables.
extract($displayData);

// Assign default values for variables that might not be present in $displayData.

// The 'id' parameter, defaulting to an empty string if not set or is null.
$id ??= '';

// The 'name' parameter, defaulting to 'id' if not set. Additionally, replace hyphens with underscores.
$name ??= $id;
$name = str_replace('-', '_', $name);

// The 'value' parameter, defaulting to an empty string if not set or is null.
$value ??= '';

// The 'class' parameter, defaulting to 'uk-input' if not set or is null.
$class ??= 'uk-input';

// The 'class_other' parameter, prepended with a space if set, otherwise defaulting to an empty string.
$class_other = isset($class_other) ? ' ' . $class_other : '';

// The 'placeholder' parameter, defaulting to an empty string if not set or is null.
$placeholder ??= '';

// The 'type' parameter, defaulting to 'text' if not set or is null.
$type ??= 'text';

// The 'readonly' attribute, set to 'readonly' if true, otherwise left as an empty string.
$readonly = !empty($readonly) ? ' readonly' : '';

// The 'format' attribute, added only if set, otherwise left as an empty string.
$format = !empty($format) ? ' format="' . $format . '"' : '';

// The 'onchange' attribute, added only if set, otherwise left as an empty string.
$onchange = isset($onchange) ? ' onchange="' . $onchange . '"' : '';

// The 'onkeydown' attribute, added only if set, otherwise left as an empty string.
$onkeydown = isset($onkeydown) ? ' onkeydown="' . $onkeydown . '"' : '';

// The 'required' attribute, set to 'required' if true, otherwise left as an empty string.
$required = !empty($required) ? ' required' : '';/***[/JCBGUI$$$$]***/


?>

<!--[JCBGUI.layout.layout.101.$$$$]-->
<input
    class="<?php echo $class . $class_other; ?>"
    name="<?php echo $name; ?>"
    id="<?php echo $id; ?>"
    type="<?php echo $type; ?>"
    placeholder="<?php echo $placeholder; ?>"
    value="<?php echo $value; ?>"
    <?php echo $readonly; echo $onchange; echo $onkeydown; echo $format; echo $required; ?>
><!--[/JCBGUI$$$$]-->

