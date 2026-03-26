<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Profile | DWCU Faculty Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    @vite(['resources/css/app.css'])
    <style>
        /* Faculty portal accent override: neon green instead of gold */
        .portal-identity          { color: #ccff00 !important; }
        .nav-link-item.active     { background: #ccff00 !important; color: #0d1b44 !important; box-shadow: 0 4px 15px rgba(204,255,0,0.2) !important; border-left-color: #0d1b44 !important; }
        .mobile-nav-drawer .nav-item.active-drawer { background: #ccff00 !important; color: #0d1b44 !important; }
    </style>
</head>
<body>

<div class="dashboard-wrapper">

    {{-- ── SIDEBAR ── --}}
    <aside class="sidebar-container" id="sidebar">
        <div class="sidebar-top-branding">
            <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo"
                 class="school-logo-img" style="display:block;margin:0 auto 15px;">
            <div class="school-title-text">DIVINE WORD COLLEGE <br> OF URDANETA</div>
            <div class="portal-identity">Faculty Portal</div>
        </div>
        <nav class="nav-links-list">
            <a href="{{ route('faculty.students') }}"      class="nav-link-item"><i class="fas fa-users"></i> Student List</a>
            <a href="{{ route('faculty.calendar') }}"      class="nav-link-item"><i class="fas fa-calendar-alt"></i> Calendar</a>
            <a href="{{ route('faculty.gradebook') }}"     class="nav-link-item"><i class="fas fa-book-open"></i> Gradebook</a>
            <a href="{{ route('faculty.announcements') }}" class="nav-link-item"><i class="fas fa-bullhorn"></i> Announcement</a>
            <a href="{{ route('faculty.logs') }}"          class="nav-link-item"><i class="fas fa-history"></i> Activity Logs</a>
        </nav>
        <div class="sidebar-footer-action">
            <form method="POST" action="{{ route('faculty.logout') }}">
                @csrf
                <button type="submit" class="exit-system-link"
                        style="background:none;border:none;cursor:pointer;width:100%;">
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
                <h1 style="font-size:1.6rem;font-weight:800;color:#0d1b44;margin:0 0 4px;">Faculty Profile</h1>
                <p style="font-size:0.82rem;color:#8892b0;margin:0;">Manage your account details and security settings.</p>
            </div>
            <div class="user-quick-profile">
                <div class="profile-info">
                    <span class="user-name">{{ session('faculty_name') }}</span>
                    <span class="user-role">Faculty Member</span>
                </div>
                <div class="profile-icon" style="width:36px;height:36px;background:linear-gradient(135deg,#1e2f7a,#0d1b44);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#ccff00;font-size:0.95rem;">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
            </div>
        </header>

        <div class="admin-content-grid">

            {{-- ══════════════════════════════════════════
                 PROFILE BANNER
                 ══════════════════════════════════════════ --}}
            <section class="management-section-card" style="padding:0;overflow:hidden;border-radius:20px;">
                <div style="background:linear-gradient(135deg,#0d1b44,#1e2f7a);padding:28px 30px;display:flex;align-items:center;justify-content:space-between;gap:24px;flex-wrap:wrap;">

                    {{-- Avatar + Name --}}
                    <div style="display:flex;align-items:center;gap:20px;">

                        {{-- Avatar box --}}
                        <div id="profileAvatar"
                             style="position:relative;width:70px;height:70px;background:rgba(204,255,0,0.15);border:2px solid rgba(204,255,0,0.5);border-radius:18px;display:flex;align-items:center;justify-content:center;color:#ccff00;font-size:1.3rem;font-weight:800;flex-shrink:0;cursor:pointer;overflow:hidden;">
                            <span id="avatarInitials" style="position:relative;z-index:1;pointer-events:none;">
                                {{ strtoupper(substr(session('faculty_name','?'), 0, 1)) }}{{ strtoupper(substr(strstr(session('faculty_name',''), ' '), 1, 1)) }}
                            </span>
                            <img src="" alt="" id="avatarPhoto"
                                 style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;border-radius:16px;display:none;z-index:2;">
                            <div id="avatarUploadTrigger"
                                 style="position:absolute;inset:0;background:rgba(0,0,0,0.45);border-radius:16px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1rem;opacity:0;transition:opacity 0.2s;z-index:3;">
                                <i class="fas fa-camera"></i>
                            </div>
                        </div>
                        <input type="file" id="avatarFileInput" accept="image/*" style="display:none;">

                        <div>
                            <h2 style="color:#fff;font-size:1.2rem;font-weight:800;margin:0 0 4px;">{{ session('faculty_name') }}</h2>
                            <p style="color:rgba(255,255,255,0.6);font-size:0.82rem;margin:0 0 10px;">{{ $faculty->designation ?? 'Faculty' }} · {{ $faculty->department ?? '' }}</p>
                            <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(46,125,50,0.2);border:1px solid rgba(46,125,50,0.4);color:#81c784;font-size:0.73rem;font-weight:700;padding:3px 10px;border-radius:20px;">
                                <span style="width:6px;height:6px;border-radius:50%;background:#81c784;display:inline-block;"></span> Active Account
                            </span>
                        </div>
                    </div>

                    {{-- Stats --}}
                    <div style="display:flex;gap:10px;flex-wrap:wrap;">

                        {{-- Employee ID --}}
                        <div style="display:flex;align-items:center;gap:10px;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);border-radius:12px;padding:10px 16px;min-width:155px;">
                            <div style="width:34px;height:34px;background:rgba(204,255,0,0.12);border-radius:9px;display:flex;align-items:center;justify-content:center;color:#ccff00;font-size:0.82rem;flex-shrink:0;">
                                <i class="fas fa-id-badge"></i>
                            </div>
                            <div>
                                <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:rgba(255,255,255,0.45);margin-bottom:2px;">Employee ID</div>
                                <div style="font-size:0.82rem;font-weight:700;color:#fff;">{{ $faculty->faculty_id ?? '—' }}</div>
                            </div>
                        </div>

                        {{-- Subject / Dept --}}
                        <div style="display:flex;align-items:center;gap:10px;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);border-radius:12px;padding:10px 16px;min-width:155px;">
                            <div style="width:34px;height:34px;background:rgba(204,255,0,0.12);border-radius:9px;display:flex;align-items:center;justify-content:center;color:#ccff00;font-size:0.82rem;flex-shrink:0;">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <div>
                                <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:rgba(255,255,255,0.45);margin-bottom:2px;">Department</div>
                                <div style="font-size:0.82rem;font-weight:700;color:#fff;white-space:nowrap;">{{ $faculty->department ?? '—' }}</div>
                            </div>
                        </div>

                        {{-- Last Login --}}
                        <div style="display:flex;align-items:center;gap:10px;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);border-radius:12px;padding:10px 16px;min-width:155px;">
                            <div style="width:34px;height:34px;background:rgba(204,255,0,0.12);border-radius:9px;display:flex;align-items:center;justify-content:center;color:#ccff00;font-size:0.82rem;flex-shrink:0;">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:rgba(255,255,255,0.45);margin-bottom:2px;">Last Login</div>
                                <div style="font-size:0.82rem;font-weight:700;color:#fff;">{{ now()->format('M d, Y · g:i A') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ══════════════════════════════════════════
                 PERSONAL INFORMATION
                 ══════════════════════════════════════════ --}}
            <section class="management-section-card">

                <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;">
                    <div style="display:flex;align-items:center;gap:14px;">
                        <div style="width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.05rem;flex-shrink:0;color:#ccff00;background:linear-gradient(135deg,#1e2f7a,#0d1b44);">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h3 style="font-size:1rem;font-weight:700;color:#0d1b44;margin:0 0 3px;">Personal Information</h3>
                            <p style="font-size:0.8rem;color:#8892b0;margin:0;">Update your display name and contact details.</p>
                        </div>
                    </div>
                    <button type="submit" form="profileForm" id="saveProfileBtn"
                            style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#ccff00,#a8d400);color:#0d1b44;border:none;padding:11px 22px;border-radius:12px;font-family:'Afacad',sans-serif;font-weight:700;font-size:0.9rem;cursor:pointer;white-space:nowrap;flex-shrink:0;box-shadow:0 4px 12px rgba(204,255,0,0.25);transition:transform 0.2s,box-shadow 0.2s;"
                            onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 18px rgba(204,255,0,0.4)'"
                            onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 12px rgba(204,255,0,0.25)'">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>

                @if (session('profile_success'))
                    <div class="flex items-center gap-2 bg-green-50 border border-green-300 text-green-800 rounded-xl px-4 py-2.5 text-sm font-semibold mb-4">
                        <i class="fas fa-check-circle mr-1"></i>{{ session('profile_success') }}
                    </div>
                @endif
                @error('name')
                    <div class="flex items-center gap-2 bg-red-50 border border-red-300 text-red-700 rounded-xl px-4 py-2.5 text-sm font-semibold mb-4">
                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                    </div>
                @enderror

                <form id="profileForm" method="POST" action="{{ route('faculty.profile.update') }}"
                      style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">
                    @csrf
                    @method('PATCH')

                    {{-- Full Name --}}
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label style="font-size:0.82rem;font-weight:700;color:#2d3a5e;">Full Name</label>
                        <div style="position:relative;display:flex;align-items:center;">
                            <i class="fas fa-user" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;z-index:1;"></i>
                            <input type="text" name="name" value="{{ old('name', $faculty->name) }}" required
                                   style="width:100%;padding:11px 14px 11px 36px;border:1.5px solid #e0e4f0;border-radius:10px;font-size:0.9rem;color:#0d1b44;background:#fafbff;outline:none;font-family:'Afacad',sans-serif;transition:border-color 0.2s,box-shadow 0.2s;"
                                   onfocus="this.style.borderColor='#1e2f7a';this.style.boxShadow='0 0 0 3px rgba(30,47,122,0.1)';this.style.background='#fff'"
                                   onblur="this.style.borderColor='#e0e4f0';this.style.boxShadow='none';this.style.background='#fafbff'">
                        </div>
                    </div>

                    {{-- Designation --}}
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label style="font-size:0.82rem;font-weight:700;color:#2d3a5e;">Designation</label>
                        <div style="position:relative;display:flex;align-items:center;">
                            <i class="fas fa-chalkboard-teacher" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;z-index:1;"></i>
                            <input type="text" name="designation" value="{{ old('designation', $faculty->designation) }}"
                                   style="width:100%;padding:11px 14px 11px 36px;border:1.5px solid #e0e4f0;border-radius:10px;font-size:0.9rem;color:#0d1b44;background:#fafbff;outline:none;font-family:'Afacad',sans-serif;transition:border-color 0.2s,box-shadow 0.2s;"
                                   onfocus="this.style.borderColor='#1e2f7a';this.style.boxShadow='0 0 0 3px rgba(30,47,122,0.1)';this.style.background='#fff'"
                                   onblur="this.style.borderColor='#e0e4f0';this.style.boxShadow='none';this.style.background='#fafbff'">
                        </div>
                    </div>

                    {{-- Department --}}
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label style="font-size:0.82rem;font-weight:700;color:#2d3a5e;">Department</label>
                        <div style="position:relative;display:flex;align-items:center;">
                            <i class="fas fa-book-open" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;z-index:1;"></i>
                            <input type="text" name="department" value="{{ old('department', $faculty->department) }}"
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
                            <input type="text" value="{{ $faculty->faculty_id }}" readonly
                                   style="width:100%;padding:11px 14px 11px 36px;border:1.5px solid #e0e4f0;border-radius:10px;font-size:0.9rem;color:#8892b0;background:#f0f2f8;cursor:not-allowed;font-family:'Afacad',sans-serif;">
                        </div>
                    </div>

                    {{-- Status (readonly) --}}
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label style="font-size:0.82rem;font-weight:700;color:#2d3a5e;">Account Status</label>
                        <div style="position:relative;display:flex;align-items:center;">
                            <i class="fas fa-circle-check" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;z-index:1;"></i>
                            <input type="text" value="{{ ucfirst($faculty->status) }}" readonly
                                   style="width:100%;padding:11px 14px 11px 36px;border:1.5px solid #e0e4f0;border-radius:10px;font-size:0.9rem;color:#8892b0;background:#f0f2f8;cursor:not-allowed;font-family:'Afacad',sans-serif;">
                        </div>
                    </div>
                </form>
            </section>

            {{-- ══════════════════════════════════════════
                 SECURITY & PASSWORD
                 ══════════════════════════════════════════ --}}
            <section class="management-section-card">

                <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;">
                    <div style="display:flex;align-items:center;gap:14px;">
                        <div style="width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.05rem;flex-shrink:0;color:#0d1b44;background:linear-gradient(135deg,#ccff00,#a8d400);">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div>
                            <h3 style="font-size:1rem;font-weight:700;color:#0d1b44;margin:0 0 3px;">Security &amp; Password</h3>
                            <p style="font-size:0.8rem;color:#8892b0;margin:0;">Change your password regularly to keep your account secure.</p>
                        </div>
                    </div>
                    <button type="submit" form="passwordForm" id="savePasswordBtn"
                            style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#ccff00,#a8d400);color:#0d1b44;border:none;padding:11px 22px;border-radius:12px;font-family:'Afacad',sans-serif;font-weight:700;font-size:0.9rem;cursor:pointer;white-space:nowrap;flex-shrink:0;box-shadow:0 4px 12px rgba(204,255,0,0.25);transition:transform 0.2s,box-shadow 0.2s;"
                            onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 18px rgba(204,255,0,0.4)'"
                            onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 12px rgba(204,255,0,0.25)'">
                        <i class="fas fa-key"></i> Change Password
                    </button>
                </div>

                @if (session('password_success'))
                    <div class="flex items-center gap-2 bg-green-50 border border-green-300 text-green-800 rounded-xl px-4 py-2.5 text-sm font-semibold mb-4">
                        <i class="fas fa-check-circle mr-1"></i>{{ session('password_success') }}
                    </div>
                @endif
                @error('current_password')
                    <div class="flex items-center gap-2 bg-red-50 border border-red-300 text-red-700 rounded-xl px-4 py-2.5 text-sm font-semibold mb-4">
                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                    </div>
                @enderror
                @error('new_password')
                    <div class="flex items-center gap-2 bg-red-50 border border-red-300 text-red-700 rounded-xl px-4 py-2.5 text-sm font-semibold mb-4">
                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                    </div>
                @enderror

                <form id="passwordForm" method="POST" action="{{ route('faculty.profile.password') }}"
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
        <span>Faculty Portal</span>
    </div>
    <a href="{{ route('faculty.students') }}"      class="nav-item"><i class="fas fa-users"></i> Student List</a>
    <a href="{{ route('faculty.calendar') }}"      class="nav-item"><i class="fas fa-calendar-alt"></i> Calendar</a>
    <a href="{{ route('faculty.gradebook') }}"     class="nav-item"><i class="fas fa-book-open"></i> Gradebook</a>
    <a href="{{ route('faculty.announcements') }}" class="nav-item"><i class="fas fa-bullhorn"></i> Announcement</a>
    <a href="{{ route('faculty.logs') }}"          class="nav-item"><i class="fas fa-history"></i> Activity Logs</a>
    <div class="mobile-logout">
        <form method="POST" action="{{ route('faculty.logout') }}">
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

    // ── Mobile nav drawer ──────────────────────────────────────
    var hamburgerBtn = document.getElementById('hamburger-btn');
    var overlay      = document.getElementById('mobile-nav-overlay');
    var drawer       = document.getElementById('mobile-nav-drawer');
    var mobileClose  = document.getElementById('mobile-nav-close');

    function openDrawer()  { drawer.classList.add('open');    overlay.classList.add('open'); }
    function closeDrawer() { drawer.classList.remove('open'); overlay.classList.remove('open'); }

    if (hamburgerBtn) hamburgerBtn.addEventListener('click', openDrawer);
    if (mobileClose)  mobileClose.addEventListener('click', closeDrawer);
    if (overlay)      overlay.addEventListener('click', closeDrawer);

    // ── Avatar photo upload ────────────────────────────────────
    var avatarBox      = document.getElementById('profileAvatar');
    var avatarTrigger  = document.getElementById('avatarUploadTrigger');
    var avatarInput    = document.getElementById('avatarFileInput');
    var avatarPhoto    = document.getElementById('avatarPhoto');
    var avatarInitials = document.getElementById('avatarInitials');

    if (avatarBox) {
        avatarBox.addEventListener('mouseenter', function () { avatarTrigger.style.opacity = '1'; });
        avatarBox.addEventListener('mouseleave', function () {
            if (!avatarPhoto.classList.contains('loaded')) avatarTrigger.style.opacity = '0';
        });
        avatarTrigger.addEventListener('click', function () { avatarInput.click(); });
    }

    if (avatarInput) {
        avatarInput.addEventListener('change', function () {
            var file = this.files[0];
            if (!file) return;
            var reader = new FileReader();
            reader.onload = function (e) {
                avatarPhoto.src = e.target.result;
                avatarPhoto.style.display = 'block';
                avatarPhoto.classList.add('loaded');
                avatarInitials.style.display = 'none';
                avatarTrigger.style.opacity  = '1';
            };
            reader.readAsDataURL(file);
        });
    }

    // ── Password eye toggles ───────────────────────────────────
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


{{-- ══════════════════════════════════════════
     SUCCESS MODAL — PERSONAL INFO
     ══════════════════════════════════════════ --}}
<div id="profileModal" style="display:none;position:fixed;inset:0;z-index:9999;align-items:center;justify-content:center;">
    {{-- Backdrop --}}
    <div style="position:absolute;inset:0;background:rgba(13,27,68,0.55);backdrop-filter:blur(4px);" onclick="closeProfileModal()"></div>
    {{-- Card --}}
    <div style="position:relative;background:#fff;border-radius:24px;padding:40px 36px 32px;max-width:400px;width:90%;box-shadow:0 24px 60px rgba(13,27,68,0.22);text-align:center;animation:modalPop 0.35s cubic-bezier(.34,1.56,.64,1) both;">
        {{-- Icon --}}
        <div style="width:68px;height:68px;background:linear-gradient(135deg,#ccff00,#a8d400);border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;box-shadow:0 8px 24px rgba(204,255,0,0.35);">
            <i class="fas fa-user-check" style="font-size:1.6rem;color:#0d1b44;"></i>
        </div>
        <h3 style="font-size:1.25rem;font-weight:800;color:#0d1b44;margin:0 0 8px;">Profile Updated!</h3>
        <p style="font-size:0.88rem;color:#8892b0;margin:0 0 28px;line-height:1.6;">Your personal information has been saved successfully.</p>
        {{-- Divider --}}
        <div style="height:1px;background:linear-gradient(90deg,transparent,#e0e4f0,transparent);margin-bottom:24px;"></div>
        <button onclick="closeProfileModal()" style="background:linear-gradient(135deg,#ccff00,#a8d400);color:#0d1b44;border:none;padding:12px 32px;border-radius:12px;font-family:'Afacad',sans-serif;font-weight:700;font-size:0.95rem;cursor:pointer;box-shadow:0 4px 14px rgba(204,255,0,0.3);transition:transform 0.2s;"
                onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            Got it
        </button>
    </div>
</div>

{{-- ══════════════════════════════════════════
     SUCCESS MODAL — PASSWORD
     ══════════════════════════════════════════ --}}
<div id="passwordModal" style="display:none;position:fixed;inset:0;z-index:9999;align-items:center;justify-content:center;">
    {{-- Backdrop --}}
    <div style="position:absolute;inset:0;background:rgba(13,27,68,0.55);backdrop-filter:blur(4px);" onclick="closePasswordModal()"></div>
    {{-- Card --}}
    <div style="position:relative;background:#fff;border-radius:24px;padding:40px 36px 32px;max-width:400px;width:90%;box-shadow:0 24px 60px rgba(13,27,68,0.22);text-align:center;animation:modalPop 0.35s cubic-bezier(.34,1.56,.64,1) both;">
        {{-- Icon --}}
        <div style="width:68px;height:68px;background:linear-gradient(135deg,#1e2f7a,#0d1b44);border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;box-shadow:0 8px 24px rgba(30,47,122,0.3);">
            <i class="fas fa-shield-alt" style="font-size:1.6rem;color:#ccff00;"></i>
        </div>
        <h3 style="font-size:1.25rem;font-weight:800;color:#0d1b44;margin:0 0 8px;">Password Changed!</h3>
        <p style="font-size:0.88rem;color:#8892b0;margin:0 0 28px;line-height:1.6;">Your password has been updated successfully. Keep it safe!</p>
        {{-- Divider --}}
        <div style="height:1px;background:linear-gradient(90deg,transparent,#e0e4f0,transparent);margin-bottom:24px;"></div>
        <button onclick="closePasswordModal()" style="background:linear-gradient(135deg,#1e2f7a,#0d1b44);color:#ccff00;border:none;padding:12px 32px;border-radius:12px;font-family:'Afacad',sans-serif;font-weight:700;font-size:0.95rem;cursor:pointer;box-shadow:0 4px 14px rgba(13,27,68,0.25);transition:transform 0.2s;"
                onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            Got it
        </button>
    </div>
</div>

<style>
@keyframes modalPop {
    from { opacity:0; transform:scale(0.85) translateY(20px); }
    to   { opacity:1; transform:scale(1)    translateY(0);    }
}
</style>

<script>
function openProfileModal()  { var m = document.getElementById('profileModal');  m.style.display='flex'; }
function closeProfileModal() { var m = document.getElementById('profileModal');  m.style.display='none'; }
function openPasswordModal()  { var m = document.getElementById('passwordModal'); m.style.display='flex'; }
function closePasswordModal() { var m = document.getElementById('passwordModal'); m.style.display='none'; }

if(session('profile_success'))
    openProfileModal();
endif
if(session('password_success'))
    openPasswordModal();
endif
</script>

</body>
</html>
