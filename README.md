========================================================================
PROJECT README: VIATUBORA E-COMMERCE SYSTEM
========================================================================

------------------------------------------------------------------------
1. STUDENT & COURSE METADATA
------------------------------------------------------------------------
* Student Name:       Jennifer Mutheu Muema
* Admission Number:   BBIT/2024/74708
* Course/Class:       Bachelor of Science in Business Information Technology (BBIT)
* Unit Code:          BIT3208
* Unit Name:          Advanced Web Design and Development
* Project Title:      Viatubora E-Commerce System
* Selected Tech:      PHP (PDO) + MySQL, Bootstrap 5, JavaScript (ES6)
* GitHub Repository:  https://github.com/jayne-mutheu/viatu-bora.git

------------------------------------------------------------------------
2. SYSTEM DOCUMENTATION & ARCHITECTURE INDEX
------------------------------------------------------------------------
This project documentation tracks the structural progress, development phases, 
and graphical components of the ViatuBora e-commerce system.

PHASE 1: Installation and Testing of Local Development Environment
   ├── Fig 1: Installation of XAMPP/WAMP
   ├── Fig 2: Apache and MySQL Running
   ├── Fig 3: Localhost Test Page
   ├── Fig 4: Hello World Test
   └── Fig 5: Database Connection Test

PHASE 2: User Interface Planning and System Design
   ├── Fig 6: Wireframe (Homepage for ViatuBora)
   ├── Fig 7: Dashboard Layout Design
   ├── Fig 8: Mobile View Mockup
   ├── Fig 9: Color Theme and Navigation Structure
   └── Fig 10: GUI Prototype (Figma/Canva/Draw.io)

PHASE 3: Frontend Interaction and Backend Foundations
   ├── Fig 11: JavaScript Form Validation (Login Constraints)
   ├── Fig 12: Password Strength Checker
   ├── Fig 13: PHP Syntax Practice
   ├── Fig 14: Database Connection Script
   └── Fig 15: Dynamic User Input Handling

PHASE 4: System Authentication and Session Management
   ├── Fig 16: User Registration Flow (register.php)
   ├── Fig 17: Secure Login Script (login.php)
   ├── Fig 18: Role-Based Redirection (Admin vs. Customer)
   └── Fig 19: Session Initialization and Management

PHASE 5: Designing the Product Catalog Database
   ├── Fig 20: Database Schema design in phpMyAdmin
   ├── Fig 21: Add Product Form (add-product.php)
   ├── Fig 22: Inventory Dashboard Records (dashboard.php)
   └── Fig 23: Edit and Delete Functionalities (edit-product.php)

------------------------------------------------------------------------
3. DETAILED TECHNICAL DEVELOPMENT PHASES
------------------------------------------------------------------------

[PHASE 1] Local Development Environment Setup
---------------------------------------------
* Scope: Deployment of local architecture tools.
* Details: Configured a local Apache server and MySQL relational instance 
  using the XAMPP stack. 
* Implementation Notes: A resilient database connectivity pipeline was established 
  using PHP Data Objects (PDO) inside 'db.php'. This structure implements clear 
  try/catch exception blocks to handle error states without exposing structural 
  vulnerabilities, satisfying baseline requirements for a secure multi-tier database application.

[PHASE 2] UI/UX Design & Layout Prototyping
--------------------------------------------
* UI Canvas: https://wireframedfgh.my.canva.site/e-commerce-system-wireframe
* Scope: Wireframing, device layout styling, and structural components.
* Details: Formulated a responsive viewport experience utilizing HTML5 semantic markers, 
  CSS3 styling tokens, and the Bootstrap 5 design ecosystem.
* Implementation Notes: Optimized the navigation hierarchy to reduce user click patterns 
  and maximize conversion funnels. The administrative portal layout uses a fixed left sidebar 
  architecture ('sidebar.php'), accommodating seamless structural upgrades as additional 
  product modules or metrics panels are implemented.

[PHASE 3] Frontend Validation & Form Security
----------------------------------------------
* Scope: Input cleaning, clientside filters, and processing basics.
* Details: Integrated vanilla JavaScript handlers to intercept form cycles, stopping 
  empty data submissions or structural submission bypasses.
* Implementation Notes: Backend handlers execute server-side data cleaning on incoming strings. 
  During registration routines ('register.php'), raw data strings pass through one-way hashing 
  via 'password_hash()' with default secure salt vectors before committing to storage tables.

[PHASE 4] Authentication & Role-Based Access Control (RBAC)
------------------------------------------------------------
* Scope: Secure session contexts and administrative route firewalls.
* Details: Implemented state isolation modules leveraging native PHP $_SESSION stores to 
  authenticate active application contexts.
* Implementation Notes: The security layer within 'login.php' executes structured multi-role checks. 
  Upon successful lookup validation, administrators are programmatically directed to the catalog 
  management dashboard ('dashboard.php') while default shopper instances drop into the retail 
  catalog interface ('index.php').

[PHASE 5] Database Catalog & Dynamic CRUD Lifecycle
---------------------------------------------------
* Scope: Schema construction, object creation, data updates, and removal pipelines.
* Details: Created an interactive database schema structure mapping parameters for shoe models, 
  pricing elements, quantities, and unique system IDs inside phpMyAdmin.
* Implementation Notes: Data input updates in 'insert-product.php', 'edit-product.php', and 
  'dashboard.php' are strictly processed through parameterized SQL engines via PDO. Using bound parameters 
  nullifies SQL injection vectors, providing a secure backend layer for inventory management.

------------------------------------------------------------------------
4. CORE PROJECT FILE MAP
------------------------------------------------------------------------
├── db.php                 <- Relational connection configuration (PDO)
├── header.php             <- Universal structural layout component & navigation bar
├── index.php              <- Primary entry page for consumers
├── products.php           <- Full catalog viewer with grid layouts
├── view-product.php       <- Detailed contextual view per individual model entry
├── cart.php               <- Transaction staging dashboard (shopping cart tracking)
├── login.php              <- Secure entry application logic
├── register.php           <- Account creation engine
├── logout.php             <- Active session destruction mechanism
├── dashboard.php          <- Administrative asset overview grid
├── add-product.php        <- Form engine to inject catalog assets
└── edit-product.php       <- Modification/removal route processing logic

========================================================================
