<?php
// Path: app/Http/Controllers/ContactController.php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Models\Contact; // You might need to create this model

class ContactController extends Controller
{
    /**
     * @var Contact $contactModel
     */
    private $contactModel;
    
    /**
     * Constructor
     * 
     * @param \PDO $db Database connection
     */
    public function __construct($db)
    {
        parent::__construct($db);
    }
    
    /**
     * Display contact page
     * 
     * @return void
     */
    public function index()
    {
        $this->render('contact/index');
    }
    
    /**
     * Process contact form submission
     * 
     * @return void
     */
    public function submit()
    {
        // Get form data
        $firstName = trim($_POST['first-name'] ?? '');
        $lastName = trim($_POST['last-name'] ?? '');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $phone = trim($_POST['phone'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');
        
        // Validate required fields
        if (!$firstName || !$lastName || !$email || !$subject || !$message) {
            $this->setFlashMessage('All required fields must be filled out.', 'danger');
            $this->redirect('/contact');
            return;
        }
        
        // Handle file upload if needed
        $attachmentPath = null;
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
            $attachmentPath = $this->handleFileUpload($_FILES['attachment']);
        }
        
        // Save contact submission
        $contactData = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'subject' => $subject,
            'message' => $message,
            'attachment_path' => $attachmentPath,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ];
        
        $success = $this->contactModel->create($contactData);
        
        if ($success) {
            // Send notification email
            $this->sendNotificationEmail($contactData);
            
            $this->setFlashMessage('Thank you! Your message has been sent. We\'ll get back to you shortly.', 'success');
        } else {
            $this->setFlashMessage('There was a problem sending your message. Please try again later.', 'danger');
        }
        
        $this->redirect('/contact');
    }
    
    /**
     * Handle file upload
     * 
     * @param array $file Uploaded file data
     * @return string|null File path or null on failure
     */
    private function handleFileUpload($file)
    {
        $uploadDir = ROOT_PATH . '/public/uploads/contacts/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Generate unique filename
        $filename = md5(uniqid(rand(), true)) . '-' . basename($file['name']);
        $filepath = $uploadDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return '/uploads/contacts/' . $filename;
        }
        
        return null;
    }
    
    /**
     * Send notification email to admin
     * 
     * @param array $contactData Contact form data
     * @return bool Success status
     */
    private function sendNotificationEmail($contactData)
    {
        $to = 'support@wildlifehaven.com';
        $subject = 'New Contact Form Submission: ' . $contactData['subject'];
        
        $message = "
        <html>
        <head>
            <title>New Contact Form Submission</title>
        </head>
        <body>
            <h2>New Contact Form Submission</h2>
            <p><strong>Name:</strong> {$contactData['first_name']} {$contactData['last_name']}</p>
            <p><strong>Email:</strong> {$contactData['email']}</p>
            <p><strong>Phone:</strong> {$contactData['phone']}</p>
            <p><strong>Subject:</strong> {$contactData['subject']}</p>
            <p><strong>Message:</strong></p>
            <p>" . nl2br(htmlspecialchars($contactData['message'])) . "</p>
        </body>
        </html>
        ";
        
        // Headers
        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=UTF-8',
            'From: Wildlife Haven <noreply@wildlifehaven.com>',
            'Reply-To: ' . $contactData['email']
        ];
        
        return mail($to, $subject, $message, implode("\r\n", $headers));
    }
}