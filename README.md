# 🧰 Maintenance Plugin for Geeklog

## Overview

The **Maintenance Plugin** allows administrators to temporarily place a Geeklog website into **maintenance mode**.  
When activated, non-administrative users and visitors see a customizable message instead of the normal website content.

This plugin works with **Geeklog 2.1.1 and newer (2.2.x compatible)** and integrates seamlessly with the Geeklog configuration manager.  
It automatically creates a PHP block and registers its topic assignment.

---

## ✨ Features

- Toggle **maintenance mode** directly from the Geeklog Configuration panel.  
- Display a **custom message** for visitors during maintenance.  
- Automatically creates the PHP block `maintenance_check`.  
- Compatible with **old and new Geeklog schemas** (`tid` detection).  
- Automatically adds topic assignment (`gl_topic_assignments`).  
- Full cleanup on uninstall (removes block, topic assignment, config).  
- Sends **503 Service Unavailable** headers for search engine crawlers.  

---

## 🧩 Installation

1. Copy the plugin folder to your Geeklog installation:
   ```
   /path/to/geeklog/plugins/maintenance/
   ```
2. Log in as a **Root** user.  
3. Go to:
   ```
   Admin → Plugins → Install New Plugin
   ```
4. Locate **Maintenance Plugin** and click **Install**.

During installation:
- A configuration group called `maintenance` is created.  
- The block `maintenance_check` is registered automatically.  
- Topic assignment (`tid = all`) is added so the block is active on all pages.

---

## ⚙️ Configuration

After installation, go to:
```
Admin → Configuration → Maintenance
```

| Setting | Description |
|----------|-------------|
| **Enable maintenance mode** | Turn the maintenance mode ON or OFF. |
| **Maintenance message** | Custom message displayed during maintenance. |

Changes take effect immediately.

---

## 🧭 Behavior

- When maintenance mode is **enabled**:
  - Anonymous users and non-admin members see the maintenance page.
  - Admins (Root group) can still access the full site.
  - Admins see a **red alert banner** as a visual reminder.
- Crawlers (Google, Bing, etc.) receive an **HTTP 503** response, indicating temporary unavailability.

---

## 🧹 Uninstallation

1. Go to:
   ```
   Admin → Plugins
   ```
2. Click **Uninstall** next to the Maintenance Plugin.

This will:
- Remove the `maintenance` configuration group  
- Delete the `maintenance_check` block  
- Remove topic assignments  
- Unregister the plugin  

Everything is cleaned automatically.

---

## 🧠 Compatibility

| Component | Version |
|------------|----------|
| **Geeklog** | 2.1.1 → 2.2.x |
| **PHP** | 7.4+ |
| **Database** | MySQL / MariaDB |

The plugin automatically adapts to the database schema (checks for `tid`).

---

## 📁 File Structure

| File | Description |
|------|--------------|
| `autoinstall.php` | Handles installation logic and automatic configuration. |
| `functions.inc` | Core logic to control access and display behavior. |
| `install_defaults.php` | Default configuration values. |
| `language/english.php` | English language file. |
| `language/french.php` | French translation. |
| `templates/maintenance.thtml` | Template for the maintenance page. |
| `README.md` | This documentation. |

---

## 🧾 License

Licensed under the **GNU General Public License v2** (or later).  
See the included LICENSE file for details.

---

## 👤 Author

**Ben**  
Maintained by the **Geeklog Community**

Contributions, feedback, and pull requests are welcome.  
If you find a bug or wish to suggest an improvement, open an issue on GitHub.

---

> “Simple, compatible, and safe — the easiest way to put your Geeklog site in maintenance mode.”
