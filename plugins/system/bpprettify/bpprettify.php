<?php
/**
 * @package     ${package}
 *
 * @copyright   Copyright (C) ${build.year} ${copyrights}, All rights reserved.
 * @license     ${license.name}; see ${license.url}
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\HTML\HTMLHelper;

defined('_JEXEC') or die;

/**
 * System plugin to use GooglePrettify as code highlighter.
 *
 * @since 1.0.2
 */
class PlgSystemBPPrettify extends CMSPlugin
{

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

        $app = Factory::getApplication();
        $doc = Factory::getDocument();
        $input = $app->input;

        // Check that we are in the site application.
        if ($app->isClient('administrator')) {

            return true;
        }

        // Check if the highlighter should be activated in this environment.
        if ($doc->getType() !== 'html' || $input->get('tmpl', '',
                'cmd') === 'component') {
            return true;
        }

        // Add prettify script
        HTMLHelper::_('jquery.framework');
        $doc->addScript('https://cdn.rawgit.com/google/code-prettify/master/src/prettify.js', ['version' => 'auto']);
        $doc->addScriptDeclaration('
			jQuery(function($){
			    var $list = jQuery("code,pre,xmp");
				if( $list.length ) {
				    $list.each(function(idx, el){
                        if( $(el).parent("pre,code").length==0 ) {
                            $(el).addClass("prettyprint");
                        }				        
				    });
					prettyPrint();
				}
			});
		');

        // Settings CSS
        $css = '';

        // Add border
        $padding = $this->params->get('padding', 20);
        if( $padding ) {
            $css.= "padding:{$padding}px;";
        }

        // Add border
        $border = $this->params->get('border', 1);
        if( $border ) {
            $css.= "box-shadow: inset 0 0 1px rgba(0,0,0,.5);";
        }

        // Set settings CSS
        if( !empty($css) ) {
            $doc->addStyleDeclaration(".prettyprint { $css }");
        }

        // Add theme
        $theme = $this->params->get('theme', 'tomorrow.min.css');
        if ($theme !== '-1') {
            $doc->addStyleSheet('/plugins/system/bpprettify/themes/' . $theme, ['version' => 'auto']);
        }

        return true;
    }
}