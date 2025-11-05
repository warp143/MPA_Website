# Translation System Cleanup Report

**Date:** November 5, 2025  
**Database:** mark9_wp  
**Current Status:** ⚠️ Old translation data detected

---

## Executive Summary

Your **MPA Translation Manager** plugin is working correctly with **134 unique translation keys** and **270 total translations** (EN, BM, CN). However, the database still contains remnants from old **Polylang** and **ACF** translation systems that are causing database bloat.

---

## 🔍 Findings

### 1. Polylang (Old System)

**Status:** ⚠️ Active but unused

**Found:**
- ✅ Configuration in `wp_options` table
- ✅ Language taxonomy with 3 terms (en, bm, cn)
- ✅ 10 translation groups linking duplicate posts
- ✅ 105 posts assigned to language terms:
  - 113 Bahasa Malaysia posts (99 attachments, 13 pages, 1 post)
  - 7 Chinese pages
  - 14 English posts (3 attachments, 11 pages)

**Database Impact:**
- Polylang options: 3 entries
- Language terms: 18 term entries
- Post-language relationships: 105+ entries

### 2. ACF Translation Fields (Old System)

**Status:** ⚠️ Some legacy data exists

**Found:**
- Hero title/subtitle translations stored in post meta:
  - `_hero_title_bm`, `_hero_title_cn`, `_hero_title_ms`
  - `_hero_subtitle_bm`, `_hero_subtitle_cn`, `_hero_subtitle_ms`
- Used in 2 posts:
  - Post #294: "Home"
  - Post #456: "Laman Utama"

**Sample Data:**
```
Post #294 (Home):
- _hero_title_bm: "Untuk Masa Depan Pasaran Hartanah yang Mampan"
- _hero_title_cn: "为可持续房地产市场的未来"
- _hero_subtitle_bm: "Memimpin Transformasi Digital..."
- _hero_subtitle_cn: "通过创新、协作和可持续增长..."
```

### 3. MPA Translation Manager (Current System)

**Status:** ✅ Working perfectly

**Statistics:**
- Unique keys: **134**
- Total translations: **270**
- Language breakdown:
  - English: 128 translations
  - Bahasa Malaysia: 41 translations
  - Chinese: 101 translations

---

## 🎯 Impact Analysis

### Database Bloat
- **Polylang tables:** 4 taxonomies (language, post_translations, term_language, term_translations)
- **Polylang options:** 3 option entries
- **ACF meta fields:** 6 hero translation fields across 2 posts
- **Duplicate posts:** Some pages exist in multiple languages (e.g., "Home" and "Laman Utama")

### Functional Impact
- ✅ No impact on current functionality (MPA Translation Manager works independently)
- ⚠️ Potential confusion with duplicate posts
- ⚠️ Increased database size
- ⚠️ Slower queries due to extra taxonomy relationships

---

## 📋 Recommended Actions

### Option 1: Conservative Cleanup (Recommended)
Keep post content but remove Polylang metadata:
1. ✅ Remove Polylang options from `wp_options`
2. ✅ Remove language taxonomy terms
3. ✅ Remove post-language relationships
4. ❌ **Keep** all posts (even language duplicates)
5. ❌ **Keep** ACF hero fields (as backup)

**Risk:** Low  
**Benefit:** Moderate (cleaner database, removes bloat)

### Option 2: Aggressive Cleanup
Remove all old translation data:
1. ✅ Remove Polylang options
2. ✅ Remove language taxonomies
3. ✅ Remove post-language relationships
4. ✅ Delete duplicate language posts
5. ✅ Remove ACF hero translation meta fields

**Risk:** Medium (may delete useful content)  
**Benefit:** High (significant database cleanup)

### Option 3: Archive First, Then Clean
1. Export all Polylang posts to backup
2. Export ACF hero fields to JSON
3. Perform Option 2 cleanup
4. Keep backups for 30 days

**Risk:** Low (with backups)  
**Benefit:** High (best of both worlds)

---

## 🧹 Cleanup Scripts Provided

### 1. `cleanup-polylang-conservative.php`
Removes Polylang metadata while keeping all posts.

### 2. `cleanup-polylang-aggressive.php`
Removes Polylang AND deletes duplicate posts.

### 3. `cleanup-acf-hero-fields.php`
Removes old ACF hero translation fields.

### 4. `export-old-translations-backup.php`
Creates JSON backup of all old translation data.

---

## ⚠️ Before Running Cleanup

1. **BACKUP YOUR DATABASE:**
   ```bash
   mysqldump -u root mark9_wp > backup_before_cleanup_$(date +%Y%m%d).sql
   ```

2. **Review duplicate posts manually:**
   - Check if "Laman Utama" (BM) should be kept or deleted
   - Verify which language posts are actually needed

3. **Test on local environment first** (you're already on localhost:8000 ✅)

4. **Run export script first** to save old data:
   ```bash
   php export-old-translations-backup.php
   ```

---

## 📊 Summary Table

| System | Status | Action Needed |
|--------|--------|---------------|
| MPA Translation Manager | ✅ Active & Working | None - keep using |
| Polylang Plugin | ⚠️ Inactive but data exists | Clean up metadata |
| ACF Hero Fields | ⚠️ Legacy data (2 posts) | Optional cleanup |
| Duplicate Posts | ⚠️ 105 posts in language taxonomy | Review and decide |

---

## 🚀 Next Steps

1. **Run the detailed analysis scripts** to review what will be deleted
2. **Choose cleanup strategy** (Conservative vs Aggressive)
3. **Backup database** before any changes
4. **Run cleanup script(s)**
5. **Verify site still works**
6. **Monitor for any issues**

---

## 📞 Support

If you need help with cleanup decisions or encounter issues:
- Review each script before running
- Test on local/staging first
- Keep database backups for at least 30 days

---

**Generated by:** Translation Cleanup Analysis Tool  
**Date:** 2025-11-05

