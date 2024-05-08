## SOS-RS


![Fluxograma](/.github/images/base-app.jpg)

Up and running
```
composer install
cp .env.example .env
php artisan key:generate
vendor/bin/sail up -d
# Expose the app behind a SSL certificate, to be able to use the browser API for Navigation
sail share
```


### Anotações

features:

- localizador de pessoas (geolocalion)

- lista de distruição
- lista de cozinhas comunitárias
- lista de vakinhas verificadas
- lista de abrigos

necessity_type:
- name: string
- color: string

necessity:
- name: string
- type_id: int references necessity_type



shelters:

- name: string
- neighborhood: string
- zone: enunm
- need_volunteers: bool
- address: text/geo
- donation_key: string
- contact: string
- capacity_count: int
- sheltered_people_count


shelter_needs:

- shelter_id: int
- product_id: int
- type_id: int


victims:

- type_id: enum (danger, rescued, missed)
- shelter_id: int (nullable)
- location:
- name:
- phone_number:
- birthdate: date
- address: json
- notes: text


victim_emergency_contact:
- victim_id: int
- name:
- phone_number:
- parenthood: enum

victim_pets:
- victim_id:
- name: string (?)
- owned: bool
- health_condition: enum
- size: enum
- type: enum

