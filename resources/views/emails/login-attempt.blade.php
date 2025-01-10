<!DOCTYPE html>
<html>

<head>
    <title>New Password</title>
</head>

<body>
    <h1>New Password</h1>
    <p>Hello {{ $name }},</p>
    <p>We have generated a new password for your account. Please use the following credentials to log in:</p>
    <p>Username: {{ $email }}</p>
    <p>Password: {{ $new_password }}</p>
    <p>After logging in, we recommend changing your password for security purposes.</p>
    <p>If you did not request a new password, please contact our support team immediately.</p>
    <p>Thank you,</p>
    <p>Your Company Name</p>
</body>

</html>