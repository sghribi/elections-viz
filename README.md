Elections-viz
=============

## Création de la base de données

```
CREATE DATABASE elections ENCODING 'UTF-8';
CREATE USER elections ENCRYPTED PASSWORD 'elections';
GRANT ALL ON DATABASE elections TO elections;
```
