# Database Event Management Guide

## Overview
This guide explains how to directly manage MPA events through the WordPress database using MySQL commands. This is useful for bulk operations, automated scripts, or when the WordPress admin interface is not available.

## Database Connection

### Connection Details
- **Database Name:** `mark9_wp`
- **Username:** `root`
- **Password:** (empty)
- **Host:** `localhost`

### Connect to Database
```bash
mysql -u root mark9_wp
```

## Event Management Operations

### 1. View All Events

#### List All Events
```sql
SELECT ID, post_title, post_date, post_status 
FROM wp_posts 
WHERE post_type = 'mpa_event' 
ORDER BY post_date DESC;
```

#### View Event Details with Metadata
```sql
SELECT 
    p.ID,
    p.post_title,
    p.post_content,
    p.post_status,
    MAX(CASE WHEN pm.meta_key = '_event_date' THEN pm.meta_value END) as event_date,
    MAX(CASE WHEN pm.meta_key = '_event_start_time' THEN pm.meta_value END) as start_time,
    MAX(CASE WHEN pm.meta_key = '_event_end_time' THEN pm.meta_value END) as end_time,
    MAX(CASE WHEN pm.meta_key = '_event_location' THEN pm.meta_value END) as location,
    MAX(CASE WHEN pm.meta_key = '_event_price' THEN pm.meta_value END) as price,
    MAX(CASE WHEN pm.meta_key = '_event_status' THEN pm.meta_value END) as status,
    MAX(CASE WHEN pm.meta_key = '_event_type' THEN pm.meta_value END) as type,
    MAX(CASE WHEN pm.meta_key = '_thumbnail_id' THEN pm.meta_value END) as featured_image_id
FROM wp_posts p
LEFT JOIN wp_postmeta pm ON p.ID = pm.post_id
WHERE p.post_type = 'mpa_event'
GROUP BY p.ID
ORDER BY event_date ASC;
```

### 2. Create New Event

#### Step 1: Insert Event Post
```sql
INSERT INTO wp_posts (
    post_author, 
    post_date, 
    post_date_gmt, 
    post_content, 
    post_title, 
    post_excerpt, 
    post_status, 
    comment_status, 
    ping_status, 
    post_password, 
    post_name, 
    to_ping, 
    pinged, 
    post_modified, 
    post_modified_gmt, 
    post_content_filtered, 
    post_parent, 
    guid, 
    menu_order, 
    post_type, 
    post_mime_type, 
    comment_count
) VALUES (
    1,                                          -- post_author (admin user ID)
    NOW(),                                      -- post_date
    UTC_TIMESTAMP(),                           -- post_date_gmt
    'Event description content goes here...',   -- post_content
    'New Event Title',                         -- post_title
    'Short event description',                 -- post_excerpt
    'publish',                                 -- post_status (publish/draft)
    'closed',                                  -- comment_status
    'closed',                                  -- ping_status
    '',                                        -- post_password
    'new-event-title',                         -- post_name (slug)
    '',                                        -- to_ping
    '',                                        -- pinged
    NOW(),                                     -- post_modified
    UTC_TIMESTAMP(),                          -- post_modified_gmt
    '',                                        -- post_content_filtered
    0,                                         -- post_parent
    '',                                        -- guid
    0,                                         -- menu_order
    'mpa_event',                              -- post_type
    '',                                        -- post_mime_type
    0                                          -- comment_count
);
```

#### Step 2: Get the New Event ID
```sql
SELECT LAST_INSERT_ID() as new_event_id;
```

#### Step 3: Add Event Metadata
Replace `NEW_EVENT_ID` with the actual ID from step 2:

```sql
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES
(NEW_EVENT_ID, '_event_date', '2025-12-25'),
(NEW_EVENT_ID, '_event_start_time', '14:00'),
(NEW_EVENT_ID, '_event_end_time', '16:00'),
(NEW_EVENT_ID, '_event_location', 'Kuala Lumpur'),
(NEW_EVENT_ID, '_event_price', 'RM 50'),
(NEW_EVENT_ID, '_event_registration_url', 'https://example.com/register'),
(NEW_EVENT_ID, '_event_status', 'upcoming'),
(NEW_EVENT_ID, '_event_type', 'conference');
```

### 3. Update Existing Event

#### Update Event Title and Content
```sql
UPDATE wp_posts 
SET 
    post_title = 'Updated Event Title',
    post_content = 'Updated event description...',
    post_modified = NOW(),
    post_modified_gmt = UTC_TIMESTAMP()
WHERE ID = EVENT_ID;
```

#### Update Event Metadata
```sql
UPDATE wp_postmeta 
SET meta_value = '2025-12-30' 
WHERE post_id = EVENT_ID AND meta_key = '_event_date';

UPDATE wp_postmeta 
SET meta_value = '15:00' 
WHERE post_id = EVENT_ID AND meta_key = '_event_start_time';

UPDATE wp_postmeta 
SET meta_value = 'Online Webinar' 
WHERE post_id = EVENT_ID AND meta_key = '_event_location';
```

### 4. Delete Event

#### Delete Event and All Metadata
```sql
-- Delete event metadata
DELETE FROM wp_postmeta WHERE post_id = EVENT_ID;

-- Delete the event post
DELETE FROM wp_posts WHERE ID = EVENT_ID;
```

### 5. Featured Image Management

#### Upload Image to Media Library
```sql
INSERT INTO wp_posts (
    post_author, 
    post_date, 
    post_date_gmt, 
    post_content, 
    post_title, 
    post_excerpt, 
    post_status, 
    comment_status, 
    ping_status, 
    post_password, 
    post_name, 
    to_ping, 
    pinged, 
    post_modified, 
    post_modified_gmt, 
    post_content_filtered, 
    post_parent, 
    guid, 
    menu_order, 
    post_type, 
    post_mime_type, 
    comment_count
) VALUES (
    1, 
    NOW(), 
    UTC_TIMESTAMP(), 
    '', 
    'event-image-name', 
    '', 
    'inherit', 
    'open', 
    'closed', 
    '', 
    'event-image-name', 
    '', 
    '', 
    NOW(), 
    UTC_TIMESTAMP(), 
    '', 
    0, 
    'http://localhost:8000/wp-content/uploads/2025/09/image-name.jpg', 
    0, 
    'attachment', 
    'image/jpeg', 
    0
);
```

#### Assign Featured Image to Event
```sql
-- Get the image ID first
SELECT ID FROM wp_posts WHERE post_name = 'image-name' AND post_type = 'attachment';

-- Assign to event (replace IMAGE_ID and EVENT_ID)
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) 
VALUES (EVENT_ID, '_thumbnail_id', 'IMAGE_ID');
```

#### Remove Featured Image from Event
```sql
DELETE FROM wp_postmeta 
WHERE post_id = EVENT_ID AND meta_key = '_thumbnail_id';
```

## Bulk Operations

### 1. Bulk Update Event Status
```sql
-- Mark all past events as 'past'
UPDATE wp_postmeta 
SET meta_value = 'past' 
WHERE meta_key = '_event_status' 
AND post_id IN (
    SELECT post_id 
    FROM wp_postmeta 
    WHERE meta_key = '_event_date' 
    AND meta_value < CURDATE()
);
```

### 2. Assign Same Image to Multiple Events
```sql
-- Assign placeholder image to all Happy Hour events
INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
SELECT p.ID, '_thumbnail_id', '193'
FROM wp_posts p
WHERE p.post_type = 'mpa_event' 
AND p.post_title LIKE '%Happy Hour%'
AND p.ID NOT IN (
    SELECT post_id 
    FROM wp_postmeta 
    WHERE meta_key = '_thumbnail_id'
);
```

### 3. Bulk Delete Events by Type
```sql
-- Delete all events of a specific type
DELETE p, pm 
FROM wp_posts p
LEFT JOIN wp_postmeta pm ON p.ID = pm.post_id
WHERE p.post_type = 'mpa_event'
AND p.ID IN (
    SELECT post_id 
    FROM wp_postmeta 
    WHERE meta_key = '_event_type' 
    AND meta_value = 'webinar'
);
```

## Event Metadata Fields

| Meta Key | Description | Example Values |
|----------|-------------|----------------|
| `_event_date` | Event date | `2025-12-25` |
| `_event_start_time` | Start time | `14:00` |
| `_event_end_time` | End time | `16:00` |
| `_event_location` | Event location | `Kuala Lumpur`, `Online Webinar` |
| `_event_price` | Event price | `RM 100`, `Free`, `Members Only` |
| `_event_registration_url` | Registration URL | `https://example.com/register` |
| `_event_status` | Event status | `upcoming`, `past`, `cancelled` |
| `_event_type` | Event type | `conference`, `webinar`, `workshop`, `summit`, `networking`, `happy-hour`, `competition`, `forum` |
| `_thumbnail_id` | Featured image ID | `193` (attachment post ID) |

## Common Queries

### Find Events by Date Range
```sql
SELECT p.ID, p.post_title, pm.meta_value as event_date
FROM wp_posts p
JOIN wp_postmeta pm ON p.ID = pm.post_id
WHERE p.post_type = 'mpa_event'
AND pm.meta_key = '_event_date'
AND pm.meta_value BETWEEN '2025-01-01' AND '2025-12-31'
ORDER BY pm.meta_value ASC;
```

### Find Events by Location
```sql
SELECT p.ID, p.post_title, pm.meta_value as location
FROM wp_posts p
JOIN wp_postmeta pm ON p.ID = pm.post_id
WHERE p.post_type = 'mpa_event'
AND pm.meta_key = '_event_location'
AND pm.meta_value LIKE '%Online%'
ORDER BY p.post_title;
```

### Find Events Without Featured Images
```sql
SELECT p.ID, p.post_title
FROM wp_posts p
WHERE p.post_type = 'mpa_event'
AND p.ID NOT IN (
    SELECT post_id 
    FROM wp_postmeta 
    WHERE meta_key = '_thumbnail_id'
);
```

## Safety Tips

1. **Always backup** your database before making changes:
   ```bash
   mysqldump -u root mark9_wp > backup_$(date +%Y%m%d_%H%M%S).sql
   ```

2. **Test queries** with SELECT before UPDATE/DELETE:
   ```sql
   -- Test what will be affected
   SELECT * FROM wp_posts WHERE condition;
   -- Then run the actual update
   UPDATE wp_posts SET ... WHERE condition;
   ```

3. **Use transactions** for complex operations:
   ```sql
   START TRANSACTION;
   -- Your queries here
   COMMIT;  -- or ROLLBACK; if something goes wrong
   ```

4. **Verify changes** after operations:
   ```sql
   SELECT * FROM wp_posts WHERE ID = EVENT_ID;
   ```

## Troubleshooting

### Event Not Showing on Frontend
1. Check post_status is 'publish'
2. Verify post_type is 'mpa_event'
3. Ensure required metadata exists
4. Clear any caching

### Featured Image Not Displaying
1. Verify image file exists in uploads directory
2. Check attachment post exists in wp_posts
3. Confirm _thumbnail_id metadata is set
4. Validate image URL in guid field

### Permission Issues
- Ensure MySQL user has proper permissions
- Check file permissions in uploads directory
- Verify WordPress file ownership

## Example: Complete Happy Hour Event Creation

```sql
-- 1. Create the event post
INSERT INTO wp_posts (post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt, post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid, menu_order, post_type, post_mime_type, comment_count) 
VALUES (1, NOW(), UTC_TIMESTAMP(), 'Monthly members-only happy hour event. Unwind and network with fellow MPA members in a relaxed atmosphere. Organized by Dato Joseph & Dr Darren.', 'MPA Happy Hour - December 2025', 'Monthly members-only networking event', 'publish', 'closed', 'closed', '', 'mpa-happy-hour-december-2025', '', '', NOW(), UTC_TIMESTAMP(), '', 0, '', 0, 'mpa_event', '', 0);

-- 2. Get the event ID
SET @event_id = LAST_INSERT_ID();

-- 3. Add event metadata
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES
(@event_id, '_event_date', '2025-12-26'),
(@event_id, '_event_start_time', '16:00'),
(@event_id, '_event_end_time', '18:00'),
(@event_id, '_event_location', 'On-site'),
(@event_id, '_event_price', 'Members Only'),
(@event_id, '_event_registration_url', ''),
(@event_id, '_event_status', 'upcoming'),
(@event_id, '_event_type', 'networking'),
(@event_id, '_thumbnail_id', '193');

-- 4. Verify creation
SELECT p.ID, p.post_title, pm.meta_key, pm.meta_value 
FROM wp_posts p 
LEFT JOIN wp_postmeta pm ON p.ID = pm.post_id 
WHERE p.ID = @event_id;
```

---

*Last updated: September 2025*
*For WordPress MPA Events Management System*
