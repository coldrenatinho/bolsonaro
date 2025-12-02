<?php
/**
 * Painel de Estatísticas
 * Mostra métricas de visitantes e anúncios
 */

require_once 'ad-manager.php';

global $adManager;
$stats = $adManager->getStats();

// Carregar logs para análise detalhada
$logsDir = __DIR__ . '/logs';
$visitorsData = [];
$clicksData = [];
$impressionsData = [];

if (file_exists($logsDir . '/visitors.json')) {
    $visitorsData = json_decode(file_get_contents($logsDir . '/visitors.json'), true) ?: [];
}

if (file_exists($logsDir . '/ad_clicks.json')) {
    $clicksData = json_decode(file_get_contents($logsDir . '/ad_clicks.json'), true) ?: [];
}

if (file_exists($logsDir . '/ad_impressions.json')) {
    $impressionsData = json_decode(file_get_contents($logsDir . '/ad_impressions.json'), true) ?: [];
}

// Calcular estatísticas avançadas
$countriesCount = [];
$hourlyVisits = array_fill(0, 24, 0);
$dailyVisits = [];

foreach ($visitorsData as $visitor) {
    $country = $visitor['country'] ?? 'Unknown';
    $countriesCount[$country] = ($countriesCount[$country] ?? 0) + 1;
    
    if (isset($visitor['first_visit'])) {
        $hour = (int)date('H', strtotime($visitor['first_visit']));
        $hourlyVisits[$hour]++;
        
        $date = date('Y-m-d', strtotime($visitor['first_visit']));
        $dailyVisits[$date] = ($dailyVisits[$date] ?? 0) + 1;
    }
}

arsort($countriesCount);
$topCountries = array_slice($countriesCount, 0, 5, true);

// Últimos 7 dias
ksort($dailyVisits);
$last7Days = array_slice($dailyVisits, -7, 7, true);

// CTR por posição
$clicksByPosition = [];
$impressionsByPosition = [];

foreach ($clicksData as $click) {
    $pos = $click['position'] ?? 'unknown';
    $clicksByPosition[$pos] = ($clicksByPosition[$pos] ?? 0) + 1;
}

foreach ($impressionsData as $imp) {
    $pos = $imp['position'] ?? 'unknown';
    $impressionsByPosition[$pos] = ($impressionsByPosition[$pos] ?? 0) + 1;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estatísticas - Bolsonaro Livre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        body {
            background: #f8f9fa;
            padding: 20px 0;
        }
        
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #0d6efd;
        }
        
        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .chart-container {
            position: relative;
            height: 300px;
            margin-top: 20px;
        }
        
        .country-flag {
            font-size: 1.5rem;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="bi bi-graph-up"></i> Painel de Estatísticas</h1>
            <a href="index.php" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>
        
        <!-- Cards de Resumo -->
        <div class="row">
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <div class="stat-number"><?= number_format($stats['total_visitors']) ?></div>
                    <div class="stat-label">Total de Visitantes</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <div class="stat-number"><?= number_format($stats['total_impressions']) ?></div>
                    <div class="stat-label">Impressões de Anúncios</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <div class="stat-number"><?= number_format($stats['total_clicks']) ?></div>
                    <div class="stat-label">Cliques em Anúncios</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <div class="stat-number"><?= $stats['ctr'] ?>%</div>
                    <div class="stat-label">CTR (Taxa de Cliques)</div>
                </div>
            </div>
        </div>
        
        <!-- Gráficos -->
        <div class="row">
            <div class="col-md-6">
                <div class="stat-card">
                    <h4><i class="bi bi-calendar-week"></i> Visitantes - Últimos 7 Dias</h4>
                    <div class="chart-container">
                        <canvas id="dailyVisitsChart"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="stat-card">
                    <h4><i class="bi bi-clock"></i> Visitantes por Hora do Dia</h4>
                    <div class="chart-container">
                        <canvas id="hourlyVisitsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Top Países -->
        <div class="row">
            <div class="col-md-6">
                <div class="stat-card">
                    <h4><i class="bi bi-globe"></i> Top 5 Países</h4>
                    <table class="table table-hover mt-3">
                        <thead>
                            <tr>
                                <th>País</th>
                                <th>Visitantes</th>
                                <th>%</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($topCountries as $country => $count): 
                                $percentage = $stats['total_visitors'] > 0 ? ($count / $stats['total_visitors'] * 100) : 0;
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($country) ?></td>
                                <td><?= number_format($count) ?></td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar" role="progressbar" style="width: <?= $percentage ?>%">
                                            <?= number_format($percentage, 1) ?>%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- CTR por Posição -->
            <div class="col-md-6">
                <div class="stat-card">
                    <h4><i class="bi bi-bullseye"></i> Performance por Posição</h4>
                    <table class="table table-hover mt-3">
                        <thead>
                            <tr>
                                <th>Posição</th>
                                <th>Impressões</th>
                                <th>Cliques</th>
                                <th>CTR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($impressionsByPosition as $position => $impressions): 
                                $clicks = $clicksByPosition[$position] ?? 0;
                                $ctr = $impressions > 0 ? ($clicks / $impressions * 100) : 0;
                            ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($position) ?></strong></td>
                                <td><?= number_format($impressions) ?></td>
                                <td><?= number_format($clicks) ?></td>
                                <td>
                                    <span class="badge bg-<?= $ctr > 3 ? 'success' : ($ctr > 1 ? 'warning' : 'danger') ?>">
                                        <?= number_format($ctr, 2) ?>%
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Projeção de Receita -->
        <div class="row">
            <div class="col-md-12">
                <div class="stat-card">
                    <h4><i class="bi bi-currency-dollar"></i> Projeção de Receita (AdSense)</h4>
                    <p class="text-muted">Estimativas baseadas em CTR atual e métricas de mercado</p>
                    
                    <?php
                    $avgCPC = 0.30; // CPC médio em USD
                    $dailyRevenue = $stats['total_clicks'] * $avgCPC;
                    $monthlyRevenue = $dailyRevenue * 30;
                    $brl_rate = 5.20; // Taxa de conversão USD para BRL (atualizar)
                    ?>
                    
                    <div class="row text-center mt-4">
                        <div class="col-md-4">
                            <div class="border p-3 rounded">
                                <h5 class="text-muted">Receita Diária</h5>
                                <div class="stat-number" style="font-size: 1.8rem; color: #28a745;">
                                    $<?= number_format($dailyRevenue, 2) ?>
                                </div>
                                <small class="text-muted">≈ R$ <?= number_format($dailyRevenue * $brl_rate, 2) ?></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 rounded">
                                <h5 class="text-muted">Receita Mensal</h5>
                                <div class="stat-number" style="font-size: 1.8rem; color: #17a2b8;">
                                    $<?= number_format($monthlyRevenue, 2) ?>
                                </div>
                                <small class="text-muted">≈ R$ <?= number_format($monthlyRevenue * $brl_rate, 2) ?></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 rounded">
                                <h5 class="text-muted">Receita Anual</h5>
                                <div class="stat-number" style="font-size: 1.8rem; color: #6f42c1;">
                                    $<?= number_format($monthlyRevenue * 12, 2) ?>
                                </div>
                                <small class="text-muted">≈ R$ <?= number_format($monthlyRevenue * 12 * $brl_rate, 2) ?></small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info mt-4">
                        <strong><i class="bi bi-info-circle"></i> Nota:</strong>
                        Valores estimados com CPC médio de $<?= number_format($avgCPC, 2) ?>. 
                        A receita real pode variar conforme nicho, qualidade do tráfego e localização dos visitantes.
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Gráfico de visitantes diários
        const dailyCtx = document.getElementById('dailyVisitsChart').getContext('2d');
        new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: <?= json_encode(array_keys($last7Days)) ?>,
                datasets: [{
                    label: 'Visitantes',
                    data: <?= json_encode(array_values($last7Days)) ?>,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
        
        // Gráfico de visitantes por hora
        const hourlyCtx = document.getElementById('hourlyVisitsChart').getContext('2d');
        new Chart(hourlyCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(range(0, 23)) ?>.map(h => h + 'h'),
                datasets: [{
                    label: 'Visitantes',
                    data: <?= json_encode($hourlyVisits) ?>,
                    backgroundColor: '#17a2b8'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
</body>
</html>
