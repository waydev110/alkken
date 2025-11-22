# Shared Registration Logic

## Overview
Admin member registration sekarang menggunakan **logika yang sama persis** dengan member self-registration untuk memastikan konsistensi 100%.

## Implementation

### File Structure
```
adminarea/controller/member/member_register.php (WRAPPER)
    ↓ includes
memberarea/controller/member/member_create.php (CORE LOGIC)
```

### How It Works

1. **Admin Controller** (`adminarea/controller/member/member_register.php`):
   - Menerima data dari form admin
   - Validasi kode aktivasi tersedia di sponsor
   - Konversi data ke format yang dibutuhkan member_create.php
   - Set session sponsor untuk context
   - Include dan execute member_create.php

2. **Member Create** (`memberarea/controller/member/member_create.php`):
   - Execute semua 16+ steps dalam transaction
   - Perhitungan semua bonus (sponsor, monoleg, cashback, generasi, dll)
   - Distribusi semua poin (pasangan, reward, level, dll)
   - Update jaringan binary
   - SMS notifications
   - Error logging dengan operation tracking

## Benefits

### ✅ Single Source of Truth
- Perubahan di 1 file = berlaku di admin dan member area
- Tidak ada duplikasi code
- Tidak ada inconsistency

### ✅ Comprehensive Features
Semua fitur otomatis tersinkron:
- ✅ Bonus Sponsor
- ✅ Bonus Monoleg
- ✅ Bonus Cashback
- ✅ Bonus Generasi (Unilevel)
- ✅ Bonus Upline
- ✅ Bonus Founder
- ✅ Bonus Balik Modal (Sharing Profit)
- ✅ Poin Pasangan (Binary)
- ✅ Poin Pasangan Level
- ✅ Poin Reward Binary
- ✅ Poin Reward Paket
- ✅ Update Jumlah Kaki (Kiri/Kanan)
- ✅ Saldo Withdrawal
- ✅ SMS Notifications
- ✅ Member Prospek Conversion

### ✅ Transaction Safety
- Semua operations dalam 1 database transaction
- Rollback otomatis jika ada error
- Error logging dengan operation label
- Consistent state guarantee

### ✅ Maintainability
- Bug fix di 1 tempat = fix di semua tempat
- Feature update otomatis apply ke semua
- Testing lebih mudah (1 logic path)
- Code review lebih efisien

## Architecture Diagram

```
┌─────────────────────────────────────────────────────────────────────┐
│                    REGISTRATION ARCHITECTURE                         │
│                   (Single Source of Truth Pattern)                   │
└─────────────────────────────────────────────────────────────────────┘

ADMIN REGISTRATION PATH:
┌──────────────────────────────────────────────────────────────────────┐
│  adminarea/view/member/member_register.php (FORM)                    │
│  ↓ submit                                                             │
│  adminarea/controller/member/member_register.php (WRAPPER - 130 baris) │
│  │                                                                     │
│  ├─ Validate form data                                                │
│  ├─ Find activation code from sponsor's inventory                     │
│  ├─ Map admin form → member_create format                             │
│  ├─ Set session context (sponsor ID)                                  │
│  ↓                                                                     │
│  require_once '../../../memberarea/controller/member/member_create.php' │
│  ↓                                                                     │
│  memberarea/controller/member/member_create.php (CORE LOGIC - 772 baris) │
│  │                                                                     │
│  ├─ Execute 16+ transaction steps                                     │
│  ├─ Calculate all bonuses (13+ types)                                 │
│  ├─ Distribute all points                                             │
│  ├─ Send SMS notifications                                            │
│  └─ Return JSON response                                              │
└──────────────────────────────────────────────────────────────────────┘

MEMBER REGISTRATION PATH:
┌──────────────────────────────────────────────────────────────────────┐
│  memberarea/view/member/member_create.php (FORM)                     │
│  ↓ submit                                                             │
│  memberarea/controller/member/member_create.php (CORE LOGIC - 772 baris) │
│  │                                                                     │
│  ├─ Execute 16+ transaction steps                                     │
│  ├─ Calculate all bonuses (13+ types)                                 │
│  ├─ Distribute all points                                             │
│  ├─ Send SMS notifications                                            │
│  └─ Return JSON response                                              │
└──────────────────────────────────────────────────────────────────────┘

KEY INSIGHT:
Both paths converge at member_create.php → ONE SOURCE OF TRUTH
Admin wrapper: 130 lines (data adapter)
Core logic: 772 lines (shared by both)
Total saved: 772 lines of duplicate code eliminated ✅
```

## Data Flow

### Admin Registration Flow
```
┌─────────────────────────────────────────────────────────────────────┐
│ STEP 1: Admin Input                                                  │
│ - Form: adminarea/view/member/member_register.php                   │
│ - Data: sponsor, upline, posisi, paket_join, member details         │
└─────────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────────┐
│ STEP 2: Wrapper Processing                                          │
│ - File: adminarea/controller/member/member_register.php             │
│ - Actions:                                                           │
│   ✓ Validate required fields                                        │
│   ✓ Query sponsor's PIN inventory                                   │
│   ✓ Find available PIN for selected package                         │
│   ✓ Convert paket_join (plan ID) → id_kodeaktivasi (PIN ID)        │
└─────────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────────┐
│ STEP 3: Session Context Setup                                       │
│ - $_SESSION['session_member_id'] = sponsor_id                       │
│ - $_SESSION['session_user_member'] = 'ADMIN_REGISTRATION'           │
│ - Why? member_create.php uses session_member_id as sponsor          │
└─────────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────────┐
│ STEP 4: Data Mapping                                                │
│ Admin Form Field          → Member Create Expected                  │
│ $_POST['sponsor']         → $_POST['sponsor']                       │
│ $_POST['upline']          → $_POST['id_upline'] (base64_encode)     │
│ $_POST['posisi']          → $_POST['posisi']                        │
│ $_POST['paket_join']      → $_POST['id_kodeaktivasi'] (resolved)    │
│ $_POST['username']        → $_POST['username']                      │
│ ... (all other fields passed through)                               │
└─────────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────────┐
│ STEP 5: Include Core Logic                                          │
│ - require_once '../../../memberarea/controller/member_create.php'   │
│ - Executes FULL TRANSACTION (16+ steps)                             │
│ - Returns JSON response automatically                                │
└─────────────────────────────────────────────────────────────────────┘
```

### Member Self-Registration Flow
```
┌─────────────────────────────────────────────────────────────────────┐
│ STEP 1: Member Input                                                 │
│ - Form: memberarea/view/member/member_create.php                    │
│ - Data: sponsor (from session), upline, posisi, id_kodeaktivasi,    │
│         member details                                               │
└─────────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────────┐
│ STEP 2: Direct Processing                                           │
│ - File: memberarea/controller/member/member_create.php              │
│ - Actions:                                                           │
│   ✓ Execute FULL TRANSACTION (16+ steps)                            │
│   ✓ Calculate all bonuses                                           │
│   ✓ Distribute all points                                           │
│   ✓ Send SMS notifications                                          │
│   ✓ Return JSON response                                            │
└─────────────────────────────────────────────────────────────────────┘
```

## Key Points

### 1. Kode Aktivasi Source
- Admin registration: PIN diambil dari **SPONSOR**
- Member registration: PIN diambil dari **SESSION MEMBER** (self)
- Logic sama: Sponsor yang menyediakan kode aktivasi

### 2. Session Management
Admin controller set:
```php
$_SESSION['session_member_id'] = $sponsor_id;
$_SESSION['session_user_member'] = 'ADMIN_REGISTRATION';
```

### 3. Data Mapping
```php
// Admin form field → Member create expected format
$_POST['paket_join']     → get id_kodeaktivasi dari sponsor
$_POST['upline']         → base64_encode → id_upline  
$_POST['sponsor']        → sponsor (same)
$_POST['username']       → username (same)
$_POST['nama_member']    → nama_member (same)
// etc...
```

### 4. Validation
Admin controller validates:
- Sponsor has activation code for selected package
- PIN is available (not used)
- Upline and position are valid

Member create validates:
- All business rules
- Position availability
- Duplicate checks
- Network integrity

## Testing Checklist

### Admin Registration Test
- [ ] Select sponsor with available PINs
- [ ] Choose package from dropdown
- [ ] Fill all required fields
- [ ] Submit and verify transaction committed
- [ ] Check all bonuses created
- [ ] Check all points distributed
- [ ] Verify SMS sent
- [ ] Check error log empty
- [ ] Verify credentials displayed

### Consistency Test
- [ ] Register same package via admin
- [ ] Register same package via member
- [ ] Compare bonus amounts → Should be identical
- [ ] Compare point distribution → Should be identical
- [ ] Compare network structure → Should be identical
- [ ] Compare SMS notifications → Should be identical

### Error Handling Test
- [ ] Test with no PIN available
- [ ] Test with position already filled
- [ ] Test with duplicate username
- [ ] Test with invalid sponsor
- [ ] Verify rollback works
- [ ] Verify error logged correctly

## Maintenance

### When to Update
Update **ONLY** `memberarea/controller/member/member_create.php` when:
- Changing bonus calculation
- Adding new bonus types
- Modifying point distribution
- Updating network logic
- Changing SMS templates
- Adding new validations

Changes will automatically apply to:
- ✅ Member self-registration
- ✅ Admin registration
- ✅ Any future registration methods

### DO NOT
- ❌ Duplicate logic in admin controller
- ❌ Create separate calculation methods
- ❌ Modify bonus/point logic outside member_create.php
- ❌ Add custom logic in admin controller (use member_create.php)

## Troubleshooting

### Issue: Admin registration not working
1. Check POST data format matches member_create.php expectations
2. Verify sponsor has available PINs for selected package
3. Check session variables set correctly
4. Review error log for detailed error messages

### Issue: Different results between admin and member registration
1. This should NOT happen
2. If it does, it means logic diverged somehow
3. Review admin controller - should only map data, not change logic
4. Verify member_create.php is being included correctly

### Issue: Transaction fails
1. Check error log for operation that failed
2. Review member_create.php transaction code
3. Verify database connection
4. Check rollback triggered properly

## Version History

**v1.0 - 2025-11-22**
- Initial implementation of shared logic
- Admin controller now wraps member_create.php
- 100% consistency achieved
- All 16+ operations synchronized
