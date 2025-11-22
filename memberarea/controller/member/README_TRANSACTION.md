# Member Registration Transaction Flow

## Overview
File `member_create.php` menggunakan **database transaction** untuk memastikan semua operasi pendaftaran member berjalan secara **atomic** (semua sukses atau semua dibatalkan).

## Transaction Structure

```php
try {
    $conn->beginTransaction();
    // All operations here...
    $conn->commit(); // Success
} catch (Exception $e) {
    $conn->rollback(); // Rollback on error
    // Error logging
}
```

## Operation Flow (16 Steps)

### STEP 1: CREATE MEMBER
- **Operation**: `Membuat Data Member`
- **Table**: `mlm_member`
- **Method**: `create_transaction($conn)`
- **Error Impact**: Pendaftaran gagal total

### STEP 2: UPDATE UPLINE & ACTIVATION
- **Operation**: `Update Kaki Upline`
- **Table**: `mlm_member` (kaki_kiri/kaki_kanan)
- **Action**: Update posisi binary upline
- **Error Impact**: Member terbuat tapi tidak terhubung ke upline

### STEP 3: ACTIVATION STATUS
- **Operation**: `Update Status Aktivasi PIN`
- **Table**: `mlm_kodeaktivasi`
- **Action**: Set PIN aktif dan activated_at
- **History**: Insert ke `mlm_kodeaktivasi_history`

### STEP 4: BONUS BALIK MODAL
- **Operation**: `Bonus Balik Modal`
- **Table**: `mlm_bonus_balik_modal_rekap`, `mlm_bonus_balik_modal`
- **Condition**: Plan 16 atau 17 only
- **Action**: Distribute profit sharing ke semua member

### STEP 5: BONUS SPONSOR
- **Operation**: `Bonus Sponsor (ID: xxx)`
- **Table**: `mlm_wallet` (plan 200) atau `mlm_bonus_sponsor`
- **Action**: Berikan bonus ke sponsor langsung
- **SMS**: Kirim notifikasi SMS

### STEP 6: BONUS SPONSOR MONOLEG
- **Operation**: `Bonus Sponsor Monoleg`
- **Table**: `mlm_bonus_sponsor_monoleg`
- **Action**: Bonus ke sponsor monoleg (jika ada)
- **SMS**: Kirim notifikasi SMS

### STEP 7: BONUS CASHBACK
- **Operation**: `Bonus Cashback (Rp xxx)`
- **Table**: `mlm_bonus_cashback`
- **Action**: Cashback langsung ke member baru
- **SMS**: Kirim notifikasi SMS

### STEP 8: POIN PASANGAN (BINARY)
- **Operation**: `Poin Pasangan Binary`
- **Table**: `mlm_member_poin_pasangan`
- **Stored Procedure**: `CALL GenerasiUpline($member_id)`
- **Action**: Insert poin ke semua upline binary
- **Duplicate Check**: Cek poin sudah ada atau belum

### STEP 9: POIN PASANGAN LEVEL
- **Operation**: `Poin Pasangan Level`
- **Table**: `mlm_member_poin_pasangan_level`
- **Stored Procedure**: `CALL GenerasiUpline($member_id)`
- **Action**: Insert poin level ke upline
- **Condition**: Bukan reposisi member

### STEP 10: POIN REWARD BINARY
- **Operation**: `Poin Reward Binary`
- **Table**: `mlm_member_poin_reward`
- **Stored Procedure**: `CALL GenerasiUpline($member_id)`
- **Validation**: Check RO aktif jika `reward_wajib_ro = 1`
- **Duplicate Check**: Cek poin sudah ada atau belum

### STEP 11: POIN REWARD PAKET
- **Operation**: `Poin Reward Paket (Sponsor)`
- **Table**: `mlm_member_poin_reward_paket`
- **Action**: Berikan poin reward promo ke sponsor
- **Duplicate Check**: Cek poin sudah ada atau belum

### STEP 12: UPDATE JUMLAH KAKI
- **Operation**: `Update Jumlah Kaki Kiri/Kanan`
- **Table**: `mlm_member` (jumlah_kiri/jumlah_kanan)
- **Stored Procedure**: `CALL GenerasiUpline($member_id)`
- **Action**: Increment counter kaki di semua upline

### STEP 13: BONUS FOUNDER
- **Operation**: `Bonus Founder Fee`
- **Table**: `mlm_bonus_founder`
- **Stored Procedure**: `CALL GenerasiUpline($member_id)`
- **Validation**: Check if upline is founder
- **Action**: Berikan fee founder ke upline founder

### STEP 14: BONUS GENERASI (UNILEVEL)
- **Operation**: `Bonus Generasi/Unilevel`
- **Table**: `mlm_bonus_generasi`
- **Method**: `create_transaction($conn, ...)`
- **Stored Procedure**: `CALL GenerasiSponsorWithMax`
- **Action**: Distribute bonus ke sponsor line dengan max level

### STEP 15: BONUS UPLINE
- **Operation**: `Bonus Upline`
- **Table**: `mlm_bonus_upline`
- **Stored Procedure**: `CALL GenerasiUpline($member_id, $max)`
- **Action**: Bonus ke upline binary dengan max generasi

### STEP 16: SALDO WITHDRAWAL
- **Operation**: `Saldo Penarikan (Rp xxx)`
- **Table**: `mlm_saldo_penarikan`
- **Action**: Tambah saldo WD atau cash (plan 200)

### STEP 17: FINALIZATION
- **Operation**: `Kirim SMS Notifikasi`
- **Action**: SMS ke member dan sponsor
- **Operation**: `Update Member Prospek`
- **Table**: `mlm_member_prospek`
- **Condition**: Jika tipe_akun = '2'

### STEP 18: COMMIT
- **Operation**: `Commit Transaction`
- **Action**: Simpan semua perubahan ke database

## Error Handling

### Error Response Format
```json
{
    "status": false,
    "message": "Pendaftaran gagal pada tahap: [Operation Name]",
    "error": "[Technical Error Message]",
    "member_id": "[Generated ID or 'Belum dibuat']",
    "timestamp": "2025-11-22 10:30:45"
}
```

### Error Log File
- **Location**: `memberarea/log/member_registration_errors.log`
- **Format**: Text log dengan timestamp
- **Content**: 
  - Timestamp
  - Operation yang gagal
  - Member ID (jika sudah terbuat)
  - Sponsor ID
  - Technical error message

### Example Error Log
```
[2025-11-22 10:30:45] Registration Error
Operation: Bonus Sponsor (ID: A12345)
Member ID: A99001
Sponsor: A12345
Error: Duplicate entry for key 'PRIMARY'
-----------------------------------
```

## Benefits

### 1. **Atomicity** ✅
- Semua operasi sukses ATAU semua dibatalkan
- Tidak ada partial save yang corrupt database

### 2. **Error Tracking** ✅
- Tahu persis di step mana error terjadi
- Log file untuk debugging detail
- Member ID tercatat untuk investigasi

### 3. **Easy Debugging** ✅
- Setiap step punya label jelas
- Error message spesifik per operasi
- Timeline error tersimpan di log

### 4. **Data Integrity** ✅
- Konsistensi data terjamin
- No orphaned records
- No inconsistent state

## Troubleshooting

### Jika Pendaftaran Gagal

1. **Check Error Response**
   - Lihat field `message` untuk tahu step mana yang gagal
   - Lihat field `error` untuk technical details

2. **Check Log File**
   - Buka `memberarea/log/member_registration_errors.log`
   - Cari berdasarkan timestamp atau member_id

3. **Common Issues**
   - **"Membuat Data Member"**: Validasi data input (username duplicate, dll)
   - **"Update Kaki Upline"**: Posisi sudah terisi atau upline tidak valid
   - **"Bonus xxx"**: Duplicate key atau constraint violation
   - **"Poin xxx"**: Stored procedure error atau plan tidak match

4. **Check Database**
   ```sql
   -- Check if member created (should be NULL if rolled back)
   SELECT * FROM mlm_member WHERE id = 'A99XXX';
   
   -- Check PIN status (should still be aktif = '0')
   SELECT * FROM mlm_kodeaktivasi WHERE id = 'xxx';
   ```

## Testing Transaction

### Test Rollback
Untuk test apakah rollback berfungsi:

1. Tambahkan error sengaja di tengah proses:
```php
if($member_id > 0){
    // ... operations ...
    throw new Exception('Test rollback'); // Force error
}
```

2. Lakukan pendaftaran
3. Check database - semua table harus kosong (tidak ada data)
4. Check log file - error tercatat

### Test Success
1. Pastikan semua validasi lolos
2. Monitor setiap step dengan echo/log
3. Verify semua table terisi dengan benar
4. Check foreign key relationships intact

## Database Tables Affected

| Table | Operation | Type |
|-------|-----------|------|
| mlm_member | CREATE | INSERT |
| mlm_member | UPDATE KAKI | UPDATE |
| mlm_member | UPDATE JUMLAH KAKI | UPDATE |
| mlm_kodeaktivasi | ACTIVATION | UPDATE |
| mlm_kodeaktivasi_history | HISTORY | INSERT |
| mlm_bonus_balik_modal_rekap | BONUS BM | INSERT |
| mlm_bonus_balik_modal | BONUS BM | INSERT |
| mlm_wallet | BONUS SPONSOR | INSERT |
| mlm_bonus_sponsor | BONUS SPONSOR | INSERT |
| mlm_bonus_sponsor_monoleg | BONUS MONOLEG | INSERT |
| mlm_bonus_cashback | BONUS CASHBACK | INSERT |
| mlm_member_poin_pasangan | POIN BINARY | INSERT |
| mlm_member_poin_pasangan_level | POIN LEVEL | INSERT |
| mlm_member_poin_reward | POIN REWARD | INSERT |
| mlm_member_poin_reward_paket | POIN PROMO | INSERT |
| mlm_bonus_founder | BONUS FOUNDER | INSERT |
| mlm_bonus_generasi | BONUS GENERASI | INSERT |
| mlm_bonus_upline | BONUS UPLINE | INSERT |
| mlm_saldo_penarikan | SALDO WD | INSERT |
| mlm_member_prospek | UPDATE STATUS | UPDATE |

**Total: 20 Tables, 28+ Operations**

## Performance Notes

- Stored procedures (`CALL GenerasiUpline`) dijalankan dalam transaction
- Duplicate checking dilakukan sebelum INSERT untuk avoid constraint errors
- Transaction lock tables yang affected - keep operations fast
- SMS operations tidak di-rollback (external service)

## Maintenance

### Adding New Operations

1. Tambahkan step di flow dengan tracking:
```php
// === STEP XX: OPERATION NAME ===
$current_operation = 'Descriptive Operation Name';
if(condition) {
    $conn->_query_transaction($sql);
}
```

2. Update dokumentasi ini dengan step baru
3. Test rollback untuk ensure step baru included

### Modifying Operations

1. Maintain `$current_operation` label
2. Keep using `$conn->_query_transaction()`
3. Add validation before operation
4. Test both success and failure scenarios
