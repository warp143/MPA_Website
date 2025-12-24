# REDESIGN: Clean-Slate DIY Polylang Pro

This document outlines a total "From Scratch" redesign of the MPA website's translation system. We are ignoring all previous custom code to build a professional, native-first architecture that provides true multi-language support.

---

## 🏗️ The "Clean Slate" Architecture

Instead of managing a "dictionary" of keys, we will treat each translation as **Native WordPress Content**. This ensures full compatibility with Gutenberg, SEO plugins, and caching.

### 1. The Data Model (Linked Posts)
- Each page/post will have three distinct versions in the `wp_posts` table (English, BM, Chinese).
- A custom "Linker" table (`wp_mpa_post_translations`) will connect them so the system knows that Page ID 1 (EN) is the same as Page ID 5 (MS).

### 2. Native URL Routing
- **English**: `proptech.org.my/association/`
- **Bahasa Malaysia**: `proptech.org.my/ms/association/`
- **Chinese**: `proptech.org.my/zh/association/`
- This leverages WordPress's native routing for maximum speed and SEO.

### 3. The "Sync" Engine (The Pro Feature)
- When you update a "Global" field (like a Company Logo or a Contact Email) on the English page, the system will **automatically sync** that change to the BM and Chinese versions.
- You only edit the **Text** three times. You manage the **Logic/Media** once.

---

## 🛠️ Implementation Roadmap

### Phase 1: The Core Plugin (`mpa-multi-lang`)
- **Language Registry**: Setup the custom taxonomy to tag every post with a language.
- **Virtual Folders**: Configure the Rewrite API to handle language prefixes.
- **Admin UI**: Add a "Translations" box to the Gutenberg sidebar to create/link pages.

### Phase 2: Content Discovery & SEO
- **Hreflang Engine**: Automatically inject `<link rel="alternate">` tags for all linked pages.
- **Language Redirects**: Detect user browser settings and suggest the `/ms/` or `/zh/` versions.
- **Site Map Integration**: Ensure all language versions appear in XML Sitemaps.

### Phase 3: The "Sync" Hook
- Implement an `update_post_meta` hook that listens for changes in non-translatable fields (like ACF images) and propagates them to linked posts.

---

## 📋 Why this is "Proper"
1. **Full SEO**: No "stitching." Google sees the full Malay/Chinese HTML instantly.
2. **Gutenberg Compatibility**: Use the native editor for all three languages. No more editing JSON keys.
3. **No Database Bloat**: No duplicate tables or messy hacks. We use WordPress the way it was designed.
4. **Zero Cost**: Achieves everything Polylang Pro does using native code.

---
**Status**: Planning (Clean Slate)  
**Version**: 2.0 (Total Redesign)
