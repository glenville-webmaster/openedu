This file contains instructions for updating your OpenEDU Drupal site.

**IMPORTANT - 2.x Update:**

Due to the major changes in 3.x, there is no upgrade path from 2.x and requires 
manual updates and **may break your site**. Please do not attempt this update in
a production environment.

# General Update
### Updating OpenEDU from a previous version.
For a typical site that has a properly configured directory for exporting config
that is managed by your VCS, you would generally follow these steps

#### In your development or local environment.

1. Check the changelog for anything possibly conflicting with custom development.

2. Update your codebase/dependencies
        
        #!php
          composer self-update
          composer require imagex/openedu:~[OPENEDU_VERSION] --no-update
          composer update imagex/openedu --with-all-dependencies
        
3. Run any database updates.
  
        #!php
          drush cache:rebuild
          drush updatedb


4. Run any Lightning configuration updates.

        #!php
          drush cache:rebuild
          drush update:lightning

5. Export the new configuration.
  
        #!php
          drush config:export

6. Commit the code and configuration changes to your VCS and push them to your
   destination environment.
  
#### On your destination environment.

1. Run any database updates.
  
        #!php          
          drush cache:rebuild
          drush updatedb

2. Import any configuration changes.
  
        #!php
          drush cache:rebuild
          drush config:import

##### Lightning Note
OpenEDU is a subprofile of Acquia's Lightning profile, as such unless otherwise stated
in this file, you should also check for any additional update steps listed in the following file:
https://github.com/acquia/lightning/blob/8.x-3.x/UPDATE.md

# Version Specific Update Notes

### 8.3.3
* Lightning 3.2.0 is last release with panelizer, next release will be layout builder orientated
* Subprofiles are not supported in core, check https://www.drupal.org/project/drupal/issues/1356276?page=1 for more information

### 8.3.2
* No database updates required.
+ Added OpenEDU Subtheme module which extends existing themes:
    * change color schemes;
    * change logo image;
    * ability to add custom css.

### 8.3.1
* the `bin` directory has been replaced with `vendor/bin` to align with current Lightning release.
* Lightning Scheduler has updated, please check Lightning update doc above
 for instructions
* Flickety has been updated to 2.x version, you may need to update your configuration settings. See modules/features/openedu_core/config/install/openedu_core.settings.yml for an example. 
* Chosen has been added as a module rather than a static library in the theme, you
will need to merge the following into your `composer.json` file under repositories: 

```
    {
      "type": "package",
      "package": {
        "name": "harvesthq/chosen",
        "version": "1.8.2",
        "type": "drupal-library",
        "dist": {
          "url": "https://github.com/harvesthq/chosen/releases/download/v1.8.2/chosen_v1.8.2.zip",
          "type": "zip"
        },
        "require": {
            "composer/installers": "^1.2.0"
        }
      }
    }
```

### 8.3.0
* Complete rebuild of theme to allow proper subtheming, new content types and config.
* First release requiring lightning 3.0.0 and Drupal 8.5
* IXM Dashboard introduced
* Better search and Events
