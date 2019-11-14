**`Test REST API symfony 4.3 project`**
============


**`Instaliation`**
------------
* [Install this project][1] with Composer.
* Do ``git clone https://github.com/kinderis/pk_sym43.git`` or download project from this [repociroty][2]
* When cloning is done - enter project's directory with ``cd pk_sym43``
* Install dependencies with ``composer install``
* Copy `.env.test` file as `.env.local`. Edit newly copied `.env.local` file and fill it with proper configuration options. You can read more on .env files [at symfony docs][3].
* Edit database connection information in .env file.
* Create DB schema ``./c doctrine:database:create``
* Run database migrations with ``./c doctrine:migrations:migrate``

**`Allowed API endpoints`**
------------
* ``/auth/tokens``
* ``/api/createTransaction`` (require authorization)
* ``/api/createTransaction`` (require authorization)

**`Authorization`**
------------
* Authorization type - "Bearer Token

Generate the SSH keys:

* mkdir -p config/jwt
* openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
* openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout

Copy configuration security.yaml.example from root dir into config/packages/ and rename security.yaml

Configure the SSH keys path in your config/packages/lexik_jwt_authentication.yaml

Detail configuring [LexikJWTAuthenticationBundle][4]

Default authorization credentials:
* username - root@example.com
* password - pkRoot0

Authorization with GET method.

Example (JSON):
``{
  	"username":" username  ",
  	"password":" passwd  "
  }
``

**`Run project`**
------------
* Run project - ``./c server:run``

**`Run test`**
------------
* Run all test - ``./t``


[1]: https://github.com/kinderis/pk_sym43
[2]: https://github.com/kinderis/pk_sym43/archive/master.zip
[3]: https://symfony.com/doc/current/components/dotenv.html
[4]: https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md#installation