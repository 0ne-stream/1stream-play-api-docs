# Swagger/OpenAPI Setup Guide

This guide explains how to view and use the OpenAPI/Swagger documentation.

## Viewing the Documentation

### Option 1: Swagger UI (Online)

1. Go to [Swagger Editor](https://editor.swagger.io/)
2. Click "File" → "Import file"
3. Select `openapi.yaml` from this repository
4. The documentation will be displayed in an interactive format

### Option 2: Swagger UI (Local)

#### Using Docker

```bash
docker run -p 8080:8080 -e SWAGGER_JSON=/openapi.yaml -v $(pwd)/openapi.yaml:/openapi.yaml swaggerapi/swagger-ui
```

Then open http://localhost:8080 in your browser.

#### Using Node.js

1. Install Swagger UI:
```bash
npm install -g swagger-ui-serve
```

2. Serve the OpenAPI spec:
```bash
swagger-ui-serve openapi.yaml
```

3. Open the URL shown in the terminal (usually http://localhost:3000)

### Option 3: Redoc

Redoc provides a beautiful, responsive documentation interface.

#### Using Docker

```bash
docker run -p 8080:80 -v $(pwd)/openapi.yaml:/usr/share/nginx/html/openapi.yaml -e SPEC_URL=openapi.yaml redocly/redoc
```

Then open http://localhost:8080 in your browser.

#### Using Node.js

1. Install Redoc CLI:
```bash
npm install -g redoc-cli
```

2. Serve the documentation:
```bash
redoc-cli serve openapi.yaml
```

3. Open http://localhost:8080 in your browser

### Option 4: Postman

1. Open Postman
2. Click "Import"
3. Select "File" and choose `openapi.yaml`
4. Postman will create a collection with all endpoints

## Using the API

### Testing with Swagger UI

1. Open Swagger UI (using one of the methods above)
2. Click "Authorize" button at the top
3. Enter your Bearer token (obtained from `/auth` endpoint)
4. Click "Authorize"
5. Now you can test all endpoints directly from the UI

### Testing with cURL

See the README.md for detailed cURL examples.

### Testing with Code Examples

See the PHP code examples in the [README.md](../README.md) file.

## Generating Client SDKs

### Using OpenAPI Generator

1. Install OpenAPI Generator:
```bash
npm install -g @openapitools/openapi-generator-cli
```

2. Generate a client (example for Python):
```bash
openapi-generator-cli generate -i openapi.yaml -g python -o ./generated/python-client
```

3. Generate a client (example for JavaScript):
```bash
openapi-generator-cli generate -i openapi.yaml -g javascript -o ./generated/javascript-client
```

Supported languages include:
- Python
- JavaScript/TypeScript
- Java
- PHP
- Go
- Ruby
- C#
- And many more...

See [OpenAPI Generator](https://openapi-generator.tech/) for the full list.

## Validating the OpenAPI Spec

### Using Swagger Validator

1. Go to [Swagger Validator](https://validator.swagger.io/)
2. Paste the contents of `openapi.yaml` or upload the file
3. Check for any validation errors

### Using Command Line

```bash
npm install -g swagger-cli
swagger-cli validate openapi.yaml
```

## Updating the Documentation

When updating the API documentation:

1. Edit `openapi.yaml` following the OpenAPI 3.0.3 specification
2. Validate the changes using one of the methods above
3. Update `README.md` if needed
4. Test the changes in Swagger UI
5. Commit and push the changes

## Additional Resources

- [OpenAPI Specification](https://swagger.io/specification/)
- [Swagger UI Documentation](https://swagger.io/tools/swagger-ui/)
- [Redoc Documentation](https://github.com/redocly/redoc)

