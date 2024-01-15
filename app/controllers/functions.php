<?php

/**
 * Print Variables. Show Variable content in <pre> ... </pre> tags via print_r
 * Show only if DEBUG Constant set to true!
 *
 * @param mixed $var Variable to show
 * @param bool $return
 * @param string $title Variable title to show
 * @return string
 * @global constant DEBUG
 */
function P($var = '', $return = false, $title = "")
{
    $title_str = "";
    if (mb_strlen($title) > 0) {
        $title_str = "<h3 class='pre_debug'>" . $title . "</h3>";
    }
    if ($return == true) {
        return '<pre>' . $title_str . print_r($var, true) . '</pre>';
    } else {
        echo $title_str . "";
        echo '<pre class="pre_debug">';
        if (is_array($var)) {
            print_r($var);
        } else {
            echo $var;
        }
        echo '</pre>';
    }
}

/**
 * Generates a CSRF token.
 *
 * @throws Exception If random_bytes() fails to generate random bytes.
 * @return string The generated CSRF token as a hexadecimal string.
 */
function generateCSRFToken()
{
    if (!function_exists('random_bytes')) {
        throw new Exception('random_bytes() function is not available.');
    } else {
        return bin2hex(random_bytes(32));
    }
}

/**
 * Checks if the user is logged in.
 *
 * @return bool Returns true if the user is logged in, false otherwise.
 */
function isUserLoggedIn()
{
    return isset($_SESSION['user_id']);
}