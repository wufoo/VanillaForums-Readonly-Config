##Read Only Config for Vanilla Forums

###Introduction

We at Wufoo needed a way to define functions for the DB connection strings, but config.php overwrites functions with strings at config save.  After a long [discussion](http://vanillaforums.org/discussion/comment/130917/#Comment_130917) with the super-helpful guys at VanillaForums, we decided this application was the best way to override this behavior.  

I wrote the project to help those who need to set configuration settings in a read/write way on localhost, but in a read-only way in the production environment.

###Instructions

1. set up the ExampleConfig class to contain the variables you need
1. install
1. rejoice

###Notes

If you're in a read-only environment, you're probably frustrated because saving the config.php file throws errors when you attempt to save your settings.  You can change this behavior by adding this code around line 375 in class.configuration.php.  If the guys from vanilla suggest a better way of handling this problem, I'll be happy to add it to the application.  For now, this is my way.  The Config class below is our own.  You'll have to create one to make this work.

	if (!is_writable($File)) {
		if (Config::jobServerName() == 'local' || Config::jobServerName() == 'dev') {
			return TRUE;
		} else {
			throw new Exception(sprintf(T("Unable to write to config file '%s' when saving."),$File));
		}
	}