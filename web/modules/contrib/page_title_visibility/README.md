Page Title Visibility
---------------------

 * Introduction
 * Using the module
 * Notes on accessibility/SEO
 * Maintainers

INTRODUCTION
------------
By default in Drupal, page titles display on every node. Modifying this behavior via the Block UI (in Drupal 8, the page title is a block) is not ideal, and is unmanageable on a per-node basis. Enter *Page Title Visibility*, which adds an on/off checkbox to nodes for making the title visible. 

In addition, a per-content type default setting is provided on the node type edit form.

![alt text](https://www.drupal.org/files/page-title-visibility.gif "Toggle on and off page title visibility")

USING THE MODULE
-----------------------------------
**Content type default**

After enabling this module, go to any node content type's edit page
(e.g., `/admin/structure/types/manage/page`). Expand the "Page Display Defaults" fieldset and choose either whether or not to *Default to "Display page title" on.*
* **NOTE:** only users with the `administer page display visibility config` permission will be able to control this
* **NOTE:** this setting is only a default; once a node is saved, its entity-level setting takes precedence. Changing the node type default will only change the starting state of the checkbox for newly created nodes.

**Per node setting**

Once this module is enabled, a new on/off checkbox will appear in the advanced tabs on all node edit form, under the "Page Display Options" section. When the checkbox is "on", the page title will be visible. When the checkbox is "off", the page title will not be visible.

NOTES ON ACCESSIBILITY/SEO
--------------------------
Drupal page titles typically are printed in `<h1>` tags. Since this tag is important for both accessibility and search engine optimization, this module does not remove the title block, but rather renders it with Drupal's `.visually-hidden` CSS class:

```
.visually-hidden {
    position: absolute !important;
    overflow: hidden;
    clip: rect(1px,1px,1px,1px);
    width: 1px;
    height: 1px;
    word-wrap: normal;
}
```

MAINTAINERS
-----------
Current maintainers:
 * [lreynaga](https://www.drupal.org/u/lreynaga)
 * [gravelpot](https://www.drupal.org/u/gravelpot)
 * [mark_fullmer](https://www.drupal.org/u/mark_fullmer)
 * [twfahey](https://www.drupal.org/u/twfahey)

This project has been sponsored by:
* [The University of Texas at Austin](https://www.drupal.org/university-of-texas-at-austin)