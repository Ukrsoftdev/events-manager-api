<p align="center"><a href="https://ukrsoftdev.github.io/list-organiazation-api/" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Description
This is simple example of Restfull API service, based on the Laravel frameworks. It implements requirements which describe in the "Requirements and definitions for implementations" chapter.

## Deploy
First step is Clone repository from GitHub.Then run from command line on the root of the repository.
1. Deploy docker `docker compose build`
2. Run docker `docker compose up -d`
3. Create and configure your `.env` file or use `.env.example` file from the working configuration
4. Enter inside the container `docker exec -it php bash`
   1. From the container run `composer install`
   2. From the container run `php artisan migrate --seed`
   3. From the container run `composer test`, to start tests (phpUnit tests and Psalm code review)

## Docker
- Run docker `docker compose up -d`
- Enter inside the container `docker exec -it php bash`

## Run tests
All commands run inside the docker container `docker exec -it php bash`
- Run all tests `composer test`
- Run only phpUnit `composer test:phpunit`
- Run only Psalm code `composer test:psalm` (code review test regarding to settings in `./psalm.xml` file)
- Run a specific phpUnit test `php artisan test --filter=EventDeleteRouteTest` (code review test regarding to settings in `./psalm.xml` file)

## OpenAPI Documentation
*All futures of this system and how to use each API Routes you can find on the* **[OpenAPI page](https://ukrsoftdev.github.io/list-organiazation-api)**

## Requirements and definitions for implementations
### 1. Tools and plugins which need to use:
 <table>
  <tr>
    <th>Global dependencies</th>
    <th>Use functionality of the plugin</th>
    <th>Use framework functionalities (Laravel)</th>
  </tr>
  <tr>
    <td>PHP 8.1+ <br>Postgres <br>Composer <br>Docker <br>Laravel 10+ </td>
    <td>- Authorization throw laravel/sanctum <br>- Code review - psalm/plugin-laravel <br>- Tests - phpunit/phpunit <br> <br> <br> </td>
    <td>EloquentModels <br>Scopes <br>Migrations <br>Seeds <br>Factories <br>Controllers <br>Requests <br>Resources</td>
  </tr>  
</table>

### 2. Database
#### Events table:
Below are the columns that the table "events" needs to have, along with the data types.
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
- The accepted content-type needs to JSON (Requests and Responses).
- All authorized requests must be with a Bearer token. 
- All requests to change a resource must be validated, to ensure only valid data will be stored in the database.
- All responses for failed requests need to return the correct http status code with a clear message of the problem, in JSON format.

<table>
  <tr>
    <th>Route name</th>
    <th>Url</th>
    <th>Description</th>
    <th>Error Handling by type errors</th>
    <th>PHPUnite tests for cover routes</th>
  </tr>
  <tr>
    <td>Event list</td>
    <td>GET /api/event/list</td>
    <td>- Authorization access
        <br>- List of records for a specific organization
        <br>- The token will determine what records are available
        <br>- Return all data as an array of JSON objects
    </td>    
    <td>- 401 Unauthorized
        <br>- 404 Entry not found
</td>
    <td>- Returns data related to this token only (organization_id) and all data as an array of JSON objects.</td>
  </tr>
  <tr>
    <td>Event show</td>
    <td>GET /api/event/{id}</td>
    <td>- Authorization access
        <br>- Authorization access
        <br>- Return a specific record
        <br>- Return all data in a JSON object
    </td>    
    <td>- 401 Unauthorized
        <br>- 404 Entry not found</td>
    <td>- Returned data in JSON object is similar to data from DB (black box test).</td>
  </tr>
  <tr>
    <td>Event replace</td>
    <td>PUT /api/event/{id}</td>
    <td>- Authorization access
        <br>- Allow the ability to replace all data, except those that can’t be modified
    </td>    
    <td>- 401 Unauthorized
        <br>- 404 Entry not found
        <br>- 422 Unprocessable object (when input is invalid)
    </td>
    <td>- After replacing the entry, the data from the database is similar to the input data (black box test).</td>
  </tr>
  <tr>
    <td>Event update</td>
    <td>PATCH /api/event/{id}</td>
    <td>- Authorization access
        <br>- Allow the ability to update one or more columns, except those that can’t be modified
    </td>    
    <td>- 401 Unauthorized
        <br>- 404 Entry not found
        <br>- 422 Unprocessable object (when input is invalid)
    </td>
    <td>- After updating the entry, the data from the database is similar to the input data (black box test).</td>
  </tr>
  <tr>
    <td>Event delete</td>
    <td>DELETE /api/event/{id}</td>
    <td>- Authorization access
        <br>- Allow the ability to delete a record
    </td>    
    <td>- 401 Unauthorized
        <br>- 404 Entry not found
    </td>
    <td>- After deleting the record, the data is not in the database.</td>
  </tr>
  <tr>
    <td>Organizations list</td>
    <td>GET /api/organization/list</td>
    <td>- Public access
        <br>- List of all organizations in DB, with login and password data that need authorization
    </td>    
    <td>- 404 Entry not found</td>
    <td>- The returned data as an array.</td>
  </tr>
  <tr>
    <td>User login</td>
    <td>POST /api/user/login</td>
    <td>- Public access
        <br>- Allow the ability to authorization
        <br>- Upon successful request, a token is returned to authorize access
    </td>    
    <td>- 404 Entry not found</td>
    <td>- The returned data is in a JSON object and contains a token.</td>
  </tr>
</table>

***Author [Ukrsoftdev](https://github.com/ukrsoftdev)***
