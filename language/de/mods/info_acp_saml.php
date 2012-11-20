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
    'SAML_NOT_IMPLEMENTED' => 'SAML wurde noch nicht implementiert.',
    'SAML_PATH' => 'SimpleSAMLphp Pfad',
    'SAML_PATH_EXPLAIN' => 'Absoluter oder Relativer Pfad zu der simpleSAMLphp Installation.',
    'SAML_SP' => 'Genutzter SP.',
    'SAML_SP_EXPLAIN' => 'SAML Service Provider, den das Board nutzt.',
    'SAML_UID' => 'SAML Benutzernamen Attribut.',
    'SAML_UID_EXPLAIN' => 'Gibt Benutzernamen an. Bsp: uid, sn, cn, username, eduPerson...',
    'SAML_MAIL' => 'SAML EMail Attribut.',
    'SAML_MAIL_EXPLAIN' => 'Setzt die EMail-Adresse des Nutzers bei der ersten Anmeldung.',

    'SAML_NOT_DIRECTORY' => 'Der angegebene Pfad ist kein gültiges Verzeichnis.',
    'SAML_CANNOT_INCLUDE' => 'Kann simpleSAMLphp Installation nicht finden. Ist der Pfad korrekt angegeben?',
    'SAML_INVALID_SP' => 'Der Name des SP ist ungültig.',
));
?>
