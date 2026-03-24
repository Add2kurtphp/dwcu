// ============================================================
// DWCU ADMIN — STUDENT RECORDS
// Data sourced from window.STUDENTS (set by Blade)
// ============================================================

var STUDENTS = window.STUDENTS ? window.STUDENTS.slice() : [];

var ROWS_PER_PAGE = 8;
var currentPage   = 1;
var searchTerm    = '';
var gradeFilter   = '';
var statusFilter  = '';
var editingDbId   = null;
var openDropId    = null;

// ── Helpers ──────────────────────────────────────────────────
function csrfToken() {
    var m = document.querySelector('meta[name="csrf-token"]');
    return m ? m.content : '';
}

function getFiltered() {
    var q = searchTerm.toLowerCase();
    return STUDENTS.filter(function(s) {
        var matchSearch = !q ||
            s.studentId.toLowerCase().includes(q) ||
            s.name.toLowerCase().includes(q)      ||
            s.email.toLowerCase().includes(q)     ||
            s.section.toLowerCase().includes(q);
        var matchGrade  = !gradeFilter  || String(s.grade) === gradeFilter;
        var matchStatus = !statusFilter || s.status === statusFilter;
        return matchSearch && matchGrade && matchStatus;
    });
}

function getInitials(name) {
    var clean = name.replace(/^(Mr\.|Mrs\.|Ms\.|Dr\.|Prof\.)\s*/i, '').trim();
    var words = clean.split(/\s+/);
    return words.length >= 2
        ? (words[0][0] + words[words.length - 1][0]).toUpperCase()
        : clean.substring(0, 2).toUpperCase();
}

function updateHeaderCounts() {
    var active  = STUDENTS.filter(function(s) { return s.status === 'active'; }).length;
    var jhs     = STUDENTS.filter(function(s) { return s.status === 'active' && s.grade >= 7  && s.grade <= 10; }).length;
    var shs     = STUDENTS.filter(function(s) { return s.status === 'active' && s.grade >= 11 && s.grade <= 12; }).length;
    var dropped = STUDENTS.filter(function(s) { return s.status === 'dropped'; }).length;

    var h = document.getElementById('headerSubtitle');
    var c = document.getElementById('cardSubtitle');
    if (h) h.textContent = active + ' active students (' + jhs + ' JHS / ' + shs + ' SHS) · ' + dropped + ' dropped';
    if (c) c.textContent = 'Total: ' + STUDENTS.length + ' students — ' + active + ' active, ' + dropped + ' dropped';
}

// ── Render table ─────────────────────────────────────────────
function renderTable() {
    closeActionDropdown();

    var data       = getFiltered();
    var totalPages = Math.max(1, Math.ceil(data.length / ROWS_PER_PAGE));
    if (currentPage > totalPages) currentPage = totalPages;

    var slice = data.slice((currentPage - 1) * ROWS_PER_PAGE, currentPage * ROWS_PER_PAGE);
    var tbody = document.getElementById('studentTbody');
    tbody.innerHTML = '';

    slice.forEach(function(s) {
        var isJHS     = s.grade >= 7 && s.grade <= 10;
        var lvlClass  = isJHS ? 'level-jhs' : 'level-shs';
        var lvlLabel  = isJHS ? 'JHS' : 'SHS';
        var avatarCls = isJHS ? 'avatar-jhs' : 'avatar-shs';
        var initials  = getInitials(s.name);
        var statusCap = s.status.charAt(0).toUpperCase() + s.status.slice(1);

        var tr = document.createElement('tr');
        tr.innerHTML =
            '<td><span class="id-badge">' + s.studentId + '</span></td>' +
            '<td><div class="student-name-cell">' +
                '<div class="student-avatar ' + avatarCls + '">' + initials + '</div>' +
                '<span class="student-name-text">' + s.name + '</span>' +
            '</div></td>' +
            '<td><span class="email-cell">' + s.email + '</span></td>' +
            '<td><span class="level-badge ' + lvlClass + '">' + lvlLabel + '</span></td>' +
            '<td>Grade ' + s.grade + (s.section ? ' – ' + s.section : '') + '</td>' +
            '<td><span class="status-pill ' + s.status + '">' + statusCap + '</span></td>' +
            '<td><button class="action-trigger-btn" data-id="' + s.id + '">Actions <i class="fas fa-chevron-down"></i></button></td>';
        tbody.appendChild(tr);
    });

    // Pagination info
    var start = data.length === 0 ? 0 : (currentPage - 1) * ROWS_PER_PAGE + 1;
    var end   = Math.min(currentPage * ROWS_PER_PAGE, data.length);
    document.getElementById('paginationInfo').textContent = data.length === 0
        ? 'No results found'
        : 'Showing ' + start + '–' + end + ' of ' + data.length + ' students';

    // Pagination controls
    var controls = document.getElementById('paginationControls');
    controls.innerHTML = '';

    var prev = document.createElement('button');
    prev.innerHTML = '<i class="fas fa-chevron-left"></i>';
    prev.disabled  = currentPage === 1;
    prev.addEventListener('click', function() { currentPage--; renderTable(); });
    controls.appendChild(prev);

    for (var p = 1; p <= totalPages; p++) {
        (function(pg) {
            var btn = document.createElement('button');
            btn.textContent = pg;
            if (pg === currentPage) btn.classList.add('active');
            btn.addEventListener('click', function() { currentPage = pg; renderTable(); });
            controls.appendChild(btn);
        })(p);
    }

    var next = document.createElement('button');
    next.innerHTML = '<i class="fas fa-chevron-right"></i>';
    next.disabled  = currentPage === totalPages;
    next.addEventListener('click', function() { currentPage++; renderTable(); });
    controls.appendChild(next);
}

// ── Action dropdown ──────────────────────────────────────────
function openActionDropdown(btn, dbId) {
    closeActionDropdown();
    openDropId = dbId;
    btn.classList.add('open');

    var rect      = btn.getBoundingClientRect();
    var s         = STUDENTS.find(function(x) { return x.id == dbId; });
    var isDropped = s && s.status === 'dropped';

    var dd = document.createElement('div');
    dd.id        = 'actionDropdown';
    dd.className = 'action-dropdown';
    dd.style.top  = (rect.bottom + 6) + 'px';
    dd.style.left = rect.left + 'px';
    dd.innerHTML =
        '<button class="action-drop-item drop-edit" data-action="edit" data-id="' + dbId + '">' +
            '<i class="fas fa-pen"></i> Edit Details' +
        '</button>' +
        '<div class="action-drop-divider"></div>' +
        '<button class="action-drop-item drop-status" data-action="toggle-status" data-id="' + dbId + '">' +
            '<i class="fas fa-' + (isDropped ? 'user-check' : 'user-slash') + '"></i> ' +
            (isDropped ? 'Mark as Active' : 'Mark as Dropped') +
        '</button>' +
        '<div class="action-drop-divider"></div>' +
        '<button class="action-drop-item drop-delete" data-action="delete" data-id="' + dbId + '">' +
            '<i class="fas fa-trash"></i> Delete Record' +
        '</button>';
    document.body.appendChild(dd);
}

function closeActionDropdown() {
    var dd = document.getElementById('actionDropdown');
    if (dd) dd.remove();
    if (openDropId) {
        var btn = document.querySelector('.action-trigger-btn[data-id="' + openDropId + '"]');
        if (btn) btn.classList.remove('open');
    }
    openDropId = null;
}

// ── Toast ─────────────────────────────────────────────────────
function showToast(message) {
    var toast = document.getElementById('toast');
    var msg   = document.getElementById('toastMessage');
    if (!toast) return;
    msg.textContent = message;
    toast.classList.add('show');
    setTimeout(function() { toast.classList.remove('show'); }, 2800);
}

// ── Modal ─────────────────────────────────────────────────────
var modal        = document.getElementById('studentModal');
var modalIcon    = document.getElementById('modalIcon');
var modalTitle   = document.getElementById('modalTitle');
var modalSub     = document.getElementById('modalSubtitle');
var modalSaveBtn = document.getElementById('modalSaveBtn');

function showModal(isEdit, student) {
    var form = document.getElementById('studentForm');
    form.reset();

    if (isEdit && student) {
        editingDbId = student.id;
        modalIcon.className    = 'fas fa-user-edit';
        modalTitle.textContent = 'Edit Student Record';
        modalSub.textContent   = 'Updating details for ' + student.name + '.';
        modalSaveBtn.innerHTML = '<i class="fas fa-save"></i> Save Changes';

        document.getElementById('sID').value     = student.studentId;
        document.getElementById('sID').readOnly  = true;
        document.getElementById('sName').value   = student.name;
        document.getElementById('sEmail').value  = student.email;
        document.getElementById('sGrade').value  = String(student.grade);
        document.getElementById('sSection').value = student.section;
        document.getElementById('sStatus').value  = student.status;
    } else {
        editingDbId = null;
        modalIcon.className    = 'fas fa-user-plus';
        modalTitle.textContent = 'Add New Student';
        modalSub.textContent   = 'Fill in the details to enroll a new student.';
        modalSaveBtn.innerHTML = '<i class="fas fa-save"></i> Save Student';
        document.getElementById('sID').readOnly = false;
    }
    modal.classList.add('active');
}

function hideModal() {
    modal.classList.remove('active');
    editingDbId = null;
}

// ── AJAX helpers ──────────────────────────────────────────────
function apiFetch(url, method, body) {
    return fetch(url, {
        method:  method,
        headers: {
            'Content-Type':  'application/json',
            'Accept':        'application/json',
            'X-CSRF-TOKEN':  csrfToken(),
        },
        body: body ? JSON.stringify(body) : undefined,
    }).then(function(r) {
        if (!r.ok) return r.json().then(function(e) { throw e; });
        return r.json();
    });
}

// ── DOMContentLoaded ─────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {

    // Mobile nav
    var hamburgerBtn = document.getElementById('hamburger-btn');
    var overlay      = document.getElementById('mobile-nav-overlay');
    var drawer       = document.getElementById('mobile-nav-drawer');
    var mobileClose  = document.getElementById('mobile-nav-close');
    function openDrawer()  { drawer.classList.add('open'); overlay.classList.add('open'); }
    function closeDrawer() { drawer.classList.remove('open'); overlay.classList.remove('open'); }
    if (hamburgerBtn) hamburgerBtn.addEventListener('click', openDrawer);
    if (mobileClose)  mobileClose.addEventListener('click', closeDrawer);
    if (overlay)      overlay.addEventListener('click', closeDrawer);

    // Initial render
    updateHeaderCounts();
    renderTable();

    // Search
    document.getElementById('studentSearch').addEventListener('input', function() {
        searchTerm  = this.value;
        currentPage = 1;
        renderTable();
    });

    // ── Custom filter dropdowns ──────────────────────────────
    function setupFilterDropdown(dropdownId, panelId, triggerId, labelId, onSelect) {
        var dropdown = document.getElementById(dropdownId);
        var panel    = document.getElementById(panelId);
        var trigger  = document.getElementById(triggerId);
        var label    = document.getElementById(labelId);

        trigger.addEventListener('click', function(e) {
            e.stopPropagation();
            var isOpen = dropdown.classList.contains('open');
            document.querySelectorAll('.custom-filter-dropdown.open').forEach(function(d) { d.classList.remove('open'); });
            if (!isOpen) dropdown.classList.add('open');
        });

        panel.addEventListener('click', function(e) {
            var opt = e.target.closest('.filter-opt');
            if (!opt) return;
            var value = opt.dataset.value;
            panel.querySelectorAll('.filter-opt').forEach(function(o) { o.classList.remove('active'); });
            opt.classList.add('active');
            label.textContent = opt.textContent.trim().replace(/\s+/g, ' ');
            value ? trigger.classList.add('has-filter') : trigger.classList.remove('has-filter');
            dropdown.classList.remove('open');
            onSelect(value);
        });
    }

    setupFilterDropdown('gradeDropdown', 'gradePanel', 'gradeTrigger', 'gradeTriggerLabel', function(val) {
        gradeFilter = val; currentPage = 1; renderTable();
    });
    setupFilterDropdown('statusDropdown', 'statusPanel', 'statusTrigger', 'statusTriggerLabel', function(val) {
        statusFilter = val; currentPage = 1; renderTable();
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.custom-filter-dropdown')) {
            document.querySelectorAll('.custom-filter-dropdown.open').forEach(function(d) { d.classList.remove('open'); });
        }
    });

    // Open add modal
    document.getElementById('openAddModal').addEventListener('click', function() { showModal(false); });

    // Close modal
    document.getElementById('closeModal').addEventListener('click', hideModal);
    document.getElementById('cancelBtn').addEventListener('click', hideModal);
    modal.addEventListener('click', function(e) { if (e.target === modal) hideModal(); });

    // Table click — action trigger
    document.getElementById('studentTbody').addEventListener('click', function(e) {
        var triggerBtn = e.target.closest('.action-trigger-btn');
        if (triggerBtn) {
            e.stopPropagation();
            var sid = triggerBtn.dataset.id;
            if (openDropId == sid) { closeActionDropdown(); return; }
            openActionDropdown(triggerBtn, sid);
        }
    });

    // Dropdown item clicks
    document.addEventListener('click', function(e) {
        var item = e.target.closest('.action-drop-item');
        if (item) {
            var action = item.dataset.action;
            var dbId   = item.dataset.id;
            closeActionDropdown();

            if (action === 'edit') {
                var student = STUDENTS.find(function(s) { return s.id == dbId; });
                if (student) showModal(true, student);

            } else if (action === 'toggle-status') {
                var student = STUDENTS.find(function(s) { return s.id == dbId; });
                if (!student) return;
                var newStatus = student.status === 'dropped' ? 'active' : 'dropped';
                apiFetch(window.studentRoutes.update + '/' + dbId, 'PATCH', { status: newStatus })
                    .then(function() {
                        student.status = newStatus;
                        updateHeaderCounts();
                        renderTable();
                        showToast(student.name + ' marked as ' + newStatus + '.');
                    })
                    .catch(function() { showToast('Error updating status.'); });

            } else if (action === 'delete') {
                var student = STUDENTS.find(function(s) { return s.id == dbId; });
                if (!student) return;
                if (!confirm('Permanently delete ' + student.name + ' from records?')) return;
                apiFetch(window.studentRoutes.destroy + '/' + dbId, 'DELETE')
                    .then(function() {
                        var idx = STUDENTS.findIndex(function(s) { return s.id == dbId; });
                        if (idx !== -1) STUDENTS.splice(idx, 1);
                        updateHeaderCounts();
                        renderTable();
                        showToast('Student record deleted.');
                    })
                    .catch(function() { showToast('Error deleting record.'); });
            }
            return;
        }

        if (!e.target.closest('.action-trigger-btn') && !e.target.closest('#actionDropdown')) {
            closeActionDropdown();
        }
    });

    window.addEventListener('scroll', closeActionDropdown, true);

    // Form submit — add or update
    document.getElementById('studentForm').addEventListener('submit', function(e) {
        e.preventDefault();

        var studentId = document.getElementById('sID').value.trim();
        var name      = document.getElementById('sName').value.trim();
        var email     = document.getElementById('sEmail').value.trim();
        var grade     = parseInt(document.getElementById('sGrade').value);
        var section   = document.getElementById('sSection').value.trim();
        var status    = document.getElementById('sStatus').value;
        var gradeLevel = 'Grade ' + grade;

        if (editingDbId) {
            apiFetch(window.studentRoutes.update + '/' + editingDbId, 'PATCH',
                { name: name, email: email, grade_level: gradeLevel, section: section, status: status })
                .then(function() {
                    var s = STUDENTS.find(function(x) { return x.id == editingDbId; });
                    if (s) { s.name = name; s.email = email; s.grade = grade; s.section = section; s.status = status; }
                    updateHeaderCounts();
                    renderTable();
                    showToast('Student updated successfully.');
                    hideModal();
                })
                .catch(function(err) {
                    showToast(err.message || 'Error updating student.');
                });
        } else {
            apiFetch(window.studentRoutes.store, 'POST',
                { student_id: studentId, name: name, email: email, grade_level: gradeLevel, section: section, status: status })
                .then(function(data) {
                    STUDENTS.push({ id: data.id, studentId: data.student_id, name: name, email: email, grade: grade, section: section, status: status });
                    updateHeaderCounts();
                    renderTable();
                    showToast('Student added successfully.');
                    hideModal();
                })
                .catch(function(err) {
                    showToast(err.message || 'Error adding student.');
                });
        }
    });
});
