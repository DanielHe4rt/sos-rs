## SOS-RS

<!-- TOC -->
  * [SOS-RS](#sos-rs)
    * [Project Goal](#project-goal)
    * [Prerequisites](#prerequisites)
      * [Contribution Guide](#contribution-guide)
    * [Features](#features)
    * [Tables](#tables)
      * [necessity_type](#necessity_type)
      * [necessity](#necessity)
      * [shelters](#shelters)
      * [shelter_needs](#shelter_needs)
      * [shelter_needs](#shelter_needs-1)
      * [victims](#victims)
      * [victim_emergency_contact](#victim_emergency_contact)
      * [victim_pets](#victim_pets)
<!-- TOC -->

<!-- ![Fluxograma](/.github/images/base-app.jpg) -->

### Project Goal

<!-- tbd -->

### Prerequisites

- [PHP](https://www.php.net/downloads) ^8.2
- [Composer](https://getcomposer.org/)
- [PostgreSQL](https://www.postgresql.org/download/)
- [PostGIS](https://postgis.net/documentation/getting_started/)

#### Contribution Guide

1. Clone the repository

```
git clone https://github.com/DanielHe4rt/sos-rs.git
```

2. Install dependencies

```shell
composer install
npm install
```

3. Copy and prepare .env

```shell
cp .env.example .env
php artisan key:generate
```

4. _(Optional)_ Run [Laravel Sail](https://laravel.com/docs/11.x/sail)

```shell
vendor/bin/sail up -d
# Expose the app behind a SSL certificate, to be able to use the browser API for Navigation
sail share
```

### Features

- localizador de pessoas (geolocalion)

- lista de distruição
- lista de cozinhas comunitárias
- lista de vakinhas verificadas
- lista de abrigos

### Tables

<!-- Please fill out, extend or adjust tables where necessary -->

#### necessity_type
| column | type   | default | nullable |
|--------|--------|---------|----------|
| name   | string |         | n        |
| color  | string |         | n        |

#### necessity
| column  | type   | default | nullable | references     |
|---------|--------|---------|----------|----------------|
| name    | string |         | n        |                |
| type_id | int    |         | n        | necessity_type |

#### shelters
| column                 | type     | default | nullable | references |
|------------------------|----------|---------|----------|------------|
| name                   | string   |         | n        |            |
| neighborhood           | string   |         | n        |            |
| zone                   | enum     |         | n        |            |
| need_volunteers        | bool     |         | n        |            |
| address                | text/geo |         | n        |            |
| donation_key           | string   |         | n        |            |
| contact                | string   |         | n        |            |
| capacity_count         | int      |         | n        |            |
| sheltered_people_count | int      |         | n        |            |

#### shelter_needs
| column     | type | default | nullable | references     |
|------------|------|---------|----------|----------------|
| shelter_id | int  |         | n        | shelters       |
| product_id | int  |         | n        | ???            |
| type_id    | int  |         | n        | necessity_type |

#### shelter_needs
| column     | type | default | nullable | references     |
|------------|------|---------|----------|----------------|
| shelter_id | int  |         | n        | shelters       |
| product_id | int  |         | n        | ???            |
| type_id    | int  |         | n        | necessity_type |

#### victims
| column       | type   | enum values                | default | nullable | references |
|--------------|--------|----------------------------|---------|----------|------------|
| status       | enum   | (danger, rescued, missing) |         | n        |            |
| shelter_id   | int    |                            |         | y        | shelters   |
| name         | string |                            |         | y        |            |
| phone_number | string |                            |         | y        |            |
| location     | string |                            |         | y        |            |
| birthdate    | date   |                            |         | y        |            |
| address      | json   |                            |         | y        |            |
| notes        | text   |                            |         | y        |            |

#### victim_emergency_contact
| column       | type   | enum values | default | nullable | references |
|--------------|--------|-------------|---------|----------|------------|
| victim_id    | int    |             |         | n        | victims    |
| name         | string |             |         | n        |            |
| phone_number | string |             |         | y        |            |
| parenthood   | enum   | (???)       |         | y        |            |

#### victim_pets
| column           | type   | enum values                          | default | nullable | references |
|------------------|--------|--------------------------------------|---------|----------|------------|
| victim_id        | int    |                                      |         | n        | victims    |
| name             | string |                                      |         | n        |            |
| owned            | string |                                      |         | y        |            |
| health_condition | enum   | (healthy, injured, immobile)         |         | y        |            |
| size             | enum   | (tiny, small, middle, large)         |         | y        |            |
| type             | enum   | (dog, cat, bird, rat, ferret, snake) |         |          |            |
