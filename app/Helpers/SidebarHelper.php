<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SidebarHelper
{
    /**
     * Cache duration in seconds (5 minutes)
     */
    const CACHE_DURATION = 300;
    
    /**
     * Get system settings (with caching)
     */
    public static function getSettings()
    {
        $cacheKey = 'system_settings';
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () {
            try {
                $settingsData = DB::table('settings')->first();
                return $settingsData ? (array) $settingsData : [];
            } catch (\Exception $e) {
                Log::error('Error fetching system settings', [
                    'error' => $e->getMessage()
                ]);
                return [];
            }
        });
    }
    
    /**
     * Check if a setting is enabled
     */
    public static function isSettingEnabled($settingKey)
    {
        $settings = self::getSettings();
        return isset($settings[$settingKey]) && $settings[$settingKey] == 1;
    }
    
    /**
     * Get user data (with caching)
     */
    public static function getUserData()
    {
        $userId = session('userid');
        
        if (!$userId) {
            return [];
        }
        
        $cacheKey = "user_data_{$userId}";
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($userId) {
            try {
                $userData = DB::table('users')->where('id', $userId)->first();
                return $userData ? (array) $userData : [];
            } catch (\Exception $e) {
                Log::error('Error fetching user data', [
                    'user_id' => $userId,
                    'error' => $e->getMessage()
                ]);
                return [];
            }
        });
    }
    
    /**
     * Clear cache for system settings
     */
    public static function clearSettingsCache()
    {
        Cache::forget('system_settings');
    }
    
    /**
     * Clear cache for user data
     */
    public static function clearUserDataCache($userId = null)
    {
        if ($userId) {
            Cache::forget("user_data_{$userId}");
        } else {
            // Clear all user data cache
            for ($i = 1; $i <= 1000; $i++) {
                Cache::forget("user_data_{$i}");
            }
        }
    }
    
    /**
     * Get language variables (with caching)
     */
    public static function getLanguageVariables($langCode = 'ar')
    {
        $cacheKey = "language_{$langCode}";
        
        return Cache::remember($cacheKey, 3600, function () use ($langCode) {
            $lang = [];
            $langFile = base_path("native/language/{$langCode}.php");
            
            if (file_exists($langFile)) {
                // Capture variables from language file
                ob_start();
                include $langFile;
                ob_end_clean();
                
                // Get all variables that start with $lang_ or $sittingpass
                $allVars = get_defined_vars();
                foreach ($allVars as $key => $value) {
                    if (strpos($key, 'lang_') === 0 || strpos($key, 'sittingpass') === 0) {
                        $lang[$key] = $value;
                    }
                }
            }
            
            return $lang;
        });
    }
    
    /**
     * Clear language cache
     */
    public static function clearLanguageCache($langCode = null)
    {
        if ($langCode) {
            Cache::forget("language_{$langCode}");
        } else {
            // Clear all language cache (common languages)
            $languages = ['ar', 'en', 'fr'];
            foreach ($languages as $lang) {
                Cache::forget("language_{$lang}");
            }
        }
    }
    
    /**
     * Get role permissions (with caching)
     */
    public static function getRole()
    {
        $userId = session('userid');
        
        if (!$userId) {
            return [];
        }
        
        $cacheKey = "user_role_{$userId}";
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($userId) {
            try {
                $userData = DB::table('users')->where('id', $userId)->first();
                if (!$userData) {
                    return [];
                }
                
                // العمود الصحيح هو userrole مش role_id
                $roleId = $userData->userrole ?? null;
                if (!$roleId) {
                    return [];
                }
                
                // جلب الصلاحيات من جدول usr_pwrs
                $role = DB::table('usr_pwrs')->where('id', $roleId)->first();
                return $role ? (array) $role : [];
            } catch (\Exception $e) {
                Log::error('Error fetching user role', [
                    'user_id' => $userId,
                    'error' => $e->getMessage()
                ]);
                return [];
            }
        });
    }
    
    /**
     * Clear role cache
     */
    public static function clearRoleCache($userId = null)
    {
        if ($userId) {
            Cache::forget("user_role_{$userId}");
        } else {
            // Clear all role cache
            for ($i = 1; $i <= 1000; $i++) {
                Cache::forget("user_role_{$i}");
            }
        }
    }
    
    /**
     * Clear all sidebar related cache
     */
    public static function clearAllCache()
    {
        self::clearSettingsCache();
        self::clearUserDataCache();
        self::clearRoleCache();
        self::clearLanguageCache();
    }
}
