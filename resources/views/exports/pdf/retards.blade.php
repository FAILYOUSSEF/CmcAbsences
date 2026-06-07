<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
        .header { margin-bottom: 30px; text-align: center; }
        .warning { color: orange; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $title }}</h2>
        <p>Date d'édition: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    </div>

    @if(isset($groupe))
    <table>
        <thead>
            <tr>
                <th>Matricule</th>
                <th>Nom & Prénom</th>
                <th class="text-center">Nombre de Retards</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groupe->stagiaires as $s)
                @if($s->total_retards > 0)
                <tr>
                    <td>{{ $s->matricule }}</td>
                    <td>{{ $s->nom }} {{ $s->prenom }}</td>
                    <td class="text-center {{ $s->total_retards >= 5 ? 'warning' : '' }}">{{ $s->total_retards }}</td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    @else
    <p>Sélectionnez un groupe spécifique pour générer ce rapport.</p>
    @endif
</body>
</html>
