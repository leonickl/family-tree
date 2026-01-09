# Family Tree

> [!WARNING]
> The tree import is unstable as it does not support all GEDCOM fields.
> The original file will be untouched, but not all data  might be transferred
> into the database.

This project allows you to run a web-app where you can view and manage your family tree.

## Installation

- Install PHP 8.4 and Composer
- Clone this repository: `git clone https://https://github.com/leonickl/family-tree`
- Install dependencies with `composer install`

## Setup

- Copy a GEDCOM file with your family tree to `database/trees/<tree-name>.ged`
- Run `./run convert <tree-name>` to convert the GEDCOM file to a JSON-based format, which will be stored next to the original file.
- Run `./run migrate` to initialize the database.
- Run `./run import <tree-name>` to import the converted tree into the database.
  Not all fields will be transferred here; please see `src/App/Importer.php` for more details.
- Create a user by running `./run create-user <username> <password>`. This will initialize the environment file `.env`
- Run the app with `./run server` and open the shown URL in your browser.

## Re-identify and Merge trees

When merging multiple GEDCOM files (e.g., from different parts of a family), some people/families can have the same identifiers.
To re-identify all people, families, sources, ..., run `./run reidentify <tree.name> <postfix>`. The postfix will be added behind
the newly generated identifiers of all entities in a file. This can be any string, like "a" for the first, and "b" for the second tree
to be merged. Then, manually copy all people, families, sources, and other entities from one file to the corresponding section of the other one.
