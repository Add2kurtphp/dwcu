<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Audit Logs | DWCU Admin Portal</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-logs-style.css') }}">
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
            <a href="{{ route('admin.logs') }}" class="nav-link-item active"><i class="fas fa-history"></i> System Audit Logs</a>
            <a href="{{ route('admin.settings') }}" class="nav-link-item"><i class="fas fa-cog"></i> System Settings</a>
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
                <h1>System Audit Logs</h1>
                <p id="headerSubtitle" style="font-size:0.82rem;color:#8892b0;margin:0;">Loading…</p>
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
            <section class="management-section-card">

                <div class="card-header">
                    <div class="card-title-group">
                        <h3>
                            <i class="fas fa-history" style="color:#f1c40f;margin-right:8px;font-size:1rem;"></i>
                            Activity History
                        </h3>
                        <p class="sub-portal-text" id="cardSubtitle">Loading…</p>
                    </div>
                    <button id="exportCsvBtn"
                        style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#f1c40f,#d4ac0d);color:#0d1b44;border:none;padding:11px 22px;border-radius:12px;font-family:'Afacad',sans-serif;font-weight:700;font-size:0.9rem;cursor:pointer;white-space:nowrap;flex-shrink:0;transition:transform 0.2s,box-shadow 0.2s;"
                        onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 18px rgba(241,196,15,0.35)'"
                        onmouseout="this.style.transform='';this.style.boxShadow=''">
                        <i class="fas fa-file-export"></i> Export CSV
                    </button>
                </div>

                {{-- Table controls --}}
                <div style="margin-bottom:20px;">
                    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">

                        <div class="search-box" style="flex:1;min-width:220px;">
                            <i class="fas fa-search"></i>
                            <input type="text" id="logSearch" placeholder="Search by user, action, or detail…">
                        </div>

                        <div style="display:flex;gap:10px;flex-wrap:wrap;">

                            {{-- Portal filter --}}
                            <div class="custom-filter-dropdown">
                                <button type="button" class="filter-trigger" id="portalTrigger">
                                    <i class="fas fa-globe"></i>
                                    <span class="filter-label" id="portalTriggerLabel">All Portals</span>
                                    <i class="fas fa-chevron-down filter-chev"></i>
                                </button>
                                <div class="filter-panel" id="portalPanel">
                                    <div class="filter-opt active" data-value=""><i class="fas fa-border-all"></i><span class="opt-text">All Portals</span></div>
                                    <div class="filter-panel-divider"></div>
                                    <div class="filter-opt" data-value="admin"><span class="portal-dot admin"></span><span class="opt-text">Admin Portal</span></div>
                                    <div class="filter-opt" data-value="faculty"><span class="portal-dot faculty"></span><span class="opt-text">Faculty Portal</span></div>
                                    <div class="filter-opt" data-value="jhs"><span class="portal-dot jhs"></span><span class="opt-text">JHS Portal</span></div>
                                    <div class="filter-opt" data-value="shs"><span class="portal-dot shs"></span><span class="opt-text">SHS Portal</span></div>
                                    <div class="filter-opt" data-value="system"><span class="portal-dot system"></span><span class="opt-text">System</span></div>
                                </div>
                            </div>

                            {{-- Action type filter --}}
                            <div class="custom-filter-dropdown">
                                <button type="button" class="filter-trigger" id="typeTrigger">
                                    <i class="fas fa-tag"></i>
                                    <span class="filter-label" id="typeTriggerLabel">All Types</span>
                                    <i class="fas fa-chevron-down filter-chev"></i>
                                </button>
                                <div class="filter-panel" id="typePanel">
                                    <div class="filter-opt active" data-value=""><i class="fas fa-border-all"></i><span class="opt-text">All Types</span></div>
                                    <div class="filter-panel-divider"></div>
                                    <div class="filter-opt" data-value="drop"><span class="type-dot drop"></span><span class="opt-text">Student Drop</span></div>
                                    <div class="filter-opt" data-value="announcement"><span class="type-dot announcement"></span><span class="opt-text">Announcement</span></div>
                                    <div class="filter-opt" data-value="login"><span class="type-dot login"></span><span class="opt-text">Login / Logout</span></div>
                                    <div class="filter-opt" data-value="system"><span class="type-dot system"></span><span class="opt-text">System Event</span></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;">
                    <table class="log-table">
                        <thead>
                            <tr>
                                <th data-col="timestamp">Timestamp <i class="sort-icon fas fa-arrow-down active"></i></th>
                                <th data-col="user">User <i class="sort-icon fas fa-sort"></i></th>
                                <th data-col="action">Action Performed <i class="sort-icon fas fa-sort"></i></th>
                                <th data-col="actionType">Type <i class="sort-icon fas fa-sort"></i></th>
                                <th data-col="portal">Portal <i class="sort-icon fas fa-sort"></i></th>
                                <th data-col="status">Status <i class="sort-icon fas fa-sort"></i></th>
                            </tr>
                        </thead>
                        <tbody id="logTbody"></tbody>
                    </table>
                </div>

                <div style="display:flex;justify-content:space-between;align-items:center;margin-top:20px;padding-top:16px;border-top:1px solid #f0f2f7;flex-wrap:wrap;gap:10px;">
                    <span style="font-size:0.82rem;color:#8892b0;" id="paginationInfo"></span>
                    <div class="pagination-controls" id="paginationControls"></div>
                </div>

            </section>
        </div>
    </main>
</div>

{{-- Drop Details Modal --}}
<div class="drop-modal-overlay" id="dropModal">
    <div class="drop-modal-content">
        <div class="drop-modal-header">
            <div style="display:flex;align-items:center;gap:14px;">
                <div style="width:44px;height:44px;background:rgba(255,255,255,0.15);border:1.5px solid rgba(255,255,255,0.3);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;color:#fff;flex-shrink:0;">
                    <i class="fas fa-user-minus"></i>
                </div>
                <div>
                    <h3 style="color:#fff;font-size:1.05rem;font-weight:700;margin:0 0 3px;">Student Drop Record</h3>
                    <p id="dropModalMeta" style="color:rgba(255,255,255,0.65);font-size:0.78rem;margin:0;">Enrollment drop details</p>
                </div>
            </div>
            <button class="drop-modal-close" id="dropModalClose">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="drop-modal-body" id="dropModalBody"></div>
    </div>
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
    <a href="{{ route('admin.logs') }}" class="nav-item active-drawer"><i class="fas fa-history"></i> System Audit Logs</a>
    <a href="{{ route('admin.settings') }}" class="nav-item"><i class="fas fa-cog"></i> System Settings</a>
    <div class="mobile-logout">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" style="background:none;border:none;cursor:pointer;color:#fca5a5;font-weight:600;padding:10px;width:100%;font-family:'Afacad',sans-serif;">
                <i class="fas fa-sign-out-alt"></i> Log out
            </button>
        </form>
    </div>
</div>

@php
    $logsJson = $logs->map(function ($l) {
        $name    = $l->admin_name;
        $words   = array_values(array_filter(preg_split('/\s+/', preg_replace('/^(Mr\.|Mrs\.|Ms\.|Dr\.)\s*/i', '', $name))));
        $initials = strtoupper(substr($words[0] ?? 'A', 0, 1) . substr(end($words) ?: '', 0, 1));
        return [
            'id'         => $l->id,
            'timestamp'  => $l->created_at->toIso8601String(),
            'user'       => $name,
            'initials'   => $initials,
            'portal'     => $l->portal      ?? 'admin',
            'actionType' => $l->action_type ?? 'system',
            'action'     => $l->action,
            'status'     => $l->status      ?? 'success',
            'dropDetail' => $l->drop_detail,
        ];
    })->values();
@endphp
<script type="application/json" id="log-data">{!! json_encode($logsJson) !!}</script>
<script>
    window.LOGS = JSON.parse(document.getElementById('log-data').textContent);
</script>
<script src="{{ asset('js/admin-logs.js') }}"></script>
</body>
</html>
