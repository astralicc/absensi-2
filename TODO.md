# Wali Kelas Access & Sidebar Separation Fix

## Progress
✅ Plan approved by user

## TODO Steps
✅ Step 1: Create `app/Http/Middleware/WaliKelasMiddleware.php`
- [ ] Step 2: Register middleware in `bootstrap/app.php`
✅ Step 3: Add `isWaliKelas()` method to `app/Models/User.php`
- [ ] Step 4: Add wali-kelas route group to `routes/web.php`
✅ Step 5: Update `DashboardController::index()` for wali redirect
✅ Step 6: Add `waliDashboard()` to `WaliKelasController.php`
✅ Step 7: Reuse StudentListController@index for wali-kelas.siswa (already filters)
- [ ] Step 8: Fix sidebar links in `resources/views/dashboard.blade.php`
✅ Step 9: Create `resources/views/wali-kelas/index.blade.php`
- [ ] Step 10: Test access, redirects, sidebars for guru/wali/admin

**Current Step:** 10/10 - Ready for testing
