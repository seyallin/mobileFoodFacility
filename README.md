# Short example for Mobile Doof Facility Permit

## Description

In this task used the database from [data.sfgov.org](https://data.sfgov.org/Economy-and-Community/Mobile-Food-Facility-Permit/rqzj-sfat/data) site.
This solution was selected because the data from the given CSV file and data is not equal. Anyway, the data was indexed by local SOLR platform.
The goal of this example is show us how we can use Solr for searching some places near us. In this example is mobile food facility.
On the home page we see all indexed data from Solr. It is the worst solution, but response from API server is too long and I have limited time for creating entities on internal side.
If we put an address in the input field and after that submit the form, we will show the mobile food places near us at 0.5 km. if we click on the facility title we will go to the description page.

This task was realised by Symfony framework because I had 3 solutions: Drupal, Symfony and Node.JS. The Drupal is not suitable for this kind of tasks. Node.js will take more time for working with SOLR platform, and the choosing was on Symfony.

## Installation and testing
1. Install Symfony CLI. For this we can use official [documentation](https://symfony.com/download#step-1-install-symfony-cli).
2. Install Docker-compose using official [documentation] (https://docs.docker.com/compose/install/).
3. Make a local clone of this repository: `git clone git@github.com:seyallin/mobileFoodFacility.git project_name`
4. Go to the project folder `cd project_name`
4. Run docker container from command: `docker-compose up -d`
5. On this step might need to run the command: `sudo chown 8983 solr/data -R` for the container accessing to the local folder solr/data.
6. Install the symfony project: `composer install`.
7. Run script for creating indexes: `bin/console solr:indexing`
8. Run local server using symfony tool: `symfony server:start`
9. Check the for using address: `2045 EVANS AVE`
10. Checking the Address description by clicking on facility link.
11. Stop server: `symfony server: stop`

## Time Spending
1. Prepare environment: 1h
2. Coding: 2h
3. Testing 0.5h
4. Documentation 0.6h

## Resume

Unfortunately, I wasted the time limits on 3h. The main issue was the development and testing of Solr part because I was stuck on moment when I wouldn't understand why the descriptions not loaded correctly. The reason of this issue was different between CSV file and external database, as result I declined to use CSV file.

## What I want to do if oi have more time.

1. For extending of this example I want cover this project by caching, and testing.
2. Also, I would like to add styles, The front part rebuild to the react Js solution.
3. Migrate data from json to the internal database and do develop the entities related to this data.
4. Extend the search form by filtering fields.
5. Put all configurations to the config folder.

## Short descriptions
1. `src/Comand/SolrIndexing.php` - class for Symfony CLI. Make console command for indexing data to solr side.
2. `src/Controller/HomeController` - controller class for the home page router.
3. `src/Controller/MobileFoodDetaileController` - controller class for the mobile food detail page router.
4. `src/Form/MobileFoodListType.php` - form class for the home page with searching form.
5. `src/Service/GeoApi.php` - GeoApi class for getting geolocation information by address. It is using the free [external API](https://geocode.maps.co/).
6. `src/Service/JsonData.php` - service of working with json data. It was used for getting data from the external data API with JSON format response.
7. `src/Service/MobileFood.php` - service for getting data from external storage [data.sfgov.org](https://data.sfgov.org/Economy-and-Community/Mobile-Food-Facility-Permit/rqzj-sfat/data).
8. `src/Service/Solr.php` - service of working with solr side.
9. `templates/home/index.html.twig` - Home page template.
10. `templates/mobile_food_details/index.html.twig` - Mobile food detail page template.
11. `templates/base.html.twig` - base template that was extended in other templates.

For the Solr working, I used  [PHP Solr Client](https://github.com/solariumphp/solarium) that has good documentation and is easy to work.