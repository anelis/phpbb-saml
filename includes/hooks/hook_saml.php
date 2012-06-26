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
 * @package hook
 * @version $Id$
 * @author Gregoire Astruc <gregoire.astruc@anelis.org>
 * @copyright (c) 2012 Anelis
 * @licence http://opensource.org/licenses/MIT MIT Licence
 *
 */

/** SAML template hook.
 *
 *  Detects if a login_box() is about to be displayed.
 *  If so, then we ensure the user is auth'd.
 *
 */
function saml_hook(&$hook, $handle, $include_once = true, $tpl)
{
    global $auth, $user, $phpbb_root_path, $phpEx, $need_auth;
    $result = $hook->previous_hook_result('display');
    if (isset($tpl->_tpldata['jumpbox_forums']) && is_array($tpl->_tpldata['jumpbox_forums'])) {
        saml_auth_or_redirect();
    }
}

/** SAML user session handler.
 *
 *  Handles the case where the user is already auth'd in SAML but phpBB does not know about it.
 *  We force the login and redirect the user transparently back to his/her current page.
 */
function saml_user_handler(&$hook)
{
    global $auth, $user;
    $result = $hook->previous_hook_result('phpbb_user_session_handler');

    /* User auth'd through SAML but phpBB is not yet aware of it... */
    if (!defined('IN_LOGIN') && !$user->data['is_registered'] && saml_instance()->isAuthenticated()) {
        $auth->login('yipi', 'kayee');
        redirect(append_sid("{$phpbb_root_path}" . $user->page['page']));
    }
}

// To avoid conflicts, we only register our hooks if SAML is the current auth method.
if ($config['auth_method'] == 'saml') {
    $phpbb_hook->register(array('template', 'display'), 'saml_hook');
    $phpbb_hook->register('phpbb_user_session_handler', 'saml_user_handler');
}
?>  
