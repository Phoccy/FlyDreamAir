**Project:** Lounge Management System (LMS)  
**Version:** 2.0 | **Status:** Approved | **Date:** 2026-04-04

---

## Functional Requirements (FR)
*These define the specific behaviors and services the system **shall** provide.*

| ID | Requirement Name | Description |
| :--- | :--- | :--- |
| **FR-01** | **Identity & Access** | The system **shall** provide secure, role-based login portals for **Airline Staff** (Verification) and **Passengers** (Self-Service). |
| **FR-02** | **Tiered Eligibility** | The system **shall** support a two-tier membership model: **FlyDreamBlue** (Standard) and **FlyDreamGold** (VIP/Priority). |
| **FR-03** | **The Six-Month Gate** | The system **must** validate that a passenger’s account age is $\ge 180$ days (6 months) before granting lounge booking eligibility. |
| **FR-04** | **Booking Lifecycle** | Passengers **shall** be able to create, view, and cancel bookings for SYD and MEL lounges within a **7-day** lead time. |
| **FR-05** | **Occupancy Logic** | The system **shall** track real-time capacity, allowing **VIP Overrides** while restricting Blue members if the lounge is at maximum capacity. |
| **FR-06** | **Payment Processing** | The system **shall** facilitate a fixed **AU$65.00** fee for pay-per-use access via the Stripe API integration. |
| **FR-07** | **QR Verification** | The system **shall** generate a unique, scannable QR code for every valid booking to be used for staff-side entry validation via the web portal. |
| **FR-08** | **Data Management** | The prototype **shall** utilize a localized database populated with **synthetic sample data** for passengers, staff, and flight records. |

---

## Non-Functional Requirements (NFR)
*These define the quality attributes and operational constraints of the LMS.*

| ID | Requirement Name | Description |
| :--- | :--- | :--- |
| **NFR-01** | **Responsiveness** | The system **shall** utilize a **Responsive Web Interface** (RWI) that fluidly adapts to mobile, tablet, and desktop browser resolutions. |
| **NFR-02** | **Availability** | The system **shall** aim for **99% uptime** during the prototype phase to ensure staff can verify entries at all times. |
| **NFR-03** | **Security** | All financial transactions **shall** be handled externally via Stripe to ensure **PCI-DSS compliance** and protect billing data. |
| **NFR-04** | **Performance** | The landing page and booking dashboard **shall** load in under **2.0 seconds** on standard Australian 4G/5G mobile networks. |
| **NFR-05** | **Usability (UX)** | The interface **shall** maintain high-contrast ratios (minimum **4.5:1**) for all primary Action Buttons (e.g., Login) to ensure accessibility. |
| **NFR-06** | **Auditability** | The database **shall** retain historical booking and transaction logs for a minimum of **365 days** for audit logic. |

---

## Technical Requirements (TR)
*These define the technical standards and environmental constraints for development.*

| ID | Category | Specification |
| :--- | :--- | :--- |
| **TR-01** | **Development Stack** | The system **must** be developed using the **LAMP Stack** (Linux, Apache, MySQL 8.0+, PHP 8.2+). |
| **TR-02** | **Coding Standards** | All PHP backend code **must** implement **Strict Typing** and full type-hinting for all methods and properties. |
| **TR-03** | **Database Design** | Data persistence **must** be managed via an RDBMS using **3rd Normal Form (3NF)** to ensure data integrity. |
| **TR-04** | **Naming Policy** | All file paths and classes **must** follow **PascalCase** (e.g., `app/Views/Common/Header.phtml`); internal variables use **snake_case**. |
| **TR-05** | **Security Protocols** | The application **must** use **Bcrypt** for password hashing and **PDO** prepared statements to prevent SQL Injection. |
| **TR-06** | **Version Control** | The project **must** utilize **Git/GitHub** with a mandatory Pull Request (PR) workflow and commit logs as evidence of contribution. |
| **TR-07** | **Front-End Tech** | The UI **must** be built using **Vanilla HTML5, CSS3, and JavaScript (ES6+)** to maintain high performance and low overhead. |

---

## Implementation Notes & Constraints
* **The "6-Month Rule":** This is a hard validation constraint. The `users` table must include a `created_at` timestamp.
* **Entry Window:** Access is permitted up to **4 hours** before flight departure.
* **Architecture:** While initially targeting two locations, the schema must be modular to support a future global rollout.
* **QR Logic:** Verification utilizes a browser-based scanner (Staff Portal) to validate the passenger's unique booking ID.