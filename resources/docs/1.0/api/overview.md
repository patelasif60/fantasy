# API Docs

This site will document all the APIs that are available for this application. There are few details that are applicable for all the APIs. These are listed below.

---

## Endpoints

|Environment|Base URI|
|:-|:-|
|Dev|`http://mohin-fantasyleague.dev.aecortech.com/api`|
|QA|`https://fantasyleague.aecordigitalqa.com/api`|

## Headers

It is suggested that the following headers are always set on each of the requests that the client makes to the server.

|Header|Value|
|:-|:-|
|`Accept`|`application/json`|
|`User-Agent`|`[app_name/version]`|

The `Accept` header should be set to `application/json` for all the requests, this will help the server in returning responses in correct format.

The `User-Agent` should be set as per the application in the above format. So for example, if the an Android app is making the request, the header should be set as `Android/2.1` where `2.1` is the current version of the application that the user has installed. Likewise for an iOS application, the header should be set as `iOS/2.1`
