<?php

namespace BPExtensions\Plugin\System\BPPrettify\Helper;

use Joomla\CMS\WebAsset\WebAssetManager;
use JUri;
use RuntimeException;

/**
 * BPPrettify plugin assets management helper.
 *
 * @package     BPExtensions\Plugin\System\BPPrettify\Helper
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
    protected static $entrypoints = ['themes' => [], 'assets' => []];

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

        foreach (self::getEntrypoints('themes') as $name => $files) {
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
            $path = self::getAssetsRootPath() . '/' . $config_name . '/entrypoints.json';

            // Make sure manifest file exists
            if (!file_exists($path)) {
                throw new RuntimeException("Unable to find manifest file in: $path");
            }

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
            self::$assets_root_path = JPATH_ROOT . '/media/plg_system_bpprettify';
        }

        return self::$assets_root_path;
    }

    /**
     * Include entry point assets into the document.
     *
     * @param   WebAssetManager  $webAssetManager
     * @param   string           $config_name
     * @param   string           $entryPoint
     *
     * @return void
     *
     * @since 1.1
     */
    public static function addEntryPointAssets(
        WebAssetManager $webAssetManager,
        string $config_name,
        string $entryPoint
    ): void {
        $entryPoints = self::getEntryPoints($config_name);

        if (array_key_exists($entryPoint, $entryPoints)) {

            // Add Styles
            if (array_key_exists('css', $entryPoints[$entryPoint])) {
                foreach ($entryPoints[$entryPoint]['css'] as $stylesheet) {
                    $webAssetManager->registerAndUseStyle('bpprettify-style', JUri::root(true) . $stylesheet);
                }
            }

            // Add scripts
            if (array_key_exists('js', $entryPoints[$entryPoint])) {
                foreach ($entryPoints[$entryPoint]['js'] as $script) {
                    $webAssetManager->registerAndUseScript('bpprettify-script', JUri::root(true) . $script, [], [],
                        ['jquery']);
                }
            }
        }
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