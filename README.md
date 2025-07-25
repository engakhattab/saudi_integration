🚀 Feature Documentation: Visitor Query by Time
1. Feature Overview
This document outlines the functionality of the Visitor Query feature added to the Sales Dashboard.

The primary purpose of this tool is to provide cashiers and managers with a real-time snapshot of park attendance, allowing them to see how many visitors are expected to be present at any specific date and time.

2. How It Works
The feature is designed to be simple and intuitive:

Navigation: A new menu item named "Query" has been added to the main sidebar, located just above the "Exit" link.

Input: On the Query page, the user is presented with two input fields:

A date picker to select the day of interest (past, present, or future).

A time input to specify the exact time for the query.

Search: Upon clicking the "Search" button, the system performs a query against the database.

Results: The page refreshes to display two key pieces of information for the selected date and time:

A summary card showing the total number of visitors whose visit duration includes the specified time.

A detailed table listing all the parent tickets associated with those visitors, including the ticket number, client name, phone, and the amount paid.

Business Logic Example
If a ticket was created for a 5-hour visit from 12:00 PM to 05:00 PM, a cashier searching for the visitor count at 02:30 PM on that day will see the visitors from that ticket included in the results. A search for 06:00 PM will not include them.

3. Technical Implementation
This feature was implemented by creating and modifying several files within the Laravel project structure.

Files Created
Controller: app/Http/Controllers/Sales/QueryController.php

This new controller contains all the backend logic. The index() method displays the page, and the search() method handles the form submission, database queries, and returns the results.

View: resources/views/sales/query/index.blade.php

This new Blade file contains the HTML structure for the search form and the results display (summary card and tickets table).

Files Modified
Sidebar View: resources/views/sales/layouts/sidebar.blade.php (or equivalent)

Modified to add the new "Query" link to the navigation menu.

Routes File: routes/web.php or routes/sales/CRUD.php

Modified to add two new routes (GET and POST for /query) that point to the QueryController.

Database Query Logic
The core of the feature lies in the search() method of the QueryController. The logic is as follows:

Validate the incoming date and time from the user.

Query the ticket_rev_models table to find all records where the selected date matches the day column.

Filter these results to only include records where the selected time falls between the shift_start and shift_end columns.

The total number of matching records is the Total Visitors.

The system then retrieves the unique ticket_ids from these records and fetches the corresponding parent tickets from the tickets table to display in the results table.