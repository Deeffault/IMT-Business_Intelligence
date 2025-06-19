<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle demande d'amélioration RSE</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #2563eb, #9333ea);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: #f9fafb;
            padding: 20px;
            border: 1px solid #e5e7eb;
        }
        .footer {
            background: #374151;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 0 0 8px 8px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 20px 0;
        }
        .info-item {
            background: white;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
        }
        .info-item strong {
            color: #1f2937;
            display: block;
            margin-bottom: 5px;
        }
        .priority {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            padding: 10px;
            border-radius: 6px;
            margin: 15px 0;
        }
        .message-box {
            background: white;
            padding: 20px;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎯 Nouvelle Demande d'Amélioration RSE</h1>
        <p>Une entreprise souhaite améliorer son score dans EcoScope</p>
    </div>

    <div class="content">
        <div class="priority">
            <strong>⚡ Demande prioritaire</strong> - Budget : {{ $budget_range }} • Timeline : {{ $timeline }}
        </div>

        <h2>📋 Informations de l'entreprise</h2>
        <div class="info-grid">
            <div class="info-item">
                <strong>🏢 Entreprise</strong>
                {{ $company_name }}
            </div>
            <div class="info-item">
                <strong>👤 Contact</strong>
                {{ $contact_name }}
            </div>
            <div class="info-item">
                <strong>✉️ Email</strong>
                <a href="mailto:{{ $email }}">{{ $email }}</a>
            </div>
            <div class="info-item">
                <strong>📞 Téléphone</strong>
                {{ $phone ?? 'Non renseigné' }}
            </div>
            <div class="info-item">
                <strong>🏭 Secteur</strong>
                {{ $sector }}
            </div>
            <div class="info-item">
                <strong>📊 Taille</strong>
                @switch($company_size)
                    @case('micro')
                        Micro-entreprise (< 10 employés)
                        @break
                    @case('small')
                        Petite entreprise (10-49 employés)
                        @break
                    @case('medium')
                        Moyenne entreprise (50-249 employés)
                        @break
                    @case('large')
                        Grande entreprise (250+ employés)
                        @break
                    @default
                        {{ $company_size }}
                @endswitch
            </div>
        </div>

        @if($current_score)
        <div class="info-item" style="margin: 15px 0;">
            <strong>📈 Score RSE actuel</strong>
            {{ $current_score }}/100
        </div>
        @endif

        <h3>🎯 Objectifs d'amélioration</h3>
        <div class="message-box">
            {{ $improvement_goals }}
        </div>

        @if($message)
        <h3>💬 Message complémentaire</h3>
        <div class="message-box">
            {{ $message }}
        </div>
        @endif

        <h3>💰 Détails commerciaux</h3>
        <div class="info-grid">
            <div class="info-item">
                <strong>💵 Budget envisagé</strong>
                @switch($budget_range)
                    @case('5000-15000')
                        5 000€ - 15 000€
                        @break
                    @case('15000-50000')
                        15 000€ - 50 000€
                        @break
                    @case('50000-100000')
                        50 000€ - 100 000€
                        @break
                    @case('100000+')
                        100 000€+
                        @break
                    @default
                        {{ $budget_range }}
                @endswitch
            </div>
            <div class="info-item">
                <strong>⏰ Timeline</strong>
                @switch($timeline)
                    @case('immediate')
                        Immédiat (< 1 mois)
                        @break
                    @case('1-3months')
                        1-3 mois
                        @break
                    @case('3-6months')
                        3-6 mois
                        @break
                    @case('6-12months')
                        6-12 mois
                        @break
                    @default
                        {{ $timeline }}
                @endswitch
            </div>
        </div>
    </div>

    <div class="footer">
        <p><strong>EcoScope Platform</strong> | Reçu le {{ date('d/m/Y à H:i') }}</p>
        <p>Veuillez traiter cette demande dans les 24-48h pour optimiser le taux de conversion</p>
    </div>
</body>
</html>
