<?php
/**
 * @package     ${package}
 *
 * @copyright   Copyright (C) ${build.year} ${copyrights}, All rights reserved.
 * @license     ${license.name}; see ${license.url}
 */

use BPExtensions\Plugin\System\BPPrettify\Helper\AssetsHelper;
use Joomla\CMS\Document\HtmlDocument;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\WebAsset\WebAssetManager;
use Joomla\CMS\WebAsset\WebAssetManagerInterface;

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
     * Page assets manager.
     * @var WebAssetManagerInterface
     *
     * @since 2.0
     */
    protected $webAssetsManager;

    /**
     * Run this method after application dispatch.
     *
     * @throws Exception
     * @since 1.0.2
     */
    public function onAfterDispatch(): void
    {

        /**
         * @var $doc HtmlDocument
         */
        $doc   = $this->app->getDocument();
        $input = $this->app->input;

        // Check that we are in the site application.
        if ($this->app->isClient('administrator')) {

            return;
        }

        // Check if the plugin should be activated in this environment.
        if ($doc->getType() !== 'html' || $input->get('tmpl', '',
                'cmd') === 'component') {
            return;
        }

        // Add border
        $line_numbers = (bool)$this->params->get('linenumbers', 1);

        // Add prettify script
        HTMLHelper::_('jquery.framework');

        $asset_manager = $this->getWebAssetManager();
        AssetsHelper::addEntryPointAssets($asset_manager, 'assets', 'plugin');
        $asset_manager->addInlineScript("
            jQuery(function($){
                $(window).BPPrettify(" . ($line_numbers ? true : '') . ");
            });
        ");

        // Settings CSS
        $css = '';

        // Add border
        $padding = (int)$this->params->get('padding', 20);
        if ($padding) {
            $css .= "padding:{$padding}px;";
        }

        // Add border
        $border = $this->params->get('border', 1);
        if ($border) {
            $css .= "box-shadow: inset 0 0 1px 1px rgba(0,0,0,.2);";
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
    }

    /**
     * Get website assets manager.
     *
     * @return WebAssetManager
     * @since 2.0
     */
    protected function getWebAssetManager(): WebAssetManager
    {
        if (!($this->webAssetsManager instanceof WebAssetManagerInterface)) {
            $this->webAssetsManager = $this->app->getDocument()->getWebAssetManager();
        }

        return $this->webAssetsManager;
    }

    /**
     * Return the map of subscribed events and class methods.
     *
     * @return array
     *
     * @since 2.0
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'onAfterDispatch' => 'onAfterDispatch',
        ];
    }
}