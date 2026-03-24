<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Settings | DWCU Admin Portal</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-settings-style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<div class="dashboard-wrapper">
    <aside class="sidebar-container" id="sidebar">
        <div class="sidebar-top-branding">
            <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo" class="school-logo-img">
            <div class="school-title-text">DIVINE WORD COLLEGE <br> OF URDANETA</div>
            <div class="portal-identity">Administrative Portal</div>
        </div>
        <nav class="nav-links-list">
            <a href="{{ route('admin.dashboard') }}" class="nav-link-item"><i class="fas fa-th-large"></i> Overview</a>
            <a href="{{ route('admin.faculty') }}" class="nav-link-item"><i class="fas fa-chalkboard-teacher"></i> Faculty Management</a>
            <a href="{{ route('admin.students') }}" class="nav-link-item"><i class="fas fa-user-graduate"></i> Student Records</a>
            <a href="{{ route('admin.announcements') }}" class="nav-link-item"><i class="fas fa-bullhorn"></i> Global Announcements</a>
            <a href="{{ route('admin.logs') }}" class="nav-link-item"><i class="fas fa-history"></i> System Audit Logs</a>
            <a href="{{ route('admin.settings') }}" class="nav-link-item active"><i class="fas fa-cog"></i> System Settings</a>
        </nav>
        <div class="sidebar-footer-action">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="exit-system-link" style="background:none;border:none;cursor:pointer;width:100%;">
                    <i class="fas fa-sign-out-alt"></i> Log out
                </button>
            </form>
        </div>
    </aside>

    <main class="main-viewport-content">
        <header class="top-nav-bar">
            <button class="hamburger-btn" id="hamburger-btn" aria-label="Open menu">
                <i class="fas fa-bars"></i>
            </button>
            <div class="header-title">
                <h1>System Settings</h1>
                <p style="font-size:0.82rem;color:#8892b0;margin:0;">Manage portal configuration, access control, and system preferences.</p>
            </div>
            <a href="{{ route('admin.profile') }}" style="text-decoration:none;color:inherit;">
                <div class="user-quick-profile">
                    <div class="profile-info">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <span class="user-role">System Administrator</span>
                    </div>
                    <div class="profile-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                </div>
            </a>
        </header>

        <div class="admin-content-grid">

            {{-- ── SCHOOL INFORMATION ─────────────────────── --}}
            <section class="management-section-card">

                <div class="card-header">
                    <div style="display:flex;align-items:center;gap:14px;">
                        <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#1e2f7a,#0d1b44);color:#f1c40f;display:flex;align-items:center;justify-content:center;font-size:1.05rem;flex-shrink:0;">
                            <i class="fas fa-building-columns"></i>
                        </div>
                        <div>
                            <h3 style="font-size:1rem;font-weight:700;color:#0d1b44;margin:0 0 3px;">School Information</h3>
                            <p class="sub-portal-text">Update the global branding displayed across all portals.</p>
                        </div>
                    </div>
                    <button type="submit" form="schoolSettingsForm" id="saveSchoolInfo"
                        style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#f1c40f,#d4ac0d);color:#0d1b44;border:none;padding:11px 22px;border-radius:12px;font-family:'Afacad',sans-serif;font-weight:700;font-size:0.9rem;cursor:pointer;white-space:nowrap;flex-shrink:0;transition:transform 0.2s,box-shadow 0.2s;"
                        onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 18px rgba(241,196,15,0.35)'"
                        onmouseout="this.style.transform='';this.style.boxShadow=''">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>

                {{-- Flash messages --}}
                @if (session('settings_success'))
                    <div style="display:flex;align-items:center;gap:10px;background:#e8f5e9;border:1.5px solid #a5d6a7;border-radius:10px;padding:12px 16px;margin-bottom:20px;color:#2e7d32;font-size:0.88rem;font-weight:600;">
                        <i class="fas fa-check-circle"></i>
                        {{ session('settings_success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div style="display:flex;align-items:center;gap:10px;background:#fdecea;border:1.5px solid #ef9a9a;border-radius:10px;padding:12px 16px;margin-bottom:20px;color:#c62828;font-size:0.88rem;font-weight:600;">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form id="schoolSettingsForm" method="POST" action="{{ route('admin.settings.update') }}">
                    @csrf
                    @method('PATCH')
                    <div class="settings-form-grid">

                        <div style="display:flex;flex-direction:column;gap:6px;">
                            <label style="font-size:0.82rem;font-weight:700;color:#2d3a5e;">School Name</label>
                            <div style="position:relative;display:flex;align-items:center;">
                                <i class="fas fa-school" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;"></i>
                                <input class="settings-input" type="text" name="school_name"
                                    value="{{ old('school_name', $settings['school_name']) }}"
                                    placeholder="School name" required>
                            </div>
                        </div>

                        <div style="display:flex;flex-direction:column;gap:6px;">
                            <label style="font-size:0.82rem;font-weight:700;color:#2d3a5e;">Portal Identity Name</label>
                            <div style="position:relative;display:flex;align-items:center;">
                                <i class="fas fa-tag" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;"></i>
                                <input class="settings-input" type="text" name="portal_name"
                                    value="{{ old('portal_name', $settings['portal_name']) }}"
                                    placeholder="Portal label" required>
                            </div>
                        </div>

                        <div style="display:flex;flex-direction:column;gap:6px;">
                            <label style="font-size:0.82rem;font-weight:700;color:#2d3a5e;">Contact Email</label>
                            <div style="position:relative;display:flex;align-items:center;">
                                <i class="fas fa-envelope" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;"></i>
                                <input class="settings-input" type="email" name="contact_email"
                                    value="{{ old('contact_email', $settings['contact_email']) }}"
                                    placeholder="admin@school.edu" required>
                            </div>
                        </div>

                        <div style="display:flex;flex-direction:column;gap:6px;">
                            <label style="font-size:0.82rem;font-weight:700;color:#2d3a5e;">Academic Year</label>
                            <div style="position:relative;display:flex;align-items:center;">
                                <i class="fas fa-calendar-alt" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;"></i>
                                <input class="settings-input" type="text" name="academic_year"
                                    value="{{ old('academic_year', $settings['academic_year']) }}"
                                    placeholder="e.g. 2025 – 2026" required>
                            </div>
                        </div>

                    </div>
                </form>
            </section>

            {{-- ── SECURITY & SYSTEM ──────────────────────── --}}
            <section class="management-section-card">

                <div style="display:flex;align-items:center;gap:14px;margin-bottom:24px;">
                    <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#f1c40f,#d4ac0d);color:#0d1b44;display:flex;align-items:center;justify-content:center;font-size:1.05rem;flex-shrink:0;">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div>
                        <h3 style="font-size:1rem;font-weight:700;color:#0d1b44;margin:0 0 3px;">Security &amp; System</h3>
                        <p class="sub-portal-text">Manage access control, session behavior, and automated tasks.</p>
                    </div>
                </div>

                <div style="height:1px;background:#f0f2f7;margin-bottom:6px;"></div>

                <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;padding:14px 0;border-bottom:1px solid #f0f2f7;">
                    <div style="display:flex;align-items:center;gap:14px;flex:1;">
                        <div style="width:38px;height:38px;background:#f5f7fb;border:1.5px solid #e8ebf0;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#5a6685;font-size:0.85rem;flex-shrink:0;">
                            <i class="fas fa-triangle-exclamation"></i>
                        </div>
                        <div>
                            <strong style="display:block;font-size:0.9rem;font-weight:700;color:#0d1b44;">Maintenance Mode</strong>
                            <p style="font-size:0.78rem;color:#8892b0;margin:3px 0 0;">Prevents faculty and students from logging in during system updates.</p>
                        </div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" id="maintenanceToggle">
                        <span class="toggle-track"></span>
                    </label>
                </div>

                <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;padding:14px 0;border-bottom:1px solid #f0f2f7;">
                    <div style="display:flex;align-items:center;gap:14px;flex:1;">
                        <div style="width:38px;height:38px;background:#f5f7fb;border:1.5px solid #e8ebf0;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#5a6685;font-size:0.85rem;flex-shrink:0;">
                            <i class="fas fa-database"></i>
                        </div>
                        <div>
                            <strong style="display:block;font-size:0.9rem;font-weight:700;color:#0d1b44;">Auto-Backup Logs</strong>
                            <p style="font-size:0.78rem;color:#8892b0;margin:3px 0 0;">Automatically saves system audit logs to secure storage every 24 hours.</p>
                        </div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" checked id="backupToggle">
                        <span class="toggle-track"></span>
                    </label>
                </div>

                <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;padding:14px 0;">
                    <div style="display:flex;align-items:center;gap:14px;flex:1;">
                        <div style="width:38px;height:38px;background:#f5f7fb;border:1.5px solid #e8ebf0;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#5a6685;font-size:0.85rem;flex-shrink:0;">
                            <i class="fas fa-envelope-open-text"></i>
                        </div>
                        <div>
                            <strong style="display:block;font-size:0.9rem;font-weight:700;color:#0d1b44;">Email Notifications</strong>
                            <p style="font-size:0.78rem;color:#8892b0;margin:3px 0 0;">Send system alerts and activity summaries to the registered admin email.</p>
                        </div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" checked id="emailToggle">
                        <span class="toggle-track"></span>
                    </label>
                </div>

            </section>

        </div>
    </main>
</div>

{{-- Toast --}}
<div class="settings-toast" id="settingsToast">
    <i class="fas fa-check-circle"></i>
    <span></span>
</div>

{{-- Mobile nav overlay + drawer --}}
<div class="mobile-nav-overlay" id="mobile-nav-overlay"></div>
<div class="mobile-nav-drawer" id="mobile-nav-drawer">
    <button class="mobile-nav-close" id="mobile-nav-close" aria-label="Close menu">
        <i class="fas fa-times"></i>
    </button>
    <div class="mobile-brand">
        <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo" style="width:70px;margin-bottom:10px;display:block;margin-left:auto;margin-right:auto;">
        <p>DIVINE WORD COLLEGE<br>OF URDANETA</p>
        <span>Administrative Portal</span>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="nav-item"><i class="fas fa-th-large"></i> Overview</a>
    <a href="{{ route('admin.faculty') }}" class="nav-item"><i class="fas fa-chalkboard-teacher"></i> Faculty Management</a>
    <a href="{{ route('admin.students') }}" class="nav-item"><i class="fas fa-user-graduate"></i> Student Records</a>
    <a href="{{ route('admin.announcements') }}" class="nav-item"><i class="fas fa-bullhorn"></i> Global Announcements</a>
    <a href="{{ route('admin.logs') }}" class="nav-item"><i class="fas fa-history"></i> System Audit Logs</a>
    <a href="{{ route('admin.settings') }}" class="nav-item active-drawer"><i class="fas fa-cog"></i> System Settings</a>
    <div class="mobile-logout">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" style="background:none;border:none;cursor:pointer;color:#fca5a5;font-weight:600;padding:10px;width:100%;font-family:'Afacad',sans-serif;">
                <i class="fas fa-sign-out-alt"></i> Log out
            </button>
        </form>
    </div>
</div>

<script src="{{ asset('js/admin-settings.js') }}"></script>
</body>
</html>
