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
 * phpBB SAML auth plug-in. English translation.
 *
 * @package language
 * @version $Id$
 * @copyright (c) 2012 Anelis
 * @author Gregoire Astruc <gregoire.astruc@anelis.org>
 * @licence http://opensource.org/licenses/MIT MIT Licence
 */

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}

$lang = array_merge($lang, array(
    'SAML_NOT_IMPLEMENTED' => 'This functionality is not implemented (yet).',
    'SAML_PATH' => 'SimpleSAMLphp path',
    'SAML_PATH_EXPLAIN' => 'Absolute or relative path to your simpleSAMLphp library.',
    'SAML_SP' => 'SP name for the board.',
    'SAML_SP_EXPLAIN' => 'SAML Service Provider name associated to this board.',
    'SAML_UID' => 'SAML username attribute.',
    'SAML_UID_EXPLAIN' => 'Such as uid, sn, cn, username...',
    'SAML_MAIL' => 'SAML user email attribute.',
    'SAML_MAIL_EXPLAIN' => 'Will fill the user email address upon first login.',

    'SAML_NOT_DIRECTORY' => 'The path you specified is not a directory.',
    'SAML_CANNOT_INCLUDE' => 'Unable to load SimpleSAMLphp library. Did you specify the right directory?',
    'SAML_INVALID_SP' => 'The given SP name is invalid.',
));
?>
