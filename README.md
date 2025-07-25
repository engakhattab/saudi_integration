# 🚀 Feature Documentation: Visitor Query by Time

## 1. Feature Overview

*This document outlines the functionality of the **Visitor Query** feature added to the **Sales Dashboard**.*

> **Primary Purpose:**  
> Provide cashiers and managers with a real‑time snapshot of park attendance, allowing them to see how many visitors are expected at any specific date and time.

---

## 2. How It Works

The feature is designed to be simple and intuitive:

1. **Navigation**  
   A new menu item named **“Query”** has been added to the main sidebar, located just above the **“Exit”** link.

2. **Input**  
   On the Query page, the user is presented with two input fields:  
   - 📅 **Date Picker**: Select the day of interest (past, present, or future).  
   - ⏰ **Time Input**: Specify the exact time for the query.

3. **Search**  
   Upon clicking the **Search** button, the system performs a query against the database.

4. **Results**  
   The page refreshes to display:

   - **Summary Card**  
     Shows the **total number** of visitors whose visit duration includes the specified time.

   - **Detailed Table**  
     Lists all the parent tickets associated with those visitors:

     | Ticket Number | Client Name    | Phone        | Amount Paid |
     | ------------- | -------------- | ------------ | ----------- |
     | 12345         | Jane Doe       | (555) 123‑4567 | $49.99      |
     | 12346         | John Smith     | (555) 987‑6543 | $59.99      |
     | ...           | ...            | ...            | ...         |

---

### Business Logic Example

> If a ticket was created for a **5‑hour** visit from **12:00 PM** to **05:00 PM**,  
> - A cashier searching at **02:30 PM** on that day will **see** those visitors included.  
> - A search at **06:00 PM** will **not** include them.

---

## 3. Technical Implementation

### Files Created

- **Controller**  
  `app/Http/Controllers/Sales/QueryController.php`  
  Contains all backend logic:  
  - `index()` method displays the form & results page.  
  - `search()` method handles validation, queries, and data passing.

- **View**  
  `resources/views/sales/query/index.blade.php`  
  Blade template for the search form, summary card, and tickets table.

### Files Modified

- **Sidebar View**  
  `resources/views/sales/layouts/sidebar.blade.php`  
  → Added new **“Query”** link.

- **Routes**  
  `routes/web.php` (or `routes/sales/CRUD.php`)  
  → Added two routes:
  ```php
  Route::get('/query', [QueryController::class, 'index'])->name('sales.query.index');
  Route::post('/query', [QueryController::class, 'search'])->name('sales.query.search');
