phpBB SAML Authentication plugin
================================

This plugin enables your board users to log in through SAML.

Pre-requisite
-------------

[simpleSAMLphp v1.x](http://simplesamlphp.org/) is required.

Setting it up might be rather complex, depending on your needs.

Installation
------------

In simpleSAMLphp, configure a Service Provider for you phpBB board.

In the metadata, add a RelayState to your board login page.

    $metadata['https://forum.example.com/'] = array(
      /* AssertionConsumer, SSO... */
      'RelayState' => 'https://forum.example.com/ucp.php?mode=login',
    );

This a bit of a hack to trick phpBB into actually doing the authentication and redirects.

Install the phpBB SAML Auth plugin just as any other plugin.

Then in the ACP, under `Authentication`, select _Saml_ and fill in the
related fields according to your setup.

In Case of Emergency
--------------------

If you happened to be locked out of your board, don't panic.

Change the authentication method in the DB table `phpbb3_config` back to db.
Clear phpbb sessions and caches and you should get access to your board again.

Bugs, Ideas and the Like
------------------------

Kindly use the GitHub issue tracker :)
