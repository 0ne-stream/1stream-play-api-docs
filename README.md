# B2C Player API Documentation

Welcome to the B2C Player API documentation. This document provides comprehensive information about integrating with our streaming content API.

## Table of Contents

- [Getting Started](#getting-started)
- [Authentication](#authentication)
- [Base URL](#base-url)
- [Endpoints](#endpoints)
  - [Authentication](#authentication-endpoint)
  - [Content Endpoints](#content-endpoints)
  - [Content Info](#content-info)
  - [Links](#links)
  - [Notifications](#notifications)
- [Query Parameters](#query-parameters)
- [Response Format](#response-format)
- [Error Handling](#error-handling)
- [Performance Optimization](#performance-optimization)
- [Code Examples](#code-examples)

## Getting Started

### Prerequisites

- API credentials (username and password)
- HTTP client capable of making JSON requests
- Bearer token authentication support

### Quick Start

1. **Authenticate** to obtain an `auth_token`:
   ```bash
   POST /play/b2c/v1/auth
   ```

2. **Use the token** in subsequent requests via `Authorization: Bearer <token>` header

3. **Fetch content** from available endpoints

## Authentication

### Authentication Endpoint

**POST** `/play/b2c/v1/auth`

Obtain an authentication token using your username and password. The token does not expire and can be reused for all subsequent requests.

#### Request Body

```json
{
  "username": "your_username",
  "password": "your_password"
}
```

#### Response

```json
{
  "auth_token": "eyJpdiI6InNkcUp0RnhlN3oxbUFsbWpLNFVnbHc9PSIsInZhbHVlIjoia3hJa2NuKys3VDdkc2FaeHY1dVc1U3dFYXh5bi9XeFZLMzZQZnlVUzU0QT0iLCJtYWMiOiI2YmEwMDM3MGU3ZGZmNTVmMTYwZjQ4MDI3ZjgwZmYzOGQ4OWI2YzFhMDg0YWY1MDZkMjEyMmU2NDEzZjlkYzNiIiwidGFnIjoiIn0=",
  "exp": null
}
```

#### Usage

Include the token in all subsequent API requests using the `Authorization` header:

```
Authorization: Bearer <auth_token>
```

## Base URL

The base URL for the API will be provided by your API provider. The examples in this documentation use:

```
https://api.example.com/play/b2c/v1
```

**Note:** Replace `api.example.com` with the actual API endpoint provided to you.

## Endpoints

### Categories Endpoints

Use these endpoints to fetch category lists for live, VOD, series, and radio content. Each response includes `content` (array of categories) and `cache.bouquets_key`.

- **GET** `/play/b2c/v1/categories/live`
- **GET** `/play/b2c/v1/categories/vod`
- **GET** `/play/b2c/v1/categories/series`
- **GET** `/play/b2c/v1/categories/radio`

**Response Example (categories/live):**
```json
{
  "content": [
    {
      "category_id": "3",
      "category_name": "Sport",
      "category_icon": null,
      "parent_id": 0
    },
    {
      "category_id": "2",
      "category_name": "Movies",
      "category_icon": null,
      "parent_id": 0
    }
  ],
  "cache": {
    "bouquets_key": "ddf1c4f590c692189ca0230e28f0357c"
  }
}
```

### Content Endpoints

All content endpoints support pagination and optional query parameters for filtering and optimization. You can filter by `category_id` and adjust ordering using `order_by`.

#### Get Live Content

**GET** `/play/b2c/v1/content/live`

Retrieve a list of live streaming channels.

**Query Parameters:**
- `page` (optional): Page number for pagination
- `per_page` (optional): Number of items per page
- `category_id` (optional): Filter by category id
- `order_by` (optional): Sorting; values `bouquet_order` (default), `category_asc`, `name_asc`, `name_desc`, `addtime_asc`, `addtime_desc`
- `with_links` (optional): Include play links (default: 1, set to 0 to disable)
- `updated_at_gt` (optional): Filter content updated after this timestamp (ISO 8601 format)
- `bkey` (optional): Bouquet hash for nginx caching (only works with `with_links=0`)

**Response Example:**
```json
{
  "pagination": {
    "page": 1,
    "per_page": null,
    "total_pages": 1,
    "total_items": 235
  },
  "content": [
    {
      "num": 1,
      "name": "Channel Name",
      "stream_type": "live",
      "stream_id": "84c09631-8fb7-4cf2-b30c-7d7e8a843574",
      "stream_icon": "http://example.com/icon.png",
      "epg_channel_id": null,
      "created_at": "2025-05-05T09:18:06+00:00",
      "is_adult": 0,
      "categories": [5],
      "links": {
        "m3u8": "https://api.example.com/play/link/.../...m3u8",
        "ts": "https://api.example.com/play/link/.../...ts"
      },
      "tv_archive": 0,
      "tv_archive_id": "",
      "tv_archive_duration": 0,
      "updated_at": "2025-11-25T09:30:47+00:00",
      "metadata": {
        "video_codec": "h264",
        "audio_codec": "aac",
        "quality": "1920x806",
        "bitrate": 1710348,
        "subtitles": []
      }
    }
  ]
}
```

#### Get VOD (Movies) Content

**GET** `/play/b2c/v1/content/vod`

Retrieve a list of Video on Demand (movie) content.

**Query Parameters:** Same as live content endpoint (includes `category_id` and `order_by`)

**Response Example:**
```json
{
  "pagination": {
    "page": 1,
    "per_page": null,
    "total_pages": 1,
    "total_items": 89
  },
  "content": [
    {
      "num": 1,
      "name": "Movie Title",
      "stream_type": "movie",
      "stream_id": "0329f4da-9882-40f6-bad6-b63f48f909e8",
      "tmdb_id": 12345,
      "release_date": "2020-01-01",
      "stream_icon": "http://example.com/poster.jpg",
      "rating": 7.5,
      "rating_5based": 3.5,
      "added": "2025-11-20T15:41:29+00:00",
      "is_adult": 0,
      "categories": [10],
      "genre": "Action, Drama",
      "links": {
        "mp4": "https://api.example.com/play/link/.../...mp4"
      },
      "updated_at": "2025-11-20T15:47:38+00:00",
      "keywords": [],
      "certification": "PG-13",
      "certification_country": "US",
      "metadata": {
        "video_codec": "h264",
        "audio_codec": "eac3",
        "quality": "1920x1080",
        "bitrate": 4231777,
        "subtitles": [
          {
            "codec_name": "mov_text",
            "language": "eng"
          }
        ]
      }
    }
  ]
}
```

#### Get VOD by ID

**GET** `/play/b2c/v1/content/vod/{id}`

Retrieve detailed information about a specific movie.

**Path Parameters:**
- `id`: The stream_id of the movie

**Response Example:**
```json
{
  "info": {
    "movie_image": "http://example.com/poster.jpg",
    "tmdb_id": "12345",
    "backdrop": "http://example.com/backdrop.jpg",
    "youtube_trailer": "video_id",
    "genre": "Action, Drama",
    "plot": "Movie description...",
    "cast": "Actor 1, Actor 2",
    "rating": "7.5",
    "director": "Director Name",
    "release_date": "2020-01-01",
    "backdrop_path": ["http://example.com/backdrop.jpg"],
    "duration_secs": 7200,
    "duration": "02:00:00",
    "is_adult": 0,
    "categories": [10],
    "keywords": [],
    "certification": "PG-13",
    "certification_country": "US",
    "certification_meaning": "Description"
  },
  "vod": {
    "stream_id": "0329f4da-9882-40f6-bad6-b63f48f909e8",
    "name": "Movie Title",
    "added": "2025-11-20T15:41:29+00:00",
    "links": {
      "mp4": "https://api.example.com/play/link/.../...mp4"
    },
    "metadata": {
      "video_codec": "h264",
      "audio_codec": "eac3",
      "quality": "1920x1080",
      "bitrate": 4231777,
      "subtitles": []
    }
  }
}
```

#### Get Series Content

**GET** `/play/b2c/v1/content/series`

Retrieve a list of TV series.

**Query Parameters:** Same as live content endpoint, except `order_by` values for series: `name_asc` (default), `episode_desc` (last episode added), `addtime_asc`, `addtime_desc`

#### Get Radio Content

**GET** `/play/b2c/v1/content/radio`

Retrieve a list of radio stations.

**Query Parameters:** Same as live content endpoint

**Response Example:**
```json
{
  "pagination": {
    "page": 1,
    "per_page": null,
    "total_pages": 1,
    "total_items": 13
  },
  "content": [
    {
      "num": 1,
      "name": "Radio Station Name",
      "stream_type": "radio",
      "stream_id": "87e2d40d-25ea-4f49-8de0-ee0388cc5e5d",
      "stream_icon": "http://example.com/icon.png",
      "epg_channel_id": null,
      "created_at": "2025-04-24T13:00:48+00:00",
      "is_adult": 0,
      "categories": [15],
      "links": {
        "m3u8": "https://api.example.com/play/link/.../...m3u8",
        "ts": "https://api.example.com/play/link/.../...ts"
      },
      "tv_archive": 0,
      "tv_archive_id": "",
      "tv_archive_duration": 0,
      "updated_at": "2025-04-24T13:00:48+00:00",
      "metadata": {
        "video_codec": null,
        "audio_codec": "mp3",
        "quality": "0x0",
        "bitrate": 141412,
        "subtitles": []
      }
    }
  ]
}
```

**Response Example:**
```json
{
  "pagination": {
    "page": 1,
    "per_page": null,
    "total_pages": 1,
    "total_items": 61
  },
  "content": [
    {
      "num": 1,
      "name": "Series Name",
      "series_id": "7fc18b3a-9e7f-4084-a9e5-f3bf05e6d00e",
      "tmdb_id": 1973,
      "cover": "https://image.tmdb.org/t/p/w400/poster.jpg",
      "youtube_trailer": "video_id",
      "genre": "Action & Adventure / Drama / Crime",
      "release_date": "2001-11-06",
      "plot": "Series description...",
      "cast": "Actor 1, Actor 2",
      "rating": "7.789",
      "rating_5based": 3.5,
      "director": "Director Name",
      "backdrop_path": ["https://image.tmdb.org/t/p/w780/backdrop.jpg"],
      "last_modified": "2025-10-02T14:59:39+00:00",
      "episode_run_time": "45",
      "categories": [10, 128],
      "updated_at": "2025-10-02T14:59:39+00:00",
      "keywords": [
        {
          "id": "cd1e51fa-e7aa-4f0e-a957-3b697dbfc012",
          "name": "keyword"
        }
      ],
      "certification": "TV-14",
      "certification_country": "US",
      "is_adult": 0
    }
  ]
}
```

#### Get Series by ID

**GET** `/play/b2c/v1/content/series/{id}`

Retrieve detailed information about a specific series, including seasons and episodes.

**Path Parameters:**
- `id`: The series_id of the series

**Response Example:**
```json
{
  "seasons": [
    {
      "air_date": "2001-11-06",
      "episode_count": 24,
      "name": "Season 1",
      "season_number": "1",
    }
  ],
  "info": {
    "name": "Series Name",
    "cover": "https://image.tmdb.org/t/p/w400/poster.jpg",
    "youtube_trailer": "video_id",
    "genre": "Action & Adventure / Drama / Crime",
    "release_date": "2001-11-06",
    "plot": "Series description...",
    "cast": "Actor 1, Actor 2",
    "rating": 8,
    "rating_5based": 4,
    "director": "Director Name",
    "backdrop_path": ["https://image.tmdb.org/t/p/w780/backdrop.jpg"],
    "last_modified": "2025-10-02T14:59:39+00:00",
    "episode_run_time": "45",
    "categories": [10, 128],
    "tmdb_id": 1973,
    "keywords": [],
    "certification": "TV-14",
    "certification_country": "US",
    "certification_meaning": "Description",
    "is_adult": 0
  },
  "episodes": {
    "1": [
      {
        "id": "2ee7d172-a2f2-4a68-a0ca-a00956eb1c8f",
        "tmdb_id": 1973,
        "episode_num": "1",
        "title": "Episode Title",
        "added": "2025-07-16T16:42:50+00:00",
        "info": {
          "movie_image": "https://image.tmdb.org/t/p/w400/episode.jpg",
          "releaseDate": "2001-11-06",
          "youtube_trailer": "",
          "plot": "Episode description",
          "cast": "Actor 1, Actor 2",
          "rating": 7,
          "rating_5based": 3.5,
          "director": "Director Name",
          "duration_secs": 2700,
          "duration": "00:45:00"
        },
        "links": {
          "mkv": "https://api.example.com/play/link/.../...mkv"
        },
        "season": "1",
        "metadata": {
          "video_codec": "h264",
          "audio_codec": "aac",
          "quality": "1920x1080",
          "bitrate": 5000000,
          "subtitles": []
        }
      }
    ]
  }
}
```

### Bouquets

Bouquets are collections of content that can be enabled or disabled for a user. The bouquet key (`bkey`) is used for caching optimization.

#### Get Bouquets

**GET** `/play/b2c/v1/bouquets`

Retrieve a list of all available bouquets for the authenticated user.

**Response Example:**
```json
{
  "pagination": [],
  "content": [
    {
      "id": 2,
      "name": "Bouquet Name",
      "is_enabled": 1
    },
    {
      "id": 3,
      "name": "Another Bouquet",
      "is_enabled": 0
    }
  ]
}
```

**Response Fields:**
- **`pagination`**: Pagination metadata (may be empty for bouquets list)
- **`content`**: Array of bouquet objects
  - `id`: Bouquet ID (integer)
  - `name`: Bouquet name
  - `is_enabled`: Integer (0 or 1) - Indicates if the bouquet is enabled for the authenticated user

**Notes:**
- The bouquet key (`bkey`) from `/content-info/hashes` can be used with the `bkey` parameter for caching
- Multiple users sharing the same bouquet will have the same `bkey` value
- Use the bouquet `id` to enable/disable bouquets via the POST endpoint

#### Enable/Disable Bouquet

**POST** `/play/b2c/v1/bouquet/{bouquet_id}/{state}`

Enable or disable a bouquet for the authenticated user line.

**Path Parameters:**
- `bouquet_id`: The bouquet ID (integer)
- `state`: State to set - `on` to enable, `off` to disable

**Response Example:**
```json
{
  "status": "success",
  "updated": 1,
  "line": "50df5150-ed22-427c-8474-4620bcc0d8e8"
}
```

**Response Fields:**
- `status`: Operation status ("success")
- `updated`: Number of records updated (1 if successful)
- `line`: The authenticated user line identifier

**Examples:**
```bash
# Enable bouquet with ID 2
curl -X POST "https://api.example.com/play/b2c/v1/bouquet/2/on" \
  -H "Authorization: Bearer $TOKEN"

# Disable bouquet with ID 2
curl -X POST "https://api.example.com/play/b2c/v1/bouquet/2/off" \
  -H "Authorization: Bearer $TOKEN"
```

**Notes:**
- This endpoint modifies the bouquet state for the authenticated user's line
- Changes take effect immediately
- The `is_enabled` field in the bouquets list reflects the current state

### Content Info

#### Get Content Hashes

**GET** `/play/b2c/v1/content-info/hashes`

Retrieve current content hashes and timestamps. This endpoint is useful for implementing feed functionality to detect content updates.

**Response Example:**
```json
{
  "content": {
    "server_time_now": "2025-12-08T15:01:16+00:00",
    "series_hash": "00e308897a1ec4f2",
    "series_last_updated_at": "2025-12-05T12:45:28+00:00",
    "movies_hash": "7955c57021cf0c22",
    "movies_last_updated_at": "2025-12-08T11:53:11+00:00",
    "lives_hash": "cac5267127a2360b",
    "lives_last_updated_at": "2025-12-01T17:00:40+00:00",
    "radios_hash": "f977d86d50b5565d",
    "radios_last_updated_at": "2025-11-11T09:49:02+00:00",
    "bouquets_key": "ddf1c4f590c692189ca0230e28f0357c",
    "bouquets_movies_hash": "dbcf20772a499d8f",
    "bouquets_lives_hash": "5fe3a92c31bc71c3",
    "bouquets_radios_hash": "e1830b1f52ea0637",
    "bouquets_series_hash": "3307aaef73e86e77"
  }
}
```

**Usage:**
- Compare hashes to detect content changes
- Use `updated_at` timestamps with `updated_at_gt` parameter for incremental updates
- Use `bouquets_key` as the `bkey` parameter for caching optimization

### User Info

#### Get User Information

**GET** `/play/b2c/v1/user-info`

Retrieve information about the authenticated user, including account status, connection limits, and allowed output formats.

**Response Example:**
```json
{
  "user_info": {
    "username": "your_username",
    "message": "",
    "auth": 1,
    "status": "Active",
    "expire_at": null,
    "active_connections": "0",
    "created_at": "2025-07-15T08:03:28+00:00",
    "max_connections": "10",
    "allowed_output_formats": [
      "m3u8",
      "ts"
    ]
  },
  "server_info": {
    "time_now": "2025-12-10T12:27:50+00:00",
    "timezone": "UTC"
  },
  "lookup_service_info": {
    "url": null
  }
}
```

**Response Fields:**
- **`user_info`**: User account information
  - `username`: The authenticated username
  - `message`: Optional message for the user
  - `auth`: Authentication status (1 = authenticated)
  - `status`: Account status (e.g., "Active")
  - `expire_at`: Account expiration date (null if no expiration)
  - `active_connections`: Current number of active connections
  - `created_at`: Account creation timestamp
  - `max_connections`: Maximum allowed concurrent connections
  - `allowed_output_formats`: Array of allowed output formats (e.g., "m3u8", "ts")
- **`server_info`**: Server information
  - `time_now`: Current server time (GMT0)
  - `timezone`: Server timezone
- **`lookup_service_info`**: Lookup service information
  - `url`: Lookup service URL (if available)

### Links

#### Get Play Links for Stream

**GET** `/play/b2c/v1/links/{stream}`

Retrieve play links for a specific stream. Use this endpoint when `with_links=0` is used in content endpoints.

**Path Parameters:**
- `stream`: The stream_id of the content

**Response Example:**
```json
{
  "links": {
    "mp4": "https://api.example.com/play/link/0329f4da-9882-40f6-bad6-b63f48f909e8/...mp4"
  }
}
```

For live streams, the response may include:
```json
{
  "links": {
    "m3u8": "https://api.example.com/play/link/.../...m3u8",
    "ts": "https://api.example.com/play/link/.../...ts"
  }
}
```

### TV Archive

TV Archive links allow you to access previously recorded content from live streams. The archive availability and information is provided in the live content response.

#### TV Archive Fields in Live Content Response

When fetching live content, each channel may include the following TV archive fields:

- **`tv_archive`**: Integer (0 or 1) - Indicates if TV archive is available for this channel
- **`tv_archive_id`**: String (UUID) - The archive identifier (UUID format) used in archive URLs (empty string if archive not available)
- **`tv_archive_duration`**: Integer - Maximum duration of available archive in seconds (0 if archive not available)

**Example response with TV archive enabled:**
```json
{
  "num": 1,
  "name": "Channel Name",
  "stream_type": "live",
  "stream_id": "84c09631-8fb7-4cf2-b30c-7d7e8a843574",
  "tv_archive": 1,
  "tv_archive_id": "a1b2c3d4-e5f6-7890-abcd-ef1234567890",
  "tv_archive_duration": 86400,
  ...
}
```

#### Building TV Archive Links

TV Archive supports two types of links:

1. **Offset-based links** (like livestream) - Play content from a specific time offset
2. **Duration-based links** (like VOD) - Play content from a specific start time for a given duration

**URL Format Parameters:**
- `{archive}`: The `tv_archive_id` from the live content response
- `{token}`: Authentication token (can be in URL or query parameter)
- `{offset}`: Seconds ago from current time (e.g., `3600` for 1 hour ago)
- `{start}`: Start timestamp in formats `Y-m-d:H-i` or `Y-m-d H:i:s` (e.g., `2025-12-08:15-30` or `2025-12-08 15:30:00`)
- `{duration}`: Duration in minutes (e.g., `60` for 1 hour)
- `{output}`: Output format - `m3u8` or `ts`

**Important:** All timestamps are in server time (GMT0).

#### Offset-Based Archive Links (Livestream-like)

These links play content from a specific time offset (seconds ago) and continue streaming forward, similar to a live stream.

**Format with token in URL:**
```
https://api.example.com/play/link_archive/{archive}/{token}/offset_{offset}.m3u8
```

**Format without token in URL** (token can be passed as query parameter):
```
https://api.example.com/play/link_archive_nt/{archive}/offset_{offset}.m3u8?token={token}
```

**Examples:**
```
# Play archive from 1 hour ago (3600 seconds)
https://api.example.com/play/link_archive/a1b2c3d4-e5f6-7890-abcd-ef1234567890/eyJpdiI6.../offset_3600.m3u8

# Play archive from 30 minutes ago (1800 seconds) - no token in URL
https://api.example.com/play/link_archive_nt/a1b2c3d4-e5f6-7890-abcd-ef1234567890/offset_1800.m3u8?token=eyJpdiI6...
```

#### Duration-Based Archive Links (VOD-like)

These links play a specific segment of archived content from a start time for a given duration, similar to VOD playback.

**Format with token in URL:**
```
https://api.example.com/play/link_archive/{archive}/{token}/{start}/duration_{duration}.{output}
```

**Format without token in URL** (token can be passed as query parameter):
```
https://api.example.com/play/link_archive_nt/{archive}/{start}/duration_{duration}.{output}?token={token}
```

**Examples:**
```
# Play 60 minutes of archive starting from 2025-12-08 15:30:00 in M3U8 format
https://api.example.com/play/link_archive/a1b2c3d4-e5f6-7890-abcd-ef1234567890/eyJpdiI6.../2025-12-08:15-30/duration_60.m3u8

# Play 30 minutes of archive starting from 2025-12-08 14:00:00 in TS format
https://api.example.com/play/link_archive/a1b2c3d4-e5f6-7890-abcd-ef1234567890/eyJpdiI6.../2025-12-08:14-00/duration_30.ts

# Play 120 minutes using alternative timestamp format - no token in URL
https://api.example.com/play/link_archive_nt/a1b2c3d4-e5f6-7890-abcd-ef1234567890/2025-12-08 14:00:00/duration_120.m3u8?token=eyJpdiI6...
```

**Notes:**
- The `tv_archive_id` is used as the `{archive}` parameter in the URL
- Timestamps must be in server time (GMT0)
- The `offset` value represents seconds ago from the current server time
- The `duration` value is in minutes
- Only channels with `tv_archive: 1` support archive playback
- Archive links require authentication (token in URL or as query parameter)
- The maximum available archive duration is specified in `tv_archive_duration` (in seconds)
- For offset-based links, ensure the offset doesn't exceed the available archive duration
- For duration-based links, ensure the start time and duration are within the available archive window

### Notifications

#### Get Notifications

**GET** `/play/b2c/v1/notifications`

Returns a list of notification messages with options for filtering and ordering.

**Query Parameters:**
- `period_sent` (optional): Filter by sent period
- `period_read` (optional): Filter by read period
- `period_created` (optional): Filter by created period
- `per_page` (optional): Number of items per page
- `page` (optional): Page number for pagination
- `order_by` (optional): Sorting order. Values:
  - `sent_asc`: Sort by sent time ascending
  - `sent_desc`: Sort by sent time descending
  - `read_asc`: Sort by read time ascending
  - `read_desc`: Sort by read time descending
  - `created_asc`: Sort by created time ascending (default)
  - `created_desc`: Sort by created time descending

**Response Example:**
```json
{
  "pagination": {
    "page": 1,
    "per_page": null,
    "total_pages": 1,
    "total_items": 0
  },
  "notifications": []
}
```

**Example Request:**
```bash
# Filter by period_sent
curl -X GET "https://api.example.com/play/b2c/v1/notifications?period_sent=2025-12-01" \
  -H "Authorization: Bearer $TOKEN"
```

#### Get New Notifications

**GET** `/play/b2c/v1/notifications/get-new`

Returns a list of new notification messages. After messages are fetched by this method, their status is updated to 'sent'.

**Query Parameters:**
- `per_page` (optional): Number of items per page
- `page` (optional): Page number for pagination
- `order_by` (optional): Sorting order. Values:
  - `created_asc`: Sort by created time ascending (default)
  - `created_desc`: Sort by created time descending

**Response Example:**
```json
{
  "pagination": {
    "page": 1,
    "per_page": null,
    "total_pages": 1,
    "total_items": 0
  },
  "notifications": []
}
```

#### Mark Notifications as Read

**POST** `/play/b2c/v1/notifications/mark-read`

Update the status to 'read' for one or all notification messages (for the authenticated line).

**Request Body (optional):**
```json
{
  "message_id": 123
}
```

**Query Parameters:**
- `message_id` (optional): Specific notification message ID to mark as read. If omitted, all notifications for the authenticated line are marked as read.

**Response Example:**
```json
{
  "status": "success"
}
```

**Examples:**
```bash
# Mark all notifications as read
curl -X POST "https://api.example.com/play/b2c/v1/notifications/mark-read" \
  -H "Authorization: Bearer $TOKEN"

# Mark specific notification as read
curl -X POST "https://api.example.com/play/b2c/v1/notifications/mark-read" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"message_id": 123}'
```

**Notes:**
- If `message_id` is provided, only that specific notification is marked as read
- If `message_id` is omitted, all notifications for the authenticated line are marked as read

### EPG (Electronic Program Guide)

#### Get XML EPG

**GET** `/play/b2c/v1/xml-epg` or `/xmltv.php`

Retrieve Electronic Program Guide (EPG) data in XML format. The output format is the same as in XC API.

**Response Format:** XML

**Response Example:**
```xml
<?xml version="1.0" encoding="UTF-8"?>
<tv>
  <channel id="bnt1.bg">
    <display-name>BG | BNT 1 HD</display-name>
    <icon src="http://example.com/icons1/Bg:/bnt1_bg.png"/>
  </channel>
  <programme start="20251211133645 +0000" stop="20251211135036 +0000" channel="bnt1.bg">
    <title>Program Title</title>
    <desc>Program description</desc>
  </programme>
  ...
</tv>
```

**Notes:**
- Returns EPG data for all channels in XML format
- Compatible with XC API EPG format
- The XML structure includes:
  - `<channel>` elements (before programmes) containing:
    - `id` attribute: Channel identifier
    - `<display-name>`: Channel display name
    - `<icon>` with `src` attribute: Channel icon URL
  - `<programme>` elements containing:
    - `start`: Program start time (format: `YYYYMMDDHHmmss +0000`)
    - `stop`: Program end time (format: `YYYYMMDDHHmmss +0000`)
    - `channel`: Channel identifier (matches channel id)
    - `<title>`: Program title
    - `<desc>`: Program description

#### Get Short EPG for Stream

**GET** `/play/b2c/v1/epg/{stream_id}/short`

Retrieve a short (4-hour) EPG listing for a specific program/stream.

**Path Parameters:**
- `stream_id`: The stream_id of the channel/program

**Response Example:**
```json
{
  "epg_listings": [
    {
      "id": "epg_id_123",
      "title": "Program Title",
      "description": "Program description",
      "start": "2025-12-10T12:00:00+00:00",
      "end": "2025-12-10T13:00:00+00:00",
      "channel": "84c09631-8fb7-4cf2-b30c-7d7e8a843574"
    }
  ]
}
```

**Notes:**
- Returns EPG listings for the next 4 hours
- Only includes listings for the specified stream
- Returns empty array if no EPG data is available for the stream

## Query Parameters

### Common Parameters

All content endpoints support the following query parameters:

#### `with_links` (optional)

- **Type:** Integer (0 or 1)
- **Default:** 1
- **Description:** Include play links in the response. Set to `0` to disable links for improved performance and caching.
- **Example:** `?with_links=0`

**Benefits of disabling links:**
- Improved performance (faster response times)
- Better caching (responses can be cached more effectively)
- Reduced response size
- Use with `bkey` parameter for nginx-level caching

#### `updated_at_gt` (optional)

- **Type:** String (ISO 8601 datetime)
- **Description:** Filter content updated after the specified timestamp. Useful for implementing feed functionality to fetch only updated content.
- **Example:** `?updated_at_gt=2025-12-01T00:00:00Z`

**Usage:**
1. Fetch initial content
2. Store the latest `updated_at` timestamp
3. Use `updated_at_gt` with the stored timestamp to get only new/updated content

#### `bkey` (optional)

- **Type:** String (bouquet hash)
- **Description:** Bouquet hash for nginx-level caching optimization. **Important:** This parameter only works when `with_links=0`.
- **Example:** `?bkey=ddf1c4f590c692189ca0230e28f0357c`

**How it works:**
- The `bkey` is the same for multiple users sharing the same bouquets
- When `with_links=0` and `bkey` is provided, nginx can cache responses at the bouquet level
- This significantly improves performance for users with the same bouquets

**Nginx Cache Logic:**
```
map "$arg_with_links|$arg_bkey" $b2c_api_client_hash {
    default         $arg_token$http_authorization;
    "~^0\|(.+)$"    $arg_bkey;
}
```

#### Pagination Parameters

- **`page`** (optional): Page number (default: 1)
- **`per_page`** (optional): Number of items per page

**Example:** `?page=1&per_page=10`

**Response includes pagination info:**
```json
{
  "pagination": {
    "page": 1,
    "per_page": 10,
    "total_pages": 9,
    "total_items": 89
  }
}
```

## Response Format

All endpoints return JSON responses. Content endpoints typically include:

- **`pagination`**: Pagination metadata (when applicable)
- **`content`**: Array of content items
- **`cache`**: Cache information (when applicable)

## Error Handling

### Error Response Format

```json
{
  "errors": {
    "message": "Error description",
    "status_code": 403
  }
}
```

### Common Error Codes

- **400**: Bad Request - Invalid parameters
- **401**: Unauthorized - Invalid or missing authentication token
- **403**: Forbidden - Authentication failed or insufficient permissions
- **404**: Not Found - Endpoint or resource not found
- **500**: Internal Server Error - Server error

## Performance Optimization

### Feed Mode (No Links)

For applications using the API as a feed (not needing immediate play links):

1. **Disable links:** Use `?with_links=0` on all content endpoints
2. **Use caching:** Include `bkey` parameter for nginx-level caching
3. **Incremental updates:** Use `updated_at_gt` to fetch only changed content
4. **Fetch links on demand:** Use `/links/{stream}` endpoint when play links are needed

**Example:**
```bash
GET /play/b2c/v1/content/vod?with_links=0&bkey=ddf1c4f590c692189ca0230e28f0357c&updated_at_gt=2025-12-01T00:00:00Z
```

### Caching Strategy

1. **Check content hashes:** Use `/content-info/hashes` to detect changes
2. **Fetch only updates:** Use `updated_at_gt` with the last known timestamp
3. **Cache without links:** Use `with_links=0` for better cacheability
4. **Use bouquet key:** Include `bkey` for shared caching across users

## Code Examples

### cURL

#### Authentication
```bash
curl -X POST "https://api.example.com/play/b2c/v1/auth" \
  -H "Content-Type: application/json" \
  -d '{"username":"your_username","password":"your_password"}'
```

#### Get VOD Content
```bash
TOKEN="your_auth_token"
curl -X GET "https://api.example.com/play/b2c/v1/content/vod" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json"
```

#### Get Content with Feed Optimization
```bash
TOKEN="your_auth_token"
curl -X GET "https://api.example.com/play/b2c/v1/content/vod?with_links=0&updated_at_gt=2025-12-01T00:00:00Z&bkey=ddf1c4f590c692189ca0230e28f0357c" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json"
```

### PHP

A complete PHP example is available in [`examples/php_example.php`](examples/php_example.php). The example includes:

- Authentication
- Fetching VOD, live, and series content
- Getting content by ID
- Retrieving content hashes
- Getting play links
- Handling notifications
- Feed mode optimization examples

To use the example:

1. Update the `$baseUrl` variable with your actual API endpoint
2. Replace `'your_username'` and `'your_password'` with your credentials
3. Run: `php examples/php_example.php`

## Additional Notes

- **Token Expiration:** Authentication tokens do not expire and can be reused indefinitely
- **XML Output:** Some endpoints may support XML output similar to XC API format
- **TV Archive:** See the [TV Archive](#tv-archive) section for details on building archive links from live content data
- **Rate Limiting:** Please implement appropriate rate limiting in your application
- **HTTPS:** For production use, ensure you're using HTTPS endpoints if available

## Support

For additional support or questions, please contact the API support team.
