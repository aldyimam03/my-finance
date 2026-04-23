<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Kata Sandi My Finance</title>
</head>

<body style="margin:0;padding:0;background-color:#0f0f10;font-family:Inter,Arial,sans-serif;color:#e5e2e1;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#0f0f10;margin:0;padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:640px;background:#171718;border:1px solid rgba(255,255,255,0.06);border-radius:24px;overflow:hidden;">
                    <tr>
                        <td style="padding:28px 32px;background:linear-gradient(135deg,#171718 0%,#202124 100%);border-bottom:1px solid rgba(255,255,255,0.06);">
                            <div style="font-size:12px;letter-spacing:0.18em;text-transform:uppercase;color:#adc6ff;font-weight:700;">My Finance</div>
                            <h1 style="margin:12px 0 0;font-size:28px;line-height:1.2;color:#ffffff;font-weight:700;">Atur Ulang Kata Sandi</h1>
                            <p style="margin:12px 0 0;font-size:14px;line-height:1.7;color:#c1c6d7;">
                                Permintaan reset kata sandi telah kami terima untuk akun Anda.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px;">
                            <p style="margin:0 0 16px;font-size:15px;line-height:1.8;color:#e5e2e1;">
                                Halo{{ $name ? ', '.$name : '' }},
                            </p>
                            <p style="margin:0 0 16px;font-size:15px;line-height:1.8;color:#c1c6d7;">
                                Klik tombol di bawah ini untuk membuat kata sandi baru. Demi keamanan, tautan ini hanya berlaku selama <strong style="color:#ffffff;">60 menit</strong>.
                            </p>
                            <table role="presentation" cellspacing="0" cellpadding="0" style="margin:28px 0;">
                                <tr>
                                    <td>
                                        <a href="{{ $resetUrl }}" style="display:inline-block;padding:14px 24px;border-radius:14px;background:linear-gradient(135deg,#adc6ff 0%,#4b8eff 100%);color:#07111f;text-decoration:none;font-size:14px;font-weight:700;">
                                            Atur Ulang Kata Sandi
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <div style="margin:0 0 18px;padding:18px 20px;border-radius:18px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.05);">
                                <p style="margin:0 0 8px;font-size:12px;letter-spacing:0.12em;text-transform:uppercase;color:#adc6ff;font-weight:700;">Catatan Keamanan</p>
                                <p style="margin:0;font-size:14px;line-height:1.7;color:#c1c6d7;">
                                    Jika Anda tidak merasa meminta reset kata sandi, abaikan email ini. Akun Anda tidak akan berubah tanpa tindakan lebih lanjut.
                                </p>
                            </div>
                            <p style="margin:0 0 12px;font-size:13px;line-height:1.8;color:#8f97ab;">
                                Jika tombol di atas tidak bisa diklik, buka tautan berikut secara manual:
                            </p>
                            <p style="margin:0;word-break:break-all;font-size:13px;line-height:1.8;color:#adc6ff;">
                                <a href="{{ $resetUrl }}" style="color:#adc6ff;text-decoration:underline;">{{ $resetUrl }}</a>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px 32px;border-top:1px solid rgba(255,255,255,0.06);background:#141415;">
                            <p style="margin:0;font-size:13px;line-height:1.7;color:#8f97ab;">
                                Hormat kami,<br>
                                <span style="color:#ffffff;font-weight:600;">My Finance</span>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
