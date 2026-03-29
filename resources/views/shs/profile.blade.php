<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHS Student Profile | DWCU Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/app.css'])
    <style>
        :root {
            --primary-blue: #1e2f7a;
            --sidebar-dark: #162152;
            --accent-blue: #283593;
            --shs-gold: #fbbf24;
            --bg-light: #f0f4f8;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --white: #ffffff;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.07);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Afacad', sans-serif; }

        body { display: flex; height: 100vh; background-color: var(--bg-light); color: var(--text-dark); overflow: hidden; }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 270px;
            background: linear-gradient(180deg, #162152 0%, #0d1535 100%);
            color: var(--white);
            display: flex; flex-direction: column; justify-content: space-between;
            padding: 20px; box-shadow: 4px 0 15px rgba(0,0,0,0.15); flex-shrink: 0;
        }
        .brand-section { text-align: center; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 18px; margin-bottom: 16px; }
        .school-logo { width: 75px; margin: 0 auto 10px; display: block; filter: drop-shadow(0 0 10px rgba(255,255,255,0.1)); }
        .school-name { font-size: 0.82rem; font-weight: 700; line-height: 1.4; letter-spacing: 0.5px; }
        .sub-brand {
            display: inline-block; margin-top: 10px;
            background: rgba(251,191,36,0.15); border: 1px solid rgba(251,191,36,0.35);
            color: #fbbf24; border-radius: 50px; padding: 3px 14px;
            font-size: 0.72rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;
        }
        .nav-menu { display: flex; flex-direction: column; gap: 3px; }
        .nav-item {
            display: flex; align-items: center; padding: 11px 16px; color: #94a3b8;
            text-decoration: none; border-radius: 12px; transition: all 0.25s ease;
            font-weight: 500; font-size: 0.95rem;
        }
        .nav-item i { margin-right: 13px; font-size: 1rem; width: 18px; text-align: center; }
        .nav-item:hover { background: rgba(255,255,255,0.08); color: var(--white); transform: translateX(4px); }
        .nav-item.active { background: rgba(251,191,36,0.12); color: #fbbf24; border: 1px solid rgba(251,191,36,0.25); }
        .sidebar-bottom { padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.08); }
        .logout-btn {
            display: flex; align-items: center; justify-content: center; gap: 10px;
            width: 100%; padding: 12px; border-radius: 10px; background: transparent;
            color: #fca5a5; border: none; cursor: pointer;
            font-weight: 600; font-size: 0.95rem; font-family: 'Afacad', sans-serif;
            transition: background 0.25s, color 0.25s;
        }
        .logout-btn:hover { background: rgba(248,113,113,0.15); color: #fff; }

        /* ── CONTENT AREA ── */
        .content-area { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
        .main-header {
            background: var(--white); padding: 18px 40px;
            display: flex; justify-content: space-between; align-items: center;
            border-bottom: 1px solid #e2e8f0; flex-shrink: 0;
        }
        .main-header h1 { font-size: 1.35rem; font-weight: 700; color: var(--primary-blue); }
        .header-user {
            display: flex; align-items: center; gap: 10px; padding: 8px 16px;
            border-radius: 50px; cursor: pointer; transition: all 0.2s ease; border: 1px solid transparent;
        }
        .header-user:hover { background-color: #f1f5f9; border-color: #e2e8f0; }
        .header-user i { font-size: 1.5rem; color: var(--primary-blue); }
        .header-user span { font-weight: 600; font-size: 0.9rem; color: var(--text-dark); }
        .scroll-container { padding: 30px 40px; overflow-y: auto; flex: 1; }

        /* ── PROFILE BANNER ── */
        .profile-banner {
            background: linear-gradient(135deg, #1e2f7a 0%, #283593 60%, #3949ab 100%);
            border-radius: 24px; padding: 40px; color: var(--white);
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 28px; box-shadow: 0 12px 30px rgba(30,47,122,0.3);
            position: relative; overflow: hidden;
        }
        .banner-decoration {
            position: absolute; width: 320px; height: 320px; border-radius: 50%;
            border: 60px solid rgba(255,255,255,0.04); top: -80px; right: -80px; pointer-events: none;
        }
        .user-meta { display: flex; align-items: center; gap: 28px; position: relative; }
        .avatar-circle {
            width: 110px; height: 110px; border-radius: 50%;
            border: 4px solid rgba(255,255,255,0.35);
            box-shadow: 0 0 0 6px rgba(255,255,255,0.08); flex-shrink: 0;
            overflow: hidden; display: flex; align-items: center; justify-content: center; background: #d9d9d9;
        }
        .user-details h2 { font-size: 1.9rem; font-weight: 700; letter-spacing: -0.3px; }
        .user-details > p { font-size: 0.92rem; opacity: 0.75; margin-top: 3px; }
        .banner-badges { display: flex; gap: 8px; margin-top: 12px; flex-wrap: wrap; }
        .banner-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2);
            border-radius: 50px; padding: 4px 13px; font-size: 0.78rem; font-weight: 600;
        }
        .student-id-display {
            font-family: 'Courier New', Courier, monospace; font-size: 1.1rem;
            background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);
            padding: 10px 22px; border-radius: 50px; letter-spacing: 2px; white-space: nowrap;
        }

        /* ── INFO CARD ── */
        .info-card { background: var(--white); border-radius: 24px; padding: 35px 40px; box-shadow: var(--shadow); }
        .info-card-header {
            display: flex; justify-content: space-between; align-items: flex-start;
            margin-bottom: 28px; padding-bottom: 20px; border-bottom: 1px solid #f1f5f9;
        }
        .info-card h3 { font-size: 1.15rem; color: var(--primary-blue); font-weight: 700; }
        .info-card-sub { font-size: 0.83rem; color: var(--text-muted); margin-top: 4px; }
        .edit-toggle-btn {
            background: transparent; border: 1.5px solid var(--primary-blue); color: var(--primary-blue);
            padding: 8px 18px; border-radius: 10px; cursor: pointer; font-weight: 700; font-size: 0.9rem;
            transition: all 0.25s; white-space: nowrap; flex-shrink: 0; font-family: 'Afacad', sans-serif;
        }
        .edit-toggle-btn:hover { background: var(--primary-blue); color: white; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(30,47,122,0.25); }
        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 22px; }
        .field { background: #f8fafc; border-radius: 12px; padding: 14px 16px; border: 1px solid #f1f5f9; transition: border-color 0.2s; }
        .field.editable { border-color: var(--primary-blue); background: #fff; box-shadow: 0 0 0 3px rgba(30,47,122,0.06); }
        .field label {
            display: flex; align-items: center; gap: 6px; font-size: 0.75rem; color: var(--text-muted);
            font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;
        }
        .field label i { font-size: 0.7rem; opacity: 0.7; }
        .field input { width: 100%; border: none; font-size: 0.97rem; color: var(--text-dark); font-weight: 600; background: transparent; outline: none; }
        .field input:not([readonly]) { color: var(--primary-blue); }
        #action-buttons { display: none; gap: 12px; margin-top: 25px; }
        .save-btn {
            background: linear-gradient(135deg, #22c55e, #16a34a); color: white; border: none;
            padding: 11px 28px; border-radius: 10px; cursor: pointer; font-weight: 700; font-size: 0.95rem;
            transition: all 0.25s; display: flex; align-items: center; gap: 8px; font-family: 'Afacad', sans-serif;
        }
        .save-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(34,197,94,0.35); }
        .cancel-btn {
            background: transparent; color: #ef4444; border: 1.5px solid #ef4444;
            padding: 11px 28px; border-radius: 10px; cursor: pointer; font-weight: 700; font-size: 0.95rem;
            transition: all 0.25s; display: flex; align-items: center; gap: 8px; font-family: 'Afacad', sans-serif;
        }
        .cancel-btn:hover { background: #ef4444; color: white; }

        /* ── HAMBURGER ── */
        .hamburger-btn { display: none; background: none; border: none; color: var(--primary-blue); font-size: 1.6rem; cursor: pointer; padding: 4px 8px; line-height: 1; }

        /* ── MOBILE NAV ── */
        .mobile-nav-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 998; }
        .mobile-nav-overlay.open { display: block; }
        .mobile-nav-drawer {
            position: fixed; top: 0; left: -300px; width: 270px; height: 100%;
            background: linear-gradient(180deg, #162152 0%, #0d1535 100%);
            z-index: 999; transition: left 0.3s ease; padding: 20px 15px;
            display: flex; flex-direction: column; gap: 6px; overflow-y: auto;
        }
        .mobile-nav-drawer.open { left: 0; }
        .mobile-nav-close { align-self: flex-end; background: none; border: none; color: #cbd5e1; font-size: 1.4rem; cursor: pointer; margin-bottom: 15px; }
        .mobile-nav-drawer .mobile-brand { text-align: center; color: white; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .mobile-nav-drawer .mobile-brand p { font-size: 0.82rem; font-weight: 700; line-height: 1.4; }
        .mobile-nav-drawer .mobile-brand span { display: inline-block; margin-top: 6px; background: rgba(251,191,36,0.15); border: 1px solid rgba(251,191,36,0.3); color: #fbbf24; border-radius: 50px; padding: 2px 12px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
        .mobile-nav-drawer .nav-item { display: flex; align-items: center; padding: 12px 15px; color: #94a3b8; text-decoration: none; border-radius: 10px; font-weight: 500; transition: background 0.2s; }
        .mobile-nav-drawer .nav-item i { margin-right: 12px; width: 18px; text-align: center; }
        .mobile-nav-drawer .nav-item:hover { background: rgba(255,255,255,0.08); color: white; }
        .mobile-logout { margin-top: auto; padding-top: 15px; border-top: 1px solid rgba(255,255,255,0.08); }

        @keyframes modalPop {
            from { opacity: 0; transform: scale(0.85) translateY(20px); }
            to   { opacity: 1; transform: scale(1)    translateY(0);    }
        }

        @media (max-width: 1100px) { .info-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .hamburger-btn { display: block; }

            .main-header {
                padding: 12px 16px;
                position: sticky; top: 0; z-index: 100;
                display: flex; flex-direction: row;
                justify-content: space-between; align-items: center;
                flex-wrap: nowrap;
            }
            .main-header > div:first-child { display: flex; align-items: center; gap: 10px; min-width: 0; flex: 1; }
            .main-header h1 { font-size: 1.05rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
            .header-user { flex-shrink: 0; padding: 6px 10px; }
            .header-user span { display: none; }
            .header-user i { font-size: 1.4rem; }

            .scroll-container { padding: 14px; }

            .profile-banner {
                flex-direction: column; text-align: center;
                gap: 14px; padding: 24px 16px;
                margin-bottom: 14px; border-radius: 16px;
                align-items: center;
            }
            .user-meta { flex-direction: column; gap: 10px; align-items: center; width: 100%; }
            .user-details { text-align: center; }
            .banner-badges { justify-content: center; }
            .user-details h2 { font-size: 1.3rem; }
            .student-id-display { font-size: 0.85rem; align-self: center; }

            .info-card { padding: 18px 14px; border-radius: 16px; }
            .info-card-header { flex-direction: column; align-items: flex-start; gap: 12px; }
            .edit-toggle-btn { width: 100%; justify-content: center; text-align: center; }
            .info-grid { grid-template-columns: 1fr; gap: 12px; margin-top: 10px; }
            #action-buttons { flex-direction: column; }
            .save-btn, .cancel-btn { width: 100%; justify-content: center; }

            #passwordForm { grid-template-columns: 1fr !important; }
            #passwordForm > div[style*="grid-column"] { grid-column: span 1 !important; }
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-top">
        <div class="brand-section">
            <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo" class="school-logo">
            <h2 class="school-name">DIVINE WORD COLLEGE<br>OF URDANETA</h2>
            <p class="sub-brand">Senior High</p>
        </div>
        <nav class="nav-menu">
            <a href="{{ route('shs.announcement') }}" class="nav-item"><i class="fas fa-bullhorn"></i> Announcement</a>
            <a href="{{ route('shs.assignments') }}"  class="nav-item"><i class="fas fa-tasks"></i> Assignments</a>
            <a href="{{ route('shs.quizzes') }}"      class="nav-item"><i class="fas fa-edit"></i> Quizzes</a>
            <a href="{{ route('shs.gradebook') }}"    class="nav-item"><i class="fas fa-chart-line"></i> Gradebook</a>
            <a href="{{ route('shs.calendar') }}"     class="nav-item"><i class="fas fa-calendar-alt"></i> Calendar</a>
            <a href="{{ route('shs.logs') }}"         class="nav-item"><i class="fas fa-history"></i> Activity Logs</a>
        </nav>
    </div>
    <div class="sidebar-bottom">
        <form method="POST" action="{{ route('shs.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Log out
            </button>
        </form>
    </div>
</aside>

<main class="content-area">

    <header class="main-header">
        <div style="display:flex; align-items:center; gap:12px;">
            <button class="hamburger-btn" id="hamburger-btn" aria-label="Open menu">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Student Profile</h1>
        </div>
        <div class="header-user" id="headerUser">
            <i class="fas fa-user-graduate"></i>
            <span>{{ session('shs_student_name') }}</span>
        </div>
    </header>

    <div class="scroll-container">

        {{-- ── PROFILE BANNER ── --}}
        <section class="profile-banner" id="profileBanner">
            <div class="banner-decoration"></div>
            <div class="user-meta">
                <div class="avatar-wrapper" style="position:relative; cursor:pointer;" id="avatarWrapper">
                    <div class="avatar-circle" id="profileDisplay">
                        <i class="fas fa-user-graduate" id="defaultIcon" style="font-size:3rem; color:#666;"></i>
                    </div>
                    <div style="position:absolute; bottom:0; right:0; background:#fbbf24; color:#1e2f7a; width:30px; height:30px; border-radius:50%; display:flex; align-items:center; justify-content:center; border:2px solid white;">
                        <i class="fas fa-camera" style="font-size:0.8rem;"></i>
                    </div>
                    <input type="file" id="imageInput" accept="image/*" style="display:none;">
                </div>
                <div class="user-details">
                    <h2>{{ $student->name }}</h2>
                    <p>{{ $student->email }}</p>
                    <div class="banner-badges">
                        <span class="banner-badge"><i class="fas fa-graduation-cap"></i> Grade {{ $student->grade_level }}</span>
                        <span class="banner-badge"><i class="fas fa-users"></i> {{ $student->section }}</span>
                    </div>
                </div>
            </div>
            <div class="student-id-display">
                <i class="fas fa-id-card" style="opacity:0.7; margin-right:8px;"></i>{{ $student->student_id }}
            </div>
        </section>

        {{-- ── PERSONAL INFORMATION ── --}}
        <section class="info-card">
            <div class="info-card-header">
                <div>
                    <h3><i class="fas fa-address-card" style="margin-right:8px; opacity:0.7;"></i>Personal Information</h3>
                    <p class="info-card-sub">Your personal details and school information</p>
                </div>
                <button id="editBtn" class="edit-toggle-btn">
                    <i class="fas fa-edit"></i> Edit Profile
                </button>
            </div>

            @if (session('profile_success'))
                <div style="background:#f0fdf4; border:1px solid #bbf7d0; color:#166534; border-radius:10px; padding:10px 16px; font-size:0.88rem; font-weight:600; margin-bottom:18px; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-check-circle"></i> {{ session('profile_success') }}
                </div>
            @endif
            @error('email')
                <div style="background:#fef2f2; border:1px solid #fecaca; color:#991b1b; border-radius:10px; padding:10px 16px; font-size:0.88rem; font-weight:600; margin-bottom:18px;">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror

            <form id="profileForm" method="POST" action="{{ route('shs.profile.update') }}">
                @csrf
                @method('PATCH')
                <div class="info-grid">

                    {{-- Always readonly --}}
                    <div class="field">
                        <label><i class="fas fa-user"></i> Name</label>
                        <input type="text" value="{{ $student->name }}" readonly>
                    </div>

                    {{-- Editable --}}
                    <div class="field" data-editable>
                        <label><i class="fas fa-envelope"></i> Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $student->email) }}" readonly>
                    </div>

                    {{-- Always readonly --}}
                    <div class="field">
                        <label><i class="fas fa-graduation-cap"></i> Grade Level</label>
                        <input type="text" value="Grade {{ $student->grade_level }}" readonly>
                    </div>
                    <div class="field">
                        <label><i class="fas fa-users"></i> Section</label>
                        <input type="text" value="{{ $student->section }}" readonly>
                    </div>

                    {{-- Editable --}}
                    <div class="field" data-editable>
                        <label><i class="fas fa-map-marker-alt"></i> Current Address</label>
                        <input type="text" name="current_address" value="{{ old('current_address', $student->current_address) }}" readonly>
                    </div>
                    <div class="field" data-editable>
                        <label><i class="fas fa-home"></i> Permanent Address</label>
                        <input type="text" name="permanent_address" value="{{ old('permanent_address', $student->permanent_address) }}" readonly>
                    </div>
                    <div class="field" data-editable>
                        <label><i class="fas fa-birthday-cake"></i> Birthday</label>
                        <input type="text" name="birthday" value="{{ old('birthday', $student->birthday) }}" readonly>
                    </div>
                    <div class="field" data-editable>
                        <label><i class="fas fa-female"></i> Mother</label>
                        <input type="text" name="mother_name" value="{{ old('mother_name', $student->mother_name) }}" readonly>
                    </div>
                    <div class="field" data-editable>
                        <label><i class="fas fa-male"></i> Father</label>
                        <input type="text" name="father_name" value="{{ old('father_name', $student->father_name) }}" readonly>
                    </div>

                </div>

                <div id="action-buttons" style="display:none; gap:12px; margin-top:25px;">
                    <button type="submit" class="save-btn"><i class="fas fa-check"></i> Save Changes</button>
                    <button type="button" id="cancelBtn" class="cancel-btn"><i class="fas fa-times"></i> Cancel</button>
                </div>
            </form>
        </section>

        {{-- ── SECURITY & PASSWORD ── --}}
        <section class="info-card" style="margin-top:28px;">
            <div class="info-card-header">
                <div style="display:flex;align-items:center;gap:14px;">
                    <div style="width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.05rem;color:#1e2f7a;background:linear-gradient(135deg,#e8eaf6,#c5cae9);">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div>
                        <h3 style="font-size:1rem;font-weight:700;color:#0d1b44;margin:0 0 3px;">Security &amp; Password</h3>
                        <p style="font-size:0.8rem;color:#8892b0;margin:0;">Change your password regularly to keep your account secure.</p>
                    </div>
                </div>
                <button type="submit" form="passwordForm"
                        style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#1e2f7a,#0d1b44);color:white;border:none;padding:11px 22px;border-radius:12px;font-family:'Afacad',sans-serif;font-weight:700;font-size:0.9rem;cursor:pointer;white-space:nowrap;box-shadow:0 4px 12px rgba(30,47,122,0.25);transition:transform 0.2s;"
                        onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <i class="fas fa-key"></i> Change Password
                </button>
            </div>

            @if (session('password_success'))
                <div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;border-radius:10px;padding:10px 16px;font-size:0.88rem;font-weight:600;margin-bottom:18px;display:flex;align-items:center;gap:8px;">
                    <i class="fas fa-check-circle"></i> {{ session('password_success') }}
                </div>
            @endif
            @error('current_password')
                <div style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b;border-radius:10px;padding:10px 16px;font-size:0.88rem;font-weight:600;margin-bottom:18px;">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
            @error('new_password')
                <div style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b;border-radius:10px;padding:10px 16px;font-size:0.88rem;font-weight:600;margin-bottom:18px;">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror

            <form id="passwordForm" method="POST" action="{{ route('shs.profile.password') }}"
                  style="display:grid;grid-template-columns:1fr 1fr;gap:18px;max-width:700px;">
                @csrf
                @method('PATCH')

                <div style="display:flex;flex-direction:column;gap:6px;grid-column:span 2;">
                    <label style="font-size:0.82rem;font-weight:700;color:#2d3a5e;">Current Password</label>
                    <div style="position:relative;display:flex;align-items:center;">
                        <i class="fas fa-lock" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;z-index:1;"></i>
                        <input type="password" name="current_password" id="currentPassword" placeholder="Enter your current password"
                               style="width:100%;padding:11px 42px 11px 36px;border:1.5px solid #e0e4f0;border-radius:10px;font-size:0.9rem;color:#0d1b44;background:#fafbff;outline:none;font-family:'Afacad',sans-serif;"
                               onfocus="this.style.borderColor='#1e2f7a';this.style.boxShadow='0 0 0 3px rgba(30,47,122,0.1)';this.style.background='#fff'"
                               onblur="this.style.borderColor='#e0e4f0';this.style.boxShadow='none';this.style.background='#fafbff'">
                        <button type="button" class="pw-eye" data-target="currentPassword"
                                style="position:absolute;right:12px;background:none;border:none;color:#8892b0;cursor:pointer;font-size:0.85rem;padding:4px;"
                                onmouseover="this.style.color='#1e2f7a'" onmouseout="this.style.color='#8892b0'">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div style="display:flex;flex-direction:column;gap:6px;">
                    <label style="font-size:0.82rem;font-weight:700;color:#2d3a5e;">New Password</label>
                    <div style="position:relative;display:flex;align-items:center;">
                        <i class="fas fa-lock" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;z-index:1;"></i>
                        <input type="password" name="new_password" id="newPassword" placeholder="Minimum 8 characters"
                               style="width:100%;padding:11px 42px 11px 36px;border:1.5px solid #e0e4f0;border-radius:10px;font-size:0.9rem;color:#0d1b44;background:#fafbff;outline:none;font-family:'Afacad',sans-serif;"
                               onfocus="this.style.borderColor='#1e2f7a';this.style.boxShadow='0 0 0 3px rgba(30,47,122,0.1)';this.style.background='#fff'"
                               onblur="this.style.borderColor='#e0e4f0';this.style.boxShadow='none';this.style.background='#fafbff'">
                        <button type="button" class="pw-eye" data-target="newPassword"
                                style="position:absolute;right:12px;background:none;border:none;color:#8892b0;cursor:pointer;font-size:0.85rem;padding:4px;"
                                onmouseover="this.style.color='#1e2f7a'" onmouseout="this.style.color='#8892b0'">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div style="display:flex;flex-direction:column;gap:6px;">
                    <label style="font-size:0.82rem;font-weight:700;color:#2d3a5e;">Confirm New Password</label>
                    <div style="position:relative;display:flex;align-items:center;">
                        <i class="fas fa-lock" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;z-index:1;"></i>
                        <input type="password" name="new_password_confirmation" id="confirmPassword" placeholder="Re-type new password"
                               style="width:100%;padding:11px 42px 11px 36px;border:1.5px solid #e0e4f0;border-radius:10px;font-size:0.9rem;color:#0d1b44;background:#fafbff;outline:none;font-family:'Afacad',sans-serif;"
                               onfocus="this.style.borderColor='#1e2f7a';this.style.boxShadow='0 0 0 3px rgba(30,47,122,0.1)';this.style.background='#fff'"
                               onblur="this.style.borderColor='#e0e4f0';this.style.boxShadow='none';this.style.background='#fafbff'">
                        <button type="button" class="pw-eye" data-target="confirmPassword"
                                style="position:absolute;right:12px;background:none;border:none;color:#8892b0;cursor:pointer;font-size:0.85rem;padding:4px;"
                                onmouseover="this.style.color='#1e2f7a'" onmouseout="this.style.color='#8892b0'">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </form>
        </section>

    </div>
</main>

{{-- ── Mobile nav overlay + drawer ── --}}
<div class="mobile-nav-overlay" id="mobile-nav-overlay"></div>
<div class="mobile-nav-drawer" id="mobile-nav-drawer">
    <button class="mobile-nav-close" id="mobile-nav-close" aria-label="Close menu">
        <i class="fas fa-times"></i>
    </button>
    <div class="mobile-brand">
        <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo" style="width:60px; margin:0 auto 8px; display:block;">
        <p>DIVINE WORD COLLEGE<br>OF URDANETA</p>
        <span>Senior High</span>
    </div>
    <a href="{{ route('shs.announcement') }}" class="nav-item"><i class="fas fa-bullhorn"></i> Announcement</a>
    <a href="{{ route('shs.assignments') }}"  class="nav-item"><i class="fas fa-tasks"></i> Assignments</a>
    <a href="{{ route('shs.quizzes') }}"      class="nav-item"><i class="fas fa-edit"></i> Quizzes</a>
    <a href="{{ route('shs.gradebook') }}"    class="nav-item"><i class="fas fa-chart-line"></i> Gradebook</a>
    <a href="{{ route('shs.calendar') }}"     class="nav-item"><i class="fas fa-calendar-alt"></i> Calendar</a>
    <a href="{{ route('shs.logs') }}"         class="nav-item"><i class="fas fa-history"></i> Activity Logs</a>
    <div class="mobile-logout">
        <form method="POST" action="{{ route('shs.logout') }}">
            @csrf
            <button type="submit" style="background:none; border:none; cursor:pointer; color:#fca5a5; font-weight:600; padding:10px; width:100%; border-radius:8px; font-family:'Afacad',sans-serif; font-size:1rem; display:flex; align-items:center; justify-content:center; gap:8px;">
                <i class="fas fa-sign-out-alt"></i> Log out
            </button>
        </form>
    </div>
</div>

{{-- ── Success Modals ── --}}
<div id="passwordModal" style="display:none; position:fixed; inset:0; z-index:9999; align-items:center; justify-content:center;">
    <div style="position:absolute; inset:0; background:rgba(13,27,68,0.5); backdrop-filter:blur(4px);" onclick="document.getElementById('passwordModal').style.display='none'"></div>
    <div style="position:relative; background:#fff; border-radius:24px; padding:40px 36px 32px; max-width:400px; width:90%; box-shadow:0 24px 60px rgba(13,27,68,0.22); text-align:center; animation:modalPop 0.35s cubic-bezier(.34,1.56,.64,1) both;">
        <div style="width:68px; height:68px; background:linear-gradient(135deg,#1e2f7a,#0d1b44); border-radius:20px; display:flex; align-items:center; justify-content:center; margin:0 auto 20px; box-shadow:0 8px 24px rgba(30,47,122,0.3);">
            <i class="fas fa-shield-alt" style="font-size:1.6rem; color:#fbbf24;"></i>
        </div>
        <h3 style="font-size:1.25rem; font-weight:800; color:#0d1b44; margin:0 0 8px;">Password Changed!</h3>
        <p style="font-size:0.88rem; color:#8892b0; margin:0 0 28px; line-height:1.6;">Your password has been updated successfully. Keep it safe!</p>
        <div style="height:1px; background:linear-gradient(90deg,transparent,#e0e4f0,transparent); margin-bottom:24px;"></div>
        <button onclick="document.getElementById('passwordModal').style.display='none'"
                style="background:linear-gradient(135deg,#1e2f7a,#0d1b44); color:#fbbf24; border:none; padding:12px 32px; border-radius:12px; font-family:'Afacad',sans-serif; font-weight:700; font-size:0.95rem; cursor:pointer;">
            Got it
        </button>
    </div>
</div>

<div id="profileModal" style="display:none; position:fixed; inset:0; z-index:9999; align-items:center; justify-content:center;">
    <div style="position:absolute; inset:0; background:rgba(13,27,68,0.5); backdrop-filter:blur(4px);" onclick="document.getElementById('profileModal').style.display='none'"></div>
    <div style="position:relative; background:#fff; border-radius:24px; padding:40px 36px 32px; max-width:400px; width:90%; box-shadow:0 24px 60px rgba(13,27,68,0.22); text-align:center; animation:modalPop 0.35s cubic-bezier(.34,1.56,.64,1) both;">
        <div style="width:68px; height:68px; background:linear-gradient(135deg,#22c55e,#16a34a); border-radius:20px; display:flex; align-items:center; justify-content:center; margin:0 auto 20px; box-shadow:0 8px 24px rgba(34,197,94,0.3);">
            <i class="fas fa-user-check" style="font-size:1.6rem; color:#fff;"></i>
        </div>
        <h3 style="font-size:1.25rem; font-weight:800; color:#0d1b44; margin:0 0 8px;">Profile Updated!</h3>
        <p style="font-size:0.88rem; color:#8892b0; margin:0 0 28px; line-height:1.6;">Your personal information has been saved successfully.</p>
        <div style="height:1px; background:linear-gradient(90deg,transparent,#e0e4f0,transparent); margin-bottom:24px;"></div>
        <button onclick="document.getElementById('profileModal').style.display='none'"
                style="background:linear-gradient(135deg,#22c55e,#16a34a); color:#fff; border:none; padding:12px 32px; border-radius:12px; font-family:'Afacad',sans-serif; font-weight:700; font-size:0.95rem; cursor:pointer;">
            Got it
        </button>
    </div>
</div>

<div id="flash-data"
     data-profile="{{ session('profile_success') ? '1' : '' }}"
     data-password="{{ session('password_success') ? '1' : '' }}"
     style="display:none;"></div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Mobile nav ──
    var hamburgerBtn = document.getElementById('hamburger-btn');
    var overlay      = document.getElementById('mobile-nav-overlay');
    var drawer       = document.getElementById('mobile-nav-drawer');
    var mobileClose  = document.getElementById('mobile-nav-close');
    function openDrawer()  { drawer.classList.add('open');    overlay.classList.add('open');    document.body.style.overflow = 'hidden'; }
    function closeDrawer() { drawer.classList.remove('open'); overlay.classList.remove('open'); document.body.style.overflow = ''; }
    if (hamburgerBtn) hamburgerBtn.addEventListener('click', openDrawer);
    if (mobileClose)  mobileClose.addEventListener('click', closeDrawer);
    if (overlay)      overlay.addEventListener('click', closeDrawer);

    // ── Header user: scroll to banner ──
    var headerUser = document.getElementById('headerUser');
    if (headerUser) {
        headerUser.addEventListener('click', function () {
            var banner = document.getElementById('profileBanner');
            banner.scrollIntoView({ behavior: 'smooth' });
            banner.style.opacity = '0.8';
            setTimeout(function () { banner.style.opacity = '1'; }, 200);
        });
    }

    // ── Avatar upload ──
    var avatarWrapper  = document.getElementById('avatarWrapper');
    var imageInput     = document.getElementById('imageInput');
    var profileDisplay = document.getElementById('profileDisplay');
    var defaultIcon    = document.getElementById('defaultIcon');
    if (avatarWrapper) {
        avatarWrapper.addEventListener('click', function () { imageInput.click(); });
        imageInput.addEventListener('change', function () {
            var file = this.files[0];
            if (!file) return;
            var reader = new FileReader();
            reader.onload = function (e) {
                if (defaultIcon) defaultIcon.style.display = 'none';
                profileDisplay.style.backgroundImage    = 'url(' + e.target.result + ')';
                profileDisplay.style.backgroundSize     = 'cover';
                profileDisplay.style.backgroundPosition = 'center';
            };
            reader.readAsDataURL(file);
        });
    }

    // ── Edit / Cancel ──
    var editBtn        = document.getElementById('editBtn');
    var cancelBtn      = document.getElementById('cancelBtn');
    var actionButtons  = document.getElementById('action-buttons');
    var editableFields = document.querySelectorAll('[data-editable]');

    function setEditable(on) {
        editableFields.forEach(function (field) {
            var input = field.querySelector('input');
            if (on) {
                input.removeAttribute('readonly');
                field.classList.add('editable');
            } else {
                input.setAttribute('readonly', true);
                field.classList.remove('editable');
            }
        });
        actionButtons.style.display = on ? 'flex' : 'none';
        editBtn.style.display = on ? 'none' : 'inline-flex';
    }

    if (editBtn)   editBtn.addEventListener('click', function () { setEditable(true); });
    if (cancelBtn) cancelBtn.addEventListener('click', function () { setEditable(false); });

    // ── Password eye toggles ──
    document.querySelectorAll('.pw-eye').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = document.getElementById(btn.dataset.target);
            var icon  = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
            }
        });
    });

    // ── Success modals ──
    var flash = document.getElementById('flash-data');
    if (flash && flash.dataset.profile)  document.getElementById('profileModal').style.display  = 'flex';
    if (flash && flash.dataset.password) document.getElementById('passwordModal').style.display = 'flex';
});
</script>

</body>
</html>
