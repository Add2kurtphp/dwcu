<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Profile | DWCU Admin Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    @vite(['resources/css/app.css'])
</head>
<body>

<div class="dashboard-wrapper">

    {{-- ── SIDEBAR ── --}}
    <aside class="sidebar-container" id="sidebar">
        <div class="sidebar-top-branding">
            <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo" class="school-logo-img" style="display:block;margin:0 auto 15px;">
            <div class="school-title-text">DIVINE WORD COLLEGE <br> OF URDANETA</div>
            <div class="portal-identity">Administrative Portal</div>
        </div>
        <nav class="nav-links-list">
            <a href="{{ route('admin.dashboard') }}"     class="nav-link-item"><i class="fas fa-th-large"></i> Overview</a>
            <a href="{{ route('admin.faculty') }}"       class="nav-link-item"><i class="fas fa-chalkboard-teacher"></i> Faculty Management</a>
            <a href="{{ route('admin.students') }}"      class="nav-link-item"><i class="fas fa-user-graduate"></i> Student Records</a>
            <a href="{{ route('admin.announcements') }}"  class="nav-link-item"><i class="fas fa-bullhorn"></i> Global Announcements</a>
            <a href="{{ route('admin.logs') }}"          class="nav-link-item"><i class="fas fa-history"></i> System Audit Logs</a>
            <a href="{{ route('admin.settings') }}"      class="nav-link-item"><i class="fas fa-cog"></i> System Settings</a>
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

    {{-- ── MAIN CONTENT ── --}}
    <main class="main-viewport-content">

        {{-- ── HEADER ── --}}
        <header class="top-nav-bar">
            <button class="hamburger-btn" id="hamburger-btn" aria-label="Open menu">
                <i class="fas fa-bars"></i>
            </button>
            <div class="header-title">
                <h1 style="font-size:2rem;font-weight:800;color:#0d1b44;margin:0 0 4px;">Administrator Profile</h1>
                <p style="font-size:0.85rem;color:#8892b0;margin:0;">Manage your account details and portal security.</p>
            </div>
            <a href="{{ route('admin.profile') }}" class="no-underline text-inherit">
                <div class="user-quick-profile">
                    <div class="profile-info">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <span class="user-role">System Administrator</span>
                    </div>
                    <div class="profile-icon"><i class="fas fa-user-shield"></i></div>
                </div>
            </a>
        </header>

        <div class="admin-content-grid">

            {{-- ══════════════════════════════════════════
                 PROFILE BANNER CARD
                 ══════════════════════════════════════════ --}}
            <section class="management-section-card" style="padding:0;overflow:hidden;border-radius:20px;">
                <div style="background:linear-gradient(135deg,#0d1b44,#1e2f7a);padding:36px 40px;display:flex;align-items:center;justify-content:space-between;gap:32px;flex-wrap:wrap;">

                    {{-- Avatar + Name --}}
                    <div style="display:flex;align-items:center;gap:24px;">

                        {{-- Avatar box --}}
                        <div id="profileAvatar"
                             style="position:relative;width:90px;height:90px;background:rgba(241,196,15,0.15);border:2px solid rgba(241,196,15,0.5);border-radius:20px;display:flex;align-items:center;justify-content:center;color:#f1c40f;font-size:1.7rem;font-weight:800;letter-spacing:2px;flex-shrink:0;cursor:pointer;overflow:hidden;">
                            <span id="avatarInitials" style="position:relative;z-index:1;pointer-events:none;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(strstr(Auth::user()->name, ' '), 1, 1)) }}
                            </span>
                            <img src="" alt="" id="avatarPhoto"
                                 style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;border-radius:18px;display:none;z-index:2;">
                            <div id="avatarUploadTrigger"
                                 style="position:absolute;inset:0;background:rgba(0,0,0,0.45);border-radius:18px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.1rem;opacity:0;transition:opacity 0.2s;z-index:3;">
                                <i class="fas fa-camera"></i>
                            </div>
                        </div>
                        <input type="file" id="avatarFileInput" accept="image/*" style="display:none;">

                        <div>
                            <h2 style="color:#fff;font-size:1.5rem;font-weight:800;margin:0 0 4px;">{{ Auth::user()->name }}</h2>
                            <p style="color:rgba(255,255,255,0.6);font-size:0.85rem;margin:0 0 12px;">System Administrator</p>
                            <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(46,125,50,0.2);border:1px solid rgba(46,125,50,0.4);color:#81c784;font-size:0.75rem;font-weight:700;padding:4px 12px;border-radius:20px;">
                                <span style="width:7px;height:7px;border-radius:50%;background:#81c784;display:inline-block;"></span> Active Account
                            </span>
                        </div>
                    </div>

                    {{-- Stats --}}
                    <div style="display:flex;gap:14px;flex-wrap:wrap;">

                        {{-- Employee ID --}}
                        <div style="display:flex;align-items:center;gap:12px;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);border-radius:14px;padding:14px 20px;min-width:175px;">
                            <div style="width:38px;height:38px;background:rgba(241,196,15,0.12);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#f1c40f;font-size:0.9rem;flex-shrink:0;">
                                <i class="fas fa-id-badge"></i>
                            </div>
                            <div>
                                <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:rgba(255,255,255,0.45);margin-bottom:3px;">Employee ID</div>
                                <div style="font-size:0.85rem;font-weight:700;color:#fff;">DWCU-ADM-2026-001</div>
                            </div>
                        </div>

                        {{-- Access Level --}}
                        <div style="display:flex;align-items:center;gap:12px;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);border-radius:14px;padding:14px 20px;min-width:175px;">
                            <div style="width:38px;height:38px;background:rgba(241,196,15,0.12);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#f1c40f;font-size:0.9rem;flex-shrink:0;">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <div>
                                <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:rgba(255,255,255,0.45);margin-bottom:3px;">Access Level</div>
                                <div style="font-size:0.85rem;font-weight:700;color:#fff;">Super Administrator</div>
                            </div>
                        </div>

                        {{-- Last Login --}}
                        <div style="display:flex;align-items:center;gap:12px;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);border-radius:14px;padding:14px 20px;min-width:175px;">
                            <div style="width:38px;height:38px;background:rgba(241,196,15,0.12);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#f1c40f;font-size:0.9rem;flex-shrink:0;">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:rgba(255,255,255,0.45);margin-bottom:3px;">Last Login</div>
                                <div style="font-size:0.85rem;font-weight:700;color:#fff;">{{ Auth::user()->updated_at->format('M d, Y · g:i A') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ══════════════════════════════════════════
                 PERSONAL INFORMATION
                 ══════════════════════════════════════════ --}}
            <section class="management-section-card">

                {{-- Section header --}}
                <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;">
                    <div style="display:flex;align-items:center;gap:14px;">
                        <div style="width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.05rem;flex-shrink:0;color:#f1c40f;background:linear-gradient(135deg,#1e2f7a,#0d1b44);">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h3 style="font-size:1rem;font-weight:700;color:#0d1b44;margin:0 0 3px;">Personal Information</h3>
                            <p style="font-size:0.8rem;color:#8892b0;margin:0;">Update your display name and contact details.</p>
                        </div>
                    </div>
                    <button type="submit" form="profileForm" id="saveProfileBtn"
                            style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#f1c40f,#d4ac0d);color:#0d1b44;border:none;padding:11px 22px;border-radius:12px;font-family:'Afacad',sans-serif;font-weight:700;font-size:0.9rem;cursor:pointer;white-space:nowrap;flex-shrink:0;box-shadow:0 4px 12px rgba(241,196,15,0.25);transition:transform 0.2s,box-shadow 0.2s;"
                            onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 18px rgba(241,196,15,0.4)'"
                            onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 12px rgba(241,196,15,0.25)'">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>

                @if (session('profile_success'))
                    <div class="flex items-center gap-2 bg-green-50 border border-green-300 text-green-800 rounded-xl px-4 py-2.5 text-sm font-semibold mb-4">
                        <i class="fas fa-check-circle"></i>{{ session('profile_success') }}
                    </div>
                @endif
                @error('name')
                    <div class="flex items-center gap-2 bg-red-50 border border-red-300 text-red-700 rounded-xl px-4 py-2.5 text-sm font-semibold mb-4">
                        <i class="fas fa-exclamation-circle"></i>{{ $message }}
                    </div>
                @enderror
                @error('email')
                    <div class="flex items-center gap-2 bg-red-50 border border-red-300 text-red-700 rounded-xl px-4 py-2.5 text-sm font-semibold mb-4">
                        <i class="fas fa-exclamation-circle"></i>{{ $message }}
                    </div>
                @enderror

                <form id="profileForm" method="POST" action="{{ route('admin.profile.update') }}"
                      style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">
                    @csrf
                    @method('PATCH')

                    {{-- Full Name --}}
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label style="font-size:0.82rem;font-weight:700;color:#2d3a5e;">Full Name</label>
                        <div style="position:relative;display:flex;align-items:center;">
                            <i class="fas fa-user" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;z-index:1;"></i>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required
                                   style="width:100%;padding:11px 14px 11px 36px;border:1.5px solid #e0e4f0;border-radius:10px;font-size:0.9rem;color:#0d1b44;background:#fafbff;outline:none;font-family:'Afacad',sans-serif;transition:border-color 0.2s,box-shadow 0.2s;"
                                   onfocus="this.style.borderColor='#1e2f7a';this.style.boxShadow='0 0 0 3px rgba(30,47,122,0.1)';this.style.background='#fff'"
                                   onblur="this.style.borderColor='#e0e4f0';this.style.boxShadow='none';this.style.background='#fafbff'">
                        </div>
                    </div>

                    {{-- Email --}}
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label style="font-size:0.82rem;font-weight:700;color:#2d3a5e;">Email Address</label>
                        <div style="position:relative;display:flex;align-items:center;">
                            <i class="fas fa-envelope" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;z-index:1;"></i>
                            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                                   style="width:100%;padding:11px 14px 11px 36px;border:1.5px solid #e0e4f0;border-radius:10px;font-size:0.9rem;color:#0d1b44;background:#fafbff;outline:none;font-family:'Afacad',sans-serif;transition:border-color 0.2s,box-shadow 0.2s;"
                                   onfocus="this.style.borderColor='#1e2f7a';this.style.boxShadow='0 0 0 3px rgba(30,47,122,0.1)';this.style.background='#fff'"
                                   onblur="this.style.borderColor='#e0e4f0';this.style.boxShadow='none';this.style.background='#fafbff'">
                        </div>
                    </div>

                    {{-- Employee ID (readonly) --}}
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label style="font-size:0.82rem;font-weight:700;color:#2d3a5e;">Employee ID</label>
                        <div style="position:relative;display:flex;align-items:center;">
                            <i class="fas fa-id-badge" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;z-index:1;"></i>
                            <input type="text" value="DWCU-ADM-2026-001" readonly
                                   style="width:100%;padding:11px 14px 11px 36px;border:1.5px solid #e0e4f0;border-radius:10px;font-size:0.9rem;color:#8892b0;background:#f0f2f8;cursor:not-allowed;font-family:'Afacad',sans-serif;">
                        </div>
                    </div>

                    {{-- Access Level (readonly) --}}
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label style="font-size:0.82rem;font-weight:700;color:#2d3a5e;">Access Level</label>
                        <div style="position:relative;display:flex;align-items:center;">
                            <i class="fas fa-user-shield" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;z-index:1;"></i>
                            <input type="text" value="Super Administrator" readonly
                                   style="width:100%;padding:11px 14px 11px 36px;border:1.5px solid #e0e4f0;border-radius:10px;font-size:0.9rem;color:#8892b0;background:#f0f2f8;cursor:not-allowed;font-family:'Afacad',sans-serif;">
                        </div>
                    </div>
                </form>
            </section>

            {{-- ══════════════════════════════════════════
                 SECURITY & PASSWORD
                 ══════════════════════════════════════════ --}}
            <section class="management-section-card">

                {{-- Section header --}}
                <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;">
                    <div style="display:flex;align-items:center;gap:14px;">
                        <div style="width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.05rem;flex-shrink:0;color:#0d1b44;background:linear-gradient(135deg,#f1c40f,#d4ac0d);">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div>
                            <h3 style="font-size:1rem;font-weight:700;color:#0d1b44;margin:0 0 3px;">Security &amp; Password</h3>
                            <p style="font-size:0.8rem;color:#8892b0;margin:0;">Change your password regularly to keep the portal secure.</p>
                        </div>
                    </div>
                    <button type="submit" form="passwordForm" id="savePasswordBtn"
                            style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#f1c40f,#d4ac0d);color:#0d1b44;border:none;padding:11px 22px;border-radius:12px;font-family:'Afacad',sans-serif;font-weight:700;font-size:0.9rem;cursor:pointer;white-space:nowrap;flex-shrink:0;box-shadow:0 4px 12px rgba(241,196,15,0.25);transition:transform 0.2s,box-shadow 0.2s;"
                            onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 18px rgba(241,196,15,0.4)'"
                            onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 12px rgba(241,196,15,0.25)'">
                        <i class="fas fa-key"></i> Change Password
                    </button>
                </div>

                @if (session('password_success'))
                    <div class="flex items-center gap-2 bg-green-50 border border-green-300 text-green-800 rounded-xl px-4 py-2.5 text-sm font-semibold mb-4">
                        <i class="fas fa-check-circle"></i>{{ session('password_success') }}
                    </div>
                @endif
                @error('current_password')
                    <div class="flex items-center gap-2 bg-red-50 border border-red-300 text-red-700 rounded-xl px-4 py-2.5 text-sm font-semibold mb-4">
                        <i class="fas fa-exclamation-circle"></i>{{ $message }}
                    </div>
                @enderror
                @error('new_password')
                    <div class="flex items-center gap-2 bg-red-50 border border-red-300 text-red-700 rounded-xl px-4 py-2.5 text-sm font-semibold mb-4">
                        <i class="fas fa-exclamation-circle"></i>{{ $message }}
                    </div>
                @enderror

                <form id="passwordForm" method="POST" action="{{ route('admin.profile.password') }}"
                      style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">
                    @csrf
                    @method('PATCH')

                    {{-- Current Password (full width) --}}
                    <div style="display:flex;flex-direction:column;gap:6px;grid-column:span 2;">
                        <label style="font-size:0.82rem;font-weight:700;color:#2d3a5e;">Current Password</label>
                        <div style="position:relative;display:flex;align-items:center;">
                            <i class="fas fa-lock" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;z-index:1;"></i>
                            <input type="password" name="current_password" id="currentPassword"
                                   placeholder="Enter your current password"
                                   style="width:100%;padding:11px 42px 11px 36px;border:1.5px solid #e0e4f0;border-radius:10px;font-size:0.9rem;color:#0d1b44;background:#fafbff;outline:none;font-family:'Afacad',sans-serif;transition:border-color 0.2s,box-shadow 0.2s;"
                                   onfocus="this.style.borderColor='#1e2f7a';this.style.boxShadow='0 0 0 3px rgba(30,47,122,0.1)';this.style.background='#fff'"
                                   onblur="this.style.borderColor='#e0e4f0';this.style.boxShadow='none';this.style.background='#fafbff'">
                            <button type="button" class="pw-eye"
                                    style="position:absolute;right:12px;background:none;border:none;color:#8892b0;cursor:pointer;font-size:0.85rem;padding:4px;z-index:1;"
                                    data-target="currentPassword"
                                    onmouseover="this.style.color='#1e2f7a'" onmouseout="this.style.color='#8892b0'">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    {{-- New Password --}}
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label style="font-size:0.82rem;font-weight:700;color:#2d3a5e;">New Password</label>
                        <div style="position:relative;display:flex;align-items:center;">
                            <i class="fas fa-lock" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;z-index:1;"></i>
                            <input type="password" name="new_password" id="newPassword"
                                   placeholder="Minimum 8 characters"
                                   style="width:100%;padding:11px 42px 11px 36px;border:1.5px solid #e0e4f0;border-radius:10px;font-size:0.9rem;color:#0d1b44;background:#fafbff;outline:none;font-family:'Afacad',sans-serif;transition:border-color 0.2s,box-shadow 0.2s;"
                                   onfocus="this.style.borderColor='#1e2f7a';this.style.boxShadow='0 0 0 3px rgba(30,47,122,0.1)';this.style.background='#fff'"
                                   onblur="this.style.borderColor='#e0e4f0';this.style.boxShadow='none';this.style.background='#fafbff'">
                            <button type="button" class="pw-eye"
                                    style="position:absolute;right:12px;background:none;border:none;color:#8892b0;cursor:pointer;font-size:0.85rem;padding:4px;z-index:1;"
                                    data-target="newPassword"
                                    onmouseover="this.style.color='#1e2f7a'" onmouseout="this.style.color='#8892b0'">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Confirm Password --}}
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label style="font-size:0.82rem;font-weight:700;color:#2d3a5e;">Confirm New Password</label>
                        <div style="position:relative;display:flex;align-items:center;">
                            <i class="fas fa-lock" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;z-index:1;"></i>
                            <input type="password" name="new_password_confirmation" id="confirmPassword"
                                   placeholder="Re-type new password"
                                   style="width:100%;padding:11px 42px 11px 36px;border:1.5px solid #e0e4f0;border-radius:10px;font-size:0.9rem;color:#0d1b44;background:#fafbff;outline:none;font-family:'Afacad',sans-serif;transition:border-color 0.2s,box-shadow 0.2s;"
                                   onfocus="this.style.borderColor='#1e2f7a';this.style.boxShadow='0 0 0 3px rgba(30,47,122,0.1)';this.style.background='#fff'"
                                   onblur="this.style.borderColor='#e0e4f0';this.style.boxShadow='none';this.style.background='#fafbff'">
                            <button type="button" class="pw-eye"
                                    style="position:absolute;right:12px;background:none;border:none;color:#8892b0;cursor:pointer;font-size:0.85rem;padding:4px;z-index:1;"
                                    data-target="confirmPassword"
                                    onmouseover="this.style.color='#1e2f7a'" onmouseout="this.style.color='#8892b0'">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </section>

        </div>{{-- end admin-content-grid --}}
    </main>
</div>

{{-- ── Mobile nav overlay + drawer ── --}}
<div class="mobile-nav-overlay" id="mobile-nav-overlay"></div>
<div class="mobile-nav-drawer" id="mobile-nav-drawer">
    <button class="mobile-nav-close" id="mobile-nav-close" aria-label="Close menu">
        <i class="fas fa-times"></i>
    </button>
    <div class="mobile-brand">
        <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo"
             style="width:70px;margin:0 auto 10px;display:block;">
        <p>DIVINE WORD COLLEGE<br>OF URDANETA</p>
        <span>Administrative Portal</span>
    </div>
    <a href="{{ route('admin.dashboard') }}"     class="nav-item"><i class="fas fa-th-large"></i> Overview</a>
    <a href="{{ route('admin.faculty') }}"       class="nav-item"><i class="fas fa-chalkboard-teacher"></i> Faculty Management</a>
    <a href="{{ route('admin.students') }}"      class="nav-item"><i class="fas fa-user-graduate"></i> Student Records</a>
    <a href="{{ route('admin.announcements') }}"  class="nav-item"><i class="fas fa-bullhorn"></i> Global Announcements</a>
    <a href="{{ route('admin.logs') }}"          class="nav-item"><i class="fas fa-history"></i> System Audit Logs</a>
    <a href="{{ route('admin.settings') }}"      class="nav-item"><i class="fas fa-cog"></i> System Settings</a>
    <div class="mobile-logout">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit"
                    style="background:none;border:none;cursor:pointer;color:#fca5a5;font-weight:600;padding:10px;width:100%;border-radius:8px;">
                <i class="fas fa-sign-out-alt"></i> Log out
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Mobile nav drawer ─────────────────────────────────────
    var hamburgerBtn = document.getElementById('hamburger-btn');
    var overlay      = document.getElementById('mobile-nav-overlay');
    var drawer       = document.getElementById('mobile-nav-drawer');
    var mobileClose  = document.getElementById('mobile-nav-close');

    function openDrawer()  { drawer.classList.add('open');    overlay.classList.add('open'); }
    function closeDrawer() { drawer.classList.remove('open'); overlay.classList.remove('open'); }

    if (hamburgerBtn) hamburgerBtn.addEventListener('click', openDrawer);
    if (mobileClose)  mobileClose.addEventListener('click', closeDrawer);
    if (overlay)      overlay.addEventListener('click', closeDrawer);

    // ── Avatar photo upload ───────────────────────────────────
    var avatarBox      = document.getElementById('profileAvatar');
    var avatarTrigger  = document.getElementById('avatarUploadTrigger');
    var avatarInput    = document.getElementById('avatarFileInput');
    var avatarPhoto    = document.getElementById('avatarPhoto');
    var avatarInitials = document.getElementById('avatarInitials');

    if (avatarBox) {
        avatarBox.addEventListener('mouseenter', function () {
            avatarTrigger.style.opacity = '1';
        });
        avatarBox.addEventListener('mouseleave', function () {
            if (!avatarPhoto.classList.contains('loaded')) {
                avatarTrigger.style.opacity = '0';
            }
        });
        avatarTrigger.addEventListener('click', function () {
            avatarInput.click();
        });
    }

    if (avatarInput) {
        avatarInput.addEventListener('change', function () {
            var file = this.files[0];
            if (!file) return;
            var reader = new FileReader();
            reader.onload = function (e) {
                avatarPhoto.src = e.target.result;
                avatarPhoto.classList.remove('hidden');
                avatarPhoto.classList.add('loaded');
                avatarInitials.style.display = 'none';
                avatarTrigger.style.opacity  = '1';
            };
            reader.readAsDataURL(file);
        });
    }

    // ── Password eye toggles ──────────────────────────────────
    document.querySelectorAll('.pw-eye').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = document.getElementById(btn.dataset.target);
            var icon  = btn.querySelector('i');
            if (input.type === 'password') {
                input.type     = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                input.type     = 'password';
                icon.className = 'fas fa-eye';
            }
        });
    });
});
</script>

</body>
</html>
