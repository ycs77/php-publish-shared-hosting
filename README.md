# Publish the PHP Website to Shared Hosting

## Local

Download `php-publish-shared-hosting` to a directory that can be browsed on your website. And open http://example.com/php-publish-shared-hosting/local.php to zip the website files. You can then upload the zip file to a production server using FileZilla.

## Production

Create the root directory, and uploading `php-publish-shared-hosting` and zip file, open http://example.com/php-publish-shared-hosting/production.php to extract the website files, delete `php-publish-shared-hosting`.

## Laravel

If the browseable directory on your site is not in the root directory, Example: the Laravel is set in the `public` folder. Please use the following URL:

* Local: http://example.com/php-publish-shared-hosting/local.php?rootRelativePath=../../
* Production: http://example.com/php-publish-shared-hosting/production.php?rootRelativePath=../../

## API

### rootRelativePath

* Default: `../`

This value is use relative path (path based on `php-publish-shared-hosting` script file) find the root path.

### zipFileName

* Default: (root directory)

This value is zip file name.

### isSaveToRoot

* Default: `false`

Controls whether the zip file is saved to the root directory. If set to `false` it is saved in` php-publish-shared-hosting`.
