<?php

namespace App\Helpers;

class RouteHelper
{
    /**
     * Get route URL with query parameters
     */
    public static function routeWithParams($routeName, $params = [])
    {
        $queryParams = [];
        $routeParams = [];
        
        foreach ($params as $key => $value) {
            // Check if this is a route parameter (common patterns)
            if (in_array($key, ['id', 'slug', 'acc', 'q', 't', 'a', 'c'])) {
                $routeParams[$key] = $value;
            } else {
                $queryParams[$key] = $value;
            }
        }
        
        $url = route($routeName, $routeParams);
        
        if (!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
        }
        
        return $url;
    }
    
    /**
     * Check if current route matches pattern
     */
    public static function isRoute($pattern)
    {
        $currentRoute = request()->route()->getName() ?? '';
        return str_contains($currentRoute, $pattern);
    }
    
    /**
     * Get active menu class
     */
    public static function activeMenu($routeName, $class = 'active')
    {
        $currentRoute = request()->route()->getName() ?? '';
        return $currentRoute === $routeName ? $class : '';
    }
}
