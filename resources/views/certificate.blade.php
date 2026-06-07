<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Certificates</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    body { font-family: 'DM Sans', sans-serif; background: #f4f4f6; margin: 0; padding: 0; color: #1a1a1a; }
    .container { max-width: 1000px; margin: 40px auto; background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.07); overflow: hidden; }

    /* Hero */
    .hero { background: #cc0000; padding: 2.5rem 2.5rem 3rem; position: relative; overflow: hidden; }
    .hero::before { content: ''; position: absolute; top: -40px; right: -40px; width: 200px; height: 200px; border-radius: 50%; background: rgba(255,255,255,0.07); }
    .hero-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); color: #fff; font-size: 12px; padding: 4px 14px; border-radius: 99px; margin-bottom: 1rem; letter-spacing: 0.05em; }
    .hero h1 { font-family: 'DM Serif Display', serif; font-size: 2rem; color: #fff; margin: 0 0 6px; font-weight: 400; }
    .hero p { color: rgba(255,255,255,0.75); margin: 0; font-size: 0.95rem; }

    /* Body */
    .body { padding: 2rem 2.5rem 2.5rem; }
    .cert-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(270px, 1fr)); gap: 1.25rem; }

    /* Card */
    .cert-card { background: #fff; border: 1px solid #e5e5e5; border-radius: 14px; padding: 1.5rem; position: relative; overflow: hidden; transition: transform 0.15s, box-shadow 0.15s; }
    .cert-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
    .cert-card-accent { position: absolute; top: 0; left: 0; right: 0; height: 3px; background: #cc0000; }
    .cert-icon { width: 42px; height: 42px; border-radius: 10px; background: #fcebeb; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; font-size: 20px; }
    .cert-title { font-family: 'DM Serif Display', serif; font-size: 1.1rem; font-weight: 400; margin: 0 0 0.9rem; color: #1a1a1a; line-height: 1.4; }
    .cert-meta { display: grid; gap: 5px; margin-bottom: 1rem; }
    .cert-row { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #666; }
    .cert-row strong { color: #1a1a1a; font-weight: 500; }

    /* Score bar */
    .score-label { display: flex; justify-content: space-between; font-size: 12px; color: #888; margin-bottom: 4px; }
    .score-bar { background: #f0f0f0; border-radius: 99px; height: 6px; overflow: hidden; margin-bottom: 0.75rem; }
    .score-fill { height: 100%; border-radius: 99px; background: #cc0000; }

    /* Status badge */
    .cert-status { display: inline-flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 500; padding: 3px 10px; border-radius: 99px; margin-bottom: 1rem; }
    .cert-status.passed { background: #eaf3de; color: #3b6d11; }
    .cert-status.failed { background: #fcebeb; color: #a32d2d; }

    /* Actions */
    .cert-actions { display: flex; gap: 8px; }
    .btn { flex: 1; display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 9px 12px; border-radius: 8px; font-size: 13px; font-weight: 500; text-decoration: none; border: 1px solid #ddd; background: transparent; color: #1a1a1a; transition: background 0.15s; }
    .btn:hover { background: #f5f5f5; }
    .btn-primary { background: #cc0000; border-color: #cc0000; color: #fff; }
    .btn-primary:hover { background: #aa0000; border-color: #aa0000; }

    /* Empty state */
    .empty-state { text-align: center; padding: 4rem 2rem; color: #666; }
    .empty-icon { width: 64px; height: 64px; border-radius: 50%; background: #f5f5f5; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; font-size: 28px; }
    .empty-state h3 { margin: 0 0 8px; font-size: 1rem; color: #1a1a1a; }
    .empty-state p { margin: 0; font-size: 14px; }

    /* Back button */
    .back-wrap { text-align: center; margin-top: 2rem; }
    .back-btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 22px; border-radius: 8px; background: transparent; border: 1px solid #ddd; color: #1a1a1a; font-size: 14px; font-weight: 500; text-decoration: none; transition: background 0.15s; }
    .back-btn:hover { background: #f5f5f5; }
  </style>
</head>
<body>
  <div class="container">
    <div class="hero">
      <div class="hero-badge">🏅 Achievements</div>
      <h1>Your Certificates</h1>
      <p>Review and download your earned certificates below.</p>
    </div>

    <div class="body">
      @if (!empty($certificates) && $certificates->count() > 0)
        <div class="cert-grid">
          @foreach ($certificates as $cert)
            @php $pct = $cert->percentage ?? 0; @endphp
            <div class="cert-card">
              <div class="cert-card-accent"></div>
              <div class="cert-icon">🎓</div>
              <div class="cert-title">{{ $cert->course_name }}</div>

              <div class="cert-meta">
                <div class="cert-row">👤 <strong>{{ $first }} {{ $last }}</strong></div>
                <div class="cert-row">@ {{ $username }}</div>
                <div class="cert-row">📅 {{ optional($cert->awarded_at)->format('F j, Y \a\t g:i A') }}</div>
              </div>

              <div class="score-label">
                <span>Score: {{ $cert->score ?? 0 }} / 50</span>
                <span>{{ number_format($pct, 0) }}%</span>
              </div>
              <div class="score-bar">
                <div class="score-fill" style="width: {{ min($pct, 100) }}%"></div>
              </div>

              <div class="cert-status {{ $cert->passed ? 'passed' : 'failed' }}">
                {{ $cert->passed ? '✅ Passed' : '❌ Not passed' }}
              </div>

              <div class="cert-actions">
                <a href="{{ route('certificate.view', ['certificateId' => $cert->id]) }}" class="btn btn-primary" target="_blank">👁 View</a>
                <a href="{{ route('certificate.download', ['certificateId' => $cert->id]) }}" class="btn" download>⬇ Download</a>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="empty-state">
          <div class="empty-icon">🎓</div>
          <h3>No certificates yet</h3>
          <p>Complete a course and pass the final exam to earn one.</p>
        </div>
      @endif

      <div class="back-wrap">
        <a href="{{ route('dashboard') }}" class="back-btn">← Back to dashboard</a>
      </div>
    </div>
  </div>
</body>
</html>
