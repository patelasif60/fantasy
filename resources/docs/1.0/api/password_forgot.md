# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Forgot password](#forgot_password)

<a name="login"></a>
## Forgot password

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`api/password/email`|Accept:application/json|

### URL Params

```text
None
```

### Data Params

```json
{
    "email"    : "example@example.com",
}
```

|Params|Type|Values|Example|
|:-|:-|:-|
|`email`|String|`required`|Ex:`example@example.com`|


> {success} Success Response

Code `200`

Content

```json
{
    "status": "Success",
    "message": "We have e-mailed your password reset link!"
}
```

> {danger} Error Response

Code `422`

Reason `Validation Error`

Content

```json
{
    "email": [
        "The email field is required."
    ]
}
```

> {danger} Error Response

Code `401`

Reason `Invalid email address`

Content

```json
{
    "status": "Error",
    "message": "We can't find a user with that e-mail address."
}
```
