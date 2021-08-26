<?php
/**
 * @package     ${package}
 *
 * @copyright   Copyright (C) ${build.year} ${copyrights}, All rights reserved.
 * @license     ${license.name}; see ${license.url}
 */

use Joomla\CMS\Document\HtmlDocument;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Plugin\System\BPPrettify\Helper\AssetsHelper;

defined('_JEXEC') or die;

/**
 * System plugin to use GooglePrettify as code highlighter.
 *
 * @since 1.0.2
 */
class PlgSystemBPPrettify extends CMSPlugin
{

    /**
     * Application object.
     *
     * @var    \Joomla\CMS\Application\CMSApplication
     * @since  2.0.0
     */
    protected $app;

    /**
     * Run this method after application dispatch.
     *
     * @return bool
     *
     * @throws Exception
     * @since 1.0.2
     */
    public function onAfterDispatch()
    {

        /**
         * @var $doc HtmlDocument
         */
        $doc   = $this->app->getDocument();
        $input = $this->app->input;

        // Check that we are in the site application.
        if ($this->app->isClient('administrator')) {

            return true;
        }

        // Check if the highlighter should be activated in this environment.
        if ($doc->getType() !== 'html' || $input->get('tmpl', '',
                'cmd') === 'component') {
            return true;
        }

        // Add border
        $line_numbers = (bool)$this->params->get('linenumbers', 1);

        // Add prettify script
        HTMLHelper::_('jquery.framework');

        $asset_manager = $doc->getWebAssetManager();
        $asset_manager->registerAndUseScript('plg_system_bpprettify-theme', AssetsHelper::getPluginScriptUrl());
        $asset_manager->addInlineScript("
            jQuery(function(){
                $(window).BPPrettify(" . ($line_numbers ? true : '') . ");
            });
        ");

        // Settings CSS
        $css = '';

        // Add border
        $padding = $this->params->get('padding', 20);
        if ($padding) {
            $css .= "padding:{$padding}px;";
        }

        // Add border
        $border = $this->params->get('border', 1);
        if ($border) {
            $css .= "box-shadow: inset 0 0 1px rgba(0,0,0,.5);";
        }

        // Set settings CSS
        if (!empty($css)) {
            $asset_manager->addInlineStyle(".prettyprint { $css }");
        }

        // Add theme
        $theme     = $this->params->get('theme', 'tomorrow');
        $style_url = AssetsHelper::getThemeStyleByName($theme);
        if ($theme !== '-1') {
            $asset_manager->registerAndUseStyle('plg_system_bpprettify-theme', $style_url, ['version' => 'auto']);
        }

        return true;
    }
}