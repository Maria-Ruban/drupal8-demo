#!/bin/bash
cd src

drush --yes en demo

# Clear cache after db changes
drush cache-rebuild
