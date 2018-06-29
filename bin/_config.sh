#!/usr/bin/env bash

#override any of these along with any other variables used in the chassisrun() command here

#project_dir='.';
#debug_log='logs/wordpress/debug.log';
#dev_log='logs/wordpress/dev.log';
#npm_dir='wp-content/themes/project-theme/assets';
#npm_run_command='ls-scripts';
site_domain="http://{{DOMAIN}}";

# add more repos on additional lines within the array. No comma needed. These will all open in separate GitTower windows
#declare -a repos=(
#'wp-content'
#'wp-content/themes/some-theme'
#'wp-content/plugins/some-plugin'
#);

# these are passed into the vagrant ssh -c '' command arg
# e.g;
# append '; exec $SHELL' to remain logged in
#startup_tasks='';