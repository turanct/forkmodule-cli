#!/bin/sh

# Get ENV variable
PREFIX=${PREFIX:='/usr/local'}

# Clone the git repo
git clone https://github.com/turanct/forkmodule-cli.git $PREFIX/forkmodule-cli

# cd to the forkmodule-cli directory
cd $PREFIX/forkmodule-cli

# Get composer
curl -sS https://getcomposer.org/installer | php

# Install dependencies using composer
php composer.phar install

# Symlink to $PREFIX/bin
ln -s $PREFIX/forkmodule-cli/forkmodule.php $PREFIX/bin/forkmodule

# Get back to where we once belonged
cd -
