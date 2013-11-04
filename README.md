Forkmodule-cli
========================================


Forkmodule-cli is a simple php command line program that helps you create new plugins for [ForkCMS](http://fork-cms.com/) by creating a skeleton of boilerplate directories and files that you otherwise need to create by hand.



1. Features
----------------------------------------

Currently Forkmodule-cli only supports creating a module from scratch. It will create all frontend and backend actions and widgets files that you need. You can then get started with writing code instead of creating directories for half an hour.



2. Configuration
----------------------------------------

When you run forkmodule-cli, it will ask you everything it needs to know.



3. Installing forkmodule-cli on your system
----------------------------------------

Assuming you're on Mac OSX or GNU/Linux with `git`, `php` and `curl` installed:

	FORKMOD_PWD=`pwd` && git clone https://github.com/turanct/forkmodule-cli.git /usr/local/forkmodule-cli && cd /usr/local/forkmodule-cli && curl -sS https://getcomposer.org/installer | php && php composer.phar install && ln -s /usr/local/forkmodule-cli/forkmodule.php /usr/local/bin/forkmodule && cd $FORKMOD_PWD

Or you could just do this:

	curl https://raw.github.com/turanct/forkmodule-cli/master/install.sh | sh

You can now run the `forkmodule` command from your command line.



4. License
----------------------------------------

Forkmodule-cli is licensed under the *MIT License*
