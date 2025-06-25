<?php
//exit;
$dsn = 'mysql:host=localhost;dbname=u657893346_saudi_db;charset=utf8';
$username = '';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'good';
    // Create notifications table if it doesn't exist
$createNotificationsTable = "
CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_id INT NOT NULL,
    created_at DATETIME NOT NULL
)
";

$pdo->exec($createNotificationsTable);
    echo "<br>good";

} catch (PDOException $e) {
    echo 'Database connection failed: ' . $e->getMessage();
}




// Current time
$current_time = new DateTime('now', new DateTimeZone('Asia/Riyadh'));
$end_time = clone $current_time;
$end_time->modify('+10 minutes');

// Format the current date to match the 'created_at' date format
$current_date = $current_time->format('Y-m-d');
$current_date_time = $current_time->format('Y-m-d H:i:s');
echo "<br>current date ".$current_date_time ."<br>";
// Fetch active tickets created today that haven't been notified
$query = "
SELECT * FROM tickets 
WHERE created_at > :current_date 
AND id NOT IN (SELECT ticket_id FROM notifications)
";
$stmt = $pdo->prepare($query);
$stmt->execute(['current_date' => $current_date]);
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);



// Prepare arrays to hold valid tickets
$validTickets = [];

foreach ($tickets as $ticket) {
    // Calculate the expiration time for each ticket
    $ticket_created_at = new DateTime($ticket['created_at'], new DateTimeZone('Asia/Riyadh'));
    $hour_count = $ticket['hours_count'];
    $ticket_expiration_time = clone $ticket_created_at;
    $ticket_expiration_time->modify("+{$hour_count} hour");
    $ticket_expiration_time_string=$ticket_expiration_time->format('Y-m-d H:i:s');
    $ticket['expire']=$ticket_expiration_time_string;

    // Check if the ticket is within the 20-minute threshold
    if ($ticket_expiration_time > $current_time && $ticket_expiration_time <= $end_time) {
        $validTickets[] = $ticket;
    }
}

if (!empty($validTickets)) {
    $url = ''; // Replace with your endpoint URL

    // Prepare the data for batch processing
    $ticketData = [];


    foreach ($validTickets as $fticket) {
        
  
        
        $sendthis=[];
        $ticketId = $fticket["id"];
        $ticketphone = $fticket["client_id"];
     $query = "
SELECT name FROM clients 
WHERE phone=:phone
";
$stmt = $pdo->prepare($query);
$stmt->execute(['phone' => $ticketphone]);
$client = $stmt->fetch(PDO::FETCH_ASSOC);   
$clientName=   $client["name"];

$sendthis["id"]=$ticketId;
$sendthis["name"]=$clientName;
$sendthis["phone"]=$ticketphone;
$sendthis["created_at"]=$fticket["created_at"];
$ticketData[$ticketId] = $sendthis;
    }

    // Prepare data to send
    $postData = [
        'p1' => 123, // Additional field for verification
        'tickets' => $ticketData
    ];
echo json_encode($postData);
    // Send ticket data in a single batch request
    $ch = curl_init($url);
// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string

    $response = curl_exec($ch);
    if ($response === false) {
        echo 'Curl error: ' . curl_error($ch);
    } else {
        echo 'Response: ' . $response;

        // Insert notification records for each ticket
        $insertNotification = "INSERT INTO notifications (ticket_id, created_at) VALUES (:ticket_id, :created_at)";
        $notificationStmt = $pdo->prepare($insertNotification);

        foreach ($ticketData as $ticketId) {
            $notificationStmt->execute([
                'ticket_id' => $ticketId["id"],
                'created_at' => $ticketId["created_at"]
            ]);
        }

    }

    curl_close($ch);
} else {
    echo "No tickets to notify.";
}
?>