Lelesys News Plugin
======================

This plugin adds news to your websites.

##### Important note: Initial package development was done when TYPO3 Neos was at alpha3/4. We are working hard continuously to get this to work perfectly and to beautify source code using best practices/concepts of Flow/Neos. Stay tuned!

Quick start
---------

* Run composer require "lelesys/plugin-news:1.0.1"

* Run ./flow doctrine:migrate

* Add following in top level Configuration/Routes.yaml just before the TYPO3 Neos route.

```
-
  name: 'news routes'
  uriPattern: '<LelesysPluginNewsSubroutes>'
  defaults:
    '@package': 'Lelesys.Plugin.News'
    '@format' : 'html'
  subRoutes:
    LelesysPluginNewsSubroutes:
      package: Lelesys.Plugin.News
```

* Add following line in your Site package’s Root.ts2

```
include: resource://Lelesys.Plugin.News/Private/TypoScripts/Library/NodeTypes.ts2
```

* Add NewsAdmin role to your backend user

```
./flow user:addrole USERNAME Lelesys.Plugin.News:NewsAdmin
```

* Now you can goto Neos backend and you will see News Management backend module and submodules. You can create a Folder then you can create Categories and News records for the Folder.

* On Neos page you can put the News list plugin e.g. and select the Folder in the inspector. You can also change the template paths from the inspector for this plugin.
