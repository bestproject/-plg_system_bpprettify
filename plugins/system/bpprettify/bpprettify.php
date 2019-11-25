<?php
/**
 * @package     ${package}
 *
 * @copyright   Copyright (C) ${build.year} ${copyrights}, All rights reserved.
 * @license     ${license.name}; see ${license.url}
 */

use Joomla\CMS\Factory;

defined('_JEXEC') or die;

/**
 * System plugin to use GooglePrettify as code highlighter.
 *
 * @since 1.0.2
 */
class PlgSystemBPPrettify extends JPlugin
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

        // Check that we are in the site application.
        $app = Factory::getApplication();
        if ($app->isClient('administrator')) {

            return true;
        }

        // Set the variables.
        $input = $app->input;

        // Check if the highlighter should be activated in this environment.
        $doc = Factory::getDocument();
        if ($doc->getType() !== 'html' || $input->get('tmpl', '',
                'cmd') === 'component') {
            return true;
        }

        // Add prettify script
        JHTML::_('jquery.framework');
        $doc->addScript('https://cdn.rawgit.com/google/code-prettify/master/src/prettify.js', ['version' => 'auto']);
        $doc->addScriptDeclaration('
			jQuery(window).load(function(){
				var $list = jQuery("code,pre,xmp");
				if( $list.length ) {
					$list.addClass("prettyprint");
					prettyPrint();
				}
			});
		');

        // Add theme
        $theme = $this->params->get('theme', 'tomorrow.min.css');
        if ($theme !== '-1') {
            $doc->addStyleSheet('/plugins/system/bpprettify/themes/' . $theme, ['version' => 'auto']);
        }

        return true;
    }
}