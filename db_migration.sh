#!/bin/bash
cd src

drush --yes en demo config_update features features_ui database_configuration infanion_customer

# Clear cache after db changes
drush cache-rebuild
