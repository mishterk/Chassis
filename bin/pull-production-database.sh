#!/usr/bin/env bash

# THE REGULAR MIGRATION WE NEED TO RUN

# This will pull the prod database using WP Migrate DB Pro's CLI tool
wp migratedb pull {http://project-domain.com} {WP MDB Pro token} \
--find={FIND},{FIND} \
--replace={REPLACE},{REPLACE} \
--exclude-spam;