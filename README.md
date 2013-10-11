GitHub Plugin Update Checker
===========================

*A custom update checker for WordPress plugins. 
Useful if you can't or don't want to host your plugin in the official WP plugin repository, 
but would still like it to support automatic plugin updates.*

Adaptated from [***YahnisElsts / plugin-update-checker***](https://github.com/YahnisElsts/plugin-update-checker), main changes:
 - Debug mode (and files) have been removed, thus reducing everything to 2 files (the updater class and the JSON). 
 - Classes renamed so as to not being confused with the originals.
 - Sample data adapted to work with GitHub<sup>`*`</sup> hosted plugins.

<sup>`*` When dealing with GitHub updates there are some specifics that have to been take care of. 
Specially because of the `-master` suffix. 
For usage in other update platforms, refer to the original.</sup>

###Demo mode
This demo plugin will always ask for an update. As the plugin header says Version `0.1`, 
and the meta file says `0.2`. Take special attention for the use of the prefix `-master`.


###Plugin Slug

In this sample plugin, the Repository slug is [defined in](/plugin-example.php#L24):

```php
public static $repo_slug = 'github-plugin-update-checker';
```

###Adding the class and instantiating a new updater
Adjust the [user name](/plugin-example.php#L57) in the URL. Check the [**documentation**](http://w-shadow.com/blog/2010/09/02/automatic-updates-for-any-plugin/).

```php
include_once 'inc/plugin-update-checker.php';
$updateChecker = new PluginUpdateCheckerB(
    'https://raw.github.com/brasofilo/'.self::$repo_slug.'/master/inc/update.json', 
    __FILE__, 
    self::$repo_slug.'-master'
);
```

###Renamer hook
[Workaround](/plugin-example.php#L102) to remove the suffix "-master" from the unzipped directory after upgrading

```php
add_filter( 'upgrader_source_selection', array( $this, 'rename_github_zip' ), 1, 3 );
```

###Update configuration file
The JSON file [consists of](/inc/update.json) (check the [**available fields**](http://goo.gl/rQxS5o) ):

```json
{
    "name" : "Plugin Name",
    "slug" : "plugin-slug-master",
    "download_url" : "https://github.com/username/plugin-slug/archive/master.zip",
    "version" : "0.1",
    "author" : "Author Name",
    "author_homepage" : "http://example.com",
    "homepage" : "https://github.com/username/plugin-slug",
    "tested" : "3.6",
    "sections" : {
        "description" : "Update plugins from GitHub hosted repositories.",
        "changelog" : "<p><ul><li><strong>0.1</strong><p>Plugin launched.</p></li></ul>"
    },
    "upgrade_notice" : "Version 0.2 Plugin fake upgrade.",
    "last_updated" : "2013-10-09"
}
```


