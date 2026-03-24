// ============================================================
// DWCU ADMIN — FACULTY MANAGEMENT
// ============================================================

document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // ── Mobile nav ──────────────────────────────────────────
    const hamburgerBtn  = document.getElementById('hamburger-btn');
    const overlay       = document.getElementById('mobile-nav-overlay');
    const drawer        = document.getElementById('mobile-nav-drawer');
    const mobileClose   = document.getElementById('mobile-nav-close');
    function openDrawer()  { drawer.classList.add('open');    overlay.classList.add('open'); }
    function closeDrawer() { drawer.classList.remove('open'); overlay.classList.remove('open'); }
    if (hamburgerBtn) hamburgerBtn.addEventListener('click', openDrawer);
    if (mobileClose)  mobileClose.addEventListener('click', closeDrawer);
    if (overlay)      overlay.addEventListener('click', closeDrawer);

    // ── Modal refs ───────────────────────────────────────────
    const modal          = document.getElementById('facultyModal');
    const modalIcon      = document.getElementById('modalIcon');
    const modalTitle     = document.getElementById('modalTitle');
    const modalSubtitle  = document.getElementById('modalSubtitle');
    const modalSaveBtn   = document.getElementById('modalSaveBtn');
    const permSection    = document.getElementById('permissionsSection');
    const facultyForm    = document.getElementById('facultyForm');
    let currentEditId    = null;

    // ── Action dropdown state ────────────────────────────────
    let openDropId = null;

    // ── Initials helper ──────────────────────────────────────
    function getInitials(name) {
        const words = name.replace(/^(Mr\.|Mrs\.|Ms\.|Dr\.)\s*/i, '').trim().split(/\s+/);
        return words.length >= 2
            ? (words[0][0] + words[words.length - 1][0]).toUpperCase()
            : name.substring(0, 2).toUpperCase();
    }

    // ── Modal show / hide ────────────────────────────────────
    function showModal(isEdit, row) {
        facultyForm.reset();

        if (isEdit && row) {
            currentEditId            = row.dataset.id;
            modalIcon.className      = 'fas fa-user-edit';
            modalTitle.textContent   = 'Edit Faculty Member';
            modalSubtitle.textContent = 'Update the details for ' + row.dataset.name + '.';
            modalSaveBtn.innerHTML   = '<i class="fas fa-save"></i> Update Faculty';

            document.getElementById('fID').value    = row.dataset.facultyId;
            document.getElementById('fID').readOnly = true;
            document.getElementById('fName').value  = row.dataset.name;
            document.getElementById('fTitle').value = row.dataset.designation;

            const deptEl = document.getElementById('fDept');
            Array.from(deptEl.options).forEach(function (opt) {
                opt.selected = opt.text === row.dataset.department;
            });

            permSection.style.display = 'block';
        } else {
            currentEditId            = null;
            modalIcon.className      = 'fas fa-user-plus';
            modalTitle.textContent   = 'Add New Faculty';
            modalSubtitle.textContent = 'Fill in the details to register a new faculty member.';
            modalSaveBtn.innerHTML   = '<i class="fas fa-save"></i> Save Faculty Member';
            document.getElementById('fID').readOnly = false;
            permSection.style.display = 'none';
        }

        modal.classList.add('active');
    }

    function hideModal() {
        modal.classList.remove('active');
        facultyForm.reset();
        currentEditId = null;
    }

    document.getElementById('openAddModal').addEventListener('click', function () { showModal(false); });
    document.getElementById('closeFacultyModal').addEventListener('click', hideModal);
    document.getElementById('cancelFacultyBtn').addEventListener('click', hideModal);
    modal.addEventListener('click', function (e) { if (e.target === modal) hideModal(); });

    // ── Action dropdown ──────────────────────────────────────
    function openActionDropdown(btn, rowId) {
        closeActionDropdown();
        openDropId = rowId;
        btn.classList.add('open');

        const rect = btn.getBoundingClientRect();
        const dd   = document.createElement('div');
        dd.id        = 'actionDropdown';
        dd.className = 'action-dropdown';
        dd.style.top  = (rect.bottom + 6) + 'px';
        dd.style.left = rect.left + 'px';

        dd.innerHTML =
            '<button class="action-drop-item drop-edit" data-action="edit" data-row-id="' + rowId + '">' +
                '<i class="fas fa-pen"></i> Edit Details' +
            '</button>' +
            '<div class="action-drop-divider"></div>' +
            '<button class="action-drop-item drop-delete" data-action="delete" data-row-id="' + rowId + '">' +
                '<i class="fas fa-trash"></i> Remove Faculty' +
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

    // Table body: trigger button clicks
    document.getElementById('facultyTbody').addEventListener('click', function (e) {
        var triggerBtn = e.target.closest('.action-trigger-btn');
        if (!triggerBtn) return;
        e.stopPropagation();
        var rowId = triggerBtn.dataset.id;
        if (openDropId === rowId) { closeActionDropdown(); return; }
        openActionDropdown(triggerBtn, rowId);
    });

    // Dropdown item clicks
    document.addEventListener('click', function (e) {
        var item = e.target.closest('.action-drop-item');
        if (item) {
            var action = item.dataset.action;
            var rowId  = item.dataset.rowId;
            closeActionDropdown();

            var row = document.querySelector('tr[data-id="' + rowId + '"]');
            if (!row) return;

            if (action === 'edit') {
                showModal(true, row);
            } else if (action === 'delete') {
                var name = row.dataset.name;
                if (!confirm('Remove ' + name + ' from the faculty directory?')) return;
                fetch(window.facultyRoutes.destroy + '/' + rowId, {
                    method:  'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    if (data.success) {
                        row.style.transition = 'opacity 0.3s, transform 0.3s';
                        row.style.opacity    = '0';
                        row.style.transform  = 'translateX(30px)';
                        setTimeout(function () { row.remove(); renderPagination(); }, 320);
                    }
                });
            }
            return;
        }

        // Close on outside click
        if (!e.target.closest('.action-trigger-btn') && !e.target.closest('#actionDropdown')) {
            closeActionDropdown();
        }
    });

    // Close dropdown on scroll
    window.addEventListener('scroll', closeActionDropdown, true);

    // ── Form submit (add / edit) ─────────────────────────────
    facultyForm.addEventListener('submit', function (e) {
        e.preventDefault();

        var body = {
            faculty_id:  document.getElementById('fID').value.trim(),
            name:        document.getElementById('fName').value.trim(),
            designation: document.getElementById('fTitle').value.trim(),
            department:  document.getElementById('fDept').value,
        };

        if (currentEditId) {
            // PATCH — edit existing
            fetch(window.facultyRoutes.update + '/' + currentEditId, {
                method:  'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body:    JSON.stringify(body),
            })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (!data.success) return;
                var f   = data.faculty;
                var row = document.querySelector('tr[data-id="' + currentEditId + '"]');
                if (!row) return;

                row.dataset.name        = f.name;
                row.dataset.designation = f.designation;
                row.dataset.department  = f.department;

                var ini = getInitials(f.name);
                row.cells[1].innerHTML =
                    '<div class="user-info">' +
                        '<div class="user-avatar">' + ini + '</div>' +
                        '<span class="user-name-text">' + f.name + '</span>' +
                    '</div>';
                row.cells[2].textContent = f.designation;
                row.cells[3].textContent = f.department;

                hideModal();
                renderPagination();
            });
        } else {
            // POST — add new
            fetch(window.facultyRoutes.store, {
                method:  'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body:    JSON.stringify(body),
            })
            .then(function (res) {
                if (res.status === 422) { alert('Faculty ID already exists.'); throw new Error(); }
                return res.json();
            })
            .then(function (data) {
                if (!data.success) return;
                var f  = data.faculty;
                var tr = document.createElement('tr');
                tr.dataset.id          = f.id;
                tr.dataset.facultyId   = f.faculty_id;
                tr.dataset.name        = f.name;
                tr.dataset.designation = f.designation;
                tr.dataset.department  = f.department;

                var ini = getInitials(f.name);
                tr.innerHTML =
                    '<td><span class="id-badge">' + f.faculty_id + '</span></td>' +
                    '<td><div class="user-info">' +
                        '<div class="user-avatar">' + ini + '</div>' +
                        '<span class="user-name-text">' + f.name + '</span>' +
                    '</div></td>' +
                    '<td>' + f.designation + '</td>' +
                    '<td>' + f.department + '</td>' +
                    '<td><span class="status-pill active">Active</span></td>' +
                    '<td><button class="action-trigger-btn" data-id="' + f.id + '">' +
                        'Actions <i class="fas fa-chevron-down"></i>' +
                    '</button></td>';

                document.getElementById('facultyTbody').appendChild(tr);
                hideModal();
                renderPagination();
            })
            .catch(function () {});
        }
    });

    // ── Pagination ───────────────────────────────────────────
    var ROWS_PER_PAGE   = 5;
    var currentPage     = 1;
    var currentSearch   = '';

    function renderPagination() {
        var tbody      = document.getElementById('facultyTbody');
        var allRows    = Array.from(tbody.querySelectorAll('tr'));
        var q          = currentSearch.toLowerCase();
        var matching   = allRows.filter(function (r) {
            return r.innerText.toLowerCase().includes(q);
        });

        var totalPages = Math.max(1, Math.ceil(matching.length / ROWS_PER_PAGE));
        currentPage    = Math.min(currentPage, totalPages);

        allRows.forEach(function (r) { r.style.display = 'none'; });
        matching.slice((currentPage - 1) * ROWS_PER_PAGE, currentPage * ROWS_PER_PAGE)
                .forEach(function (r) { r.style.display = ''; });

        var start = matching.length === 0 ? 0 : (currentPage - 1) * ROWS_PER_PAGE + 1;
        var end   = Math.min(currentPage * ROWS_PER_PAGE, matching.length);
        document.getElementById('paginationInfo').textContent = matching.length === 0
            ? 'No results found'
            : 'Showing ' + start + '–' + end + ' of ' + matching.length + ' faculty';

        var controls = document.getElementById('paginationControls');
        controls.innerHTML = '';

        var prev = document.createElement('button');
        prev.innerHTML = '<i class="fas fa-chevron-left"></i>';
        prev.disabled  = currentPage === 1;
        prev.addEventListener('click', function () { currentPage--; renderPagination(); });
        controls.appendChild(prev);

        for (var p = 1; p <= totalPages; p++) {
            (function (pg) {
                var btn = document.createElement('button');
                btn.textContent = pg;
                if (pg === currentPage) btn.classList.add('active');
                btn.addEventListener('click', function () { currentPage = pg; renderPagination(); });
                controls.appendChild(btn);
            })(p);
        }

        var next = document.createElement('button');
        next.innerHTML = '<i class="fas fa-chevron-right"></i>';
        next.disabled  = currentPage === totalPages;
        next.addEventListener('click', function () { currentPage++; renderPagination(); });
        controls.appendChild(next);
    }

    renderPagination();

    // ── Search ───────────────────────────────────────────────
    document.getElementById('facultySearch').addEventListener('input', function () {
        currentSearch = this.value;
        currentPage   = 1;
        renderPagination();
    });
});
