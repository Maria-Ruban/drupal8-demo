#!/bin/bash
cd src

drush --yes en demo config_update features database_configuration

# Clear cache after db changes
drush cache-rebuild
