# Item Copy for Omeka S

Item Copy adds a **Copy item** action to every row of the administrative item
browse page. The copy contains the source item's metadata, resource class,
resource template, item sets and visibility. Media are deliberately not copied.

After creating the copy, the module opens its edit page so it can be reviewed
before further use.

## Requirements

- Omeka S 3.x or 4.x
- PHP 7.4 or later

## Installation

1. Download the release archive and extract it into the Omeka S `modules`
   directory.
2. Make sure the directory is named `ItemCopy`.
3. In the Omeka S administrative interface, open **Modules** and install
   **Item Copy**.

See the [Omeka S module installation documentation](https://omeka.org/s/docs/user-manual/modules/#installing-modules)
for general installation guidance.

## Usage

Open **Resources > Items**, then select the copy icon in an item's action list.
Confirm the operation. The normal Omeka S authorization rules apply: a user can
only read and create resources allowed by their role.

No API keys or source-code configuration are needed. Copying is performed on
the server with the logged-in user's session and a CSRF-protected POST request;
credentials are never stored in browser assets.

## Upgrade from 1.x

Remove any API credentials previously entered in `asset/item-copy.js`. Version
2.0 no longer uses them. Replace the complete module directory when upgrading,
then confirm that Omeka S reports version 2.0.0 on the Modules page.

## License

WTFPL. See [LICENCE.md](LICENCE.md).
