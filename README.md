AWS Example
===========

About
-----

This repository illustrates an example Amazon AWS deployment script for the
following requirements:

* Deploy CentOS on EC2
* Deploy PostgreSQL database on RDS
* Create an S3 bucket
* Implement load balancing and contingency solution
* Implement AWS session handling for an e-commerce website.

Additionally:

* Provide a network diagram and any additional documentation to describe the
  setup.

Application
-----------

This repository includes a very basic PHP test application, that does the
following:

* Read configuration from `.env` file
* Connect to PostgreSQL database
* Get current database timestamp and print it out

The application can be installed as so:

```
cd app
./bin/composer install
cp .env.example .env
```

From then on, edit and adjust the `.env` file to match your environment.  You
can also run the PHP application locally as:

```
cd webroot
php -S localhost:8000
```

Navigating to [http://localhost:8000](http://localhost:8000) should show an
empty page with the current database timestamp printed out.
