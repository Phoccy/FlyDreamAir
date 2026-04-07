# FlyDreamAir: Lounge Management System
**CSIT214 IT Project Management | Group T18**

## ✈️ Project Overview
Development of a centralized software system to manage global airline lounges. Key functionalities include membership validation, pay-per-use processing, real-time occupancy tracking, and booking/cancellation logic.

### 🛠 Technical Stack
- **Environment:** Local LAMP Stack (Linux, Apache, MySQL, PHP 8.x)
- **Database:** MySQL (Relational Schema)
- **Frontend:** HTML5, CSS3, JavaScript
- **Version Control:** Git/GitHub

---

## 👥 Team Roles & Responsibilities

### **Harri — Project Manager (PM)**
* **Focus:** The "Triple Constraint" (Scope, Time, Cost).
* **Key Deliverables:** MS Project Schedule (Gantt), Meeting Minutes, Project Charter, and Closing Report.
* **Primary Directory:** `/docs/management`

### **Anas — Business Analyst (BA)**
* **Focus:** Requirements Elicitation & Logic.
* **Key Deliverables:** Business Case, Scope Statement, WBS, and WBS Dictionary.
* **Primary Directory:** `/docs/requirements`

### **Adam — Systems Architect & Developer**
* **Focus:** Technical Architecture & Working Prototype.
* **Key Deliverables:** GitHub Management, PHP/SQL Logic, Technical Specifications, and Live Demo.
* **Primary Directory:** `/src`, `/app`, `/db`, `/docs/technical`

### **Denisha — UI/UX Designer & Document Controller**
* **Focus:** Interface Design & Final Assembly.
* **Key Deliverables:** Figma/Canva Prototypes, UI Screenshots, and Final Document Formatting/Merging.
* **Primary Directory:** `/docs/design`

### **Finley — Risk & Quality Manager (QA)**
* **Focus:** Mitigation & Compliance.
* **Key Deliverables:** Risk Register, Cost Estimation (COCOMO), Rubric Cross-referencing, and System Testing.
* **Primary Directory:** `/docs/testing`

---

## 📂 Repository Structure
- `/src`: Core PHP source files.
- `/app`: Core PHP application files.
- `/db`: SQL Schema exports and database initialization scripts.
- `/docs`: All project management and technical documentation.
    - `/requirements`: [Anas] Scope, Business Case, WBS, and Functional Requirements.
    - `/management`: [Harri] Project Charter, Schedule, and Budgeting.
    - `/design`: [Denisha] Figma wireframes, style guides, and UI mockups.
    - `/testing`: [Finley] Risk Register, Test Plans, and Audit Logs.
    - `/technical`: [Adam] ERDs, Architecture Diagrams, and Specs.
    - `/templates`: **Source of Truth** for formatting. No unformatted docs allowed.
    - `/minutes`: Weekly records of progress and decisions.
    - `/deliverables`: Final form documentation for submission.

---

## 🛠 Team Development Workflow (Git Protocols)

To ensure project stability and avoid losing work, all members must follow these steps:

### 1. The Golden Rule: Pull Before You Push
Before adding a file or editing a document, always click **Pull** (or `git pull origin main`) to ensure you have the latest version of the project.

### 2. Standardized Commit Messages
Please use descriptive labels to keep the history searchable:
* `docs: updated risk register` (Finley)
* `ui: added login wireframe` (Denisha)
* `plan: updated WBS dictionary` (Anas)
* `mgmt: uploaded week 5 minutes` (Harri)
* `db: initial schema export` (Adam)

### 3. Conflict Resolution & Safety
* **Code Integrity:** The `/app`, `/src`, and `/db` folders contain the core system logic. **Do not modify or delete files in these folders** without consulting the Systems Architect (Adam).
* **Merge Conflicts:** If Git gives you an error about a "Merge Conflict," **STOP**. Do not force the push. Message Adam immediately to resolve it safely.

### 4. Final Document Protocol
All "Final Drafts" must be pushed to this repository. Emails are for quick drafts; GitHub is the official record for the Tutor/Client.

### 5. How to Commit (The "Sandbox" Method)
To protect our working code, **NO ONE** should push directly to the `main` branch. Please follow this "Sandbox" method:

#### A. Create Your Branch (The First Time)
Before you start your work, create a "branch" named after your role. This is your safe space to upload files.
* **Command:** `git checkout -b feature/docs-[your-name]` 
* **GitHub Desktop:** Click "Current Branch" -> "New Branch" -> Name it `feature/docs-harri` (or your name).

#### B. The 3-Step Upload Process
1. **Pull:** Always click "Pull" first to make sure you have Adam's latest database updates.
2. **Commit:** Add your files and write a summary (e.g., `docs: added week 5 minutes`).
3. **Push:** Click "Push" to send your branch to GitHub.

#### C. Getting Your Work into the Main Folder
Once your document or design is uploaded to your branch:
1. Go to our GitHub page.
2. You will see a yellow bar that says **"Compare & pull request"**. Click it.
3. Click **"Create pull request"**.
4. **Adam (Systems Architect)** will review the changes and merge them into the `main` branch. This ensures all formatting and file paths stay consistent.

---
**⚠️ WARNING:** If you see an option to "Commit directly to the main branch," **DO NOT** select it. Always choose "Create a new branch for this commit."