# Family Tree

A self-hosted family tree software working with a GEDCOM file.

## Setup

- Docker must be installed
- Navigate to the project folder
- Run `./vendor/bin/sail up -d` to start the docker container
- Run `./vendor/bin/sail artisan migrate` to create database tables
- Build the frontend with `./vendor/bin/sail npm run build`
