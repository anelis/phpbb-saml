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
 * phpBB SAML auth plug-in. French translation.
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
    'SAML_NOT_IMPLEMENTED' => 'Cette fonctionnalite SAML n\'est pas encore implementee',
    'SAML_PATH' => 'Chemin vers SimpleSAMLphp',
    'SAML_PATH_EXPLAIN' => 'Chemin (relatif ou absolu) vers votre installation de simpleSAMLphp',
    'SAML_SP' => 'Nom du SP pour ce forum',
    'SAML_SP_EXPLAIN' => 'Nom du Service Provider associe a ce forum',
    'SAML_UID' => 'Attribut SAML correspondant aux noms d\'utilisateur.',
    'SAML_UID_EXPLAIN' => 'Cet attribut prend souvent le nom uid, sn, ...',
    'SAML_MAIL' => 'Attribut SAML pour l\'adresse e-mail.',
    'SAML_MAIL_EXPLAIN' => 'Cet attribut permettra de remplir le mail a la premiere connexion des utilisateurs.',

    'SAML_NOT_DIRECTORY' => 'Le chemin que vous avez specifie n\'est pas un repertoire.',
    'SAML_CANNOT_INCLUDE' => 'Impossible d\'include la librairie SimpleSAMLphp. Avez-vous indique le bon repertoire ?',
    'SAML_INVALID_SP' => 'Le SP fourni est invalide.',
));
?>
