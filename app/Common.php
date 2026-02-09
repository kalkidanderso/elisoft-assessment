<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

if (! function_exists('env')) {
    /**
     * Override CodeIgniter's env() function to support Render's environment variables
     * Render sets environment variables in $_ENV, not just getenv()
     * Also, Docker doesn't reliably pass variables with dots, so we check underscore versions too
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    function env(string $key, $default = null)
    {
        // Also try underscore version (Docker-friendly)
        $underscoreKey = str_replace('.', '_', $key);
        
        // Check $_ENV first (Render uses this)
        if (isset($_ENV[$key]) && $_ENV[$key] !== '') {
            return $_ENV[$key];
        }
        if ($underscoreKey !== $key && isset($_ENV[$underscoreKey]) && $_ENV[$underscoreKey] !== '') {
            return $_ENV[$underscoreKey];
        }

        // Check $_SERVER
        if (isset($_SERVER[$key]) && $_SERVER[$key] !== '') {
            return $_SERVER[$key];
        }
        if ($underscoreKey !== $key && isset($_SERVER[$underscoreKey]) && $_SERVER[$underscoreKey] !== '') {
            return $_SERVER[$underscoreKey];
        }

        // Check getenv() as fallback
        $value = getenv($key);
        if ($value !== false && $value !== '') {
            return $value;
        }
        if ($underscoreKey !== $key) {
            $value = getenv($underscoreKey);
            if ($value !== false && $value !== '') {
                return $value;
            }
        }

        return $default;
    }
}
