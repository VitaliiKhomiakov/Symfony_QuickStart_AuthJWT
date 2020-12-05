# Symfony 5 - Quick Start AUTH JWT (Login and Registration)
Used materials from open sources

- Create Access and Refresh tokens
- Validator example
- Repository example
- Added error output for json response

Based on: 
 - LexikJWTAuthenticationBundle
 - JWTRefreshTokenBundle

## Commands:
Generate ssl keys:
 - $ mkdir -p config/jwt
 - $ openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
 - $ openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
 
Don't forget about secret key
Put pass phrase in config/packages/lexik_jwt_authentication.yaml

Database configuration in .env file in base directory

Generate DataBases And Tables
- php bin/console doctrine:database:create
- php bin/console doctrine:migrations:migrate

Start 
- symfony server:start


## Using

#### SignUp
POST http://127.0.0.1:8000/auth/login
{"email": "email", "password": "password", "confirmPassword": "confirmPassword"}

#### Login - get access and refresh token
POST http://127.0.0.1:8000/auth/sign-up
{"email": "email", "password": "password"}

#### Refresh Token
POST http://127.0.0.1:8000/auth/refresh
{"refresh_token": "refresh_token"}

#### Get User
GET http://127.0.0.1:8000/core/user
Set Header - Authorization: 'access token'

#### Admin Role Test
PATCH http://127.0.0.1:8000/core/user
Set Header - Authorization: 'access token'

Update your user - UPDATE `user` SET `roles` = '[\"ROLE_ADMIN\"]' WHERE `user`.`id` = <ID>;
