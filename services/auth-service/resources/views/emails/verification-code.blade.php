<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SALN Verification Code</title>
</head>
<body style="margin:0;padding:0;background:#f9f9f9;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;color:#1a1a1a;">
<table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="padding:24px 12px;">
    <tr>
        <td align="center">
            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="max-width:560px;background:#ffffff;border:1px solid #e0e0e0;border-radius:8px;overflow:hidden;">
                <tr>
                    <td style="padding:24px;border-bottom:1px solid #e0e0e0;background:#f9f9f9;">
                        <h2 style="margin:0;font-size:20px;line-height:1.3;color:#1a1a1a;">SALN Login Verification</h2>
                    </td>
                </tr>
                <tr>
                    <td style="padding:24px;">
                        <p style="margin:0 0 16px 0;font-size:15px;line-height:1.6;color:#666666;">
                            Use the verification code below to continue logging in.
                        </p>

                        <div style="margin:0 0 20px 0;padding:16px;text-align:center;border:1px dashed #0066cc;border-radius:6px;background:#f5f9ff;">
                            <span style="display:inline-block;font-size:32px;letter-spacing:8px;font-weight:700;color:#0066cc;">{{ $code }}</span>
                        </div>

                        <p style="margin:0 0 12px 0;font-size:14px;line-height:1.6;color:#666666;">
                            This code expires in <strong>{{ $expiresInMinutes }} minutes</strong>.
                        </p>

                        <p style="margin:0;font-size:13px;line-height:1.6;color:#999999;">
                            If you did not request this code, you can safely ignore this email.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
