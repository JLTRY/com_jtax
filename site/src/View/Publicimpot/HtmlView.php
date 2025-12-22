<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
                JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

    @version		1.0.8
    @build			15th December, 2025
    @created		4th March, 2025
    @package		JTax
    @subpackage		HtmlView.php
    @author			Jean-Luc Tryoen <http://www.jltryoen.fr>	
    @copyright		Copyright (C) 2015. All Rights Reserved
    @license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/
namespace JLTRY\Component\Jtax\Site\View\Publicimpot;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Document\Document;
use JLTRY\Component\Jtax\Site\Helper\HeaderCheck;
use JLTRY\Component\Jtax\Site\Helper\JtaxHelper;
use JLTRY\Component\Jtax\Site\Helper\RouteHelper;
use JLTRY\Joomla\Jtax\Utilities\Permitted\Actions;
use JLTRY\Joomla\Utilities\StringHelper;
use Joomla\CMS\Application\CMSApplicationInterface;
use Joomla\Input\Input;
use Joomla\Registry\Registry;
use Joomla\CMS\User\User;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Jtax Html View class for the Publicimpot
 *
 * @since  1.6
 */
class HtmlView extends BaseHtmlView
{
    /**
     * The app class
     *
     * @var    CMSApplicationInterface
     * @since  5.2.1
     */
    public CMSApplicationInterface $app;

    /**
     * The input class
     *
     * @var    Input
     * @since  5.2.1
     */
    public Input $input;

    /**
     * The params registry
     *
     * @var    Registry
     * @since  5.2.1
     */
    public Registry $params;

    /**
     * The user object.
     *
     * @var    User
     * @since  3.10.11
     */
    public User $user;

    /**
     * The toolbar object
     *
     * @var    Toolbar
     * @since  3.10.11
     */
    public Toolbar $toolbar;

    /**
     * The styles url array
     *
     * @var    array
     * @since  3.10.11
     */
    protected array $styles;

    /**
     * The scripts url array
     *
     * @var    array
     * @since  3.10.11
     */
    protected array $scripts;

    /**
     * The actions object
     *
     * @var    object
     * @since  3.10.11
     */
    public object $canDo;

    /**
     * Display the view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     * @throws \Exception
     * @since  1.6
     */
    public function display($tpl = null): void
    {
        // get application
        $this->app ??= Factory::getApplication();
        // get input
        $this->input ??= method_exists($this->app, 'getInput') ? $this->app->getInput() : $this->app->input;
        // set params
        $this->params ??= method_exists($this->app, 'getParams')
            ? $this->app->getParams()
            : ComponentHelper::getParams('com_jtax');
        $this->menu = $this->app->getMenu()->getActive();
        // get the user object
        $this->user ??= $this->getCurrentUser();

        // get the permitted actions the current user can do.
        $this->canDo = Actions::get('publicimpot');

        // Load module values
        $model = $this->getModel();
        $this->styles = $model->getStyles() ?? [];
        $this->scripts = $model->getScripts() ?? [];
        // Initialise variables.
        $this->item = $model->getItem();
        
        /***[JCBGUI.site_view.php_jview_display.30.$$$$]***/
        // Load the form manually by name
        \Joomla\CMS\Form\Form::addFormPath(JPATH_COMPONENT . '/forms');
        $form = \Joomla\CMS\Form\Form::getInstance('impot', 'impot', array('control' => 'jform'));
        $this->form = $form;
        $app = Factory::getApplication();
        $jinput = $app->getInput();
        $this->editor = $jinput->getString('editor', null);
        $this->id =  $jinput->getString('id', -1);
        if ($this->id !== -1) {
            $model = new \JLTRY\Component\Jtax\Site\Model\PublicimpotModel;
            $this->setModel($model);
            $this->item = $model->getItem((int)$this->id);
               $this->form->bind($this->item);
        }/***[/JCBGUI$$$$]***/
        

        // Set the toolbar
        $this->addToolBar();

        // Set the html view document stuff
        $this->_prepareDocument();

        // Check for errors.
        if (count($errors = $model->getErrors()))
        {
            throw new \Exception(implode(PHP_EOL, $errors), 500);
        }

        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @return  void
     * @throws  \Exception
     * @since   1.6
     */
    protected function addToolbar(): void
    {
        
        // now initiate toolbar if it's not already loaded
        $this->toolbar ??= $this->getDocument()->getToolbar();
/***[JCBGUI.site_view.view_toolbar.30.$$$$]***/
ToolbarHelper::custom('impot.calculate', 'joomla custom-button-calculate', '', Text::_('COM_JTAX_CALCULER'), false);/***[/JCBGUI$$$$]***/

    }

    /**
     * Prepare some document related stuff.
     *
     * @return  void
     * @since   1.6
     */
    protected function _prepareDocument(): void
    {

        // Only load jQuery if needed. (default is true)
        if ($this->params->get('add_jquery_framework', 1) == 1)
        {
            Html::_('jquery.framework');
        }
        // Load the header checker class.
        // Initialize the header checker.
        $HeaderCheck = new HeaderCheck();

        // Add View JavaScript File
        Html::_('script', 'components/com_jtax/assets/js/publicimpot.js', ['version' => 'auto']);
        // add styles
        foreach ($this->styles as $style)
        {
            Html::_('stylesheet', $style, ['version' => 'auto']);
        }
        // add scripts
        foreach ($this->scripts as $script)
        {
            Html::_('script', $script, ['version' => 'auto']);
        }
    }

    /**
     * Escapes a value for output in a view script.
     *
     * @param   mixed  $var     The output to escape.
     * @param   bool   $shorten The switch to shorten.
     * @param   int    $length  The shorting length.
     *
     * @return  mixed  The escaped value.
     * @since   1.6
     */
    public function escape($var, bool $shorten = false, int $length = 40)
    {
        if (!is_string($var))
        {
            return $var;
        }

        return StringHelper::html($var, $this->_charset ?? 'UTF-8', $shorten, $length);
    }
}
