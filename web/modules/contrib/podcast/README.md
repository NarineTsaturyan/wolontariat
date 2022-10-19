# Podcast (using Views)

CONTENTS
--------

 * Introduction
 * Usage
 * Feed Requirements
 * Maintainers


INTRODUCTION
------------

Podcasts is a module that aims to create a podcast feed using Views.

Watch a tutorial on **Youtube**
https://www.youtube.com/watch?v=ApQ3P0XI3S4

USAGE
-----

Create a Feed view and then select the style and fields options as shown in the captures.

 * Go to Structure > Views.

 * Select Add view.

 * Under View Settings, select the correct content type for the podcast episodes.

 * It isn't required to select Page or Block at this point.

 * Click Save and edit.

 * At the top of the new View, select Add then click Feed. This will generate a new feed View.

 * Under Format, click RSS Feed and then select Podcast RSS Feed.
   ![Select format](https://www.drupal.org/files/select-style.png)

 * Add all the fields that will go into the RSS feed using common Views techniques. There is nothing specific to this module to extract the data from Drupal. Once the data is extracted as fields using views, start the field  mapping. NOTE: to add static information (not contained in any content type) use the Custom text field shipped with views to input arbitrary text (that text can be mapped to a property in the podcast feed later).

 * Use the select boxes to map the fields to the channel/show properties in the resulting XML.
   ![Map channel options](https://www.drupal.org/files/channel-options.png)

 * **Select Podcast Fields.** Under the Format section select Podcast Fields for show.
   ![Podcast fields](https://www.drupal.org/files/select-fields_1.png)

 * **Podcast episode properties**. Use the select boxes to map the fields to the item/episode properties in the resulting XML.
   ![Options for each view item/row](https://www.drupal.org/files/item-options.png)

 * When all of the fields that need to be included on the podcast feed are mapped don't forget to set the feed path.

 * Under Feed Settings, click on "No path is set".

 * Enter an appropriate path and it is always helpful to end the path with "rss.xml" but it is not required.

 * Save the view.


FEED REQUIREMENTS
-----------------

Once the podcast feed has been created, it is a good idea to validate the feed before submitting it to any
podcast library. There are many validators out there but here is one of the more popular validators currently
available.

 * https://podba.se/validate/

Learn more about what fields are required for a podcast feed. iTunes is the currently
"standard" for podcast feeds.

 * https://help.apple.com/itc/podcasts_connect/


MAINTAINERS
-----------

Current maintainers:

 * Mateu Aguiló Bosch (e0ipso) - https://www.drupal.org/u/e0ipso
 * Rodrigo Aguilera (rodrigoaguilera) - https://www.drupal.org/u/rodrigoaguilera
