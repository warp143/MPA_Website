# Quick Reference - MPA Website

## 🚀 Quick Links

- **Live Site:** https://proptech.org.my
- **Member Update Form:** https://proptech.org.my/member-update/
- **WordPress Admin:** https://proptech.org.my/wp-admin
- **Pending Approvals:** `/wp-admin/edit.php?post_type=mpa_member&page=member-approvals`

---

## 🔑 SSH Access

```bash
ssh -i ssh/proptech_mpa proptech@smaug.cygnusdns.com
```

**Theme Location:**
```bash
cd ~/public_html/proptech.org.my/wp-content/themes/mpa-custom/
```

---

## 📝 Key Files

| File | Purpose |
|------|---------|
| `functions.php` | Member submission handler, approval system, meta boxes |
| `template-member-submission.php` | Public member update form |
| `front-page.php` | Homepage template |
| `wp-config.php` | WordPress configuration |

---

## 🎯 Member Form Fields

### Required Fields:
1. Company Name
2. Company Description
3. Company Website
4. Company Logo (image upload)
5. Vertical (dropdown)
6. Categories (checkboxes, min 1)
7. Contact Person
8. Contact Email

### Optional Fields:
- Contact Phone

---

## 🏢 Verticals & Categories

### PLAN & CONSTRUCT
Feasibility, Land Use, Design, BIM/Digital Twins, Modular, Carbon/Supply Chain, Resilience, Permitting

### MARKET & TRANSACT
Sales, Leasing, Finance, Marketplaces, CRM, Digital Contracts, Title/Registry, Crowdfunding/Tokenized REITs

### OPERATE & MANAGE
Property/Facility Mgmt, IoT, Utilities, Tenant/Citizen Experience, Mobility Integration, Health/Wellness, Cybersecurity

### REINVEST, REPORT & REGENERATE
ESG & Financial Reporting, Portfolio Analytics, Regeneration, Recycling, Circular Economy, Deconstruction

---

## 🔧 Common Tasks

### View Pending Submissions
```
WordPress Admin → Members → Pending Approvals
```

### Edit Member Before Approval
```
Click "✏️ Edit Before Approval" → Make changes → Update
```

### Approve Member
```
Click "✅ Approve & Publish" → Confirms → Published + Email sent
```

### Add New Member Manually
```
WordPress Admin → Members → Add New
Fill in all fields → Publish
```

---

## 💾 Backups

**UpdraftPlus Backups:** 313MB in `wp-content/updraft/`  
**Latest:** Oct 20, 2025 - 13:09

**Manual Backups:** Theme folder `*.backup-*` files  
**Important:** `functions.php.backup-before-form-update-20251020_063822`

---

## 🐛 Troubleshooting

### Form Not Submitting
1. Check browser console for JavaScript errors
2. Verify AJAX endpoint: `/wp-admin/admin-ajax.php`
3. Check server error logs

### Categories Not Appearing
1. Ensure Vertical is selected first
2. Check JavaScript console for errors
3. Verify `verticalCategories` object loaded

### Dark Mode Not Working
1. Check `main.js` is loaded
2. Verify `get_footer()` in template
3. Check CSS variables in `style.css`

---

## 📞 Support

**Server:** smaug.cygnusdns.com  
**Config:** `ssh/proptech.json`  
**Documentation:** `SERVER_ACCESS_GUIDE.md`

---

**Last Updated:** October 20, 2025

