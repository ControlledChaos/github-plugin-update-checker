GitHub Plugin Update Checker
===========================

Custom update checker library for WordPress plugins. 

It's an adaptation from [YahnisElsts / plugin-update-checker](https://github.com/YahnisElsts/plugin-update-checker):
 - the Debug mode and files have been removed, thus reducing everything to 2 files (the updater class and the JSON). 
 - the classes renamed so as to not being confused with the originals.

When dealing with GitHub updates there are some specifics that have to been take care of.  
Specially because of the `-master` suffix.  
For usage in other update platforms, refer to the original.

This demo plugin will always ask for an update. As the plugin header says Version `0.1`, 
and the meta file says `0.2`. Take special attention for the use of the prefix `-master`.


###Plugin Slug

In this sample plugin, the Repository slug is defined in

```php
public static $repo_slug = 'github-plugin-update-checker';
```

###Adding the class and instantiating a new updater
Adjust the user name in the URL. Check the [**documentation**](http://w-shadow.com/blog/2010/09/02/automatic-updates-for-any-plugin/).

```php
include_once 'inc/plugin-update-checker.php';
$updateChecker = new PluginUpdateCheckerB(
    'https://raw.github.com/brasofilo/'.self::$repo_slug.'/master/inc/update.json', 
    __FILE__, 
    self::$repo_slug.'-master'
);
```

###Update configuration file
The JSON file consists of (check the [**available fields **](http://goo.gl/rQxS5o) ):

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


