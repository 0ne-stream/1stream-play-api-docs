# Quick Start Guide

This guide will help you get started with the B2C Player API quickly.

## Files in This Repository

- **README.md** - Comprehensive API documentation with all endpoints, parameters, and examples
- **openapi.yaml** - OpenAPI 3.0.3 specification (Swagger-compatible)
- **SWAGGER_SETUP.md** - Guide for viewing and using the Swagger documentation

## Quick Start Steps

### 1. Authenticate

First, obtain an authentication token:

```bash
curl -X POST "https://api.example.com/play/b2c/v1/auth" \
  -H "Content-Type: application/json" \
  -d '{"username":"your_username","password":"your_password"}'
```

Save the `auth_token` from the response.

### 2. Make Your First Request

Use the token to fetch content:

```bash
TOKEN="your_auth_token_here"
curl -X GET "https://api.example.com/play/b2c/v1/content/vod" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json"
```

### 3. View Interactive Documentation

1. Go to [Swagger Editor](https://editor.swagger.io/)
2. Import `openapi.yaml`
3. Click "Authorize" and enter your token
4. Test endpoints directly from the UI

## Key Features to Know

### Feed Mode (Performance Optimization)

For applications using the API as a feed (not needing immediate play links):

```bash
# Disable links for better performance
curl -X GET "https://api.example.com/play/b2c/v1/content/vod?with_links=0" \
  -H "Authorization: Bearer $TOKEN"
```

### Incremental Updates

Fetch only updated content:

```bash
# Get content updated after a specific date
curl -X GET "https://api.example.com/play/b2c/v1/content/vod?updated_at_gt=2025-12-01T00:00:00Z" \
  -H "Authorization: Bearer $TOKEN"
```

### Caching Optimization

Use bouquet key for nginx-level caching:

```bash
# First, get the bouquet key
curl -X GET "https://api.example.com/play/b2c/v1/content-info/hashes" \
  -H "Authorization: Bearer $TOKEN"

# Then use it with with_links=0
curl -X GET "https://api.example.com/play/b2c/v1/content/vod?with_links=0&bkey=YOUR_BOUQUET_KEY" \
  -H "Authorization: Bearer $TOKEN"
```

## Available Endpoints

- **POST** `/auth` - Authenticate and get token
- **GET** `/content/live` - Get live streaming channels
- **GET** `/content/vod` - Get movies/VOD content
- **GET** `/content/vod/{id}` - Get movie details
- **GET** `/content/series` - Get TV series
- **GET** `/content/series/{id}` - Get series details with episodes
- **GET** `/content-info/hashes` - Get content hashes and timestamps
- **GET** `/links/{stream}` - Get play links for a stream
- **GET** `/notifications` - Get notifications

## Next Steps

1. Read the full [README.md](README.md) for detailed documentation
2. Check out the PHP example in [examples/php_example.php](examples/php_example.php)
3. Check out [SWAGGER_SETUP.md](SWAGGER_SETUP.md) for viewing interactive docs
4. Use the [openapi.yaml](openapi.yaml) to generate client SDKs

## Need Help?

- Review the comprehensive documentation in `README.md`
- Check the PHP code example in `examples/php_example.php`
- View the interactive Swagger documentation
- Contact API support for additional assistance

