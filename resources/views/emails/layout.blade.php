<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; background:#f6f6f6; padding:20px;">
<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
            <table width="600" style="background:#ffffff; padding:20px;">
                <tr>
                    <td>
                        <h2 style="color:#2c3e50;">
                            {{ config('app.name') }}
                        </h2>
                        <hr>
                        @yield('content')
                        <hr>
                        <p style="font-size:12px; color:#777;">
                            This is a system-generated email. Please do not reply.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
