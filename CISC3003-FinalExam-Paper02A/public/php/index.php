<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// A.05: Process form data
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors = [];
    
    // A.06: Sanitize and validate inputs
    $full_name = trim($_POST["full_name"] ?? "");
    $email     = trim($_POST["email"] ?? "");
    $phone     = trim($_POST["phone"] ?? "");
    $gender    = $_POST["gender"] ?? null;
    $country   = $_POST["country"] ?? "";
    $message   = trim($_POST["message"] ?? "");
    
    // Handle Hobbies (Array to String)
    $hobbies_array = $_POST["hobbies"] ?? [];
    $hobbies_str   = !empty($hobbies_array) ? implode(", ", $hobbies_array) : null;
    
    // Handle Newsletter
    $newsletter = isset($_POST["newsletter"]) ? 1 : 0;
    
    // Basic Validation
    if (empty($full_name)) $errors[] = "Full Name is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "A valid email address is required.";
    if (empty($country))   $errors[] = "Please select your country.";
    if (empty($message))   $errors[] = "Message cannot be empty.";
    
    if (empty($errors)) {
        // A.07: Database Integration
        $conn = require __DIR__ . "/connect.php";
        
        // A.10: SQL INSERT INTO statement
        $sql = "INSERT INTO users (full_name, email, phone, gender, country, hobbies, message, newsletter)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        // A.08: Prepared statement to prevent SQL Injection
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            $errors[] = "Database preparation error: " . $conn->error;
        } else {
            // Bind 8 parameters: s=string, i=integer
            $stmt->bind_param("sssssssi", $full_name, $email, $phone, $gender, $country, $hobbies_str, $message, $newsletter);
            
            if ($stmt->execute()) {
                $_SESSION['success'] = "🎉 Registration submitted successfully!";
                header("Location: index.php");
                exit;
            } else {
                $errors[] = "Execution error: " . $stmt->error;
            }
        }
    }
    
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: index.php");
        exit;
    }
}

$success = $_SESSION['success'] ?? '';
$errors  = $_SESSION['errors']  ?? [];
unset($_SESSION['success'], $_SESSION['errors']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CISC3003 Scenario A | Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <style>
        .req { color: #e74c3c; font-weight: bold; }
        .alert { padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .success-msg { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error-msg { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        fieldset { margin-bottom: 20px; border: 1px solid #ccc; padding: 15px; border-radius: 8px; }
        legend { font-weight: bold; padding: 0 10px; color: #333; }
        .option-group { display: flex; gap: 15px; flex-wrap: wrap; margin-top: 5px; }
    </style>
</head>
<body>

    <header>
        <h1>Registration Form</h1>
        <p>CISC3003 Web Programming | Angus Che (DC325182)</p>
    </header>

    <main>
        <?php if ($success): ?>
            <div class="alert success-msg"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert error-msg">
                <ul style="margin:0;">
                    <?php foreach ($errors as $e): ?> <li><?= htmlspecialchars($e) ?></li> <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" novalidate>
            
            <fieldset>
                <legend>Personal Information</legend>
                
                <label for="full_name">Full Name <span class="req">*</span></label>
                <input type="text" id="full_name" name="full_name" placeholder="e.g. Angus Che" required>

                <label for="email">Email Address <span class="req">*</span></label>
                <input type="email" id="email" name="email" placeholder="chechihin24@gmail.com" required>

                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" placeholder="123123123">
            </fieldset>

            <fieldset>
                <legend>Preferences</legend>

                <label for="country">Country <span class="req">*</span></label>
                <select id="country" name="country" required>
                    <option value="">-- Select Country --</option>
                    <option value="Macau SAR">Macau SAR</option>
                    <option value="Hong Kong SAR">Hong Kong SAR</option>
                    <option value="China">Mainland China</option>
                    <option value="Other">Other</option>
                </select>

                <label>Gender</label>
                <div class="option-group">
                    <label><input type="radio" name="gender" value="Male"> Male</label>
                    <label><input type="radio" name="gender" value="Female"> Female</label>
                    <label><input type="radio" name="gender" value="Other"> Other</label>
                </div>

                <label style="margin-top: 15px; display: block;">Hobbies</label>
                <div class="option-group">
                    <label><input type="checkbox" name="hobbies[]" value="Reading"> Reading</label>
                    <label><input type="checkbox" name="hobbies[]" value="Coding"> Coding</label>
                    <label><input type="checkbox" name="hobbies[]" value="Gaming"> Gaming</label>
                    <label><input type="checkbox" name="hobbies[]" value="Sports"> Sports</label>
                    <label><input type="checkbox" name="hobbies[]" value="Music"> Music</label>
                </div>

                <div style="margin-top: 15px;">
                    <label>
                        <input type="checkbox" name="newsletter" value="1"> Subscribe to Newsletter
                    </label>
                </div>
            </fieldset>

            <fieldset>
                <legend>Message</legend>
                <label for="message">Message <span class="req">*</span></label>
                <textarea id="message" name="message" rows="5" placeholder="Enter your message here..." required></textarea>
            </fieldset>

            <div style="display: flex; gap: 10px;">
                <button type="submit">Submit Registration</button>
                <button type="reset" style="background-color: #bdc3c7; color: #333;">Clear Form</button>
            </div>

        </form>
    </main>

    <footer style="margin-top: 40px; text-align: center; border-top: 1px solid #eee; padding-top: 20px; font-size: 0.9em;">
        CISC3003 Web Programming: Che Chi Hin, DC325182 2026
    </footer>

</body>
</html>