[![Release](https://github.com/mattdemarillac/acf-custom-fields-plugin/actions/workflows/main.yml/badge.svg)](https://github.com/mattdemarillac/acf-custom-fields-plugin/actions/workflows/main.yml) 

# Custom Site Functions

A lightweight WordPress plugin for managing site-specific functionality using ACF.

Created by **Matthew de Marillac**.

---

## 🚀 Features

This plugin provides centralized site functionality including:

### 🛒 WooCommerce Enhancements
- Displays a custom holiday notice on the checkout page
- Dynamically shows shipping return dates
- Fully controlled via ACF settings

### ⚙️ ACF-Driven Configuration
All settings are managed via a single ACF options page (ID: `66313`), including:
- Holiday notice enable/disable toggle
- Holiday start date
- Holiday return date
- Customisable notice message

---

## 🧠 How It Works

The plugin hooks into WooCommerce checkout:

- Checks if holiday notice is enabled
- Validates date range (start → return)
- Compares against current site timezone
- Displays a formatted WooCommerce notice during the holiday period

Example output:

> To our valued customers, we are currently on a short break. Orders can still be placed and will be shipped on **[return date]**.

---

## 🛠 Requirements

- WordPress 5.8+
- WooCommerce
- Advanced Custom Fields (ACF)
- PHP 7.4+

---

## ⚙️ ACF Fields Required

This plugin expects the following fields on options page ID `66313`:

| Field Name | Type | Description |
|------------|------|-------------|
| `holiday_notice_enabled` | True/False | Enable/disable holiday notice |
| `holiday_start_date` | Date Picker (d/m/Y) | Start of holiday period |
| `holiday_return_date` | Date Picker (d/m/Y) | Return / shipping resume date |
| `holiday_notice` | Text / WYSIWYG | Message shown to customers |

---

## 📦 Installation

### Manual Install
1. Download the latest release ZIP
2. Upload to `/wp-content/plugins/`
3. Activate via WordPress admin
4. Configure ACF fields

---

## 🔁 GitHub Releases

This plugin is designed to work with GitHub Releases for updates and deployments.

Each tagged release (e.g. `v1.0.0`) generates a production-ready ZIP.

---

## 🧪 Development

To build locally:

```bash
composer install
