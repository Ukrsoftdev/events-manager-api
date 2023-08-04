<p align="center"><a href="https://ukrsoftdev.github.io/events-manager-api/" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Events Manager API
Events Manager API is a RESTFullAPI application with an expressive, elegant solution that usually uses developers when creating RESTFullAPI applications. Events Manager API provides a structure and starting point for creating real project applications, allowing you to see best practices in web development.

## Deploy and installations
The first step is Clone repository from GitHub. Then run from the command line on the root of the repository.

1. Deploy docker `docker compose build`
2. Run docker `docker compose up -d`
3. Create and configure your `.env` file or use `.env.example` file from the working configuration
4. Enter inside the container `docker exec -it php bash`
   1. From the container run `composer install`
   2. From the container run `php artisan migrate --seed`
   3. From the container run `composer test`, to start tests (phpUnit tests and Psalm code review)

## Run app and usage 

### Docker container
- Run docker `docker compose up -d`
- Enter inside the container `docker exec -it php bash`
- Remove container `docker compose down`

    More information about Docker Compose you find <a href="https://docs.docker.com/compose/">on the official site</a>.

### Run tests
All commands run inside the docker container `docker exec -it php bash`
- Run all tests `composer test`
- Run only phpUnit `composer test:phpunit`
- Run only Psalm code `composer test:psalm` (code review test regarding settings in `./psalm.xml` file)
- Run a specific phpUnit test `php artisan test --filter=EventDeleteRouteTest` (code review test regarding to settings in `./psalm.xml` file)

### OpenAPI Documentation
*All futures of this system and how to use each API route you can find on the* **[OpenAPIdoc page](https://ukrsoftdev.github.io/events-manager-api)**. Swagger is deployed separately from the framework and does not have a local link. You can set it up in the `./docs` directory.

By default, you can use Swagger OpenAPIdoc with two server:
- On the GitHub Pages servers (but correctly handling only GET requests) - URL is [OpenAPIdoc page](https://ukrsoftdev.github.io/events-manager-api)
- After running the Docker container, you can use your local app. (If you use the default config from the `.env.example` file)


## Requirements and definitions for implementations
### 1. Tools and plugins which need to use:
 <table>
  <tr>
    <th>Global dependencies</th>
    <th>Use functionalities</th>
    <th>Use Laravel functionalities</th>
  </tr>
  <tr>
    <td>PHP 8.1+ <br>Postgres <br>Composer <br>Docker <br>Laravel 10+ </td>
    <td>- <b>Authorization</b> throw laravel/sanctum <br>- <b>Code review</b> with psalm/plugin-laravel <br>- <b>Tests</b> with phpunit/phpunit <br>- <b>OpenAPI documentation</b> - with Swagger and deployed throw GitHub Pages</td>
    <td>EloquentModels <br>Scopes <br>Migrations <br>Seeds <br>Factories <br>Controllers <br>Requests <br>Rules <br>Resources</td>
  </tr>  
</table>

### 2. Database tables
Below are the columns that the tables need to have, along with the data types.

#### Organizations table
<table>
  <tr>
    <th>Key</th>
    <th>Data type</th>
  </tr>
  <tr>
    <td>id</td>
    <td>long integer (Primary Key)</td>
  </tr>
  <tr>
    <td>name</td>
    <td>varchar(255)</td>
  </tr>
  <tr>
    <td>email</td>
    <td>varchar(255)</td>
  </tr>
  <tr>
    <td>email_verified_at</td>
    <td>timestamp w/o time zone</td>
  </tr>
  <tr>
    <td>password</td>
    <td>varchar(255)</td>
  </tr>
  <tr>
    <td>remember_token</td>
    <td>varchar(100)</td>
  </tr>
  <tr>
    <td>created_at</td>
    <td>timestamp w/o time zone</td>
  </tr>
  <tr>
    <td>updated_at</td>
    <td>timestamp w/o time zone</td>
  </tr>
</table>

#### Events table
<table>
  <tr>
    <th>Key</th>
    <th>Data type</th>
    <th>Data Integrity and Validation requirements</th>
  </tr>
  <tr>
    <td>id</td>
    <td>long integer (Primary Key)</td>
    <td>- This column cannot be modified.
        <br>- Cannot be null.
        <br>- This column is required.
        <br>- This needs to be an integer.
    </td>    
  </tr>
    <tr>
    <td>event_title</td>
    <td>varchar(200)</td>
    <td>- This column is required
        <br>- Cannot be null.
    </td>
  </tr>
    <tr>
    <td>event_start_date</td>
    <td>timestamp w/o time zone</td>
    <td>- This column is required.
        <br>- Cannot be null.
        <br>- Must be a date/time (I would enforce a format to expect).
        <br>- The value can’t be after the event_end_date column.
    </td>
  </tr>
    <tr>
    <td>event_end_date</td>
    <td>timestamp w/o time zone</td>
    <td>- This column is required.
        <br>- Cannot be null.
        <br>- Must be a date/time (I would enforce a format to expect).
        <br>- The value can’t be before the event_start_date.
        <br>- The duration between the event_start_date and event_end_date cannot exceed 12 hours.
    </td>
  </tr>
    <tr>
    <td>organization_id</td>
    <td>long integer(Foreign Key)</td>
    <td>- This column cannot be modified.
        <br>- This column is required.
        <br>- Cannot be null.
        <br>- This needs to be an integer.
        <br>- Must be one of the records in the authorization table.
    </td>
  </tr>    
</table>

### 3. API Endpoints
- **For all requirements (Request Header, Body, etc.) for each route, you find there** ***[OpenAPIdoc page](https://ukrsoftdev.github.io/events-manager-api)***
- The accepted content-type needs to JSON (Requests and Responses).
- All authorized requests must be with a Bearer token. 
- All requests to change a resource must be validated, to ensure only valid data will be stored in the database.
- All responses for failed requests need to return the correct http status code with a clear message of the problem, in JSON format.

<table>
  <tr>
    <th>Route name</th>
    <th>Short description</th>
    <th>PHPUnite tests for cover routes</th>
  </tr>
  <tr>
    <td>Event list</td>
    <td>List of Events records for a authorized Organization</td>       
    <td>- Returns data related to this token only (organization_id) and all data as an array of JSON objects.</td>
  </tr>
  <tr>
    <td>Event show</td>
    <td>Show a specific Event</td>
    <td>- Returned data in JSON object is similar to data from DB (black box test).</td>
  </tr>
  <tr>
    <td>Event replace</td>
    <td>Allow the ability to replace all data, except those that can’t be modified</td>        
    <td>- After replacing the entry, the data from the database is similar to the input data (black box test).</td>
  </tr>
  <tr>
    <td>Event update</td>
    <td>Allow the ability to update one or more columns, except those that can’t be modified</td>    
    <td>- After updating the entry, the data from the database is similar to the input data (black box test).</td>
  </tr>
  <tr>
    <td>Event delete</td>
    <td>Allow the ability to delete a record</td>
    <td>- After deleting the record, the data is not in the database.</td>
  </tr>
  <tr>
    <td>Organizations list</td>
    <td>List of all organizations in DB, with login and password data that need authorization</td>    
    <td>- The returned data as an array.</td>
  </tr>
  <tr>
    <td>Auth login</td>
    <td>Allow the ability to authorization. Upon successful request, a token is returned to authorize access
    </td>    
    <td>- The returned data is in a JSON object and contains a token.</td>
  </tr>
</table>

### 4. Error Handling
All responses for failed requests need to return the correct HTTP status code with a clear message of the problem, in JSON format. For more information on each route, you find their ***[OpenAPIdoc page](https://ukrsoftdev.github.io/events-manager-api)***.

### 5. Testing
Add basic Feature tests based on the PHPUnit framework. 
Develop tests regarding the list in column 'PHPUnite tests for cover routes', chapter 3. API Endpoints.

### 6. Documenting
Create OpenAPIdoc which describes all routes, and deploy it on GitHub Page.

***Author [Ukrsoftdev](https://github.com/ukrsoftdev)***
