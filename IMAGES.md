# Image Assets Guide

## Required Images

To make the website fully functional, you need to add the following images to the specified directories:

### Logo and Branding
- `assets/images/logo.png` - Main logo (transparent background, 200x80px recommended)
- `assets/images/favicon.png` - Browser favicon (32x32px or 64x64px)
- `assets/images/apple-touch-icon.png` - iOS home screen icon (180x180px)
- `assets/images/og-image.jpg` - Open Graph image for social sharing (1200x630px)

### Hero Section
- `assets/images/hero-bg.jpg` - Homepage hero background (1920x1080px minimum)
- `assets/images/about-preview.jpg` - About section preview image (800x600px)

### About Page
- `assets/images/company-overview.jpg` - Company overview image (800x600px)
- `assets/images/difference.jpg` - The KDC difference section (800x600px)

### Community Page
- `assets/images/youth-empowerment.jpg` - Youth empowerment program (800x600px)
- `assets/images/sustainable-farming.jpg` - Sustainable farming practices (800x600px)
- `assets/images/farmer-support.jpg` - Farmer support programs (800x600px)

### Product Images
Place product images in `assets/images/products/` directory:

- `arabica-coffee.jpg` - Premium Arabica Coffee product
- `robusta-coffee.jpg` - Robusta Coffee Beans product
- `ground-coffee.jpg` - Ground Coffee product
- `organic-blend.jpg` - Organic Coffee Blend product
- `dark-roast.jpg` - Dark Roast Coffee product
- `espresso-blend.jpg` - Espresso Blend product

**Product Image Specifications:**
- Format: JPEG, PNG, or WebP
- Size: 800x800px (square)
- Max file size: 500KB (optimized)
- Background: White or transparent

## Creating Placeholder Images

If you don't have images yet, you can create placeholders using these free services:

1. **Placeholder.com**
   - URL format: `https://via.placeholder.com/800x600.png?text=Image+Name`
   - Example: Download and save as needed

2. **Unsplash** (Free coffee images)
   - Visit: https://unsplash.com/s/photos/coffee
   - Search for: "coffee beans", "coffee farm", "coffee plantation"
   - Download high-resolution images

3. **Pexels** (Free stock photos)
   - Visit: https://www.pexels.com/search/coffee/
   - Free to use for commercial purposes

## Image Optimization

Before uploading, optimize all images:

1. **Online Tools:**
   - TinyPNG: https://tinypng.com/
   - Squoosh: https://squoosh.app/
   - ImageOptim (Mac): https://imageoptim.com/

2. **Recommended Settings:**
   - JPEG Quality: 80-85%
   - PNG: Use 24-bit with compression
   - WebP: Quality 80%

## Directory Structure

```
assets/images/
├── logo.png
├── favicon.png
├── apple-touch-icon.png
├── og-image.jpg
├── hero-bg.jpg
├── about-preview.jpg
├── company-overview.jpg
├── difference.jpg
├── youth-empowerment.jpg
├── sustainable-farming.jpg
├── farmer-support.jpg
└── products/
    ├── arabica-coffee.jpg
    ├── robusta-coffee.jpg
    ├── ground-coffee.jpg
    ├── organic-blend.jpg
    ├── dark-roast.jpg
    └── espresso-blend.jpg
```

## Quick Setup Script

Create a PowerShell script to create placeholder image directories:

```powershell
# Run in PowerShell from coffee_farm directory
New-Item -ItemType Directory -Force -Path "assets/images/products"
New-Item -ItemType Directory -Force -Path "logs"

Write-Host "Directories created successfully!"
Write-Host "Please add your images to assets/images/ and assets/images/products/"
```

## Testing Without Images

The website will work without images, but placeholder icons will show. To test:

1. The website uses Font Awesome icons as fallbacks
2. Alt text is displayed if images are missing
3. No broken image links (handled gracefully)

## Notes

- All images should be properly licensed for commercial use
- Maintain consistent aspect ratios for product images
- Use descriptive file names (lowercase, hyphens instead of spaces)
- Always include alt text for accessibility
