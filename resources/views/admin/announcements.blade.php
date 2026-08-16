<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Announcements | Admin Portal</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-announcements.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <div class="dashboard-wrapper">
        <aside class="sidebar-container">
            <div class="sidebar-top-branding">
                <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo"
                     class="school-logo-img" style="display:block;margin:0 auto 15px;">
                <div class="school-title-text">DIVINE WORD COLLEGE <br>OF URDANETA</div>
                <div class="portal-identity">Administrative Portal</div>
            </div>

            <nav class="nav-links-list">
                <a href="{{ route('admin.dashboard') }}" class="nav-link-item">
                    <i class="fas fa-th-large"></i> Overview
                </a>
                <a href="{{ route('admin.faculty') }}" class="nav-link-item">
                    <i class="fas fa-chalkboard-teacher"></i> Faculty Management
                </a>
                <a href="{{ route('admin.students') }}" class="nav-link-item">
                    <i class="fas fa-user-graduate"></i> Student Records
                </a>
                <a href="{{ route('admin.announcements') }}" class="nav-link-item active">
                    <i class="fas fa-bullhorn"></i> Global Announcements
                </a>
                <a href="{{ route('admin.logs') }}" class="nav-link-item">
                    <i class="fas fa-history"></i> System Audit Logs
                </a>
                <a href="{{ route('admin.settings') }}" class="nav-link-item">
                    <i class="fas fa-cog"></i> System Settings
                </a>
            </nav>

            <div class="sidebar-footer-action">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="exit-system-link"
                            style="background:none;border:none;cursor:pointer;width:100%;">
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
                    <h1 style="font-size:1.6rem;font-weight:800;color:#0d1b44;margin:0 0 2px;">Global Announcements</h1>
                    <p id="headerSubtitle" style="font-size:0.85rem;color:#8892b0;margin:0;">Loading announcements…</p>
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
                <div class="ann-main-layout">

                    {{-- ── Broadcast table card ── --}}
                    <section style="background:#fff;border-radius:18px;padding:24px;box-shadow:0 2px 12px rgba(13,27,68,0.08);border:1px solid #edf0f7;min-width:0;overflow:hidden;">

                        {{-- Card header --}}
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;padding-bottom:16px;border-bottom:1px solid #f0f2f5;flex-wrap:wrap;gap:12px;">
                            <div>
                                <h3 style="font-size:1.05rem;font-weight:800;color:#0d1b44;margin:0 0 4px;display:flex;align-items:center;gap:8px;">
                                    <i class="fas fa-bullhorn" style="color:#f1c40f;font-size:0.95rem;"></i>
                                    Broadcast Management
                                </h3>
                                <p id="cardSubtitle" style="font-size:0.82rem;color:#8892b0;margin:0;">Loading…</p>
                            </div>
                            <button id="openAddModal"
                                    style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#f1c40f,#d4ac0d);color:#0d1b44;border:none;padding:11px 22px;border-radius:12px;font-family:'Afacad',sans-serif;font-weight:700;font-size:0.9rem;cursor:pointer;white-space:nowrap;flex-shrink:0;transition:transform 0.2s,box-shadow 0.2s;"
                                    onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 18px rgba(241,196,15,0.35)'"
                                    onmouseout="this.style.transform='';this.style.boxShadow=''">
                                <i class="fas fa-plus"></i> Create Announcement
                            </button>
                        </div>

                        {{-- Filters --}}
                        <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;flex-wrap:wrap;">
                            <div class="search-box" style="flex:1;min-width:200px;">
                                <i class="fas fa-search"></i>
                                <input type="text" id="annSearch" placeholder="Search by title, author, or content…">
                            </div>
                            <div style="display:flex;gap:10px;flex-shrink:0;">

                                {{-- Category filter --}}
                                <div class="custom-filter-dropdown">
                                    <button type="button" class="filter-trigger" id="categoryTrigger">
                                        <i class="fas fa-tag"></i>
                                        <span class="filter-label" id="categoryTriggerLabel">All Categories</span>
                                        <i class="fas fa-chevron-down filter-chev"></i>
                                    </button>
                                    <div class="filter-panel" id="categoryPanel">
                                        <div class="filter-opt active" data-value="">
                                            <i class="fas fa-border-all"></i>
                                            <span class="opt-text">All Categories</span>
                                        </div>
                                        <div class="filter-panel-divider"></div>
                                        <div class="filter-opt" data-value="general">
                                            <span class="cat-dot general"></span>
                                            <span class="opt-text">General</span>
                                        </div>
                                        <div class="filter-opt" data-value="academic">
                                            <span class="cat-dot academic"></span>
                                            <span class="opt-text">Academic</span>
                                        </div>
                                        <div class="filter-opt" data-value="event">
                                            <span class="cat-dot event"></span>
                                            <span class="opt-text">Event</span>
                                        </div>
                                        <div class="filter-opt" data-value="urgent">
                                            <span class="cat-dot urgent"></span>
                                            <span class="opt-text">Urgent</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Audience filter --}}
                                <div class="custom-filter-dropdown">
                                    <button type="button" class="filter-trigger" id="audienceTrigger">
                                        <i class="fas fa-users"></i>
                                        <span class="filter-label" id="audienceTriggerLabel">All Audiences</span>
                                        <i class="fas fa-chevron-down filter-chev"></i>
                                    </button>
                                    <div class="filter-panel" id="audiencePanel">
                                        <div class="filter-opt active" data-value="">
                                            <i class="fas fa-border-all"></i>
                                            <span class="opt-text">All Audiences</span>
                                        </div>
                                        <div class="filter-panel-divider"></div>
                                        <div class="filter-opt" data-value="all">
                                            <span class="aud-dot all"></span>
                                            <span class="opt-text">All Students</span>
                                        </div>
                                        <div class="filter-opt" data-value="jhs">
                                            <span class="aud-dot jhs"></span>
                                            <span class="opt-text">JHS Only</span>
                                        </div>
                                        <div class="filter-opt" data-value="shs">
                                            <span class="aud-dot shs"></span>
                                            <span class="opt-text">SHS Only</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Table --}}
                        <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;">
                            <table style="width:100%;border-collapse:collapse;min-width:680px;">
                                <thead>
                                    <tr style="background:#f5f7fb;">
                                        <th style="text-align:left;padding:12px 16px;color:#8892b0;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.6px;white-space:nowrap;border-bottom:2px solid #edf0f7;">Date</th>
                                        <th style="text-align:left;padding:12px 16px;color:#8892b0;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.6px;white-space:nowrap;border-bottom:2px solid #edf0f7;">Author</th>
                                        <th style="text-align:left;padding:12px 16px;color:#8892b0;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.6px;white-space:nowrap;border-bottom:2px solid #edf0f7;">Announcement</th>
                                        <th style="text-align:left;padding:12px 16px;color:#8892b0;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.6px;white-space:nowrap;border-bottom:2px solid #edf0f7;">Category</th>
                                        <th style="text-align:left;padding:12px 16px;color:#8892b0;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.6px;white-space:nowrap;border-bottom:2px solid #edf0f7;">Audience</th>
                                        <th style="text-align:left;padding:12px 16px;color:#8892b0;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.6px;white-space:nowrap;border-bottom:2px solid #edf0f7;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="annTbody" class="ann-table-tbody"></tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div style="display:flex;align-items:center;justify-content:space-between;padding-top:18px;margin-top:4px;border-top:1px solid #f0f2f5;flex-wrap:wrap;gap:10px;">
                            <span class="pagination-info" id="paginationInfo"></span>
                            <div class="pagination-controls" id="paginationControls"></div>
                        </div>

                    </section>

                    {{-- ── Calendar widget ── --}}
                    <aside style="background:#0d1b44;border-radius:18px;padding:20px;box-shadow:0 10px 30px rgba(13,27,68,0.25);">
                        <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
                            <div style="width:36px;height:36px;border-radius:10px;background:rgba(241,196,15,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-calendar-alt" style="color:#f1c40f;font-size:0.9rem;"></i>
                            </div>
                            <div>
                                <h4 style="margin:0;font-size:0.9rem;font-weight:700;color:#fff;">Event Calendar</h4>
                                <span id="currentMonth" style="font-size:0.72rem;color:#f1c40f;font-weight:600;">Loading…</span>
                            </div>
                        </div>
                        <div class="calendar-days">
                            <span>S</span><span>M</span><span>T</span><span>W</span><span>T</span><span>F</span><span>S</span>
                        </div>
                        <div class="calendar-grid" id="calendarGrid"></div>
                        <div style="display:flex;align-items:center;gap:6px;margin-top:12px;">
                            <span class="cal-has-dot"></span>
                            <span style="font-size:0.72rem;color:rgba(255,255,255,0.6);">Has announcement</span>
                        </div>
                    </aside>

                </div>
            </div>
        </main>
    </div>

    {{-- ── ADD / EDIT MODAL ── --}}
    <div class="modal-overlay" id="annModal">
        <div style="background:#fff;width:100%;max-width:560px;border-radius:18px;box-shadow:0 20px 60px rgba(0,0,0,0.2);animation:modalIn 0.25s ease-out;">

            {{-- Dark header --}}
            <div style="background:#0d1b44;padding:22px 24px;display:flex;align-items:center;justify-content:space-between;border-radius:18px 18px 0 0;">
                <div style="display:flex;align-items:center;gap:14px;">
                    <div style="width:40px;height:40px;border-radius:10px;background:rgba(241,196,15,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-bullhorn" id="modalIcon" style="color:#f1c40f;font-size:1rem;"></i>
                    </div>
                    <div>
                        <h3 id="modalTitle" style="margin:0;font-size:1rem;font-weight:700;color:#fff;">Create Announcement</h3>
                        <p id="modalSubtitle" style="margin:0;font-size:0.78rem;color:rgba(255,255,255,0.6);">Broadcast a new announcement to the portal.</p>
                    </div>
                </div>
                <button id="closeModal" aria-label="Close"
                        style="background:rgba(255,255,255,0.1);border:none;width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;cursor:pointer;color:rgba(255,255,255,0.7);font-size:0.9rem;"
                        onmouseover="this.style.background='rgba(255,255,255,0.2)'"
                        onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Form body --}}
            <form id="annForm" style="padding:24px;display:flex;flex-direction:column;gap:18px;">

                <div style="font-size:0.7rem;font-weight:800;text-transform:uppercase;letter-spacing:0.8px;color:#b0b8cc;">Announcement Details</div>

                <div class="modal-form-grid">
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label style="font-size:0.8rem;font-weight:700;color:#4a5568;">Title</label>
                        <div style="position:relative;display:flex;align-items:center;">
                            <i class="fas fa-heading" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;z-index:1;"></i>
                            <input type="text" id="aTitle" placeholder="Announcement title" required
                                   style="width:100%;padding:11px 14px 11px 36px;border:1.5px solid #e0e4f0;border-radius:10px;font-size:0.9rem;color:#0d1b44;background:#fafbff;outline:none;font-family:'Afacad',sans-serif;box-sizing:border-box;"
                                   onfocus="this.style.borderColor='#1e2f7a';this.style.boxShadow='0 0 0 3px rgba(30,47,122,0.1)';this.style.background='#fff'"
                                   onblur="this.style.borderColor='#e0e4f0';this.style.boxShadow='none';this.style.background='#fafbff'">
                        </div>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label style="font-size:0.8rem;font-weight:700;color:#4a5568;">Date</label>
                        <div style="position:relative;display:flex;align-items:center;">
                            <i class="fas fa-calendar" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;z-index:1;"></i>
                            <input type="date" id="aDate" required
                                   style="width:100%;padding:11px 14px 11px 36px;border:1.5px solid #e0e4f0;border-radius:10px;font-size:0.9rem;color:#0d1b44;background:#fafbff;outline:none;font-family:'Afacad',sans-serif;box-sizing:border-box;"
                                   onfocus="this.style.borderColor='#1e2f7a';this.style.boxShadow='0 0 0 3px rgba(30,47,122,0.1)';this.style.background='#fff'"
                                   onblur="this.style.borderColor='#e0e4f0';this.style.boxShadow='none';this.style.background='#fafbff'">
                        </div>
                    </div>
                </div>

                <div style="display:flex;flex-direction:column;gap:6px;">
                    <label style="font-size:0.8rem;font-weight:700;color:#4a5568;">Content</label>
                    <div style="position:relative;">
                        <i class="fas fa-align-left" style="position:absolute;left:13px;top:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;z-index:1;"></i>
                        <textarea id="aContent" placeholder="Write the announcement content here…" required
                                  style="width:100%;padding:11px 14px 11px 36px;border:1.5px solid #e0e4f0;border-radius:10px;font-size:0.9rem;color:#0d1b44;background:#fafbff;outline:none;font-family:'Afacad',sans-serif;height:110px;resize:vertical;box-sizing:border-box;"
                                  onfocus="this.style.borderColor='#1e2f7a';this.style.boxShadow='0 0 0 3px rgba(30,47,122,0.1)';this.style.background='#fff'"
                                  onblur="this.style.borderColor='#e0e4f0';this.style.boxShadow='none';this.style.background='#fafbff'"></textarea>
                    </div>
                </div>

                <div style="font-size:0.7rem;font-weight:800;text-transform:uppercase;letter-spacing:0.8px;color:#b0b8cc;margin-top:4px;">Broadcast Settings</div>

                <div class="modal-form-grid">

                    {{-- Category custom dropdown --}}
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label style="font-size:0.8rem;font-weight:700;color:#4a5568;">Category</label>
                        <div class="modal-select-wrap" id="mCatDrop">
                            <button type="button" class="modal-select-trigger" id="mCatTrigger">
                                <i class="fas fa-tag"></i>
                                <span class="modal-sel-label" id="mCatLabel">Select Category</span>
                                <i class="fas fa-chevron-down modal-sel-chev"></i>
                            </button>
                            <div class="modal-select-panel" id="mCatPanel">
                                <div class="modal-sel-opt" data-value="general">
                                    <span class="cat-dot general"></span>
                                    <span>General</span>
                                    <span class="msel-badge general">General</span>
                                    <i class="fas fa-check msel-check"></i>
                                </div>
                                <div class="modal-sel-opt" data-value="academic">
                                    <span class="cat-dot academic"></span>
                                    <span>Academic</span>
                                    <span class="msel-badge academic">Academic</span>
                                    <i class="fas fa-check msel-check"></i>
                                </div>
                                <div class="modal-sel-opt" data-value="event">
                                    <span class="cat-dot event"></span>
                                    <span>Event</span>
                                    <span class="msel-badge event">Event</span>
                                    <i class="fas fa-check msel-check"></i>
                                </div>
                                <div class="modal-sel-opt" data-value="urgent">
                                    <span class="cat-dot urgent"></span>
                                    <span>Urgent</span>
                                    <span class="msel-badge urgent">Urgent</span>
                                    <i class="fas fa-check msel-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Audience custom dropdown --}}
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label style="font-size:0.8rem;font-weight:700;color:#4a5568;">Audience</label>
                        <div class="modal-select-wrap" id="mAudDrop">
                            <button type="button" class="modal-select-trigger" id="mAudTrigger">
                                <i class="fas fa-users"></i>
                                <span class="modal-sel-label" id="mAudLabel">Select Audience</span>
                                <i class="fas fa-chevron-down modal-sel-chev"></i>
                            </button>
                            <div class="modal-select-panel" id="mAudPanel">
                                <div class="modal-sel-opt" data-value="all">
                                    <span class="aud-dot all"></span>
                                    <span>All Students</span>
                                    <span class="msel-badge aud-all">All</span>
                                    <i class="fas fa-check msel-check"></i>
                                </div>
                                <div class="modal-sel-opt" data-value="jhs">
                                    <span class="aud-dot jhs"></span>
                                    <span>JHS Only</span>
                                    <span class="msel-badge aud-jhs">JHS</span>
                                    <i class="fas fa-check msel-check"></i>
                                </div>
                                <div class="modal-sel-opt" data-value="shs">
                                    <span class="aud-dot shs"></span>
                                    <span>SHS Only</span>
                                    <span class="msel-badge aud-shs">SHS</span>
                                    <i class="fas fa-check msel-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div style="display:flex;justify-content:flex-end;gap:10px;padding-top:4px;">
                    <button type="button" id="cancelBtn"
                            style="padding:11px 22px;border-radius:10px;border:1.5px solid #e0e4f0;background:#f5f7fb;color:#5a6685;font-family:'Afacad',sans-serif;font-weight:600;font-size:0.9rem;cursor:pointer;"
                            onmouseover="this.style.background='#ebedf5'"
                            onmouseout="this.style.background='#f5f7fb'">
                        Cancel
                    </button>
                    <button type="submit"
                            style="display:inline-flex;align-items:center;gap:8px;padding:11px 22px;border-radius:10px;border:none;background:linear-gradient(135deg,#0d1b44,#1e2f7a);color:#fff;font-family:'Afacad',sans-serif;font-weight:700;font-size:0.9rem;cursor:pointer;"
                            onmouseover="this.style.opacity='0.9'"
                            onmouseout="this.style.opacity='1'">
                        <i class="fas fa-paper-plane"></i> Post Announcement
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- Toast notification --}}
    <div id="toast" class="toast-notification" aria-live="polite">
        <i class="fas fa-check-circle"></i>
        <span id="toastMessage">Success!</span>
    </div>

    {{-- Mobile nav overlay + drawer --}}
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
        <a href="{{ route('admin.dashboard') }}" class="nav-item"><i class="fas fa-th-large"></i> Overview</a>
        <a href="{{ route('admin.faculty') }}" class="nav-item"><i class="fas fa-chalkboard-teacher"></i> Faculty Management</a>
        <a href="{{ route('admin.students') }}" class="nav-item"><i class="fas fa-user-graduate"></i> Student Records</a>
        <a href="{{ route('admin.announcements') }}" class="nav-item active-drawer"><i class="fas fa-bullhorn"></i> Global Announcements</a>
        <a href="{{ route('admin.logs') }}" class="nav-item"><i class="fas fa-history"></i> System Audit Logs</a>
        <a href="{{ route('admin.settings') }}" class="nav-item"><i class="fas fa-cog"></i> System Settings</a>
        <div class="mobile-logout">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit"
                        style="background:none;border:none;cursor:pointer;color:#fca5a5;font-weight:600;padding:10px;width:100%;">
                    <i class="fas fa-sign-out-alt"></i> Log out
                </button>
            </form>
        </div>
    </div>

    @php
        $annJson = $announcements->map(function ($a) {
            $name     = $a->posted_by;
            $words    = array_values(array_filter(preg_split('/\s+/', preg_replace('/^(Mr\.|Mrs\.|Ms\.|Dr\.)\s*/i', '', $name))));
            $initials = strtoupper(substr($words[0] ?? 'A', 0, 1) . substr(end($words) ?: '', 0, 1));
            return [
                'id'       => $a->id,
                'date'     => $a->target_date->format('Y-m-d'),
                'author'   => $a->posted_by,
                'initials' => $initials,
                'title'    => $a->title,
                'content'  => $a->content,
                'category' => $a->category ?? 'general',
                'audience' => $a->audience ?? 'all',
            ];
        })->values();
    @endphp
    <script type="application/json" id="ann-data">{!! json_encode($annJson, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}</script>
    <script>
        window.annRoutes = {
            store:   "{{ route('admin.announcements.store') }}",
            update:  "{{ url('admin/announcements') }}",
            destroy: "{{ url('admin/announcements') }}",
        };
        window.ANNOUNCEMENTS = JSON.parse(document.getElementById('ann-data').textContent);
    </script>
    <script src="{{ asset('js/admin-announcements.js') }}"></script>
</body>
</html>
