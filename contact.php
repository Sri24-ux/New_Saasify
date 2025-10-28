<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; // adjust if PHPMailer is placed differently
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form inputs
    $name     = htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8');
    $email    = htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8');
    $phone    = htmlspecialchars($_POST['phone'] ?? '', ENT_QUOTES, 'UTF-8');
    $location = htmlspecialchars($_POST['location'] ?? '', ENT_QUOTES, 'UTF-8');
    $country  = htmlspecialchars($_POST['country'] ?? '', ENT_QUOTES, 'UTF-8');
    $enquiry  = htmlspecialchars($_POST['enquiry'] ?? '', ENT_QUOTES, 'UTF-8');
    $company  = htmlspecialchars($_POST['company'] ?? '', ENT_QUOTES, 'UTF-8');
    $message  = htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES, 'UTF-8');
    $mail = new PHPMailer(true);
    try {
        // Brevo SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp-relay.brevo.com';
        $mail->SMTPAuth = true;
        $mail->Username = '93c4d0001@smtp-brevo.com';  // your Brevo SMTP username (usually your Brevo email)
        $mail->Password = 'GQIrvTDnmLYkgfpd';  // your Brevo SMTP password (get it from Brevo SMTP settings)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        //Recipients
        $mail->setFrom('dharshine@saasifysolutions.com', 'Saasify Solutions');
        $mail->addAddress('sales@saasifysolutions.com'); // your receiving email
        $mail->addReplyTo($email, $name);
        // Content
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = "New Contact from $name";
        $mail->Body = "
        <h2 style='color:#333;'>New Contact Request</h2>
        <table style='border-collapse:collapse; width:100%;'>
        <tr><td><strong>Name:</strong></td><td>$name</td></tr>
        <tr><td><strong>Email:</strong></td><td>$email</td></tr>
        <tr><td><strong>Phone:</strong></td><td>$phone</td></tr>"
        . (!empty($location) ? "<tr><td><strong>Location:</strong></td><td>$location</td></tr>" : "")
        . (!empty($country) ? "<tr><td><strong>Country:</strong></td><td>$country</td></tr>" : "")
        . (!empty($enquiry) ? "<tr><td><strong>Enquiry:</strong></td><td>$enquiry</td></tr>" : "")
        . (!empty($company) ? "<tr><td><strong>Company:</strong></td><td>$company</td></tr>" : "") .
        "<tr><td valign='top'><strong>Message:</strong></td><td>" . nl2br($message) . "</td></tr>
        </table>";    
         // Plain-text fallback
        $mail->AltBody = "New Contact Request\n\n"
            . "Name: $name\n"
            . "Email: $email\n"
            . "Phone: $phone\n"
            . (!empty($location) ? "Location: $location\n" : "")
            . (!empty($country) ? "Country: $country\n" : "")
            . (!empty($enquiry) ? "Enquiry: $enquiry\n" : "")
            . (!empty($company) ? "Company: $company\n" : "")
            . "Message:\n$message";
        $mail->send();
        echo "Success! Mail sent successfully.";
        exit;
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
        echo "Something went wrong, please try again later.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}   
