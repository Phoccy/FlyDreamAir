# System Requirements Specification: FlyDreamAir LMS

**Date:** 2026-04-03  
**Status:** Baseline (v1.0)  
**Project Role:** Systems Architecture

---

## 1. Technical Infrastructure (Non-Functional)
* **Tech Stack:** Implementation will utilize a **LAMP (PHP 8.x / MySQL)** environment. 
* **Architecture:** Modular design to support potential future "Multi-Tenant" global rollout (initially targeting SYD and MEL).
* **Data Migration:** Schema must support legacy customer record imports (Basic Customer Info).
* **Compliance (PII):** Prototype uses sample data; however, architecture must be "Privacy-Ready" for **Australian Privacy Act** standards in future iterations.
* **Auditability:** Database must retain historical booking and transaction logs for a minimum of **one year**.

---

## 2. Membership & Eligibility Logic (Functional)
* **Membership Tiers:**
    * **Basic:** Standard account holders.
    * **VIP:** Priority members with access to special lounge facilities.
* **The "Six-Month" Gate:** * System must verify that a passenger’s account has been active for at least **180 days (6 months)** before lounge booking eligibility is granted.
* **Access Credentials:** * Entry requires a valid **Flight Booking/Boarding Pass**.
    * System must support **QR Code scanning** (physical printouts or mobile web version) to confirm identity and booking status.

---

## 3. Booking & Revenue Rules (Functional)
* **Pricing Structure:** * **Standard Entry Fee:** AU$65.00 (Fixed).
    * **Dynamic Pricing:** Not required for MVP (Static rates only).
* **Booking Windows:**
    * **Advance Booking:** Up to **7 days** before scheduled flight departure.
    * **Entry Window:** Access permitted up to **4 hours** before flight departure.
* **Payment:** Mandatory pre-payment via the existing web portal prior to lounge arrival.

---

## 4. Occupancy & Access Control (Technical)
* **Capacity Management:**
    * **Lounge Locations:** Sydney (SYD) and Melbourne (MEL).
    * **Entry Rule:** Entry is dependent on current occupancy levels for Basic members.
    * **VIP Override:** VIP members are entitled to **Priority/Guaranteed Entry** regardless of current occupancy (Architecture must reserve a "VIP buffer" or allow override).
* **Real-Time Sync:** * While manual sync is acceptable for the prototype, the architecture must support **Real-Time Occupancy Updates**.
    * **Checkout Logic:** System should prompt a "Manual Checkout" or "Complete Booking" upon exit to ensure live occupancy accuracy.

---

## 5. UI/UX & Branding (Design Constraints)
* **Visual Identity:** * **Color Palette:** Primary Blue and White (consistent with existing FlyDreamAir brand).
* **Brand Tone:**
    * **Casual:** For standard messaging to Basic members.
    * **Personal/Formal:** For VIP-facing communications and interfaces.
* **Interface Type:** * **Staff Portal:** Dedicated Administrative view for booking verification and manual occupancy overrides.
    * **Passenger Portal:** Self-service view for checking/modifying bookings and ordering basic services.

---

## 6. Technical Risks & Contingencies
* **Integration:** System acts as a "Greenfield" implementation for the logic, while interfacing with legacy customer data.
* **Scalability:** Initial rollout is a pilot for two Australian locations, but the database must be structured to support 50+ global locations.

---

### Implementation Notes for Development:
> **Note:** The "6-Month Rule" is a hard validation constraint. Ensure the `users` table includes a `created_at` timestamp. The fixed $65 fee should be stored in a `config` table or as a constant to allow for future "Promotional" overrides as mentioned by the client.