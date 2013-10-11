GitHub Plugin Update Checker
===========================

This is a custom update checker library for WordPress plugins. 
It is an adaptation from [YahnisElsts / plugin-update-checker](https://github.com/YahnisElsts/plugin-update-checker):
 - the Debug mode and files have been removed, thus reducing everything to 2 files (the updater class and the JSON). 
 - the classes renamed so as to not being confused with the originals.

In this example, we are dealing with GitHub updates, as there are some specifics that have to been take care of. 
For usage in other update platforms, refer to the original.

In this sample plugin, the Repository slug is defined in

```php
public static $repo_slug = 'github-plugin-update-checker';
```

Also, adjust the user name in the URL

```php
include_once 'inc/plugin-update-checker.php';
$updateChecker = new PluginUpdateCheckerB(
    'https://raw.github.com/brasofilo/'.self::$repo_slug.'/master/inc/update.json', 
    __FILE__, 
    self::$repo_slug.'-master'
);
```

The JSON file consists of:

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

This example will always ask for an update. As the plugin header says Version `0.1`, 
and the meta file says `0.2`. Note that the slug has the prefix `-master`.

