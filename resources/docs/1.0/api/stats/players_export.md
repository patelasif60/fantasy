- [Export as PDF](#export_pdf)
- [Export as Excel/Xls](#export_xls)

<a name="export_pdf"></a>
## Players list export PDF

This api will export players list as in PDF format

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/players/{division}/export/pdf`|`Bearer Token`|

### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`valid numeric division id`|Ex: `1`


### Success response

```json
{
    "success": true,
    "file": "http://jayprakash-fantasyleague.dev.aecortech.com/printable/Player List - Fantasy League.pdf"
}
```



<a name="export_xls"></a>
## Players list export Excel

This api will export players list as in Excel/xls format

### Endpoint
	
|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/players/{division}/export/excel`|`Bearer Token`|

### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`valid numeric division id`|Ex: `1`

### Success response

```json
{
    "success": true,
    "file": "http://jayprakash-fantasyleague.dev.aecortech.com/printable/Player List - Fantasy League.xls"
}
```