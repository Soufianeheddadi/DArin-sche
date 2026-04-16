# DArin-sche

## Overview

DArin-sche is a web-based workforce scheduling and roster planning tool built for a Customer Experience team. It is designed to help planners manage weekly staffing, employee leave, holidays, Ramadan shift adjustments, and demand-based break planning from one place.

The website also includes a separate agent-facing view so each team member can open the portal and check their own schedule, shift hours, OFF days, leave days, and break times.

## What the website is used for

This website is used to:

- build and review the weekly roster
- balance staffing coverage by day
- manage leave and holiday rules
- configure special Ramadan schedules
- assign and adjust shift patterns
- generate break plans based on demand and interaction volume
- share the latest schedule with agents through the agent portal

## Main features and characteristics

### 1. Dashboard
The dashboard gives a quick operational view of the selected week.

It shows:
- total active agents
- weekly coverage levels
- under-covered days
- leave and holiday impact
- a day-by-day staffing snapshot

### 2. Weekly planner
The weekly planner automatically builds the roster for the selected week.

Main characteristics:
- Friday is treated as a fixed OFF day
- one additional OFF day can be assigned automatically
- manual overrides can still be applied when needed
- staffing levels are shown for each day

### 3. Leave and Holidays
This section allows you to manage both normal leave and holiday-based OFF rules.

Functions available:
- add individual leave records
- set leave type and date range
- create holiday periods
- define how many days are fixed OFF
- choose the exact fixed OFF dates
- distribute the remaining OFF days over a selected period such as 1, 2, or 4 weeks

### 4. Break control
The break control page helps you plan breaks according to workload.

Functions available:
- upload Excel or CSV interaction data
- generate a demand heat map
- place breaks away from peak interaction periods
- edit breaks manually for each agent and day
- keep all break changes synced with the rest of the system

### 5. Team setup
This is the team master data section.

You can manage:
- agent names
- language skills
- main shift assignment
- preferred extra OFF day
- active or inactive status

If preferred extra OFF is set to **Not specified**, the app can assign the extra OFF day automatically depending on operational needs.

### 6. Ramadan configuration
The Ramadan section allows special shift planning during Ramadan.

You can:
- enable or disable Ramadan mode
- choose Ramadan start and end dates
- create one or more Ramadan shifts
- set start and end hours for those shifts
- assign agents automatically or manually
- keep the same master-data style as the main team setup

### 7. Agent portal
The website includes an agent-facing page where employees can select their name and view their schedule.

Agents can see:
- working days
- OFF days
- leave days
- Ramadan shifts when active
- break and lunch times

### 9. UI and motion enhancements
Recent interface improvements were added to improve clarity and visual feedback.

These include:
- animated abstract background layers in both admin and agent portals
- directional week-change transitions (next/previous)
- box-level loading shimmer during week navigation so schedule changes feel explicit
- roster-focused loading behavior (effect on boxes/cards, not section containers)
- responsive form/grid improvements to avoid overlapping inputs
- improved week-change feedback in schedule cards with staggered motion

### 10. Admin productivity updates
Additional planning controls were introduced for faster team management.

These include:
- add new agent section in Admin
- full agent deletion with cascade cleanup from related schedule/leave/override data
- stronger sync/save coverage for interactive controls to reduce missed updates

### 11. Header and theme toggle behavior
The agent page was adjusted to avoid duplicate top navigation.

Current behavior:
- the global top bar is visible on the portal picker screen
- when entering agent schedule view, the global top bar is hidden
- this leaves a single schedule header and a single theme toggle in agent view

### 8. Sync and shared data
The app is designed so updates reflect across the planner and the agent view.

This includes:
- local browser storage sync
- automatic refresh when data changes
- optional JSONBin cloud sync for shared access across devices

## How to use the website

### Step 1: Open the admin page
Use the admin dashboard to manage the full schedule and configuration.

### Step 2: Set up the team
Go to the Team Setup section and confirm:
- agent names
- shifts
- languages
- preferred extra OFF settings
- status

### Step 3: Select the month and week
Use the month and week selectors at the top of the page to move through the schedule.

### Step 4: Add leave and holidays
Use the Leave and Holidays section to add:
- personal leave
- holiday periods
- fixed OFF dates
- distributed holiday OFF rules

### Step 5: Configure Ramadan if needed
If Ramadan scheduling is active, go to the Ramadan section and define the temporary shifts and assignments.

### Step 6: Upload interactions for break planning
In Break Control, upload the interactions file so the app can suggest better break timings based on demand.

### Step 7: Share the agent portal
Once the planning is ready, use the agent-facing link so team members can open the website and view their own schedules.

## Change log (recent)

- Added animated abstract moving background to `index.html` and `admin.html`.
- Added stronger directional week transitions for schedule content.
- Added week-navigation loading shimmer and then scoped it to roster boxes/cards only.
- Expanded shimmer to all boxes inside schedule sections without applying effect to section wrappers.
- Fixed duplicate top bars/theme toggles in agent view by hiding global top bar after agent entry.
- Added Admin improvements for team management: add agent and deep-delete agent cleanup.
- Improved sync consistency by ensuring key UI actions trigger save/sync updates.

## Website links

- Public website: [https://soufianeheddadi.github.io/DArin-sche/](https://soufianeheddadi.github.io/DArin-sche/)
- Agent view with shared data: [https://soufianeheddadi.github.io/DArin-sche/?bin=69dcda4aaaba882197f3a327](https://soufianeheddadi.github.io/DArin-sche/?bin=69dcda4aaaba882197f3a327)
- Admin dashboard with shared data: [https://soufianeheddadi.github.io/DArin-sche/admin.html?bin=69dcda4aaaba882197f3a327](https://soufianeheddadi.github.io/DArin-sche/admin.html?bin=69dcda4aaaba882197f3a327)

> Use the public website link for the landing page, the agent link for employee access, and the admin link for planning and configuration.
