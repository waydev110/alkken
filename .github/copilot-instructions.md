# Copilot Instructions for Alkken MLM System

## Project Overview
This is a PHP-based Multi-Level Marketing (MLM) system with binary/unilevel compensation plans, running on XAMPP (Apache/MySQL). The system manages member networks, bonuses, product sales, and includes separate admin, member, and stokis (reseller) portals.

## Architecture

### Three-Portal Structure
- **`memberarea/`** - Member dashboard and operations (main user interface)
- **`adminarea/`** - Administrative control panel for system management
- **`stokisarea/`** - Reseller/distributor portal for inventory management

### Core Directory Structure
```
helper/       - Shared utility functions (auth, config, view helpers)
model/        - Business logic classes (class*.php pattern)
assets/       - Frontend resources (Bootstrap, jQuery, plugins)
images/       - User-uploaded media organized by feature
vendor/       - Third-party dependencies (PHPMailer, QRCode)
```

## Key Conventions

### Routing Pattern
All portals use `routes.php` with query string navigation: `?go=page_name`
- Routes map to views in `view/` subdirectories
- Example: `?go=member_create` → `view/member/member_create.php`
- Default route is `home` when no `go` parameter is provided

### Class Naming & Structure
- **Models**: `class[EntityName].php` (e.g., `classMember.php`, `classBonus.php`)
- **Database Connection**: `classConnection` handles all DB operations via mysqli
- **CRUD Base**: `classCRUD` extends `classConnection` with magic methods for attributes
- All model classes use `require_once 'classConnection.php'`

### Database Patterns
- **Connection Methods**:
  - `_query($sql)` - Execute query
  - `_query_fetch($sql)` - Return single row as object
  - `_query_insert($sql)` - Return last insert ID
  - `_queryPrepared($sql, $params, $types)` - Prepared statements
- **Table Naming**: `mlm_[entity]` (e.g., `mlm_member`, `mlm_bonus_sponsor`)
- **Soft Deletes**: Check `deleted_at IS NULL` in queries
- **Magic Methods**: Models use `__get()` and `__set()` via `$attributes` array

### Helper Functions Organization
- **`helper/all.php`** - Master include file that loads all helpers
- **`helper/config.php`** - Business logic functions (encryption, order IDs, file uploads)
- **`helper/view.php`** - Display formatters (status badges, currency, dates)
- **`helper/language.php`** - Multi-language labels via `$lang` array
- **`helper/auth.php`** - Session validation and user authentication

### Session Management
- Members: `$_SESSION['session_member_id']`, `$_SESSION['session_user_member']`
- Admins: `$_SESSION['user_login']`, `$_SESSION['nama_login']`
- Profile completion flag: `$_SESSION['profile_updated']` (forces profile update if '0')

## MLM-Specific Patterns

### Binary Tree Structure
- **Binary Mode**: Controlled by `$_binary` flag (global config)
- Members have `kaki_kiri` (left leg) and `kaki_kanan` (right leg)
- Points track via `mlm_member_poin` and `mlm_member_poin_pasangan` tables
- Genealogy functions: `GenerasiUpline($id)`, `GenerasiSponsor($id)` (stored procedures)

### Bonus System
- **Types**: sponsor, pasangan (binary), generasi (unilevel), cashback, reward, netborn
- **Status Flow**: `-1` (hidden) → `0` (pending) → `1` (transferred) or `2` (rejected)
- **Bonus Tables**: `mlm_bonus_[type]` with `status_transfer` tracking
- **Processing**: Admin transfers bonuses via `controller/bonus/*/transfer.php`

### Order ID Generation
- Format: `INV[YYYYMMDD][0001]` via `generateKodeOrder($id, $date)`
- Withdrawals: `TRX[YYYYMMDD][0001]` via `idWD($id, $date)`
- Extract ID from code: `extractIdFromOrderCode($code)` returns last 4 digits

### Key Business Rules
- **Binary vs. Unilevel**: `$_binary = true` enables binary compensation
- **RO Aktif**: Repeat Order activation tracked via `jenis_aktivasi = 14`
- **Autosave**: Special wallet type (`jenis_saldo = 'poin'`) for forced savings
- **Stokis**: Resellers manage inventory and process member orders
- **Reposisi**: Member repositioning flag (`reposisi` field)

## Development Workflow

### Local Environment
- **Database**: MySQL via phpMyAdmin at `http://localhost/phpmyadmin`
- **Config**: `classConnection::openConnection()` switches on `$_SERVER['SERVER_NAME']`
- **Timezone**: Asia/Jakarta (set in `classConnection.php`)

### Database Connection Pattern
```php
$c = new classConnection();
$query = $c->_query("SELECT * FROM mlm_member WHERE id = '$id'");
$member = $c->_query_fetch("SELECT * FROM mlm_member WHERE id = '$id'");
```

### View Rendering Flow
1. Portal `index.php` validates session and loads `helper/all.php`
2. `routes.php` maps `$_GET['go']` to view file path
3. View includes `view/layout/header.php` and renders content
4. Controllers in `controller/[feature]/` handle AJAX operations

### Common Patterns
- **DataTables**: Server-side via `datatable()` method in models
- **File Uploads**: `storeImage()` and `storeFile()` in `helper/config.php`
- **Currency Display**: `currency($amount)` formats with thousand separators
- **Date Formatting**: `tgl_indo($date)` for Indonesian date format

## Security Considerations
- **SQL Injection**: Most queries use string concatenation - use `_queryPrepared()` for new code
- **Encryption**: `encrypt()` and `decrypt()` functions use AES-256-CBC with hardcoded key
- **Session Validation**: Check exists at top of `index.php` in each portal
- **Input Sanitization**: `clean_input()` uses `htmlspecialchars()` and `trim()`

## Testing & Debugging
- **Error Reporting**: Enabled in memberarea (`ini_set('display_errors', 1)`)
- **Log Files**: Bonus processing logs in `log/bonus_[type]/`
- **Monitor Connections**: `adminarea/monitor_connections.php` tracks active sessions

## Common Gotchas
- Binary mode affects available features - check `$_binary` flag before binary-specific code
- Profile completion forces redirect - check `$profile_updated` session variable
- Maintenance mode redirects all members - controlled by `$_maintenance` in `helper/config.php`
- Order IDs are display-only - always use numeric `id` for database operations
- Soft deletes require `deleted_at IS NULL` in ALL queries

## File Organization Tips
- Controllers typically return JSON for AJAX operations
- Views combine PHP and HTML - avoid inline styles, use centralized CSS files
- Models handle both business logic AND presentation (datatable formatting)
- Language labels avoid hardcoded text - use `$lang['key']` from `language.php`

## CSS Architecture
- **Centralized Styling**: All memberarea styles in `memberarea/assets/css/custom-memberarea.css`
- **No Inline Styles**: Avoid `<style>` tags in PHP views - use CSS classes instead
- **CSS Variables**: Use root variables for consistent theming (colors, spacing, etc)
- **Mobile-First**: Responsive breakpoints defined in custom-memberarea.css
- **Component Classes**: Reusable classes for cards, buttons, forms (e.g., `.stats-card`, `.btn-gold`)

### Available CSS Components
- **Cards**: `.stats-card`, `.card-modern`, `.member-card`, `.info-card`
- **Buttons**: `.btn-gold`, `.btn-category`, `.btn-load`, `.btn-action`, `.btn-search`, `.upline-btn`
- **Forms**: `.form-floating-2`, `.form-floating-2-fix`, `.form-search-custom`, `.search-input`
- **Network**: `.network-swiper`, `.network-stat`, `.empty-slot`, `.member-avatar`, `.tree-container`, `.tree`, `.genealogy-header`
- **Badges**: `.badge-info`, `.badge-date`, `.level-badge`, `.plan-badge`
- **Alerts**: `.alert-danger`, `.alert-warning`, `.alert-success`, `.alert-info`
- **Sidebar**: All sidebar styling handled via `.sidebar` class
- **Genealogy**: `.search-wrapper`, `.search-box`, `.member-status`, `.poin-row`, `.ro-info`, `.card-actions`
- **Utilities**: Spacing (mb-*, mt-*, px-*, py-*), Display (d-flex, d-none), Text (fw-bold, text-gold)

### Adding New Styles
1. Add component styles to `custom-memberarea.css` under appropriate section
2. Use CSS variables from `:root` for consistency (--color-gold, --color-black, etc)
3. Follow naming convention: component-property (e.g., `.member-card`, `.stats-value`)
4. Group related styles with section comments: `/* ======== SECTION NAME ======== */`
5. Test responsive behavior with defined breakpoints (576px, 768px, 992px)
