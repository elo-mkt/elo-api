# Elo Api Library

To include this library in other projects, you have to add 
following lines to your projects `composer.json` file.

```json
{
	"require": {
    		"catskillet/elo-api": "dev-master"
    	},
	"repositories": [
		{
			"type": "package",
			"package": {
				"name": "catskillet/elo-api",
				"version": "dev-master",
				"source": {
					"url": "git@git.catskillet.com:elo/elo-api.git",
					"type": "git",
					"reference": "{TAG-VERSION}"
				},
				"autoload": {
					"psr-0": {
						"Elo\\Api": "src"
					}
				}
			}
		}
	],
}
```

Note that the `{TAG-VERSION}` should be a valid tag name like `0.0.1` 
or use `master` if you would like to use the latest version. 

