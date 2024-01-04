
# Dynamic Forms Bundle

Dynamic form bundle allows to create and manage dynamic forms

# Installation

You need to install Stimulus Bundle to use Dynamic Fomrs Bundle.

Install this bundle using Composer and Symfony Flex:

	 $ composer require tkuska/dynamic-form  
If you're using WebpackEncore, install your assets and restart Encore (not  
needed if you're using AssetMapper):

	 $ npm install --force $ npm run watch  
	 # or use yarn 
	 $ yarn install --force $ yarn watch  

# Configuration

In file `package.json` place in *devDependencies* section

	"@tkuska/dynamic-form": "file:vendor/tkuska/dynamic-form-bundle/assets",  

In file `assets/controllers.json` add stimulus controller definition:

	"@tkuska/dynamic-form": { 
		"form-collection": { 
			"enabled": true, 
			"fetch": "eager" 
		} 
	}