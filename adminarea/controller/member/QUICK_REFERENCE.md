# 🎯 Quick Reference - Shared Registration Logic

## File Struktur

```
memberarea/controller/member/member_create.php
├─ 772 lines
├─ CORE LOGIC - Single Source of Truth
└─ Used by: Admin & Member registration

adminarea/controller/member/member_register.php
├─ 130 lines
├─ WRAPPER ONLY - Data adapter
└─ Includes: member_create.php
```

## Code Size Comparison

| Metric | Before | After | Saved |
|--------|--------|-------|-------|
| Admin Controller | 450 lines | 130 lines | 320 lines |
| Total Lines | 1,222 | 902 | 320 lines |
| Duplicate Code | 450 lines | 0 lines | 100% |
| Maintenance Files | 2 files | 1 file | 50% |

## Admin Wrapper Flow

```php
// adminarea/controller/member/member_register.php

// 1. Validate
if(!isset($_POST['sponsor'])) exit;

// 2. Find PIN from sponsor
$pin = find_activation_code($sponsor_id, $plan_id);

// 3. Map data
$_POST['id_kodeaktivasi'] = $pin->id;
$_POST['sponsor'] = $sponsor_id;
// ... map other fields

// 4. Set context
$_SESSION['session_member_id'] = $sponsor_id;

// 5. Execute core logic
require_once '../../../memberarea/controller/member/member_create.php';
// Done! member_create.php handles everything
```

## What to Edit Where

### Edit member_create.php when:
- ✅ Changing bonus calculation
- ✅ Modifying point distribution
- ✅ Adding new bonus types
- ✅ Updating SMS messages
- ✅ Changing transaction logic
- ✅ Adding validation rules
- ✅ Updating network logic

### Edit member_register.php when:
- ✅ Changing admin form structure
- ✅ Adding admin-specific validation
- ✅ Modifying data mapping
- ✅ Updating activation code selection
- ⚠️ **NEVER edit bonus/poin logic here!**

## Testing Checklist

After editing member_create.php:

```
[ ] Test member self-registration
    └─ Fill form di memberarea
    └─ Check all bonuses created
    └─ Check points distributed
    └─ Verify SMS sent

[ ] Test admin registration
    └─ Fill form di adminarea
    └─ Check all bonuses created (must be identical to member)
    └─ Check points distributed (must be identical)
    └─ Verify SMS sent

[ ] Compare results
    └─ Bonus amounts should be EXACTLY same
    └─ Point values should be EXACTLY same
    └─ Network structure should be identical
```

## Common Mistakes to Avoid

### ❌ Mistake 1: Adding logic to wrapper
```php
// member_register.php - WRONG!
if($bonus_sponsor > 0) {
    // ❌ NO! This creates duplication
    $sql = "INSERT INTO mlm_bonus_sponsor ...";
}
```

### ❌ Mistake 2: Editing only one file
```php
// Only update member_create.php but forget to test admin
// Result: Works for member, breaks for admin
```

### ❌ Mistake 3: Creating "admin-specific" logic
```php
// member_register.php - WRONG!
if(ADMIN_REGISTRATION_CONTEXT) {
    // ❌ Different logic for admin = inconsistency!
    $bonus = calculate_admin_bonus();
} else {
    $bonus = calculate_member_bonus();
}
```

### ✅ Correct Approach
```php
// member_create.php - CORRECT!
// Same logic for everyone
$bonus_sponsor = $plan->bonus_sponsor;
$sql = "INSERT INTO mlm_bonus_sponsor ...";

// member_register.php - CORRECT!
// Only map data, then delegate
$_POST['sponsor'] = $sponsor_id;
require_once '../../../memberarea/controller/member/member_create.php';
```

## Emergency Checklist

If you find duplicate logic:

```
[ ] Stop immediately
[ ] Remove duplicate code from member_register.php
[ ] Ensure member_create.php has the correct logic
[ ] Test both registration methods
[ ] Verify results are identical
[ ] Update documentation
[ ] Commit with clear message
```

## Key Benefits

1. **Consistency**: 1 edit = all methods updated
2. **Maintainability**: 1 file to maintain
3. **Testing**: 1 logic path to test
4. **Reliability**: No sync issues
5. **Scalability**: Easy to add new registration methods

## Remember

> **GOLDEN RULE:**
> member_create.php = SINGLE SOURCE OF TRUTH
> 
> Everything else = DATA ADAPTERS

---

Last Updated: 2025-11-22
