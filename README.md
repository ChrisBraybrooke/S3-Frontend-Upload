# Laravel S3 Direct Upload

This package provides the backend required for performing direct uploads to an s3 bucket from a frontend application.

## Installation

First install the package

```
composer require chrisbraybrooke/s3-direct-upload
```

## Setup
1. It is reccomended that you publish the config file and perform the relvant setup. This can be done by running `php artisan vendor:publish --tag=s3-direct-upload-config`.

2. The package does require some migrations to be run, if you wish to customise these you should mark the `ignore_migrations` value as `false` in the config file. You should then run the `php artisan vendor:publish --tag=s3-direct-upload-migrations` command to bring the default migrations into your project.

3. After you are happy with the migrations, please run `php artisan migrate`.

## Usage

First have your frontend application make a POST request to `/api/files/upload-url`, this will return the information you need to make a POST request to aws for the file upload. A VUEJS example is below.

```javascript
// Retrieve the credentials needed to upload a file to S3.
axios.post('https://laravel-backend.test/api/files/upload-url')
    .then(data => {
        let formData = new FormData()

        Object.keys(data.inputs).forEach(inputKey => {
            formData.append(inputKey, data.inputs[inputKey])
        })
        formData.append('file', this.$refs.file.files[0])

        // Make the request to S3 using the credentials returned from the server.
        axios.post(
            data.attributes.action,
            formData,
            {
                headers: {
                    'Content-Type': data.attributes.enctype
                },
                withCredentials: false,

                // Listen to the upload progress event and update our local value
                onUploadProgress: progressEvent => {
                    this.uploadProgress = parseInt(Math.round((progressEvent.loaded / progressEvent.total) * 100))
                }
            }
        )
    })
```

Once the file has been uploaded to S3, you will want save a record of this file in the database. This is handled for you by the package, in the form of the `File.php` model. This can be overidden at any point in the config file.

To ensure this record is saved, a request to the file upload complete url `/api/files/complete` must be made. A VUEJS example is below.

```javascript
// Make the request to S3 using the credentials returned from the server.
axios.post(
    data.attributes.action,
    formData,
    {
        headers: {
            'Content-Type': data.attributes.enctype
        },
        withCredentials: false,

        // Listen to the upload progress event and update our local value
        onUploadProgress: progressEvent => {
            this.uploadProgress = parseInt(Math.round((progressEvent.loaded / progressEvent.total) * 100))
        }
    }
)
    .then(() => {
        let file = this.$refs.file.files[0]
        axios.post(
            // The complete url is returned by the server on your original "/api/files/upload-url" request
            data.attributes.complete_url,
            {
                mime_type: file.type,
                size: file.size,
                name: file.name,
                description: this.userFileDescription || `File Upload - ${file.name}`,
            }
        )
            .then(({ data : { data: upload } }) => {
                this.$emit('file:uploaded', upload)
            })
    })
```

There is also an endpoint availble to delete files. Just make a DELETE request to `/api/files/{fileId}`
