<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // adjust if PHPMailer is placed differently

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $phone = htmlspecialchars($_POST['phone'] ?? '');
    $location = htmlspecialchars($_POST['location'] ?? '');
    $country = htmlspecialchars($_POST['country'] ?? '');
    $enquiry = htmlspecialchars($_POST['enquiry'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');
    $company = htmlspecialchars($_POST['company'] ?? '');

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
        $mail->CharSet = 'UTF-8';
        //Recipients
        $mail->setFrom('dharshine@saasifysolutions.com', 'Saasify Solutions');
        $mail->addAddress('dharshine@saasifysolutions.com'); // your receiving email
        $mail->addReplyTo($email, $name);
        

        // Content
        $mail->Subject = "New Contact from $name";
        $mail->Body = "
        <h2>New Contact Request</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> $phone</p>" .
        (!empty($location) ? "<p><strong>Location:</strong> $location</p>" : "") .
        (!empty($country) ? "<p><strong>Country:</strong> $country</p>" : "") .
        (!empty($enquiry) ? "<p><strong>Enquiry:</strong> $enquiry</p>" : "") .
        (!empty($company) ? "<p><strong>Company:</strong> $company</p>" : "") .
        "<p><strong>Message:</strong><br>" . nl2br($message) . "</p>";


        $mail->send();
        echo "Mail sent successfully!";
        exit;
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}
