# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Password Set](#password_set)

<a name="password_set"></a>
## Password Set

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`api/password/reset`|Accept:application/json|

### URL Params

```text
None
```

### Data Params

```json
{
    "token"    : "b2bf39bd4e5cef9468119e1f297212c90f75240482b5193bc8165090258a6a30",
    "email"    : "example@example.com",
    "password"    : "password",
    "password_confirmation"    : "password",
}
```

|Params|Type|Values|Example|
|:-|:-|:-|
|`token`|String|`required`|Ex:`b2bf39bd4e5cef9468119e1f297212c90f75240482b5193bc8165090258a6a30`|
|`email`|String|`required`|Ex:`example@example.com`|
|`password`|String|`required`|Ex:`password`|
|`password_confirmation`|String|`required`|Ex:`password`|



> {success} Success Response

Code `200`

Content

```json
{
    "status": "Success",
    "message": "Your password has been reset!"
}
```

> {danger} Error Response

Code `422`

Reason `Validation Error`

Content

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "token": [
            "The token field is required."
        ],
        "email": [
            "The email field is required."
        ],
        "password": [
            "The password confirmation does not match.",
            "The password must be at least 6 characters."
        ]
    }
}
```

> {danger} Error Response

Code `401`

Reason `Invalid email address`

Content

```json
{
    "status": "Error",
    "message": "This password reset token is invalid."
}
```
