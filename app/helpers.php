<?php

if (! function_exists('module_asset')) {
    /**
     * Generate the URL to a module asset.
     *
     * @param  string  $module  The module name
     * @param  string  $path  The asset path relative to the module's assets directory
     * @return string
     */
    function module_asset(string $module, string $path = ''): string
    {
        $assetsPath = config('modules.paths.assets', public_path('modules'));
        $moduleName = strtolower($module);
        $assetPath = trim($path, '/');
        
        // Remove 'assets/' prefix if present (since we're already in the assets directory)
        if (str_starts_with($assetPath, 'assets/')) {
            $assetPath = substr($assetPath, 7);
        }
        
        // Get the relative path from public directory
        $relativePath = str_replace(public_path(), '', $assetsPath);
        $relativePath = trim($relativePath, '/');
        
        // Build the full asset URL
        $fullPath = $relativePath . '/' . $moduleName . '/' . $assetPath;
        
        return asset($fullPath);
    }
}
