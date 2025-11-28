<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; color:#333; line-height: 1.6;">

    <p>Hi {{ $name }},</p>

    <p>You requested a password reset for your <strong>Mini Pocket</strong> account.</p>

    <p>
        <a href="{{ $url }}">Click here to reset your password</a>
    </p>

    <p>If you didn’t request this, just ignore this email.</p>

    <p>Thanks,<br>Mini Pocket Team</p>

</body>
</html>
