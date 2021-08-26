<?php

namespace Joomla\Plugin\System\BPPrettify\Helper;

/**
 * BPPrettify plugin assets managemen helper.
 *
 * @package     Joomla\Plugin\System\BPPrettify\Helper
 *
 * @since       2.0.0
 */
class AssetsHelper
{
    /**
     * Assets base path.
     *
     * @var string
     * @since 2.0.0
     */
    protected static $assets_root_path = '';

    /**
     * Plugin entrypoints.
     *
     * @var array[]
     * @since 2.0.0
     */
    protected static $entrypoints = ['themes' => [], 'build' => []];

    /**
     * Get list of themes entrypoints.
     *
     * @return array
     *
     * @since 2.0.0
     */
    public static function getThemes(): array
    {
        $themes = [];

        foreach (AssetsHelper::getEntrypoints('themes') as $name => $files) {
            if (!array_key_exists('css', $files)) {
                continue;
            }

            $themes[] = $name;
        }

        return $themes;
    }

    /**
     * Get entrypoints from a specific config.
     *
     * @param   string  $config_name  Name of a config (themes|plugin).
     *
     * @return array
     *
     * @since 2.0.0
     */
    public static function getEntrypoints(string $config_name): array
    {
        if (self::$entrypoints[$config_name] === []) {
            $path                            = self::getAssetsRootPath() . '/' . $config_name . '/entrypoints.json';
            $manifest                        = json_decode(file_get_contents($path), true, 512, JSON_OBJECT_AS_ARRAY);
            self::$entrypoints[$config_name] = $manifest['entrypoints'];
        }

        return self::$entrypoints[$config_name];
    }

    /**
     * Get plugin assets root path.
     *
     * @return string
     *
     * @since 2.0.0
     */
    public static function getAssetsRootPath(): string
    {
        if (self::$assets_root_path === '') {
            self::$assets_root_path = dirname(__DIR__, 2) . '/assets';
        }

        return self::$assets_root_path;
    }

    /**
     * Get theme style css file URL.
     *
     * @param   string  $name  Name of the theme.
     *
     * @return string
     *
     * @since 2.0.0
     */
    public static function getThemeStyleByName(string $name): string
    {
        return self::getEntrypoints('themes')[$name]['css'][0];
    }

    /**
     * Get plugin script.
     *
     * @return string
     *
     * @since 2.0.0
     */
    public static function getPluginScriptUrl(): string
    {
        return self::getEntrypoints('build')['plugin']['js'][0];
    }

}