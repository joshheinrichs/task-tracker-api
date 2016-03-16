<?php
use Slim\Http\Request;
use Slim\Http\Response;

include '../models/user.php';
include '../models/project.php';
include '../models/task.php';
include '../models/comment.php';

require '../vendor/autoload.php';

$app = new \Slim\App;

// Users
$app->get('/api/users', function (Request $request, Response $response, $args) {
    $users = User::getAll();
    $response->getBody()->write(json_encode($users));
    return $response;
});
$app->get('/api/users/{name}', function (Request $request, Response $response, $args) {
    $user = User::find($args['name']);
    $response->getBody()->write(json_encode($user));
    return $response;
});
$app->post('/api/users', function (Request $request, Response $response, $args) {
    $body = $request->getParsedBody();
    User::insert($body['name'], $body['email']);
    return $response;
});
$app->put('/api/users/{name}', function (Request $request, Response $response, $args) {
    $body = $request->getParsedBody();
    User::update($args['name'], $body['email']);
    return $response;
});
$app->delete('/api/users/{name}', function (Request $request, Response $response, $args) {
    User::delete($args['name']);
    return $response;
});

// Projects
$app->get('/api/projects', function (Request $request, Response $response, $args) {
    $projects = Project::getAll();
    $response->getBody()->write(json_encode($projects));
    return $response;
});
$app->get('/api/projects/{projectID}', function (Request $request, Response $response, $args) {
    $project = Project::find($args['projectID']);
    $response->getBody()->write(json_encode($project));
    return $response;
});
$app->post('/api/projects', function (Request $request, Response $response, $args) {
    $body = $request->getParsedBody();
    Project::insert($body['name'], $body['user']);
    return $response;
});
$app->put('/api/projects/{projectID}', function (Request $request, Response $response, $args) {
    $body = $request->getParsedBody();
    Project::update($args['projectID'], $body['name']);
    return $response;
});
$app->delete('/api/projects/{projectID}', function (Request $request, Response $response, $args) {
    Project::delete($args['projectID']);
    return $response;
});

// Tasks
$app->get('/api/projects/{projectID}/tasks', function (Request $request, Response $response, $args) {
    $tasks = Task::getAllForProject($args['projectID']);
    $response->getBody()->write(json_encode($tasks));
    return $response;
});
$app->get('/api/projects/{projectID}/tasks/{taskID}', function (Request $request, Response $response, $args) {
    $task = Task::find($args['taskID']);
    $response->getBody()->write(json_encode($task));
    return $response;
});
$app->post('/api/projects/{projectID}/tasks', function (Request $request, Response $response, $args) {
    $body = $request->getParsedBody();
    Task::insert($args['projectID'], $body['user'], $body['title'], $body['description']);
    return $response;
});
$app->put('/api/projects/{projectID}/tasks/{taskID}', function (Request $request, Response $response, $args) {
    $body = $request->getParsedBody();
    Task::update($args['taskID'],  $body['title'], $body['description'], $body['stage']);
    return $response;
});
$app->delete('/api/projects/{projectID}/tasks/{taskID}', function (Request $request, Response $response, $args) {
    Task::delete($args['taskID']);
    return $response;
});

// Comments
$app->get('/api/projects/{projectID}/tasks/{taskID}/comments', function (Request $request, Response $response, $args) {
    $comments = Comment::getAllForTask($args['taskID']);
    $response->getBody()->write(json_encode($comments));
    return $response;
});
$app->post('/api/projects/{projectID}/tasks/{taskID}/comments', function (Request $request, Response $response, $args) {
    $body = $request->getParsedBody();
    Comment::insert($args['taskID'], $body['user'], $body['text']);
    return $response;
});

// Run app
$app->run();
