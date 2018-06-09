# PHP-Twitch-lib

### Please Note That This library in its current state will only work until 31-Dec-2018. This library will be updated to the new api later this year so keep checking this Repository so that your up-to-date

To get this to work you need to add the following lines to your php file

```php
    include 'path/to/config.php';
    require_once 'path//twitch.php';
```
Before the code works please edit in config.php the values for client-id and access-token if you already have a config.php add the following to it:

```php
    $config['Twitch_Client-id'] = 'YOUR CLIENT ID';
    $config['Twitch_Access-token'] = 'YOUR ACCESS TOKEN';
```

You can find examples in the index.php file

To get a access-token:
+ Go to the [Twitch Developers area.](https://dev.twitch.tv/dashboard)
+ Login if your not already logged in.
+ Click on view apps.
+ Click on Register Your Application.
+ Give it a name.
+ Set the OAuth Redirect URL to http://localhost.
+ And select Website Intergration as catagory.
+ Click on create.
+ Copy your client-id and add it into your config.
+ To gain a access-token go to:
```
https://api.twitch.tv/kraken/oauth2/authorize612?client_id=YOUR-CLIENT-ID&redirect_uri=http://localhost&response_type=code&scope=channel_subscriptions
```
+ After you Authorize yourself you will see in http://localhost?code=YOUR-ACCESS-TOKEN in the url bar.
+ Add your access token into the config file and your ready to go.
