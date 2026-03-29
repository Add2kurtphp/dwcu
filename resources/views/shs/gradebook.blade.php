<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gradebook | DWCU SHS Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Afacad',sans-serif; }
        body { display:flex; align-items:center; justify-content:center; min-height:100vh; background:#f0f4f8; }
        .card { background:#fff; border-radius:24px; padding:60px 50px; text-align:center; box-shadow:0 4px 20px rgba(0,0,0,0.07); max-width:420px; width:90%; }
        .badge { display:inline-block; background:rgba(251,191,36,0.12); border:1px solid rgba(251,191,36,0.35); color:#fbbf24; border-radius:50px; padding:4px 14px; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:20px; }
        h1 { font-size:1.6rem; font-weight:700; color:#1e2f7a; margin-bottom:10px; }
        p { font-size:0.95rem; color:#64748b; margin-bottom:28px; line-height:1.6; }
        a { display:inline-flex; align-items:center; gap:8px; background:#1e2f7a; color:#fff; text-decoration:none; padding:11px 24px; border-radius:12px; font-weight:700; font-size:0.95rem; transition:opacity 0.2s; }
        a:hover { opacity:0.85; }
    </style>
</head>
<body>
    <div class="card">
        <div class="badge"><i class="fas fa-graduation-cap"></i> Senior High</div>
        <h1>Gradebook</h1>
        <p>This page is under construction.<br>Check back soon.</p>
        <a href="{{ route('shs.profile') }}"><i class="fas fa-arrow-left"></i> Back to Profile</a>
    </div>
</body>
</html>
