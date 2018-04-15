<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 *  xnewsletterSession class
 *
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         xnewsletter
 * @since           1.3
 * @author          trabis <lusopoemas@gmail.com>
 * @author          Harry Fuecks (PHP Anthology Volume II)
 */

require_once  dirname(__DIR__) . '/include/common.php';

/**
 * Class xnewsletterSession
 */
class xnewsletterSession
{
    /**
     * Session constructor<br>
     * Starts the session with session_start()
     * <strong>Note:</strong> that if the session has already started,
     * session_start() does nothing
     */
    protected function __construct()
    {
        @session_start();
    }

    /**
     * Sets a session variable
     *
     * @param string $name  name of variable
     * @param mixed  $value value of variable
     *
     * @return void
     * @access public
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Fetches a session variable
     *
     * @param string $name name of variable
     *
     * @return mixed value of session variable
     * @access public
     */
    public function get($name)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        } else {
            return false;
        }
    }

    /**
     * Deletes a session variable
     *
     * @param string $name name of variable
     *
     * @return void
     * @access public
     */
    public function del($name)
    {
        unset($_SESSION[$name]);
    }

    /**
     * Destroys the whole session
     *
     * @return void
     * @access public
     */
    public function destroy()
    {
        $_SESSION = [];
        session_destroy();
    }

    /**
     * @return xnewsletterSession
     */
    public static function getInstance()
    {
        static $instance;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }
}
