<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records | DWCU Admin Portal</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-students.css') }}">
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
                <a href="{{ route('admin.students') }}" class="nav-link-item active">
                    <i class="fas fa-user-graduate"></i> Student Records
                </a>
                <a href="{{ route('admin.announcements') }}" class="nav-link-item">
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
                    <h1 style="font-size:1.6rem;font-weight:800;color:#0d1b44;margin:0 0 2px;">Student Records</h1>
                    <p id="headerSubtitle" style="font-size:0.85rem;color:#8892b0;margin:0;">Loading enrollment data…</p>
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

                    {{-- Card Header --}}
                    <div class="card-header">
                        <div class="card-title-group">
                            <h3>
                                <i class="fas fa-user-graduate" style="color:#f1c40f;margin-right:8px;font-size:0.95rem;"></i>
                                High School Enrollment
                            </h3>
                            <p id="cardSubtitle" style="color:#8892b0;font-size:0.85rem;margin:4px 0 0;">Loading…</p>
                        </div>
                        <button id="openAddModal"
                                style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#f1c40f,#d4ac0d);color:#0d1b44;border:none;padding:11px 22px;border-radius:12px;font-family:'Afacad',sans-serif;font-weight:700;font-size:0.9rem;cursor:pointer;white-space:nowrap;flex-shrink:0;transition:transform 0.2s,box-shadow 0.2s;"
                                onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 18px rgba(241,196,15,0.35)'"
                                onmouseout="this.style.transform='';this.style.boxShadow=''">
                            <i class="fas fa-plus"></i> Add Student
                        </button>
                    </div>

                    {{-- Filters --}}
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;flex-wrap:wrap;">

                        {{-- Search --}}
                        <div class="search-box" style="display:flex;align-items:center;gap:10px;background:#f8f9fc;border:1.5px solid #e8ebf0;border-radius:12px;padding:10px 16px;flex:1;min-width:200px;transition:border-color 0.2s,box-shadow 0.2s;">
                            <i class="fas fa-search" style="color:#8892b0;font-size:0.9rem;flex-shrink:0;"></i>
                            <input type="text" id="studentSearch" placeholder="Search by name, ID, email, or section…"
                                   style="border:none;background:transparent;outline:none;width:100%;font-size:0.9rem;color:#0d1b44;font-family:'Afacad',sans-serif;">
                        </div>

                        {{-- Filter group --}}
                        <div style="display:flex;gap:10px;flex-shrink:0;">

                            {{-- Grade filter --}}
                            <div class="custom-filter-dropdown" id="gradeDropdown">
                                <button type="button" class="filter-trigger" id="gradeTrigger">
                                    <i class="fas fa-layer-group"></i>
                                    <span class="filter-label" id="gradeTriggerLabel">All Grade Levels</span>
                                    <i class="fas fa-chevron-down filter-chev"></i>
                                </button>
                                <div class="filter-panel" id="gradePanel">
                                    <div class="filter-opt active" data-value=""><i class="fas fa-border-all"></i> All Grade Levels</div>
                                    <div class="filter-panel-divider"></div>
                                    <div class="filter-opt-group-label">Junior High School</div>
                                    <div class="filter-opt" data-value="7"><span class="opt-level-dot jhs"></span> Grade 7 <span class="opt-badge jhs">JHS</span></div>
                                    <div class="filter-opt" data-value="8"><span class="opt-level-dot jhs"></span> Grade 8 <span class="opt-badge jhs">JHS</span></div>
                                    <div class="filter-opt" data-value="9"><span class="opt-level-dot jhs"></span> Grade 9 <span class="opt-badge jhs">JHS</span></div>
                                    <div class="filter-opt" data-value="10"><span class="opt-level-dot jhs"></span> Grade 10 <span class="opt-badge jhs">JHS</span></div>
                                    <div class="filter-panel-divider"></div>
                                    <div class="filter-opt-group-label">Senior High School</div>
                                    <div class="filter-opt" data-value="11"><span class="opt-level-dot shs"></span> Grade 11 <span class="opt-badge shs">SHS</span></div>
                                    <div class="filter-opt" data-value="12"><span class="opt-level-dot shs"></span> Grade 12 <span class="opt-badge shs">SHS</span></div>
                                </div>
                            </div>

                            {{-- Status filter --}}
                            <div class="custom-filter-dropdown" id="statusDropdown">
                                <button type="button" class="filter-trigger" id="statusTrigger">
                                    <i class="fas fa-circle-dot"></i>
                                    <span class="filter-label" id="statusTriggerLabel">All Status</span>
                                    <i class="fas fa-chevron-down filter-chev"></i>
                                </button>
                                <div class="filter-panel" id="statusPanel">
                                    <div class="filter-opt active" data-value=""><i class="fas fa-border-all"></i> All Status</div>
                                    <div class="filter-panel-divider"></div>
                                    <div class="filter-opt" data-value="active"><span class="opt-status-dot active"></span> Active</div>
                                    <div class="filter-opt" data-value="dropped"><span class="opt-status-dot dropped"></span> Dropped</div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Table --}}
                    <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;">
                        <table class="student-table">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Level</th>
                                    <th>Grade &amp; Section</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="studentTbody"></tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-top:20px;padding-top:16px;border-top:1px solid #f0f2f7;flex-wrap:wrap;gap:10px;">
                        <span class="pagination-info" id="paginationInfo"></span>
                        <div class="pagination-controls" id="paginationControls"></div>
                    </div>

                </section>
            </div>
        </main>
    </div>

    {{-- ── ADD / EDIT MODAL ── --}}
    <div class="modal-overlay" id="studentModal">
        <div style="background:#fff;width:100%;max-width:620px;border-radius:20px;box-shadow:0 30px 60px rgba(0,0,0,0.25);overflow:hidden;animation:modalIn 0.25s cubic-bezier(0.34,1.56,0.64,1);">

            {{-- Modal Header --}}
            <div style="background:linear-gradient(135deg,#0d1b44,#1e2f7a);padding:22px 26px;display:flex;align-items:center;justify-content:space-between;gap:16px;">
                <div style="display:flex;align-items:center;gap:14px;">
                    <div style="width:44px;height:44px;background:rgba(241,196,15,0.15);border:1.5px solid rgba(241,196,15,0.4);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;color:#f1c40f;flex-shrink:0;">
                        <i class="fas fa-user-plus" id="modalIcon"></i>
                    </div>
                    <div>
                        <h3 id="modalTitle" style="color:#fff;font-size:1.1rem;font-weight:700;margin:0 0 3px;font-family:'Afacad',sans-serif;">Add New Student</h3>
                        <p id="modalSubtitle" style="color:rgba(255,255,255,0.55);font-size:0.78rem;margin:0;font-family:'Afacad',sans-serif;">Fill in the details to enroll a new student.</p>
                    </div>
                </div>
                <button id="closeModal" aria-label="Close"
                        style="background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.15);color:rgba(255,255,255,0.7);width:34px;height:34px;border-radius:8px;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:0.9rem;"
                        onmouseover="this.style.background='rgba(239,68,68,0.25)';this.style.color='#ff6b6b'"
                        onmouseout="this.style.background='rgba(255,255,255,0.1)';this.style.color='rgba(255,255,255,0.7)'">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Modal Form --}}
            <form id="studentForm" style="padding:26px 28px 28px;overflow-y:auto;max-height:calc(100vh - 160px);">

                <div style="font-size:0.72rem;font-weight:800;text-transform:uppercase;letter-spacing:1px;color:#8892b0;margin-bottom:14px;font-family:'Afacad',sans-serif;">Student Information</div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label for="sID" style="font-size:0.82rem;font-weight:700;color:#2d3a5e;font-family:'Afacad',sans-serif;">Student ID</label>
                        <div style="position:relative;display:flex;align-items:center;">
                            <i class="fas fa-id-card" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;"></i>
                            <input type="text" id="sID" placeholder="e.g. 2024-0001" required
                                   style="width:100%;padding:11px 14px 11px 36px;border:1.5px solid #e0e4f0;border-radius:10px;font-size:0.9rem;color:#0d1b44;background:#fafbff;outline:none;font-family:'Afacad',sans-serif;transition:border-color 0.2s,box-shadow 0.2s;"
                                   onfocus="this.style.borderColor='#1e2f7a';this.style.boxShadow='0 0 0 3px rgba(30,47,122,0.1)';this.style.background='#fff'"
                                   onblur="this.style.borderColor='#e0e4f0';this.style.boxShadow='none';this.style.background='#fafbff'">
                        </div>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label for="sName" style="font-size:0.82rem;font-weight:700;color:#2d3a5e;font-family:'Afacad',sans-serif;">Full Name</label>
                        <div style="position:relative;display:flex;align-items:center;">
                            <i class="fas fa-user" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;"></i>
                            <input type="text" id="sName" placeholder="e.g. Juan Dela Cruz" required
                                   style="width:100%;padding:11px 14px 11px 36px;border:1.5px solid #e0e4f0;border-radius:10px;font-size:0.9rem;color:#0d1b44;background:#fafbff;outline:none;font-family:'Afacad',sans-serif;transition:border-color 0.2s,box-shadow 0.2s;"
                                   onfocus="this.style.borderColor='#1e2f7a';this.style.boxShadow='0 0 0 3px rgba(30,47,122,0.1)';this.style.background='#fff'"
                                   onblur="this.style.borderColor='#e0e4f0';this.style.boxShadow='none';this.style.background='#fafbff'">
                        </div>
                    </div>
                </div>

                <div style="display:flex;flex-direction:column;gap:6px;margin-bottom:16px;">
                    <label for="sEmail" style="font-size:0.82rem;font-weight:700;color:#2d3a5e;font-family:'Afacad',sans-serif;">Email Address</label>
                    <div style="position:relative;display:flex;align-items:center;">
                        <i class="fas fa-envelope" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;"></i>
                        <input type="email" id="sEmail" placeholder="student@dwcu.edu.ph" required
                               style="width:100%;padding:11px 14px 11px 36px;border:1.5px solid #e0e4f0;border-radius:10px;font-size:0.9rem;color:#0d1b44;background:#fafbff;outline:none;font-family:'Afacad',sans-serif;transition:border-color 0.2s,box-shadow 0.2s;"
                               onfocus="this.style.borderColor='#1e2f7a';this.style.boxShadow='0 0 0 3px rgba(30,47,122,0.1)';this.style.background='#fff'"
                               onblur="this.style.borderColor='#e0e4f0';this.style.boxShadow='none';this.style.background='#fafbff'">
                    </div>
                </div>

                <div style="font-size:0.72rem;font-weight:800;text-transform:uppercase;letter-spacing:1px;color:#8892b0;margin-bottom:14px;margin-top:20px;font-family:'Afacad',sans-serif;">Enrollment Details</div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label for="sGrade" style="font-size:0.82rem;font-weight:700;color:#2d3a5e;font-family:'Afacad',sans-serif;">Grade Level</label>
                        <div style="position:relative;display:flex;align-items:center;">
                            <i class="fas fa-graduation-cap" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;z-index:1;"></i>
                            <select id="sGrade" required
                                    style="width:100%;padding:11px 36px 11px 36px;border:1.5px solid #e0e4f0;border-radius:10px;font-size:0.9rem;color:#0d1b44;background:#fafbff;appearance:none;-webkit-appearance:none;outline:none;font-family:'Afacad',sans-serif;cursor:pointer;transition:border-color 0.2s,box-shadow 0.2s;"
                                    onfocus="this.style.borderColor='#1e2f7a';this.style.boxShadow='0 0 0 3px rgba(30,47,122,0.1)';this.style.background='#fff'"
                                    onblur="this.style.borderColor='#e0e4f0';this.style.boxShadow='none';this.style.background='#fafbff'">
                                <option value="" disabled selected>Select Grade</option>
                                <option value="7">Grade 7</option>
                                <option value="8">Grade 8</option>
                                <option value="9">Grade 9</option>
                                <option value="10">Grade 10</option>
                                <option value="11">Grade 11</option>
                                <option value="12">Grade 12</option>
                            </select>
                            <i class="fas fa-chevron-down" style="position:absolute;right:13px;color:#8892b0;font-size:0.72rem;pointer-events:none;"></i>
                        </div>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label for="sSection" style="font-size:0.82rem;font-weight:700;color:#2d3a5e;font-family:'Afacad',sans-serif;">Section / Strand</label>
                        <div style="position:relative;display:flex;align-items:center;">
                            <i class="fas fa-users" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;"></i>
                            <input type="text" id="sSection" placeholder="e.g. Explorers or STEM"
                                   style="width:100%;padding:11px 14px 11px 36px;border:1.5px solid #e0e4f0;border-radius:10px;font-size:0.9rem;color:#0d1b44;background:#fafbff;outline:none;font-family:'Afacad',sans-serif;transition:border-color 0.2s,box-shadow 0.2s;"
                                   onfocus="this.style.borderColor='#1e2f7a';this.style.boxShadow='0 0 0 3px rgba(30,47,122,0.1)';this.style.background='#fff'"
                                   onblur="this.style.borderColor='#e0e4f0';this.style.boxShadow='none';this.style.background='#fafbff'">
                        </div>
                    </div>
                </div>

                <div style="display:flex;flex-direction:column;gap:6px;margin-bottom:16px;">
                    <label for="sStatus" style="font-size:0.82rem;font-weight:700;color:#2d3a5e;font-family:'Afacad',sans-serif;">Enrollment Status</label>
                    <div style="position:relative;display:flex;align-items:center;">
                        <i class="fas fa-circle-dot" style="position:absolute;left:13px;color:#8892b0;font-size:0.85rem;pointer-events:none;z-index:1;"></i>
                        <select id="sStatus" required
                                style="width:100%;padding:11px 36px 11px 36px;border:1.5px solid #e0e4f0;border-radius:10px;font-size:0.9rem;color:#0d1b44;background:#fafbff;appearance:none;-webkit-appearance:none;outline:none;font-family:'Afacad',sans-serif;cursor:pointer;transition:border-color 0.2s,box-shadow 0.2s;"
                                onfocus="this.style.borderColor='#1e2f7a';this.style.boxShadow='0 0 0 3px rgba(30,47,122,0.1)';this.style.background='#fff'"
                                onblur="this.style.borderColor='#e0e4f0';this.style.boxShadow='none';this.style.background='#fafbff'">
                            <option value="active">Active</option>
                            <option value="dropped">Dropped</option>
                        </select>
                        <i class="fas fa-chevron-down" style="position:absolute;right:13px;color:#8892b0;font-size:0.72rem;pointer-events:none;"></i>
                    </div>
                </div>

                <div style="display:flex;justify-content:flex-end;gap:12px;margin-top:24px;padding-top:20px;border-top:1px solid #f0f2f7;">
                    <button type="button" id="cancelBtn"
                            style="padding:10px 22px;background:#f5f7fb;color:#5a6685;border:1.5px solid #e0e4f0;border-radius:10px;font-weight:600;font-size:0.9rem;cursor:pointer;font-family:'Afacad',sans-serif;"
                            onmouseover="this.style.background='#e8ebf5'"
                            onmouseout="this.style.background='#f5f7fb'">
                        Cancel
                    </button>
                    <button type="submit" id="modalSaveBtn"
                            style="display:inline-flex;align-items:center;gap:8px;padding:10px 24px;background:linear-gradient(135deg,#0d1b44,#1e2f7a);color:#fff;border:none;border-radius:10px;font-weight:700;font-size:0.9rem;cursor:pointer;font-family:'Afacad',sans-serif;transition:transform 0.2s,box-shadow 0.2s;"
                            onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 6px 18px rgba(13,27,68,0.3)'"
                            onmouseout="this.style.transform='';this.style.boxShadow=''">
                        <i class="fas fa-save"></i> Save Student
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
        <a href="{{ route('admin.students') }}" class="nav-item active-drawer"><i class="fas fa-user-graduate"></i> Student Records</a>
        <a href="{{ route('admin.announcements') }}" class="nav-item"><i class="fas fa-bullhorn"></i> Global Announcements</a>
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
        $studentsJson = $students->map(function ($s) {
            $grade = (int) preg_replace('/[^0-9]/', '', $s->grade_level ?? '0');
            return [
                'id'        => $s->id,
                'studentId' => $s->student_id,
                'name'      => $s->name,
                'email'     => $s->email ?? '',
                'grade'     => $grade,
                'section'   => $s->section ?? '',
                'status'    => $s->status ?? 'active',
            ];
        })->values();
    @endphp
    <script type="application/json" id="students-data">{!! json_encode($studentsJson, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}</script>
    <script>
        window.studentRoutes = {
            store:   "{{ route('admin.students.store') }}",
            update:  "{{ url('admin/students') }}",
            destroy: "{{ url('admin/students') }}",
        };
        window.STUDENTS = JSON.parse(document.getElementById('students-data').textContent);
    </script>
    <script src="{{ asset('js/admin-students.js') }}"></script>
</body>
</html>
