## SOS-RS

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
