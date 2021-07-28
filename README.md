Hexagonal / DDD Skeleton in PHP
==============================

Example project showcasing the implementation of DDD for REST APIs PHP. Using:

* Symfony, using as little as possible
* Tactician CommandBus with Middlewares
* Doctrine, although implementations with just SQL are shown, and you can implement another database of your choice
* OpenAPI for documentation and easily try out the examples

#Project Structure

I built 3 bounded contexts each with their own Application/Domain/Infrastructure organization:
* Security: For user creation and authorization
* Core: Main business login. For this example Movie storage
* Shared: For classes and interfaces which can be used in different bounded contexts, no business login should be conducted here

##Application
* Query: Used for actions to view information
* Command: Used for actions to create/change information
* UseCase: Used for actions that require different "Core" Models (In this example I used Genres and Movies)

##Domain
Domain Models, try to have as much logic as possible

##Infrastructure
* Framework: Everything related to Symfony should be here, such as configuration and the security user
* Domain: Repositories/Views/Hydrators for database persistence and retrieval
* UI: User Interface. Controllers and IO

#Installation
1. execute `docker-compose up -d`
2. Inside the docker container (`docker exec -it 'nameofthecontainer' bash`) create a new database and update the schema
3. The database can be view/interacted on `8080` port, and the api documentation on `9090/api/doc/v1`

_Disclaimer: I made this to have a reference to help me when working with DDD, and as plain practise. But you are welcome if you find it helpful!_


_TODO: DomainEvent Handling_
