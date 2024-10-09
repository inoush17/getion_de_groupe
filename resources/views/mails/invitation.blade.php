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

    <p>Vous êtes invité par {{ $invited_by }} à rejoindre le groupe {{ $group_name }}.
    <p>Veuillez-vous s'inscrire et connecter pour y avoir accès à l'application</p>
</html>