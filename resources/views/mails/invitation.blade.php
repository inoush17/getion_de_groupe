<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Invitation à rejoindre un groupe</h1>
    
    <h3>Bonjour, {{ $email }}</h3>

    <p>Vous avez été invité par {{ $invited_by }} à rejoindre un groupe {{ $group_id }}. Cliquez sur le lien ci-dessous pour accepter l'invitation</p>
    <a href="{{ $url }}">Accepter l'invitation</a>
</html>