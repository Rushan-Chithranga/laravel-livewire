<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Welcome to Our Platform</title>
    <style>
        /* Inline styles for simplicity, consider using CSS classes for larger templates */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        p{
            color: red;
            font-size: 12px;
            display: flex;
            justify-content:center;
            align-items: center;

        }
        img{
            display: flex;
            justify-content:center;
            align-items: center;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f1f1f1;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 200px;
        }

        .message {
            padding: 20px;
            background-color: #ffffff;
        }

        .message p {
            margin-bottom: 10px;
        }

        .footer {
            height: 20px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="message">
            <p>Dear {{ $mailData['name'] }},</p>
            <p>Category name: {{ $mailData['catrgoryName'] }},</p>
            <p>Description: {{ $mailData['description'] }},</p>
            <img src="{{ $mailData['image'] ? env('APP_URL')."/storage/".$mailData['image'] : 'https://p16-va-tiktok.ibyteimg.com/obj/musically-maliva-obj/df2319bb31ac87ac015128373b630b11.png' }}" alt="Category Image" width="80" height="80">

        </div>
        <div class="footer">
            @ 2024 rushan Copy right
        </div>

    </div>
</body>

</html>
