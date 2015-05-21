Shuwee
======

Shuwee is (or will be) a backend administration application (yes, one more) for your websites or RESTFUL apps.

Features will include:

- CRUD capabilities
- Nice backend interface
- REST API
- And much more

This is my playground for the development of Shuwee bundles.  This repository nothing more than a working demonstration of all Shuwee bundles. 

Documentation
-------------

See documentation of all bundles separately.

How to install this demo
------------------------

- Checkout
- $ composer install
- $ bin/console doctrine:schema:update --force 
- $ bin/console cache:clear --env=prod 
- $ bin/console assets:install --symlink
- $ bin/console assetic:dump --env=prod
- $ bin/console doctrine:fixtures:load
- $ bin/console shuwee:admin:user:add --roles=ROLE_ADMIN
- Connect to http://your.domain.dev/admin



License
-------

This work is under the MIT license. 

Why "Shuwee" ?
--------------

Shuwee name comes from a Lakota word : čhuwí.  It's defined as the upper back of the body.
