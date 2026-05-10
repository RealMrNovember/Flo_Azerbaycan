# TODO.md — FLO Azerbaijan Enterprise E-Commerce Platform

## Project Vision

Build a premium, enterprise-grade omnichannel e-commerce platform for the Azerbaijan market inspired by the architecture quality, scalability and professionalism of global fashion retailers like FLO, Zara, Nike and Trendyol — but optimized specifically for FLO Azerbaijan operations.

This is NOT a demo project.
This is a production-ready, scalable, modular and maintainable enterprise commerce ecosystem.

The platform must feel:
- Modern
- Editorial
- Premium
- Fast
- Fashion-tech focused
- Mobile-first
- Clean and luxurious
- Conversion optimized

The design language should avoid cheap marketplace aesthetics.
The system should feel like a premium international fashion brand.

---

# PRIMARY TECHNOLOGY STACK

## Backend
- Laravel 11
- PHP 8.3+
- MySQL 8+
- Redis
- Laravel Horizon
- Laravel Queue
- Laravel Scheduler
- Laravel Sanctum
- Laravel Scout
- Meilisearch / Typesense
- Spatie Packages
- Filament PHP v3
- Livewire v3
- Alpine.js
- REST API architecture
- Repository + Service Pattern
- DTO architecture where necessary
- Event Driven architecture for critical operations

## Frontend
- Tailwind CSS
- TALL Stack
- Responsive Mobile-First architecture
- Glassmorphism UI elements
- Framer-like smooth micro interactions
- Ultra clean whitespace usage
- Premium animations
- Optimized lazy loading
- Skeleton loading states
- SPA-like UX using Livewire navigation

## DevOps
- Docker support
- Queue workers
- ERP synchronization queues (event-driven): SAP / Nebim / 1C kaynaklı varyant-stok-fiyat güncellemelerini DTO tabanlı “ERP Sync Pipeline” (Job/Event mimarisi) ile asenkron ve geri basınç (backpressure) kontrollü işlemek
- Redis caching
- Nginx optimized configs
- CDN-ready asset structure
- Image optimization pipeline
- CI/CD friendly architecture

---

# PROJECT GOALS

The system must support:

- Multi-language
- Multi-currency
- Multi-store architecture
- Omnichannel inventory
- Warehouse management
- Campaign management
- Coupon system
- Advanced filtering
- Product variants
- Store pickup
- Delivery tracking
- Staff management
- Activity logs
- Audit system
- SEO optimization
- High performance
- Future mobile app integrations

---

# BRAND RESEARCH TASK

Before coding:

Research and collect real FLO ecosystem data from the internet.

Research:
- FLO official branding
- FLO color palette
- FLO typography style
- FLO UI structure
- FLO mobile UX
- FLO campaign styles
- FLO category structures
- FLO shoe sizing logic
- FLO product card behavior

Research all major FLO brands:
- Kinetix
- Lumberjack
- Polaris
- Butigo
- Nine West
- Dockers
- Nike
- Adidas
- Puma
- Reebok
- Skechers
- U.S. Polo Assn.
- Converse
- Vans

Collect:
- Real category structures
- Real product types
- Real filters
- Real attribute systems
- Real brand data
- Real color systems

Use this data for:
- Seeders
- Factories
- Demo content
- UI structure
- Filtering systems
- Product architecture

DO NOT generate fake/random fashion data.

---

# ENTERPRISE DATABASE ARCHITECTURE

Design a scalable database structure.

## Core Tables

### Users
- Staff
- Customers
- Admins

### Roles & Permissions
Use:
- Spatie Permission
OR
- Filament Shield

Roles:
- Super Admin
- Store Manager
- Warehouse Staff
- Order Operator
- Content Editor
- Customer Support

---

# PRODUCT SYSTEM ARCHITECTURE

Products must support:

## Product Structure
- Brand
- Categories
- Subcategories
- Collections
- Gender
- Season
- Material
- Features
- Barcode
- SKU
- Slug
- SEO metadata

## Product Variant System

A product can have:
- Multiple colors
- Multiple sizes
- Multiple stock quantities
- Different warehouse stock
- Different images per variant
- Variant-specific pricing

Example:
Sneaker
└── Black
    ├── 40
    ├── 41
    ├── 42

Each size:
- Separate SKU
- Separate barcode
- Separate stock
- Separate warehouse quantity

Use:
- Repeater
- Builder
- Nested forms
inside Filament Resource architecture.

---

# INVENTORY & WAREHOUSE SYSTEM

Build professional inventory logic.

Support:
- Multi warehouse
- Stock transfers
- Low stock alerts
- Warehouse movements
- Inventory history
- Barcode support
- Reserved stock
- Damaged stock tracking
- Store stock
- Online stock

All stock operations must be logged.

---

# MEDIA MANAGEMENT

Use:
- Spatie Media Library
- On-the-fly image optimization: Cloudflare Images veya CDN tabanlı dinamik yeniden boyutlandırma (mobil/desktop) + format dönüşümü (AVIF/WebP) mimarisi

Features:
- Drag-drop uploads
- Multiple image galleries
- Variant image galleries
- WebP optimization
- Auto resizing
- Lazy loading
- CDN compatibility

Support:
- Product videos
- Campaign banners
- Hero sliders
- Editorial blocks

---

# ACTIVITY LOGGING & SECURITY

Use:
- Spatie Activitylog

Track:
- Product edits
- Price changes
- Stock changes
- Login history
- Staff operations
- Permission changes

Use:
- SoftDeletes everywhere critical
- Policies
- Gates
- Rate limiting
- Audit logs
- Failed login tracking

---

# FRONTEND UX REQUIREMENTS

The frontend MUST feel premium.

## Design Philosophy
Editorial Fashion-Tech

Inspired by:
- Zara
- Nike
- Apple
- FLO
- COS
- A modern luxury fashion retailer

---

# UI STYLE RULES

## Typography
Use:
- Inter
- Playfair Display

Hierarchy:
- Huge clean headings
- Elegant spacing
- Minimal text noise

---

# VISUAL STYLE

Use:
- Soft shadows
- Blur layers
- Glassmorphism
- Smooth hover animations
- Large hero sections
- Premium white spacing
- Minimal borders
- Rounded-xl layouts
- Elegant transitions

Avoid:
- Cheap gradients
- Overcrowded cards
- Marketplace feeling
- Old ecommerce aesthetics

---

# FRONTEND PAGES

Build:

## Public Pages
- Homepage
- Category pages
- Product listing
- Product detail
- Brand pages
- Campaign pages
- Store locator
- About
- Contact
- Blog
- FAQ

## Commerce Pages
- Cart
- Checkout
- Wishlist
- Compare
- Orders
- Returns
- Customer profile

## Authentication
- Login
- Register
- Password reset
- OTP support
- Social login ready

---

# PRODUCT LISTING EXPERIENCE

Build advanced filtering using Livewire.

Filters:
- Brand
- Size
- Color
- Gender
- Price
- Season
- Material
- Campaign
- Stock availability

Features:
- Instant filtering
- Debounced search
- URL state persistence
- Infinite scroll
- Skeleton loaders
- Dynamic sorting

---

# PRODUCT DETAIL PAGE

The PDP must feel world-class.

Include:
- Large gallery
- Variant selectors
- Dynamic stock state
- Related products
- Recently viewed
- Campaign badges
- Product videos
- Accordion tabs
- Shipping info
- Return policy
- Reviews

Use:
- Smooth transitions
- Variant image switching
- Sticky purchase panel

---

# SEARCH SYSTEM

Use:
- Laravel Scout
- Meilisearch or Typesense

Features:
- Instant search
- Suggestions
- Typo tolerance
- Trending searches
- Popular products
- Search analytics
- AI destekli vektörel arama (Vector Search): bağlamsal sorguların anlaşılması (örn. “Yağmurlu hava için şık ayakkabı”) için embedding tabanlı semantic retrieval katmanı

---

# LOCALIZATION

Must support:
- Azerbaijani (AZ)
- Russian (RU)
- English (EN)

Architecture must be fully translatable.

Use:
- Localization files
- Dynamic content translations
- Currency formatting
- RTL-safe architecture future support

---

# SEO & PERFORMANCE

Implement:
- Structured data
- OpenGraph
- Dynamic meta tags
- Canonical URLs
- XML sitemap
- Robots.txt
- Breadcrumb schema
- Server-side rendering friendly architecture

Performance targets:
- Lighthouse 90+
- Mobile optimized
- Lazy loading everywhere
- Optimized images
- Redis caching
- Query optimization

---

# FILAMENT ADMIN PANEL

Build a fully enterprise-grade backend.

- Filament Multi-Panel mimarisi: güvenlik ve izolasyon için 3 ayrı panel (AdminPanelProvider: Super Admin/IT, StorePanelProvider: mağaza müdürü kısıtlı UI, WarehousePanelProvider: stok & barkod odaklı)

## Required Resources

### Core
- ProductResource
- CategoryResource
- BrandResource
- OrderResource
- CustomerResource
- UserResource
- WarehouseResource
- InventoryResource
- CampaignResource

---

# PRODUCT RESOURCE REQUIREMENTS

Must include:
- Nested repeaters
- Variant management
- Bulk image uploads
- Drag-sort
- Stock management
- Price management
- SEO fields
- Media gallery
- Status badges
- Soft delete support

---

# ORDER MANAGEMENT

Features:
- Order statuses
- Payment tracking
- Refunds
- Return requests
- Shipment tracking
- Invoice generation
- Customer notes
- Internal staff notes

---

# CUSTOMER EXPERIENCE FEATURES

Implement:
- Wishlist
- Recently viewed
- Personalized recommendations
- Loyalty system ready architecture
- Coupon system
- Gift cards architecture
- Notifications system

---

# API ARCHITECTURE

Prepare API-first architecture for future:
- Mobile app
- POS systems
- External integrations
- Marketplace integrations

Build:
- REST API
- Sanctum auth
- API Resources
- Rate limiting
- API versioning

---

# CODE QUALITY RULES

MANDATORY:
- declare(strict_types=1);
- SOLID principles
- Clean Architecture
- Repository Pattern
- Service Layer
- Form Requests
- DTO usage
- Enum usage
- PHPStan level max
- Pint formatting
- Pest tests

Never write:
- Spaghetti code
- Monolithic controllers
- Inline business logic
- Duplicate code

---

# EXPECTED OUTPUTS

Generate step-by-step:

## 1. Full Folder Architecture
Provide full scalable project structure.

## 2. Database Migrations
Enterprise-level migrations with indexes and constraints.

## 3. Eloquent Models
Including:
- Relations
- Traits
- Casts
- Scopes
- Accessors
- Mutators

## 4. Filament Resources
Complete resources with:
- Forms
- Tables
- Filters
- Actions
- Policies

## 5. Seeder Architecture
Use real FLO ecosystem data.

## 6. Tailwind Config
Inject researched FLO brand colors.

## 7. Livewire Components
Build production-ready components.

## 8. API Architecture
REST endpoints and resources.

## 9. Inventory Logic
Warehouse movement architecture.

## 10. Authentication System
Enterprise staff + customer auth.

---

# IMPORTANT DEVELOPMENT RULES

- Think like a billion-dollar fashion retailer.
- Build scalable architecture from day one.
- Prioritize maintainability.
- Prioritize clean UX.
- Prioritize speed.
- Prioritize conversion optimization.
- Prioritize admin usability.
- Prioritize enterprise scalability.

DO NOT:
- Build amateur CRUD systems.
- Use ugly ecommerce layouts.
- Use outdated UI patterns.
- Use Bootstrap.
- Use generic themes.
- Use fake data structures.
- Use simplistic architecture.

Every screen must feel:
Premium.
Modern.
Elegant.
Fast.
Professional.
Enterprise-grade.

Start with:
1. Architecture planning
2. Database design
3. Backend system
4. Filament admin
5. Frontend components
6. API layer
7. Performance optimization
8. Final UX polish
