Elections-viz
=============

## Création de la base de données

```
CREATE DATABASE elections ENCODING 'UTF-8';
CREATE USER elections ENCRYPTED PASSWORD 'elections';
GRANT ALL ON DATABASE elections TO elections;
```

## Usage

```
php bin/console doc:sch:drop --full-database --force && php bin/console doc:mig:mig -n && php bin/console import:data
```
