Requirements: 
- Docker 

Notes:
- Stack: Laravel 9, Mysql 8, PHP 8
- Design patterns: Repository Pattern, Service Pattern, and complying with SOLID principle where practically applicable
- Front-end: Using Bootstrap and served using Laravel Livewire. In real-world application, I would use ReactJs library to have Laravel render purely data only

Install:
- unzip rnw.zip
- cd CC/Docker
- docker compose up --build -d nginx mysql
- docker compose exec workspace composer install
- docker-compose exec mysql bash
    - mysql -u root -p < /docker-entrypoint-initdb.d/createdb.sql (password is "root")
- docker compose exec workspace php artisan migrate:refresh --seed
- Open in browser - http://realtimenetworks.localhost:90

Dev Notes:
- running the migration and seeder will take quite some time because the match_stats.csv is being imported.

- Test can be run in console by running:
    - php artisan test

- Importing CSV to Mysql DB
    - some rows referencing to a related table using an ID that does not exist in the related table -  I just assigned null value to that cell of the row
    - additional columns (created_at, updated_at, deleted_at) are added each tables
- Database:
    - I have set some columns to be nullable which in real-world scenario is unnecessary but for this test I had to in order to work around the provided datasets in CSV files. Ex: some player ids in match_stats.csv do not exist in players.csv
    - Match_stats table contains team_id and player_id. Optimally, it should only be player ID (which it already is in the Players table) but I am assuming that this case is possible in the event that the player is transferred to another team and we still want to keep that player's stats from his previous team.


- Cache is implemented using File Driver and applied to the following
    - Redid was initially used but for purpose of conserving hardware resource (memory), I moved it to file-based caching
    - implemented on rarely or almost non-changing datasets
