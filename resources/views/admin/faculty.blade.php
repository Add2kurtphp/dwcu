<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Management | Admin Portal</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-faculty-style.css') }}">
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
                <a href="{{ route('admin.faculty') }}" class="nav-link-item active">
                    <i class="fas fa-chalkboard-teacher"></i> Faculty Management
                </a>
                <a href="{{ route('admin.students') }}" class="nav-link-item">
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
                    <h1 style="font-size:1.6rem;font-weight:800;color:#0d1b44;margin:0 0 2px;">Faculty Management</h1>
                    <p>Manage and monitor all registered faculty members.</p>
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
                            <h3><i class="fas fa-chalkboard-teacher" style="color:#f1c40f;margin-right:8px;font-size:0.95rem;"></i> Faculty Directory</h3>
                            <p style="color:#8892b0;font-size:0.85rem;margin:4px 0 0;">
                                All registered faculty members and their assigned sections.
                            </p>
                        </div>
                        <button class="add-btn-gold" id="openAddModal">
                            <i class="fas fa-plus"></i> Add Faculty
                        </button>
                    </div>

                    <div class="table-controls">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="facultySearch" placeholder="Search by name, ID, department…">
                        </div>
                    </div>

                    <div class="table-responsive-container">
                        <table class="faculty-table">
                            <thead>
                                <tr>
                                    <th>Faculty ID</th>
                                    <th>Name</th>
                                    <th>Designation / Subject</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="facultyTbody">
                                @foreach($faculty as $f)
                                    @php
                                        $words    = array_values(array_filter(preg_split('/\s+/', preg_replace('/^(Mr\.|Mrs\.|Ms\.|Dr\.)\s*/i', '', $f->name))));
                                        $initials = strtoupper(substr($words[0] ?? 'F', 0, 1) . substr(end($words) ?: '', 0, 1));
                                    @endphp
                                    <tr data-id="{{ $f->id }}"
                                        data-faculty-id="{{ $f->faculty_id }}"
                                        data-name="{{ $f->name }}"
                                        data-designation="{{ $f->designation }}"
                                        data-department="{{ $f->department }}">
                                        <td><span class="id-badge">{{ $f->faculty_id }}</span></td>
                                        <td>
                                            <div class="user-info">
                                                <div class="user-avatar">{{ $initials }}</div>
                                                <span class="user-name-text">{{ $f->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $f->designation }}</td>
                                        <td>{{ $f->department }}</td>
                                        <td><span class="status-pill {{ $f->status ?? 'active' }}">{{ ucfirst($f->status ?? 'Active') }}</span></td>
                                        <td>
                                            <button class="action-trigger-btn" data-id="{{ $f->id }}">
                                                Actions <i class="fas fa-chevron-down"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-bar">
                        <span class="pagination-info" id="paginationInfo"></span>
                        <div class="pagination-controls" id="paginationControls"></div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    {{-- ── ADD / EDIT MODAL ── --}}
    <div class="modal-overlay" id="facultyModal">
        <div class="modal-content">

            <div class="modal-header-bar">
                <div class="modal-header-left">
                    <div class="modal-header-icon">
                        <i class="fas fa-user-plus" id="modalIcon"></i>
                    </div>
                    <div>
                        <h3 id="modalTitle">Add New Faculty</h3>
                        <p id="modalSubtitle">Fill in the details to register a new faculty member.</p>
                    </div>
                </div>
                <button class="modal-close-x" id="closeFacultyModal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="facultyForm" class="modal-form">

                <div class="form-section-label">Basic Information</div>
                <div class="form-row-2">
                    <div class="form-group">
                        <label for="fID">Faculty ID</label>
                        <div class="input-with-icon">
                            <i class="fas fa-id-badge"></i>
                            <input type="text" id="fID" placeholder="e.g. FAC-2026-001" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fName">Full Name</label>
                        <div class="input-with-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" id="fName" placeholder="e.g. Mr. John Doe" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="fTitle">Designation / Subject</label>
                    <div class="input-with-icon">
                        <i class="fas fa-briefcase"></i>
                        <input type="text" id="fTitle" placeholder="e.g. Secondary School Teacher III (Science)" required>
                    </div>
                </div>

                <div class="form-section-label" style="margin-top:20px;">Assignment</div>
                <div class="form-group">
                    <label for="fDept">Department</label>
                    <div class="select-wrapper">
                        <i class="fas fa-building"></i>
                        <select id="fDept" required>
                            <option value="" disabled selected>Select Department</option>
                            <option>Junior High School</option>
                            <option>SHS - STEM</option>
                            <option>SHS - HUMSS</option>
                            <option>SHS - ICT</option>
                            <option>Administration</option>
                        </select>
                        <i class="fas fa-chevron-down select-chevron"></i>
                    </div>
                </div>

                {{-- Permissions — shown only on Edit --}}
                <div class="permissions-section" id="permissionsSection" style="display:none;">
                    <div class="form-section-label">Feature Access Control</div>
                    <div class="permissions-grid">
                        <label class="perm-item">
                            <input type="checkbox" name="perm" value="Student List">
                            <div class="perm-box"><i class="fas fa-users"></i> Student List</div>
                        </label>
                        <label class="perm-item">
                            <input type="checkbox" name="perm" value="Calendar">
                            <div class="perm-box"><i class="fas fa-calendar-alt"></i> Calendar</div>
                        </label>
                        <label class="perm-item">
                            <input type="checkbox" name="perm" value="Gradebook">
                            <div class="perm-box"><i class="fas fa-book-open"></i> Gradebook</div>
                        </label>
                        <label class="perm-item">
                            <input type="checkbox" name="perm" value="Announcements">
                            <div class="perm-box"><i class="fas fa-bullhorn"></i> Announcements</div>
                        </label>
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="button" class="modal-cancel-btn" id="cancelFacultyBtn">Cancel</button>
                    <button type="submit" class="modal-save-btn" id="modalSaveBtn">
                        <i class="fas fa-save"></i> Save Faculty Member
                    </button>
                </div>
            </form>
        </div>
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
        <a href="{{ route('admin.dashboard') }}" class="nav-item">
            <i class="fas fa-th-large"></i> Overview
        </a>
        <a href="{{ route('admin.faculty') }}" class="nav-item active-drawer">
            <i class="fas fa-chalkboard-teacher"></i> Faculty Management
        </a>
        <a href="{{ route('admin.students') }}" class="nav-item">
            <i class="fas fa-user-graduate"></i> Student Records
        </a>
        <a href="{{ route('admin.announcements') }}" class="nav-item">
            <i class="fas fa-bullhorn"></i> Global Announcements
        </a>
        <a href="{{ route('admin.logs') }}" class="nav-item">
            <i class="fas fa-history"></i> System Audit Logs
        </a>
        <a href="{{ route('admin.settings') }}" class="nav-item">
            <i class="fas fa-cog"></i> System Settings
        </a>
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

    <script>
        window.facultyRoutes = {
            store:   "{{ route('admin.faculty.store') }}",
            update:  "{{ url('admin/faculty') }}",
            destroy: "{{ url('admin/faculty') }}",
        };
    </script>
    <script src="{{ asset('js/admin-faculty.js') }}"></script>
</body>
</html>
