# Group Countries

The **Group Countries** module provides a taxonomy vocabulary that automatically organizes countries by continent/region.
It uses the [FIRST.org Countries API](https://api.first.org/data/v1/countries) to fetch countries and group them under their respective regions.

---

## Features

- Creates a vocabulary `continent_countries` with:
  - **Parent terms**: continents/regions (e.g. *Europe, Africa, Asia*).
  - **Child terms**: countries belonging to that region.
- Automatically adds a `field_iso2` to each term to store the ISO 2 country code.
- Terms are created during module installation.
- Vocabulary is automatically removed when the module is uninstalled.

---

## Requirements

- Drupal 9 or 10
- Internet access to reach the FIRST.org API

---

## Installation

1. Install as you would normally install a Drupal module:
   - Place the module in `modules/custom/group_countries`
   - Enable via `drush en group_countries` or through the Drupal UI.
2. On installation:
   - A vocabulary `continent_countries` will be created.
   - Countries will be fetched from the API and organized under continents.
   - Each country will have its ISO 2 code stored in `field_iso2`.

---

## Usage

- Go to **Structure > Taxonomy > Countries** to see the generated terms.
- You can reference this taxonomy from:
  - Content types
  - User profiles
  - Custom entities
- Example: Add a taxonomy term reference field to "User" to allow users to select their country.

---

## Configuration

Currently, the module works automatically without configuration.
Future enhancements may include:
- Caching the API response
- Cron job to refresh the list
- Admin UI to re-import or update countries

---

## Uninstallation

When the module is uninstalled:
- The vocabulary `continent_countries` and all its terms are deleted.
- The `field_iso2` field is removed.

---

## Maintainers

- Initial developer: [Ben Mansour Marouan](https://www.drupal.org/u/admin2020)

Contributions are welcome via merge requests and issue queue.

---

## License

This project is licensed under the GPL v2. See the [LICENSE.txt](https://www.drupal.org/licensing/faq) for details.
