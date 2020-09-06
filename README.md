# Heck-AllyBot-API

Kingdoms of Heckfire Allybot API paired with discord.js bot

## Requirements

```
PHP
MySQL® Database
Node
Discord
```

## Installation

Import ```api.sql```to database

Fill in db creds API ``` api/config/database.php ```
```php
private $host = "localhost";
private $db_name = "db_name";
private $username = "username";
private $password = "password";
```


Fill website URL in at ``` api/config/core.php ```

```php
$home_url="https://website.com/api/";
```

Create a discord application and fill in the token at ``` discord/config.json ```
```json
{
"prefix": "!",
"token": "discordapptoken",
"api-url": "https://www.website.com/api"
}

```

## Usage

Starting the bot

```bash forever start -o out.log -e err.log bot.js ```


Create a new discord channel, invite the bot and use ```!help```



```
Search for someones allies using `!allies owner`

List someones allies using `!list owner`

Add an ally using `!add name value owner clan`

Update an ally using `!update name value owner clan`

Delete an ally using `!delete name`

List allies gathered for specific clans `!clan clan`

Show all clans in database `!clanlist`

Search specific price `!value 300m` or `!value 133415849`

List clan pins `!pins 95` or `!pins 23`

Add a pin using `!pin clan x y realm`

```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.