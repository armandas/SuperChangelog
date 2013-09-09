SuperChangelog
==============

SuperChangelog is a tool developed with an aim to make it easier to maintain multiple changelogs. SCL will be most effective in situations where a code base is shared accross multiple products and the same change needs to be added to several changelogs.

Being a web application, SCL comes with an added benefit of having all your changelogs in a central location, allowing you to quickly see the latest changes as well as current versions of all your products.

Requirements
------------

* Server: `PHP 5`, `MySQL`.
* Client: `HTML 5`, `CSS 3` and `JavaScript`.

Installation
------------

Start by downloading the files to your server and directing your browser to the `setup.php` script. At this point, you will get a bunch of errors and the setup will fail. Assuming you have a compatible version of PHP, here's what you need to do next:

* Open the database configuration file (`include/db.php`) and fill in the correct values.
* Grant write permissions to the `tmp/` directory. This directory is will contain the compiled template script as well as SCL setup signature.

Now refresh the setup page and, hopefully, the installation will be completed successfully.

Usage
-----

### Administration

On a fresh install, you will want to start by adding some products. The "administration" page can be accessed by double-clicking on the footer (i.e. the "Powered by" text)<sup>‡</sup>. Here, you can add new products and deactivate the ones that are irrelevant at that point.

If you need to delete products or perform more sophisticated housekeeping tasks, you will need to use a database administration tool, such as phpMyAdmin.

<sup>‡</sup> It should be obvious that this is NOT a security feature, but rather a user interface design quirk. The reasoning is that you don't need to use this page very often and so it should not clutter the main menu. On the other hand, it needs to be quickly accessible from the application itself.

### Day-to-day use

Daily usage will include adding changes, creating releases and viewing/downloading changelogs. All these features are accessible from the main menu at the top.

The workflow is as follows: you develop your product and add the changes to the log. When the development cycle ends, you add a release and all the changes added until then will be assigned to this new release.

You cannot make a release with no changes. If this is required, just add a change that says "No changes in this release" or, if it's your first release, log an "Initial release".
