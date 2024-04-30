# MM Controller

This project is designed to store and change a microcontroller's state while providing an API for it to interact with a database.

## Features

- Store and retrieve the microcontroller's state in the database.
- Change the microcontroller's state through the provided API.
- Interact with the microcontroller's state using various endpoints.


## Usage

1. Set database connection info in db_credentials.php
2. Start the server.
3. Access the API endpoints to interact with the microcontroller's state.

## API Endpoints

- GET ALL - /api/api.php
- GET ONE - /api/api.php?operation=get&id={id}
- CREATE - /api/api.php?operation=create&name={name}&state={state}
- UPDATE - /api/api.php?operation=update&id={id}&name={name}&state={state}
- DELETE - /api/api.php?operation=delete&id={id}