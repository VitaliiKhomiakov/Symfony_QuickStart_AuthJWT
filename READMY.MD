# Symfony 5 - Quick Start AUTH JWT (Login and Registration)
Used materials from open sources

Based on: LexikJWTAuthenticationBundle

## Commands:
Generate ssl keys:
 - $ mkdir -p config/jwt
 - $ openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
 - $ openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
 
Don't forget about secret key

Generate Entities From DataBases
php bin/console doctrine:mapping:import "App\Entity" annotation --path=src/Entity

Generate DataBases From Entities
./bin/console make:migration
./bin/console doctrine:migrations:migrate
