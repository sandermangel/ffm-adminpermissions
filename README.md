# Ffm_Adminusersubscriptions
This module adds the option to duplicate an admin role with all of it's rules.
A new role is created with all the origionals settings and '[DUPLICATE]' added in the name.

Installation Instructions
-------------------------

### Via modman

- Install [modman](https://github.com/colinmollenhour/modman)
- Use the command from your Magento installation folder: `modman clone https://github.com/sandermangel/ffm-adminpermissions`

### Manually
- You can copy the files from the folders of this repositories `src` directory to the same folders of your installation

### Installation in ALL CASES
* Clear the cache, disable compiler, logout from the admin panel and then login again.

Uninstallation
--------------
* Remove all extension files from your Magento installation

## Usage

Configure the different loggers in `System > Permissions > Roles > [ROLE] > Duplicate`


## Further Information

### Contributors

* Sander Mangel <sander@sandermangel.nl>

### How to contribute

Make a fork, commit to develop branch and make a pull request

Licence
-------
[The Open Software License 3.0 (OSL-3.0)](http://opensource.org/licenses/OSL-3.0)
