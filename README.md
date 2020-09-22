# Convert-PO-Editor-Export-To-Chrome-Extension-i18n

## Description

Convert a json "Key Value" to a json used in Chrome extensions

**Input**

```json
{
  "appName":"Name of my app",
  "updatedAt":"Updated at $date$",
  "fullname":"$firstname$ $lastname$"
}
```

**Output**
```json
{
  "appName": { "message": "Name of my app" },
  "updatedAt": {
    "message": "Updated at $date$",
    "placeholders": { "date": { "content": "$1" } }
  },
  "fullname": {
    "message": "$firstname$ $lastname$",
    "placeholders": {
      "firstname": { "content": "$1" },
      "lastname": { "content": "$2" }
    }
  }
}
```

## Usage

```bash
git clone https://github.com/antoine1003/Convert-PO-Editor-Export-To-Chrome-Extension-i18n.git
php po-editor-to-chrome-i18n.php path/to/json/file.json
# This will output a reminder of the above line
php po-editor-to-chrome-i18n.php -h 
```

All files will be exported in an `output` folder.
