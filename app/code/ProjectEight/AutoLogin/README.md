# ProjectEight AutoLogin

## Purpose

Automatically performs admin login whenever the admin login page is loaded.

Obviously this should only be installed on local dev sites. No responsibility is taken for installing it anywhere else.

## Installation

```bash
# Add github repository to composer first
composer require --dev projecteight/module-autologin
```

## Road map

- [ ] Add IP restriction
- [ ] Add ability to enable/disable module in admin
- [ ] Add ability to choose the admin user profile to use
- [ ] Add feature to count failed logins and stop attempting to login after a configured number of times
