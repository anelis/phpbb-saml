<?php
/*
Copyright (c) 2012 ANELIS <anelis@anelis.org>

Permission is hereby granted, free of charge, to any person obtaining a copy of this software
and associated documentation files (the "Software"), to deal in the Software without restriction,
including without limitation the rights to use, copy, modify, merge, publish, distribute,
sublicense, and/or sell copies of the Software, and to permit persons to whom the Software
is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies
or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE
AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
/**
 * SAML auth plug-in for phpBB3.
 *
 * @package login
 * @version $Id$
 * @author Gregoire Astruc <gregoire.astruc@anelis.org>
 * @copyright (c) 2012 Anelis
 * @licence http://opensource.org/licenses/MIT MIT Licence
 *
 */

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
    exit;
}

if (defined('IN_LOGIN') && request_var('mode', '') === 'login')
    saml_auth_or_redirect();

/** SAML init from ACP.
 *  
 *  When there is a change in the configuration and SAML is selected as authentication method,
 *  this method is called to check if the library can be loaded and the service provider is valid.
*/
function init_saml()
{
    global $config, $user;

    if(!array_key_exists('saml_path',  $config) || empty($config['saml_path'])) {
         return $user->lang['SAML_CANNOT_INCLUDE'];
    }

    $config['saml_path'] = rtrim($config['saml_path'], '/');

    if (!is_dir($config['saml_path']))
        return $user->lang['SAML_NOT_DIRECTORY'];
    if (!(include_once($config['saml_path'] . '/lib/_autoload.php')))
        return $user->lang['SAML_CANNOT_INCLUDE'];

    if (!is_string($config['saml_sp']) || empty($config['saml_sp']))
        return $user->lang['SAML_INVALID_SP'];

    return false;
}

/** Autologin through SAML.
 *
 *  Get the authenticated user (if any) from SAML. If the user is already authenticated, we fetch
 *  his/her attributes (yum!) from the SAML provider.
 *
 *  @return the matching user row or an empty array.
 */
function autologin_saml()
{
    global $config;
    if (!saml_instance()->isAuthenticated())
        return array();

    return saml_user_row(saml_attribute($config['saml_uid']));
}

/** Login through SAML.
 *
 *  Called both when hitting the "Login" button or whenever a login_box() call occur.
 *  Both parameters are unused since everything is done through SAML.
 *
 *  @param string $username Supplied username (unused)
 *  @param string $password Supplied password (unused)
 *
 *  @return Matching user row (eventually anonymous) or an error.
 */
function login_saml(&$username, &$password)
{
    global $config, $user, $phpbb_root_path, $phpEx;
    $saml = saml_instance();
    if ($saml === null) {
        return array(
            'status'    => LOGIN_ERROR_EXTERNAL_AUTH,
            'error_msg' => 'SAML_NOT_IMPLEMENTED',
            'user_row'  => array('user_id' => ANONYMOUS),
        );
    }

    saml_auth_or_redirect();

    if ($saml->isAuthenticated()) {
        $username = saml_attribute($config['saml_uid']);
        $user_row = saml_user_row($username);

        if (empty($user_row)) {
            // User unknown... We create his/her profile.
            $usermail = '';
            if (!empty($config['saml_mail'])) 
                $usermail = utf8_htmlspecialchars(saml_attribute($config['saml_mail']));

            // retrieve default group id
            global $db;
            $sql = 'SELECT group_id
                    FROM ' . GROUPS_TABLE . "
                    WHERE group_name = '" . $db->sql_escape('REGISTERED') . "'
                    AND group_type = " . GROUP_SPECIAL;
            $result = $db->sql_query($sql);
            $row = $db->sql_fetchrow($result);
            $db->sql_freeresult($result);
            if (!$row) {
                trigger_error('NO_GROUP');
            }

            $user_row = array(
                'username' => $username,
                'user_password' => phpbb_hash($usermail . rand() . $username),
                'user_email' => $usermail,
                'user_type'  => USER_NORMAL,
                'group_id'   => (int) $row['group_id'],
                'user_ip'    => $user->ip,
                'user_new'   => ($config['new_member_post_limit']) ? 1 : 0,
            );

            return array(
                'status' => LOGIN_SUCCESS_CREATE_PROFILE,
                'error_msg' => false,
                'user_row' => $user_row,
            );
        }
        else {
            // Known user, we just log him in.
            if ($user_row['user_type'] == USER_INACTIVE || $user_row['user_type'] == USER_IGNORE) {
                return array(
                    'status' => LOGIN_ERROR_ACTIVE,
                    'error_msg' => 'ACTIVE_ERROR',
                    'user_row' => $user_row,
                );
            }

            return array(
                'status' => LOGIN_SUCCESS,
                'error_msg' => false,
                'user_row' => $user_row,
            );
        }
    }
}

/** Single Logout.
 *
 *  Logout the user from SAML and bring him back to the board index.
 *
 *  @param array $user_row The user row (unused)
 *  @param array $new_session His/Her new session (unused)
 */
function logout_saml($user_row, $new_session)
{
    saml_instance()->logout(generate_board_url());
}

/** Validate user session.
 *
 *  Check whether the user is still auth'd in SAML.
 *  The check is disabled in login pages to avoid loops and bad behaviour.
 *
 *  @param array $user_row The user row to check against (unused).
 *
 *  @return bool Is user auth'd or not.
 */
function validate_session_saml($user_row)
{
    if (defined('IN_LOGIN') && request_var('mode', '') == 'login')
        return false;
    return saml_instance()->isAuthenticated();
}

/** Generate fields in ACP for SAML.
 *
 *  Generates the fields required by the SAML plugin.
 *
 *  @param array $new The configuration variables.
 *
 *  @return array The updated template.
 */
function acp_saml(&$new)
{
    global $user;
    $tpl = 
        saml_acp_line('saml_path', 'SAML_PATH', 'SAML_PATH_EXPLAIN', $new)       
        . saml_acp_line('saml_sp', 'SAML_SP', 'SAML_SP_EXPLAIN', $new)       
        . saml_acp_line('saml_uid', 'SAML_UID', 'SAML_UID_EXPLAIN', $new)       
        . saml_acp_line('saml_mail', 'SAML_MAIL', 'SAML_MAIL_EXPLAIN', $new);

    return array(
        'tpl'       => $tpl,
        'config'    => array('saml_path', 'saml_sp', 'saml_uid', 'saml_mail'),
    );
}

/** HTML generation for a configuration variable.
 *
 *  Generates the HTML code for a configuration variable.
 *
 *  @param string   $name       Parameter name.
 *  @param string   $short_desc Short description of the parameter.
 *  @param string   $long_desc  Long description of the parameter.
 *  @param array    $new        Configuration array.
 *
 *  @return string The HTML code.
 */
function saml_acp_line($name, $short_desc, $long_desc, &$new)
{
    global $user;
    return '
        <dl>
            <dt><label for="' . $name . '">' . $user->lang[$short_desc] . ':</label><br/><span>' . $user->lang[$long_desc] . '</span></dt>
            <dd><input type="text" id="' . $name . '" size="40" name="config[' . $name . ']" value="' . $new[$name] . '" /></dd>
        </dl>
        ';
}

/** Reads a SAML attribute.
 *
 *  @param string $attr Attribute name
 *
 *  @return string The attribute value.
 */
function saml_attribute($attr)
{
    $attributes = saml_instance()->getAttributes();
    return $attributes[$attr][0];
}

/** Reads SAML username attribute.
 *
 *  Reads the SAML username attribute using the saml_uid configuration property.
 *
 *  @return string The username.
 */
function saml_username()
{
    return saml_attribute($config['saml_uid']);
}

/** Get the user row.
 *
 *  Reads the user row from the database. If none is found, then returns the $default_row.
 *
 *  @param string $username Username.
 *  @param array $default_row The default row in case no user is found.
 *  @param bool $select_all Whether to retrieve all fields or just a specific subset.
 *
 *  @return array The user row or $default_row if the user does not exists in phpBB.
 */
function saml_user_row($username, $default_row = array(), $select_all = true)
{
    global $db;
    $user_row = $default_row;
    $sql = 'SELECT';
    if ($select_all)
        $sql .= ' *';
    $sql .= ' FROM ' . USERS_TABLE . " WHERE username_clean = '" . $db->sql_escape(utf8_clean_string($username)) . "'";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $db->sql_freeresult($result);

    if ($row)
        $user_row = $row;

    return $user_row;
}

/** Static SimpleSAML_Auth_Simple instance.
 *
 *  Shared instance in the module.
 *
 *  @return SimpleSAML_Auth_Simple SAML service instance.
 */
function saml_instance()
{
    global $config;
    init_saml();
    $saml = new SimpleSAML_Auth_Simple($config['saml_sp']);
    return $saml;
}

/** Authenticate or redirect.
 *
 *  Requires SAML authentication or redirects the user to the SAML login page.
 *  The ReturnTo parameter is set to the 'redirect' value or the current user page.
 */
function saml_auth_or_redirect()
{
    global $user, $phpEx;
    $returnTo = generate_board_url() . '/';
    $returnTo .= request_var('redirect', $user->page['page']);
    saml_instance()->requireAuth(array(
        'ReturnTo' => $returnTo,
    ));
}
