<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - E-Commerce System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: #f4f7fb; font-family: 'Poppins', sans-serif; overflow-x: hidden; margin: 0; }
        .app-container { display: flex; min-height: 100vh; }
        .sidebar-aside { width: 260px; background: linear-gradient(180deg, #0f172a, #1e293b); color: #94a3b8; flex-shrink: 0; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 4px 0 15px rgba(0,0,0,0.05); }
        .sidebar-brand { padding: 24px; font-size: 1.2rem; font-weight: 700; color: #ffffff; letter-spacing: 0.5px; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .sidebar-menu { padding: 20px 0; margin: 0; }
        .sidebar-link { display: block; width: 100%; padding: 14px 24px; color: #94a3b8; text-decoration: none; font-weight: 500; font-size: 14px; transition: all 0.2s ease; box-sizing: border-box; }
        .sidebar-link:hover, .sidebar-link.active { color: #ffffff; background: rgba(255,255,255,0.05); border-left: 4px solid #2563eb; padding-left: 20px; }
        .sidebar-footer { margin-top: auto; padding: 24px; background: rgba(0, 0, 0, 0.2); border-top: 1px solid rgba(255,255,255,0.05); }
        .main-workspace { flex-grow: 1; padding: 40px; overflow-y: auto; }
        .page-title { font-weight: 700; color: #0f172a; }
        .subtitle { color: #64748b; font-size: 14px; }
        .dashboard-card { border: none; border-radius: 18px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.04); }
        .table thead { background: #0f172a; color: white; }
        .table thead th { border: none; padding: 18px; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; }
        .table tbody td { padding: 18px; vertical-align: middle; }
        .btn-custom-primary { background: linear-gradient(135deg, #2563eb, #1d4ed8); border: none; color: white; padding: 10px 18px; border-radius: 10px; font-weight: 500; transition: 0.3s ease; text-decoration: none; }
        .btn-custom-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(37,99,235,0.3); color: white; }
        .btn-edit { background: #facc15; border: none; color: #111827; border-radius: 8px; padding: 6px 14px; font-weight: 500; text-decoration: none;}
        .btn-delete { background: #ef4444; border: none; color: white; border-radius: 8px; padding: 6px 14px; font-weight: 500; text-decoration: none;}
        .stock-high { background: #dcfce7; color: #166534; padding: 7px 12px; border-radius: 30px; font-size: 12px; font-weight: 600; }
        .stock-low { background: #fee2e2; color: #991b1b; padding: 7px 12px; border-radius: 30px; font-size: 12px; font-weight: 600; }
        .alert { border-radius: 12px; border: none; }
    </style>
</head>
<body>
<div class="app-container">