<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Projects</title>
</head>
<body>
    <h1>Projects</h1>
    <ul>
        @foreach($projects as $project)
            <li>{{ $project }}</li>
        @endforeach
    </ul>
</body>
</html>
