#!/bin/bash
cd src

#drush --yes en features

# Clear cache after db changes
drush drush cache-rebuild
