# dependency.me - An Amazing Project

Service to check statuses of composer's dependencies, hosted on http://dependency.me .

## Installation

1.  Clone this project

2. Configure the database information

    ```
    # Apache :
    SetEnv          SYMFONY__DATABASE__USER yourUsername
    SetEnv          SYMFONY__DATABASE__PASSWORD yourPassword
    ```

    ```
    # cli
    export SYMFONY__DATABASE__USER=yourUsername
    export SYMFONY__DATABASE__PASSWORD=yourPassword
    ```

3.  update dependencies

    ```
    ./composer.phar update --dev
    ```

4.  Install the database

    ```bash
    ./app/console doctrine:schema:drop
    ./app/console doctrine:schema:create
    ./app/console doctrine:schema:update --force
    ./app/console doctrine:fixtures:load
    ```
## Usage

add the following commands to your crontab :

    ; Update statuses
    ; hal:release:declarations:update <number-to-update> <date>
    hal:release:declarations:update 100 yesterday

    ; Update the packages
    ; hal:release:packages:update <number-to-update> <date>
    hal:release:packages:update 100 today


### Licence

Licence [Affero GPL](http://www.gnu.org/licenses/why-affero-gpl.html)
(Symfony 2 (MIT Licence) is used)
