# Document Library

A Laravel package for managing a hierarchical document library with directories, file uploads, and visibility controls.

## Installation

Add the package to your Laravel application:

```bash
composer require okorpheus/document-library
```

The service provider is auto-discovered. Run the migrations:

```bash
php artisan migrate
```

Publish the configuration file:

```bash
php artisan vendor:publish --tag=documentlibrary-config
```

## Configuration

The configuration file will be published to `config/documentlibrary.php`:

```php
return [
    // Prefix for database tables
    'db_table_prefix' => env('DOCLIB_DB_TABLE_PREFIX', 'okorpheus_doclib_'),

    // Storage disk for uploaded files
    'storage_disk' => env('DOCLIB_STORAGE_DISK', 'public'),

    // Path within the disk for file storage
    'storage_path' => env('DOCLIB_STORAGE_PATH', 'document-library'),

    // Callable to determine if a user is an admin
    'admin_check' => function ($user) {
        return $user->isAdmin();
    }
];
```

### Admin Check Configuration

The `admin_check` configuration option determines which users have administrative privileges in the document library. Admins can:

- View all documents and directories regardless of visibility
- Create documents and directories anywhere
- Edit and delete any document or directory

Configure this to match your application's admin logic:

```php
// Using a method on the User model
'admin_check' => function ($user) {
    return $user->isAdmin();
}

// Using a role-based system (e.g., Spatie Permissions)
'admin_check' => function ($user) {
    return $user->hasRole('admin');
}

// Using a simple email check
'admin_check' => function ($user) {
    return in_array($user->email, ['admin@example.com']);
}

// Using a database column
'admin_check' => function ($user) {
    return $user->is_admin === true;
}
```

### Environment Variables

You can configure the package via environment variables:

```env
DOCLIB_DB_TABLE_PREFIX=okorpheus_doclib_
DOCLIB_STORAGE_DISK=public
DOCLIB_STORAGE_PATH=document-library
```

## Visibility Levels

Documents and directories support three visibility levels:

| Visibility | Description |
|------------|-------------|
| `public` | Visible to everyone, including guests |
| `restricted` | Visible to any authenticated user |
| `private` | Visible only to the owner and admins |

## Authorization

The package uses Laravel policies for authorization:

### Documents

- **View**: Based on visibility level and ownership
- **Create**: Authenticated users can create in public directories or directories they own
- **Update**: Owner or admin only
- **Delete**: Owner or admin only

### Directories

- **View**: Based on visibility level and ownership
- **Create**: Authenticated users can create in public directories or directories they own
- **Update**: Owner or admin only
- **Delete**: Owner or admin only (directory must be empty)

## Routes

All routes are prefixed with `/document-library`:

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/` | `document-library.index` | List root directories and documents |
| GET | `/{directory}` | `document-library.directory` | List contents of a directory |
| POST | `/directory` | `document-library.directory.store` | Create a new directory |
| PATCH | `/directory/{directory}` | `document-library.directory.update` | Update a directory |
| DELETE | `/directory/{directory}` | `document-library.directory.destroy` | Delete a directory |
| POST | `/` | `document-library.file.store` | Upload a new file |
| PATCH | `/file/{document}` | `document-library.document.update` | Update a document |
| DELETE | `/file/{document}` | `document-library.document.destroy` | Delete a document |

## Usage

Navigate to `/document-library` to access the document library interface. Authenticated users can:

- Create directories and upload files
- Edit and delete their own content
- View content based on visibility settings

Admins have full access to all content.

## Requirements

- PHP 8.2+
- Laravel 11+
- `blade-ui-kit/blade-heroicons` (installed as a dependency)

## License

MIT