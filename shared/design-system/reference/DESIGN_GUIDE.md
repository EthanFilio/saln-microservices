# SALN Form Application - Design Documentation

## Design System

### Color Palette

```css
Primary: #0066cc (Blue - trust, government, reliability)
Primary Hover: #0052a3
Success: #2d8659 (Green - approval, completion)
Text Primary: #1a1a1a (Almost black for readability)
Text Secondary: #666666 (Gray for supporting text)
Text Muted: #999999 (Light gray for hints)
Background White: #ffffff
Background Light: #f9f9f9 (Subtle gray for sections)
Border: #e0e0e0 (Light border for separation)
```

### Typography

**Font Family**: System font stack for optimal performance and native feel
```css
-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif
```

**Font Sizes**:
- H1: 2.5rem (40px) - Page titles
- H2: 2rem (32px) - Section headers
- H3: 1.5rem (24px) - Subsections
- Body: 16px - Base font size
- Small: 14px - Helper text, captions
- Tiny: 13px - Privacy notices

**Line Height**: 1.6 for body text (optimal readability)

### Spacing System

Based on 8px grid:
- XS: 4px
- SM: 8px
- MD: 16px
- LG: 24px
- XL: 32px
- XXL: 48px, 64px, 80px

### Components

#### Buttons

**Primary Button**
- Background: Primary blue
- White text
- 12px vertical, 24px horizontal padding
- 4px border radius
- Hover: Darker blue
- Use for: Main actions (Login, Save, Generate PDF)

**Secondary Button**
- Transparent background
- Border: 1px solid border-color
- Dark text
- Hover: Light gray background
- Use for: Secondary actions (Export, Import, Logout)

**Add Item Button**
- Dashed border (2px)
- Light background
- Full width
- Use for: Adding repeatable form entries

#### Form Inputs

**Text Inputs**
- 12px/16px padding
- 1px solid border
- 4px border radius
- Focus: Blue border, no shadow
- Full width by default

**Labels**
- Font weight: 500
- 8px margin bottom
- Dark text

**Helper Text**
- 14px font size
- Muted color
- 4px margin top

#### Cards

**Standard Card**
- 1px border
- 8px border radius
- 32px padding (24px on mobile)
- White background
- Subtle shadow on hover (optional)

**Section Card**
- Collapsible header (20px padding)
- Light gray header background
- Content padding: 24px
- Toggle indicator (+/−)

#### Modals

- Fixed position overlay
- Semi-transparent backdrop (50% black)
- Centered content box
- Max width: 480px
- 32px padding
- 8px border radius

### Layout

#### Container
- Max width: 1200px (main content)
- Max width: 640px (narrow forms, auth pages)
- Left/right padding: 24px
- Centered with auto margins

#### Navigation Bar
- Sticky position (stays at top on scroll)
- White background
- 1px bottom border
- 16px vertical padding
- Flexbox layout (space-between)

#### Form Sections
- Generous vertical spacing (24px between sections)
- Collapsible for better organization
- Visual hierarchy with borders and backgrounds

### Responsive Design

**Breakpoints**:
- Mobile: < 768px
- Tablet: 768px - 1024px
- Desktop: > 1024px

**Mobile Adaptations**:
- Stack form rows vertically
- Reduce heading sizes
- Adjust navbar to column layout
- Reduce card padding
- Full-width buttons

### Accessibility

**WCAG 2.1 AA Compliance**:
- Color contrast ratio ≥ 4.5:1 for text
- Focus indicators on all interactive elements
- Semantic HTML (proper heading hierarchy)
- Form labels associated with inputs
- Keyboard navigation support
- Screen reader friendly

**Form Accessibility**:
- Required fields marked with asterisk (*)
- Error messages clearly associated with fields
- Logical tab order
- Helper text for complex fields

### User Experience Principles

#### 1. **Progressive Disclosure**
- Collapsible sections reduce cognitive load
- Only essential fields shown by default
- Optional sections clearly marked

#### 2. **Clear Feedback**
- Save status indicator
- Loading states on buttons
- Success/error alerts
- Confirmation for destructive actions

#### 3. **Forgiveness**
- Auto-save every 2 minutes
- Export/import for backup
- Undo-friendly (non-destructive edits)
- Clear warnings before data loss

#### 4. **Privacy Transparency**
- Privacy notices on relevant pages
- Clear data retention policy
- No hidden data collection
- User control over their data

#### 5. **Consistency**
- Consistent button styles and positions
- Uniform spacing and alignment
- Predictable interactions
- Standard patterns throughout

### Page-Specific Designs

#### Landing Page

**Layout**:
- Centered narrow column
- Hero section at top
- Feature cards below
- Privacy notice
- Footer with disclaimer

**Hierarchy**:
1. Main headline (H1)
2. Descriptive paragraph
3. Primary CTA (Get Started)
4. Three feature cards
5. Privacy notice
6. Footer text

**Spacing**:
- 80px top/bottom page padding
- 64px between major sections
- 24px around hero text
- 16px between feature cards

#### Login Page

**Layout**:
- Single centered card (480px max width)
- Two-step process in one view
- Progressive reveal (email → verification)
- Back button for navigation

**Interaction Flow**:
1. Enter email
2. AJAX request (loading state)
3. Show verification form
4. Submit both code and password
5. Server-side validation
6. Redirect to dashboard

#### Dashboard/Form Interface

**Layout**:
- Sticky navbar at top
- Full-width content area
- Collapsible sections
- Fixed action buttons in navbar

**Navbar Actions** (left to right):
- New Entry
- Import JSON
- Export JSON
- Save
- Generate PDF
- (right side) Email + Logout

**Form Organization**:
1. Form Information
2. Personal Information
3. Spouse Information
4. Children Below 18
5. Real Properties
6. Personal Properties
7. Liabilities
8. Business Interests
9. Relatives in Government
10. Certification

**Section States**:
- Essential sections start expanded
- Optional sections start collapsed
- Visual indicator (+/−) for state

### Interaction Patterns

#### Collapsible Sections
- Click anywhere on header to toggle
- Smooth transition (CSS)
- Icon rotates to indicate state
- Hover effect on header

#### Repeatable Fields
- "Add" button at bottom of list
- Each item has remove button (top-right)
- Consistent card styling for items
- Auto-focus on new item (optional)

#### Form Validation
- Real-time validation on blur
- Red error text below field
- Border color change on error
- Prevent submission if invalid

#### Save States
- Draft (default)
- Saving... (during save)
- Saved (success, 2 seconds)
- Back to Draft

### Performance Considerations

- Minimal CSS (no external frameworks)
- Vanilla JavaScript (no jQuery/React overhead)
- Inline critical CSS
- Lazy-load form sections if needed
- Efficient DOM manipulation
- Debounced auto-save

### Browser Support

- Chrome/Edge (latest 2 versions)
- Firefox (latest 2 versions)
- Safari (latest 2 versions)
- Mobile browsers (iOS Safari, Chrome Android)

### Design Inspiration

**fullstackopen influences**:
- Clean whitespace usage
- Minimal visual noise
- Focus on content over decoration
- Systematic spacing
- Subtle use of color

**Google Forms influences**:
- Sectioned layout
- Collapsible panels
- Clear field labels
- Progressive form filling
- Simple, accessible design

### Future Design Enhancements

- Dark mode toggle
- Custom theme colors per agency
- Progress indicator (% complete)
- Field-level help tooltips
- Keyboard shortcuts modal
- Print-friendly styles
- Offline mode indicator

---

## Component Library

For future development, consider extracting these into reusable components:

- Button (primary, secondary, danger, success)
- FormGroup (label + input + help + error)
- Card (with optional header)
- Modal (with header, body, footer)
- Alert (success, error, info, warning)
- Section (collapsible container)
- RepeaterField (for dynamic lists)
- Navbar
- PrivacyNotice

This would enable:
- Consistent styling
- Easier maintenance
- Potential migration to component framework
- Style guide documentation
- Design system scalability
