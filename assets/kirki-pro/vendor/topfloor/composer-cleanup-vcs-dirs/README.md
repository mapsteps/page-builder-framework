# composer-cleanup-vcs-dirs

If you're stuck needing to commit your composer dependencies,
you might find you need to delete some extra .git directories
after every time you install or update something with Composer.

While not a best practice, sometimes it's simply a requirement.

## How to use the plugin

When required in composer.json, the plugin will automatically
search for any .git directories in installed or updated 
dependencies and delete them immediately.

There's nothing else you need to do after requiring this plugin
in your main composer.json file.

## Running the command directly

You can also run the cleanup-vcs-dirs command directly in Composer.

To do so, simply run:

    composer cleanup-vcs-dirs

Your entire project will be scanned, and all child .git
directories under the project directory will be deleted.
