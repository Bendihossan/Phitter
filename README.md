Phitter!
====================

Because Twitter apps appear to be the "Hello, World!" of modern development, Phitter is an experiment in building a simple command line app in PHP using the Symfony Console component.

Current build status: [![Build Status](https://travis-ci.org/Bendihossan/Phitter.png)](https://travis-ci.org/Bendihossan/Phitter)

Basic Usage
====================
Phitter! uses the Symfony Console component to register commands.

Run ``php bin/phitter`` to find out the available commands:
```
Available commands:
home
  home:mentions   Lists latest mentions for this user.
  home:retweets   Lists latest retweets for this user.
  home:timeline   Lists latest tweets from your followers.
  home:tweet      Post a new tweet.
user
  user:show       Lists info for a user.
  user:timeline   Lists latest tweets from a user. Defaults to you.
```

Coming soon!
====================

* More API endpoints
* Tests

Contribute
====================
1. Fork the repository and download the source to your development workspace and run ``bin/composer install``.
2. Copy ``Resources/config/parameters.json.dist`` to ``Resources/config/parameters.json`` and populate with your own Twitter tokens.
3. Checkout a branch for your code
4. Write the logic for your command in ``src/Bendihossan/Phitter/Command``.
5. Register your new command in ``bin/phitter``.
6. Write unit tests for your command.
7. Commit and push your code to GitHub, make a Pull Request to the Phitter! project.

Contact
====================
Contact: [contact@steffanharries.me.uk](mailto:contact@steffanharries.me.uk)
