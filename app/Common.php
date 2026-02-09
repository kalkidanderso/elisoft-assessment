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
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    function env(string $key, $default = null)
    {
        // Check $_ENV first (Render uses this)
        if (isset($_ENV[$key]) && $_ENV[$key] !== '') {
            return $_ENV[$key];
        }

        // Check $_SERVER
        if (isset($_SERVER[$key]) && $_SERVER[$key] !== '') {
            return $_SERVER[$key];
        }

        // Check getenv() as fallback
        $value = getenv($key);
        if ($value !== false && $value !== '') {
            return $value;
        }

        return $default;
    }
}
