# task-tracker-api

A simple task tracker API built using [LAMP](https://en.wikipedia.org/wiki/LAMP_(software_bundle)) and [Slim](http://www.slimframework.com/), inspired by Atlassian JIRA. This was built in a day for my CMPT 350 course, and likely won't be extended.

### users
Method | URI | Description | Request Body
-------|-------|-------|-------
GET    | `/api/users` | Returns the user info for all users in the database.
GET    | `/api/users/{name}` | Return the user info for the user with the name `{name}`.
POST   | `/api/users` | Adds the given user, assuming a user with that name does not already exist. | `{"name": "foo", "email": "bar"}`
PUT    | `/api/users/{name}` | Edits the information for the user with the name `{name}`. | `{"email": "foo"}`
DELETE | `/api/users/{name}` | Deletes the user with name `{name}`.      

### projects
Method | URI | Description | Request Body
-------|-------|-------|-------
GET    | `/api/projects` | Returns the project info for all projects in the database.
GET    | `/api/projects/{projectID}` | Returns the project info for the project with the ID `{projectID}`
POST   | `/api/projects` | Adds the given project to the database assuming that a user with the give name exists. | `{"name": "foo", "user": "bar"}`
PUT    | `/api/projects/{projectID}` | Edits the project with the ID `{projectID}`. | `{"name": "foo"}`
DELETE | `/api/projects/{projectID}`| Deltes the project with the ID `{projectID}`.

### tasks
Method | URI | Description | Request Body
-------|-------|-------|-------
GET    | `/api/projects/{projectID}/tasks` | Returns all of the tasks for the project with the ID `{projectID}`.
GET    | `/api/projects/{projectID}/tasks/{taskID}` | Returns the task with ID `{taskID}`.
POST   | `/api/projects/{projectID}/tasks` | Adds the given task to the database assuming that a project with ID `{projectID}` exists, and a user with the given name exists. | `{"user": "foo", "title": "bar", "description": "baz"}`
PUT    | `/api/projects/{projectID}/tasks/{taskID}` | Edits the task with the ID `{taskID}`. Stage should be one of the following values: `"to do"`, `"in progress"`, `"in review"`, `"done"` | `{"title": "bar", "description": "baz" "stage": "to do"}`
DELETE | `/api/projects/{projectID}/tasks/{taskID}` | Deletes the task with the ID `{taskID}`.

### comments
Method | URI | Description | Request Body
-------|-------|-------|-------
GET    | `/api/projects/{projectID}/tasks/{taskID}/comments` | Returns all of the comments for the task with the ID `{taskID}`.
POST   | `/api/projects/{projectID}/tasks/{taskID}/comments` | Adds the given comment to the database assuming that a task with ID `{taskID}` and a user with the given name exists. | `{"user": "foo", "text": "bar"}`
