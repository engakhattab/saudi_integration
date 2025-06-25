<?php



if(isset($_POST["search"])){
    $ticket_num=$_POST["search"];
    $domain = $_POST["domain"];
}
if($domain=="a"){
    $username = 'u657893346_alyasmeen';
    $password = 'Yasmen@2024';
    $host = 'localhost'; // Change if needed
    $dbname = 'u657893346_alyasmeen';  
}else{

    $username = 'u657893346_saudi_db';
    $password = 'Successteam2022';
    $host = 'localhost'; // Change if needed
    $dbname = 'u657893346_saudi_db';
}



$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        

$stmt = $pdo->prepare("SELECT client_id ,id FROM tickets WHERE ticket_num =?");
                            $stmt->execute([$ticket->id]);
                            $results =$stmt->fetchAll(PDO::FETCH_ASSOC);
                            $client_mob = $results[0]["client_id"];
                            $id = $results[0]["id"];

$stmt = $pdo->prepare("SELECT name FROM clients WHERE phone =?");
                            $stmt->execute([$client_mob]);
                            $results =$stmt->fetchAll(PDO::FETCH_ASSOC);
                            $client_name = $results[0]["name"];



// Initialize cURL session
$ch = curl_init();

// Define the URL
$url = '';

// Define the POST parameters
$postData = [
    'p1' => '123', // Replace 'value1' with the actual value for p1
    'p2' => $client_name,//'Ahmed', // Replace 'value2' with the actual value for p2
    'p3' => $client_mob, // Replace 'value3' with the actual value for p3
    'p4' => $id, // Replace with the actual URL
    'p5' => $domain,
    'domain'=>'domain'
];

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string

// Execute cURL request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    // Print the response from the server
    echo 'Response: ' . $response;
    echo $cash_m;
 
}

// Close the cURL session
curl_close($ch);


?>
