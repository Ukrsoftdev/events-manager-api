<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Description
This is simple example of Restfull API service, based on the Laravel frameworks. It implements requirements which describe in the "Requirements and definitions for implementations" chapter.

## Deploy
First step is Clone repository from Github.

Then run from command line on the PHP Server.
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

## Futures and how to use
### 1. Look at list Organizations

***Route:*** `GET /api/organization/list`

***Example Request:***

`GET /api/organization/list HTTP/1.1
Host: localhost:8001
Accept: application/json` 

And from the response get login ("email" fields) and password ("password" fields) data that need authorization.

***Example Response:***

`[
{
"OrganizationId": 1,
"OrganizationName": "Little, McClure and Ebert",
"email": "dgoyette@kunze.com",
"password": "password",
"countEvents": 0
},
{
"OrganizationId": 2,
"OrganizationName": "Ward-West",
"email": "mueller.elaina@pfannerstill.net",
"password": "password",
"countEvents": 7
},
{
"OrganizationId": 3,
"OrganizationName": "Bernhard, Haley and Gulgowski",
"email": "thiel.kellen@cole.org",
"password": "password",
"countEvents": 15
}]`

### 2. Authorization 
Send request with login and password data and get token from response.

***Route:*** `POST /api/user/login`

***Example Request:***

`POST /api/user/login HTTP/1.1 Host: localhost:8001
Accept: application/json
Content-Type: application/json
Content-Length: 66
{
"email":"dgoyette@kunze.com",
"password":"password"
}`

***Example Response:***

`{
"accessToken": {
"name": "dgoyette@kunze.com",
"abilities": [
"*"
],
"expires_at": null,
"tokenable_id": 1,
"tokenable_type": "App\\Models\\Organization",
"updated_at": "2023-07-27T13:20:42.000000Z",
"created_at": "2023-07-27T13:20:42.000000Z",
"id": 191
},
"plainTextToken": "191|V8vpByaurdnZblkahHFRgshdc0dCf8i9nmeTXx80"
}`
### 3. List of events records for a specific organization
***Route:*** `GET /api/event/list`

***Example Request:*** `GET /api/event/list HTTP/1.1
Host: localhost:8001
Accept: application/json
Authorization: Bearer 84|GszUVRVdQvkMUEgBjbol0MTDnj4rxUJcLkxjQBlt`

***Example Response:*** `[
{
"id": 76,
"event_title": "Fuga sequi aliquid voluptatem iusto esse beatae.",
"event_start_date": "2024-05-25 03:35:49",
"event_end_date": "2024-05-25 07:09:50",
"organization_id": 6
},
{
"id": 77,
"event_title": "Et cupiditate modi labore non.",
"event_start_date": "2024-01-01 05:51:15",
"event_end_date": "2024-01-01 16:02:51",
"organization_id": 6
},
{
"id": 78,
"event_title": "Ea alias delectus blanditiis quia.",
"event_start_date": "2023-12-20 04:04:24",
"event_end_date": "2023-12-20 06:45:13",
"organization_id": 6
},
{
"id": 79,
"event_title": "Dolorem sint aut repellat sit cumque.",
"event_start_date": "2023-12-25 10:02:23",
"event_end_date": "2023-12-25 12:20:23",
"organization_id": 6
}`

### 4. Return a specific event
***Route:*** `GET /api/event/{id}`

***Example Request:***
`GET /api/event/78 HTTP/1.1
Host: localhost:8001
Accept: application/json
Authorization: Bearer 192|WQiGm1DrX9scjTq5mvCyso3J4mpEpkUYuE5ypjuf`

***Example Response:*** `{
"id": 78,
"event_title": "Ea alias delectus blanditiis quia.",
"event_start_date": "2023-12-20 04:04:24",
"event_end_date": "2023-12-20 06:45:13",
"organization_id": 6
}`

### 5. Replace all data in a specific event
***Route:*** `PUT /api/event/{id}`

***Example Request:*** `PUT /api/event/78 HTTP/1.1
Host: localhost:8001
Accept: application/json
Content-Type: application/json
Authorization: Bearer 192|WQiGm1DrX9scjTq5mvCyso3J4mpEpkUYuE5ypjuf
Content-Length: 137
{
"event_title":"event_title title",
"event_start_date": "2023-08-18 09:04:38",
"event_end_date": "2023-08-18 12:45:52"
}`

***Example Response:*** `Status code 204 No content`

### 6. Update one or more columns in a specific event
***Route:*** `PATCH /api/event/{id}`

***Example Request:*** `PATCH /api/event/78 HTTP/1.1
Host: localhost:8001
Accept: application/json
Content-Type: application/json
Authorization: Bearer 192|WQiGm1DrX9scjTq5mvCyso3J4mpEpkUYuE5ypjuf
Content-Length: 49
{
"event_end_date": "2023-08-18 14:45:52"
}`

***Example Response:*** `Status code 204 No content`

### 7. Delete a specific event
***Route:*** `DELETE /api/event/{id}`

***Example Request:*** `DELETE /api/event/78 HTTP/1.1
Host: localhost:8001
Accept: application/json
Authorization: Bearer 192|WQiGm1DrX9scjTq5mvCyso3J4mpEpkUYuE5ypjuf`

***Example Response:*** `Status code 204 No content`

# Requirements and definitions for implementations
### 1. Tools and plugins which need to use:
- PHP 8.1, Postgres
- Composer, Git, Docker
- Laravel 10, Sanctum, psalm/plugin-laravel
 

### 2. Database
***Use migrations*** files to create an authorization table and a table called "events".

***Use Seeders and Factories*** to populate the database.

Below are the columns that the table "events" needs to have, along with the data types.

#### Columns Name Datatype "events" table:
- ***id*** long integer (Primary Key)
- ***event_title*** varchar(200)
- ***event_start_date*** timestamp w/o time zone
- ***event_end_date*** timestamp w/o time zone
- ***organization_id*** long integer (Foreign Key). The value in the organization_id column will need to be associated with a record in the
authorization table (One-To-Many relationship).

#### Data Integrity and Validation requirements
- id
  - This column cannot be modified.
  - Cannot be null.
  - This column is required.
  - This needs to be an integer.
- event_title
  - This column is required
  - Cannot be null.
- event_start_date
  - This column is required.
  - Cannot be null.
  - Must be a date/time (I would enforce a format to expect).
  - The value can’t be after the event_end_date column.
- event_start_date
  - This column is required.
  - Cannot be null.
  - Must be a date/time (I would enforce a format to expect).
  - The value can’t be before the event_start_date.
  - The duration between the event_start_date and event_end_date cannot exceed 12 hours.
- organization_id
  - This column cannot be modified.
  - This column is required.
  - Cannot be null.
  - This needs to be an integer.
  - Must be one of the records in the authorization table.

### 3. API Endpoints
- The accepted content-type needs to JSON (Requests and Responses).
- All authorized requests must be with a Bearer token. 
- All requests to change a resource must be validated, to ensure only valid data will be stored in the database.

1. *GET /api/event/list*
- Authorization access
- List of records for a specific organization
- The token will determine what records are available
- Return all data as an array of JSON objects
2. *GET /api/event/{id}*
- Authorization access
- Return a specific record
- Return all data in a JSON object
3. *PUT /api/event/{id}*
- Authorization access
- Allow the ability to replace all data, except those that can’t be modified
4. *PATCH /api/event/{id}*
- Authorization access
- Allow the ability to update one or more columns, except those that can’t be modified
5. *DELETE /api/event/{id}*
- Authorization access
- Allow the ability to delete a record
6. *GET /api/organization/list*
- Public access
- List of all organizations in DB, with login and password data that need authorization
7. *POST /api/user/login*
- Public access
- Allow the ability to login in the system 
- Upon successful request, a token is returned to authorize access

### 4. Error Handling

All responses for failed requests need to return the correct http status code with a clear message of the problem, in JSON format.

**List routes with type errors:**
1. *GET /api/event/list*
- 401 Unauthorized
2. *GET /api/event/{id}:*
- 401 Unauthorized, 404 Entry not found
2. *PUT /api/event/{id}:*
- 401 Unauthorized, 404 Entry not found, 422 Unprocessable object (when input is invalid)
3. *PATCH /api/event/{id}:*
- 401 Unauthorized, 404 Entry not found, 422 Unprocessable object (when input is invalid)
4. *DELETE /api/event/{id}:*
- 401 Unauthorized, 404 Entry not found, 422 Unprocessable object (when input is invalid)
6. *GET /api/organization/list*
- 404 Entry not found
7. *POST /api/user/login*
- 404 Entry not found

### 5. Testing 
***Use PHPUnite*** tests for cover routes:
1. *GET /api/event/list:*
- Returns data related to this token only (organization_id) and all data as an array of JSON objects.
2. *GET /api/event/{id}:*
- Returned data in JSON object is similar to data from DB (black box test).
3. *PUT /api/event/{id}:*
- After replacing the entry, the data from the database is similar to the input data (black box test).
4. *PATCH /api/event/{id}:*
- After updating the entry, the data from the database is similar to the input data (black box test).
5. *DELETE /api/event/{id}:*
- After deleting the record, the data is not in the database.
6. *GET /api/organization/list*
- The returned data as an array.
7. *POST /api/user/login*
- The returned data is in a JSON object and contains a token.

***Author [Ukrsoftdev](https://github.com/ukrsoftdev)***
