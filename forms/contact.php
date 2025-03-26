<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // PHPMailer ka path set karein

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Create instance of PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();                                      // Use SMTP
        $mail->Host = 'smtp.gmail.com';                        // Your SMTP server
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'user your email';    // SMTP username (your email)
        $mail->Password = 'password';                 // SMTP password (use App Password if using Gmail 2FA)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       // Enable SSL encryption
        $mail->Port = 587;                                   // TCP port to connect to

        // Recipients
        $mail->setFrom('from email', $name);  // Sender's email and name
        $mail->addAddress('to email');           // Recipient's email

        // Content
        $mail->isHTML(false);                                        // Set email format to plain text
        $mail->Subject = "New Contact Form Submission: " . $subject;
        $mail->Body    = "You have received a new message from your website contact form.\n\n";
        $mail->Body    .= "Name: $name\n";
        $mail->Body    .= "Email: $email\n";
        $mail->Body    .= "Subject: $subject\n";
        $mail->Body    .= "Message:\n$message\n";

        // Send email
        if ($mail->send()) {
            echo 'Message has been sent';  // Success message
        } else {
            echo 'Message could not be sent.';    // Error message
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
