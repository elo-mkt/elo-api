# Elo Api Library

## Server dependencies
`sudo apt-get install php7.x-gmp`

## Usage
To include this library in other projects, you have to add 
following lines to your projects `composer.json` file.

```json
{
	"require": {
    		"catskillet/elo-api": "{VERSION}"
    	},
	"repositories": [
		{
			"type": "vcs",
			"url": "git@git.catskillet.com:elo/elo-api.git"
		}
	],
}
```

Note that the `{VERSION}` should be a valid version like `1.0.x`, `1.0.1`.
To get the current developed version use `dev-master` or `master`, both 
are pointing to the same branch.

