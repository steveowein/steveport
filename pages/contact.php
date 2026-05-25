<?php
require_once 'core/mailer.php';
global $personal_info;
global $conn;
$msg_status = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_message'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);
    
    if ($conn->query("INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message')")) {
        $msg_status = 'success';
        
        // Autoresponder HTML
        $user_html = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; background-color: #0a0a0a; color: #ffffff; border: 1px solid #222222; border-radius: 8px; overflow: hidden;'>
            <div style='background-color: #141414; padding: 30px; text-align: center; border-bottom: 1px solid #222222;'>
                <h1 style='margin: 0; font-size: 24px; letter-spacing: 2px; color: #ffffff;'>STEVE<span style='color: #636363;'>.</span></h1>
            </div>
            <div style='padding: 40px 30px;'>
                <h2 style='margin-top: 0; color: #ffffff; font-size: 20px;'>Hello " . htmlspecialchars($name) . ",</h2>
                <p style='color: #bbbbbb; line-height: 1.6;'>Thank you for reaching out! This is an automated message to confirm that I have successfully received your inquiry.</p>
                <p style='color: #bbbbbb; line-height: 1.6;'>I will review your message and get back to you as soon as possible (usually within 24-48 hours).</p>
                <hr style='border: 0; border-top: 1px solid #222222; margin: 30px 0;'>
                <h3 style='color: #ffffff; font-size: 16px; margin-bottom: 10px;'>Your Message:</h3>
                <blockquote style='margin: 0; padding: 15px; background-color: #141414; border-left: 3px solid #ffffff; color: #bbbbbb; font-style: italic;'>
                    " . nl2br(htmlspecialchars($message)) . "
                </blockquote>
            </div>
            <div style='background-color: #141414; padding: 20px; text-align: center; border-top: 1px solid #222222; color: #666666; font-size: 12px;'>
                &copy; " . date('Y') . " Steve Owein Presidente. All rights reserved.
            </div>
        </div>
        ";

        // Admin Notification HTML
        $admin_html = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; background-color: #f4f4f4; padding: 20px;'>
            <div style='background-color: #ffffff; padding: 30px; border-radius: 8px; border-top: 4px solid #000000;'>
                <h2 style='margin-top: 0;'>New Portfolio Message</h2>
                <p><strong>From:</strong> " . htmlspecialchars($name) . " (" . htmlspecialchars($email) . ")</p>
                <p><strong>Date:</strong> " . date('M d, Y h:i A') . "</p>
                <hr style='border: 0; border-top: 1px solid #eeeeee; margin: 20px 0;'>
                <p style='white-space: pre-wrap; font-size: 15px; color: #333333;'>" . htmlspecialchars($message) . "</p>
                <div style='margin-top: 30px; text-align: center;'>
                    <a href='$base_url/admin/' style='background-color: #000000; color: #ffffff; text-decoration: none; padding: 10px 20px; border-radius: 4px; font-weight: bold;'>View in Admin Panel</a>
                </div>
            </div>
        </div>
        ";
        
        // Send Autoresponder to User
        send_brevo_email($email, $name, "Thanks for reaching out! - Steve Portfolio", $user_html);
        
        // Send Notification to Steve
        send_brevo_email("steveoweinpresidente@gmail.com", "Steve Owein Presidente", "New Message from $name", $admin_html);
        
    } else {
        $msg_status = 'error';
    }
}
?>
<section class="page-hero">
    <div class="container">
        <span class="page-subtitle">// Get in touch</span>
        <h1 class="page-title">Contact Me</h1>
    </div>
</section>

<section class="page-content">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5">
                <h3 class="mb-4 text-white" style="font-weight: 700;">Let's Connect</h3>
                <p class="text-muted mb-5">Have a project in mind or want to discuss opportunities? Reach out to me directly.</p>
                
                <div class="d-flex align-items-center mb-4">
                    <div class="card-icon mb-0 me-4"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <h5 class="text-white mb-1">Address</h5>
                        <p class="text-muted mb-0"><?= htmlspecialchars($personal_info['address'] ?? 'Not set') ?></p>
                    </div>
                </div>
                
                <div class="d-flex align-items-center mb-4">
                    <div class="card-icon mb-0 me-4"><i class="fas fa-phone-alt"></i></div>
                    <div>
                        <h5 class="text-white mb-1">Phone</h5>
                        <p class="text-muted mb-0"><?= htmlspecialchars($personal_info['contact_number'] ?? 'Not set') ?></p>
                    </div>
                </div>
                
                <div class="d-flex align-items-center">
                    <div class="card-icon mb-0 me-4"><i class="fas fa-envelope"></i></div>
                    <div>
                        <h5 class="text-white mb-1">Email</h5>
                        <p class="text-muted mb-0"><?= htmlspecialchars($personal_info['email'] ?? 'Not set') ?></p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-7">
                <div class="card-premium">
                    <h3 class="mb-4 text-white" style="font-weight: 700;">Send a Message</h3>
                    
                    <form action="" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="text-muted mb-2">Name</label>
                                <input type="text" name="name" class="form-control bg-transparent text-white border-secondary" style="padding: 12px;" required>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted mb-2">Email</label>
                                <input type="email" name="email" class="form-control bg-transparent text-white border-secondary" style="padding: 12px;" required>
                            </div>
                            <div class="col-12">
                                <label class="text-muted mb-2">Message</label>
                                <textarea name="message" class="form-control bg-transparent text-white border-secondary" rows="5" style="padding: 12px;" required></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" name="submit_message" class="btn-primary-solid w-100" style="padding: 15px;">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if($msg_status != ''): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: '<?= $msg_status == "success" ? "success" : "error" ?>',
            title: '<?= $msg_status == "success" ? "Message Sent!" : "Error" ?>',
            text: '<?= $msg_status == "success" ? "Your message has been sent successfully. I will get back to you soon!" : "There was an error sending your message. Please try again." ?>',
            background: '#141414',
            color: '#fff',
            confirmButtonColor: '#fff',
            confirmButtonText: '<span style="color: #000; font-weight: bold;">OK</span>'
        });
    });
</script>
<?php endif; ?>
