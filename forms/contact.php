<?php
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';

// Basic Validation
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
  http_response_code(400);
  echo "Please fill in all fields.";
  exit;
}

// Sanitization
$name = htmlspecialchars(strip_tags($name));
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$subject = htmlspecialchars(strip_tags($subject));
$message = htmlspecialchars(strip_tags($message));

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  http_response_code(400);
  echo "Invalid email format.";
  exit;
}

// Email Settings
$to = "khanareb5922@gmail.com";  // Your actual email
$email_subject = "New Contact Message from $name";
$email_body = "You received a new message from your website contact form:\n\n" .
              "Name: $name\n" .
              "Email: $email\n" .
              "Subject: $subject\n\n" .
              "Message:\n$message";

// Headers
$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send Email
if (mail($to, $email_subject, $email_body, $headers)) {
  echo "OK";
} else {
  http_response_code(500);
  echo "Something went wrong. Email not sent.";
}
?>
