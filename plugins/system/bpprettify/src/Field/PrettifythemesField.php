<?php
/**
 * @package     ${package}
 *
 * @copyright   Copyright (C) ${build.year} ${copyrights}, All rights reserved.
 * @license     ${license.name}; see ${license.url}
 */

namespace Joomla\Plugin\System\BPPrettify\Field;

\defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Form\Field\ListField;
use Joomla\Plugin\System\BPPrettify\Helper\AssetsHelper;

/**
 * Shows list of themes fields.
 *
 * @since  2.0.0
 */
class PrettifythemesField extends ListField
{
    /**
     * The form field type.
     *
     * @var    string
     * @since  2.0.0
     */
    protected $type = 'prettifythemes';

    /**
     * Method to get the field options.
     *
     * @return  array  The field option objects.
     *
     * @since   3.7.0
     */
    protected function getOptions()
    {

        // Collect themes
        $themes = [];

        foreach (AssetsHelper::getThemes() as $theme) {
            $themes[] = [
                'value' => $theme,
                'text'  => ucwords(str_ireplace('-', ' ', $theme)),
            ];
        }

        return array_merge(parent::getOptions(), $themes);
    }
}
