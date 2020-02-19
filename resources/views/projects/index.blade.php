<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Projects</title>
</head>
<body>
    <h1>Projects</h1>
    <ul>
        @forelse($projects as $project)
            <li>
                <a href="{{ $project->path() }}">
                    {{ $project->title }}
                </a>
            </li>
        @empty
            <li>No project yet.</li>
        @endforelse
    </ul>
</body>
</html>
