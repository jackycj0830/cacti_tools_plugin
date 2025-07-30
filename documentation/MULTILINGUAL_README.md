# Cacti Documentation Multi-language Support

This documentation has been enhanced with multi-language support for English, Simplified Chinese (简体中文), and Traditional Chinese (繁體中文).

## Features

- **Language Selector**: Located in the top-right corner of each page
- **Back Button**: Located in the top-left corner for easy navigation
- **Persistent Language Selection**: Your language choice is saved and remembered across pages
- **Automatic Translation**: Content is automatically translated when you change languages

## Supported Languages

1. **English** (Default)
2. **简体中文** (Simplified Chinese)
3. **繁體中文** (Traditional Chinese)

## How to Use

### For Users

1. **Changing Language**: Click the language dropdown in the top-right corner and select your preferred language
2. **Navigation**: Use the "← Back" button in the top-left corner to return to the previous page
3. **Language Persistence**: Your language selection will be remembered when you navigate to other pages

### For Developers/Maintainers

#### File Structure

```
documentation/
├── js/
│   ├── i18n.js          # Main internationalization script with translations
│   └── common.js        # Common functionality for all pages
├── documentation.html   # Main documentation page (fully updated)
├── Requirements.html    # Example updated page
├── update_all_docs.py   # Script to batch update all HTML files
└── *.html              # Other documentation pages
```

#### Adding Translations

1. **Edit `js/i18n.js`**: Add new translation keys to the `translations` object
2. **Add data-i18n attributes**: Add `data-i18n="key"` attributes to HTML elements that need translation
3. **Page-specific translations**: Add page-specific translations in individual HTML files

#### Example Translation Addition

In `js/i18n.js`:
```javascript
'en': {
    'new_key': 'English text',
    // ... other translations
},
'zh-cn': {
    'new_key': '中文文本',
    // ... other translations
},
'zh-tw': {
    'new_key': '中文文字',
    // ... other translations
}
```

In HTML:
```html
<h1 data-i18n="new_key">English text</h1>
```

#### Batch Update Script

Use the provided Python script to automatically add multi-language support to all HTML files:

```bash
python update_all_docs.py
```

This script will:
- Add the necessary JavaScript includes
- Update HTML lang attributes
- Add basic translation support
- Skip files that are already updated

#### Manual Page Updates

For pages that need specific translations:

1. Add the JavaScript includes before `</body>`:
```html
<script type="text/javascript" src="js/i18n.js"></script>
<script type="text/javascript" src="js/common.js"></script>
```

2. Add page-specific translations:
```html
<script type="text/javascript">
const pageTranslations = {
    'en': { 'page_title': 'Page Title' },
    'zh-cn': { 'page_title': '页面标题' },
    'zh-tw': { 'page_title': '頁面標題' }
};

// Merge with global translations
Object.keys(pageTranslations).forEach(lang => {
    if (!translations[lang]) translations[lang] = {};
    Object.assign(translations[lang], pageTranslations[lang]);
});
</script>
```

3. Add `data-i18n` attributes to elements that need translation

## Technical Implementation

### JavaScript Files

- **i18n.js**: Contains all translations and core internationalization functions
- **common.js**: Provides common functionality like navigation controls and page initialization

### Key Functions

- `loadLanguage(lang)`: Loads and applies translations for a specific language
- `changeLanguage()`: Handles language selector changes
- `initializeLanguage()`: Sets up the page with the saved language preference
- `initializeDocumentationPage()`: Adds navigation controls and initializes language support

### CSS Styling

The system includes responsive CSS for:
- Fixed-position language selector (top-right)
- Fixed-position back button (top-left)
- Proper spacing to avoid content overlap

## Browser Compatibility

This multi-language system is compatible with:
- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+

## Future Enhancements

Potential improvements could include:
- Additional language support
- Right-to-left (RTL) language support
- Dynamic content loading
- Search functionality with multi-language support
- Automatic language detection based on browser settings

## Troubleshooting

### Common Issues

1. **Translations not appearing**: Check that `data-i18n` attributes are correctly added to HTML elements
2. **Language not persisting**: Ensure localStorage is enabled in the browser
3. **Scripts not loading**: Verify that the JavaScript files are in the correct `js/` directory
4. **Styling issues**: Check that the CSS in `common.js` is being applied correctly

### Debug Mode

To debug translation issues, open browser developer tools and check:
- Console for JavaScript errors
- Network tab to ensure JS files are loading
- Local Storage to verify language preference is saved

## Contributing

When adding new content or pages:
1. Add appropriate `data-i18n` attributes to translatable content
2. Include the required JavaScript files
3. Add translations to `js/i18n.js` or create page-specific translations
4. Test language switching functionality
5. Ensure the back button works correctly

For questions or issues, please refer to the main Cacti documentation or forums.
