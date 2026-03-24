'use strict';

/* ── Data & state ─────────────────────────────────────────── */
var ANNOUNCEMENTS  = window.ANNOUNCEMENTS || [];
var searchQuery    = '';
var categoryFilter = '';
var audienceFilter = '';
var currentPage    = 1;
var ROWS_PER_PAGE  = 8;

/* ── Helpers ──────────────────────────────────────────────── */
function formatDate(dateStr) {
    var d = new Date(dateStr + 'T00:00:00');
    return d.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
}

var CAT_LABELS = { general: 'General', academic: 'Academic', event: 'Event', urgent: 'Urgent' };
var AUD_LABELS = { all: 'All Students', jhs: 'JHS Only', shs: 'SHS Only' };

function getFiltered() {
    var q = searchQuery.toLowerCase();
    return ANNOUNCEMENTS.filter(function (a) {
        var matchSearch = !q || a.title.toLowerCase().includes(q)
                              || a.author.toLowerCase().includes(q)
                              || a.content.toLowerCase().includes(q);
        var matchCat = !categoryFilter || a.category === categoryFilter;
        var matchAud = !audienceFilter || a.audience === audienceFilter;
        return matchSearch && matchCat && matchAud;
    });
}

function updateHeaderCounts() {
    var total = ANNOUNCEMENTS.length;
    document.getElementById('headerSubtitle').textContent =
        total + ' announcement' + (total !== 1 ? 's' : '') + ' in the broadcast system';
    document.getElementById('cardSubtitle').textContent =
        total + ' total broadcast' + (total !== 1 ? 's' : '');
}

/* ── AJAX helper ──────────────────────────────────────────── */
function apiFetch(url, method, body) {
    var csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    var opts = {
        method:  method,
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' },
    };
    if (body) opts.body = JSON.stringify(body);
    return fetch(url, opts).then(function (r) { return r.json(); });
}

/* ── Toast ────────────────────────────────────────────────── */
function showToast(message) {
    var toast = document.getElementById('toast');
    document.getElementById('toastMessage').textContent = message;
    toast.classList.add('show');
    setTimeout(function () { toast.classList.remove('show'); }, 2800);
}

/* ── Table render ─────────────────────────────────────────── */
function renderTable() {
    var filtered   = getFiltered();
    var totalPages = Math.max(1, Math.ceil(filtered.length / ROWS_PER_PAGE));
    if (currentPage > totalPages) currentPage = totalPages;
    var start     = (currentPage - 1) * ROWS_PER_PAGE;
    var pageItems = filtered.slice(start, start + ROWS_PER_PAGE);

    var tbody = document.getElementById('annTbody');
    tbody.innerHTML = '';

    if (pageItems.length === 0) {
        tbody.innerHTML =
            '<tr><td colspan="6" class="empty-state-cell">' +
                '<i class="fas fa-bullhorn"></i>' +
                '<p>No announcements found.</p>' +
            '</td></tr>';
        document.getElementById('paginationInfo').textContent = '';
        document.getElementById('paginationControls').innerHTML = '';
        return;
    }

    pageItems.forEach(function (a) {
        var tr      = document.createElement('tr');
        var preview = a.content.length > 65 ? a.content.slice(0, 65) + '\u2026' : a.content;
        tr.innerHTML =
            '<td><div class="ann-date-text">' + formatDate(a.date) + '</div></td>' +
            '<td><div class="ann-author-wrap">' +
                '<div class="ann-avatar">' + a.initials + '</div>' +
                '<span class="ann-author-name">' + a.author + '</span>' +
            '</div></td>' +
            '<td class="ann-msg-cell">' +
                '<div class="ann-title-text">' + a.title + '</div>' +
                '<div class="ann-preview-text">' + preview + '</div>' +
            '</td>' +
            '<td><span class="cat-badge ' + a.category + '">' + (CAT_LABELS[a.category] || a.category) + '</span></td>' +
            '<td><span class="aud-badge ' + a.audience + '">' + (AUD_LABELS[a.audience] || a.audience) + '</span></td>' +
            '<td><button class="action-trigger-btn" data-id="' + a.id + '" aria-label="Actions">' +
                '<i class="fas fa-ellipsis-h"></i>' +
            '</button></td>';
        tbody.appendChild(tr);
    });

    tbody.querySelectorAll('.action-trigger-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            openActionDropdown(btn, parseInt(btn.dataset.id));
        });
    });

    // Pagination info
    document.getElementById('paginationInfo').textContent =
        'Showing ' + (start + 1) + '\u2013' + Math.min(start + ROWS_PER_PAGE, filtered.length) + ' of ' + filtered.length;

    // Pagination controls
    var ctrl = document.getElementById('paginationControls');
    ctrl.innerHTML = '';

    var prevBtn = document.createElement('button');
    prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
    prevBtn.disabled  = currentPage === 1;
    prevBtn.addEventListener('click', function () { currentPage--; renderTable(); });
    ctrl.appendChild(prevBtn);

    for (var p = 1; p <= totalPages; p++) {
        (function (pg) {
            var pb = document.createElement('button');
            pb.textContent = pg;
            if (pg === currentPage) pb.classList.add('active');
            pb.addEventListener('click', function () { currentPage = pg; renderTable(); });
            ctrl.appendChild(pb);
        })(p);
    }

    var nextBtn = document.createElement('button');
    nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
    nextBtn.disabled  = currentPage === totalPages;
    nextBtn.addEventListener('click', function () { currentPage++; renderTable(); });
    ctrl.appendChild(nextBtn);
}

/* ── Action Dropdown ──────────────────────────────────────── */
var _openDropBtn = null;

function positionDropPanel(btn) {
    var panel = document.getElementById('activeDropPanel');
    if (!panel || !btn) return;
    var rect = btn.getBoundingClientRect();
    panel.style.top   = (rect.bottom + 4) + 'px';
    panel.style.right = (window.innerWidth - rect.right) + 'px';
}

function openActionDropdown(btn, aid) {
    closeActionDropdown();
    var ann = ANNOUNCEMENTS.find(function (a) { return a.id === aid; });
    if (!ann) return;

    var panel = document.createElement('div');
    panel.className = 'action-dropdown-panel';
    panel.id = 'activeDropPanel';
    panel.innerHTML =
        '<div class="action-drop-item" id="dropEdit">' +
            '<i class="fas fa-pencil-alt"></i> Edit Announcement' +
        '</div>' +
        '<div class="action-drop-item drop-delete" id="dropDelete">' +
            '<i class="fas fa-trash-alt"></i> Delete Announcement' +
        '</div>';
    document.body.appendChild(panel);

    _openDropBtn = btn;
    positionDropPanel(btn);

    panel.querySelector('#dropEdit').addEventListener('click', function () {
        closeActionDropdown();
        showModal(true, ann);
    });

    panel.querySelector('#dropDelete').addEventListener('click', function () {
        closeActionDropdown();
        apiFetch(window.annRoutes.destroy + '/' + aid, 'DELETE', null)
            .then(function (data) {
                if (data.success) {
                    var idx = ANNOUNCEMENTS.findIndex(function (a) { return a.id === aid; });
                    if (idx !== -1) ANNOUNCEMENTS.splice(idx, 1);
                    renderTable();
                    updateHeaderCounts();
                    renderCalendar();
                    showToast('Announcement deleted.');
                }
            });
    });
}

function closeActionDropdown() {
    var old = document.getElementById('activeDropPanel');
    if (old) old.remove();
    _openDropBtn = null;
}

/* ── Modal custom selects ─────────────────────────────────── */
var modalCategoryVal = '';
var modalAudienceVal = '';

function closeAllModalSelects() {
    document.querySelectorAll('.modal-select-panel.open').forEach(function (p) { p.classList.remove('open'); });
    document.querySelectorAll('.modal-select-trigger.open').forEach(function (t) { t.classList.remove('open'); });
}

function setupModalSelect(triggerId, panelId, onSelect) {
    var trigger = document.getElementById(triggerId);
    var panel   = document.getElementById(panelId);

    trigger.addEventListener('click', function (e) {
        e.stopPropagation();
        var isOpen = panel.classList.contains('open');
        closeAllModalSelects();
        if (!isOpen) {
            panel.classList.add('open');
            trigger.classList.add('open');
        }
    });

    panel.querySelectorAll('.modal-sel-opt').forEach(function (opt) {
        opt.addEventListener('click', function () {
            panel.querySelectorAll('.modal-sel-opt').forEach(function (o) { o.classList.remove('selected'); });
            opt.classList.add('selected');
            var labelEl  = document.getElementById(triggerId.replace('Trigger', 'Label'));
            var textSpan = opt.querySelectorAll('span')[1];
            if (labelEl && textSpan) labelEl.textContent = textSpan.textContent.trim();
            trigger.classList.add('has-value');
            trigger.classList.remove('open');
            panel.classList.remove('open');
            onSelect(opt.dataset.value);
        });
    });
}

function setModalSelect(triggerId, panelId, val) {
    var trigger = document.getElementById(triggerId);
    var panel   = document.getElementById(panelId);
    var labelEl = document.getElementById(triggerId.replace('Trigger', 'Label'));
    panel.querySelectorAll('.modal-sel-opt').forEach(function (opt) {
        opt.classList.toggle('selected', opt.dataset.value === val);
        if (opt.dataset.value === val && labelEl) {
            var textSpan = opt.querySelectorAll('span')[1];
            if (textSpan) labelEl.textContent = textSpan.textContent.trim();
        }
    });
    if (val) trigger.classList.add('has-value');
}

function resetModalSelect(triggerId, panelId, placeholder) {
    var trigger = document.getElementById(triggerId);
    var panel   = document.getElementById(panelId);
    var labelEl = document.getElementById(triggerId.replace('Trigger', 'Label'));
    panel.querySelectorAll('.modal-sel-opt').forEach(function (o) { o.classList.remove('selected'); });
    if (labelEl) labelEl.textContent = placeholder;
    trigger.classList.remove('has-value', 'open');
    panel.classList.remove('open');
}

/* ── Modal ────────────────────────────────────────────────── */
var editingId = null;

function showModal(isEdit, ann) {
    editingId = isEdit ? ann.id : null;
    var icon     = document.getElementById('modalIcon');
    var titleEl  = document.getElementById('modalTitle');
    var subtitle = document.getElementById('modalSubtitle');

    if (isEdit) {
        icon.className       = 'fas fa-pencil-alt';
        titleEl.textContent  = 'Edit Announcement';
        subtitle.textContent = 'Update the announcement details.';
        document.getElementById('aTitle').value   = ann.title;
        document.getElementById('aDate').value    = ann.date;
        document.getElementById('aContent').value = ann.content;
        setModalSelect('mCatTrigger', 'mCatPanel', ann.category);
        setModalSelect('mAudTrigger', 'mAudPanel', ann.audience);
        modalCategoryVal = ann.category;
        modalAudienceVal = ann.audience;
    } else {
        icon.className       = 'fas fa-bullhorn';
        titleEl.textContent  = 'Create Announcement';
        subtitle.textContent = 'Broadcast a new announcement to the portal.';
        document.getElementById('aTitle').value   = '';
        document.getElementById('aDate').value    = new Date().toISOString().slice(0, 10);
        document.getElementById('aContent').value = '';
        resetModalSelect('mCatTrigger', 'mCatPanel', 'Select Category');
        resetModalSelect('mAudTrigger', 'mAudPanel', 'Select Audience');
        modalCategoryVal = '';
        modalAudienceVal = '';
    }

    document.getElementById('annModal').classList.add('open');
}

function hideModal() {
    document.getElementById('annModal').classList.remove('open');
    closeAllModalSelects();
    editingId = null;
}

/* ── Filter dropdowns ─────────────────────────────────────── */
function setupFilterDropdown(panelId, triggerId, labelId, onSelect) {
    var panel   = document.getElementById(panelId);
    var trigger = document.getElementById(triggerId);
    var labelEl = document.getElementById(labelId);

    trigger.addEventListener('click', function (e) {
        e.stopPropagation();
        var isOpen = panel.classList.contains('open');
        document.querySelectorAll('.filter-panel.open').forEach(function (p) { p.classList.remove('open'); });
        document.querySelectorAll('.filter-trigger.open').forEach(function (t) { t.classList.remove('open'); });
        if (!isOpen) {
            panel.classList.add('open');
            trigger.classList.add('open');
        }
    });

    panel.querySelectorAll('.filter-opt').forEach(function (opt) {
        opt.addEventListener('click', function () {
            panel.querySelectorAll('.filter-opt').forEach(function (o) { o.classList.remove('active'); });
            opt.classList.add('active');
            var textEl = opt.querySelector('.opt-text');
            labelEl.textContent = textEl ? textEl.textContent.trim() : opt.textContent.trim();
            panel.classList.remove('open');
            trigger.classList.remove('open');
            var val = opt.dataset.value;
            if (val) { trigger.classList.add('has-filter'); } else { trigger.classList.remove('has-filter'); }
            onSelect(val);
        });
    });
}

/* ── Calendar ─────────────────────────────────────────────── */
function renderCalendar() {
    var now   = new Date();
    var year  = now.getFullYear();
    var month = now.getMonth();
    var today = now.getDate();

    var MONTH_NAMES = ['January','February','March','April','May','June',
                       'July','August','September','October','November','December'];
    document.getElementById('currentMonth').textContent = MONTH_NAMES[month] + ' ' + year;

    var firstDay    = new Date(year, month, 1).getDay();
    var daysInMonth = new Date(year, month + 1, 0).getDate();

    var annDays = new Set();
    ANNOUNCEMENTS.forEach(function (a) {
        var d = new Date(a.date + 'T00:00:00');
        if (d.getFullYear() === year && d.getMonth() === month) {
            annDays.add(d.getDate());
        }
    });

    var grid = document.getElementById('calendarGrid');
    grid.innerHTML = '';

    for (var i = 0; i < firstDay; i++) {
        grid.appendChild(document.createElement('span'));
    }

    for (var d = 1; d <= daysInMonth; d++) {
        var span = document.createElement('span');
        span.textContent = d;
        if (d === today)    span.classList.add('today');
        if (annDays.has(d)) span.classList.add('has-ann');
        grid.appendChild(span);
    }
}

/* ── DOMContentLoaded ─────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', function () {

    // Mobile nav
    var hamburgerBtn = document.getElementById('hamburger-btn');
    var overlay      = document.getElementById('mobile-nav-overlay');
    var drawer       = document.getElementById('mobile-nav-drawer');
    var mobileClose  = document.getElementById('mobile-nav-close');

    function openDrawer()  { drawer.classList.add('open');    overlay.classList.add('open'); }
    function closeDrawer() { drawer.classList.remove('open'); overlay.classList.remove('open'); }

    if (hamburgerBtn) hamburgerBtn.addEventListener('click', openDrawer);
    if (mobileClose)  mobileClose.addEventListener('click', closeDrawer);
    if (overlay)      overlay.addEventListener('click', closeDrawer);

    // Modal custom selects
    setupModalSelect('mCatTrigger', 'mCatPanel', function (val) { modalCategoryVal = val; });
    setupModalSelect('mAudTrigger', 'mAudPanel', function (val) { modalAudienceVal = val; });

    // Reposition action dropdown on scroll
    window.addEventListener('scroll', function () { positionDropPanel(_openDropBtn); }, true);

    // Global click — close dropdowns
    document.addEventListener('click', function (e) {
        if (!e.target.closest('#activeDropPanel') && !e.target.closest('.action-trigger-btn')) {
            closeActionDropdown();
        }
        if (!e.target.closest('.custom-filter-dropdown')) {
            document.querySelectorAll('.filter-panel.open').forEach(function (p) { p.classList.remove('open'); });
            document.querySelectorAll('.filter-trigger.open').forEach(function (t) { t.classList.remove('open'); });
        }
        if (!e.target.closest('.modal-select-wrap')) {
            closeAllModalSelects();
        }
    });

    // Search
    document.getElementById('annSearch').addEventListener('input', function (e) {
        searchQuery = e.target.value;
        currentPage = 1;
        renderTable();
    });

    // Filter dropdowns
    setupFilterDropdown('categoryPanel', 'categoryTrigger', 'categoryTriggerLabel', function (val) {
        categoryFilter = val;
        currentPage = 1;
        renderTable();
    });

    setupFilterDropdown('audiencePanel', 'audienceTrigger', 'audienceTriggerLabel', function (val) {
        audienceFilter = val;
        currentPage = 1;
        renderTable();
    });

    // Modal open / close
    document.getElementById('openAddModal').addEventListener('click', function () { showModal(false, null); });
    document.getElementById('closeModal').addEventListener('click', hideModal);
    document.getElementById('cancelBtn').addEventListener('click', hideModal);
    document.getElementById('annModal').addEventListener('click', function (e) {
        if (e.target === document.getElementById('annModal')) hideModal();
    });

    // Form submit
    document.getElementById('annForm').addEventListener('submit', function (e) {
        e.preventDefault();
        var title    = document.getElementById('aTitle').value.trim();
        var date     = document.getElementById('aDate').value;
        var content  = document.getElementById('aContent').value.trim();
        var category = modalCategoryVal;
        var audience = modalAudienceVal;

        if (!category) {
            var ct = document.getElementById('mCatTrigger');
            ct.style.borderColor = '#be123c';
            setTimeout(function () { ct.style.borderColor = ''; }, 1500);
            return;
        }
        if (!audience) {
            var at = document.getElementById('mAudTrigger');
            at.style.borderColor = '#be123c';
            setTimeout(function () { at.style.borderColor = ''; }, 1500);
            return;
        }

        var body = { title: title, target_date: date, content: content, category: category, audience: audience };

        if (editingId) {
            apiFetch(window.annRoutes.update + '/' + editingId, 'PATCH', body)
                .then(function (data) {
                    if (data.success) {
                        var a   = data.announcement;
                        var idx = ANNOUNCEMENTS.findIndex(function (x) { return x.id === editingId; });
                        if (idx !== -1) {
                            ANNOUNCEMENTS[idx].title    = a.title;
                            ANNOUNCEMENTS[idx].date     = a.target_date;
                            ANNOUNCEMENTS[idx].content  = a.content;
                            ANNOUNCEMENTS[idx].category = a.category;
                            ANNOUNCEMENTS[idx].audience = a.audience;
                        }
                        hideModal();
                        renderTable();
                        updateHeaderCounts();
                        renderCalendar();
                        showToast('Announcement updated successfully.');
                    }
                });
        } else {
            apiFetch(window.annRoutes.store, 'POST', body)
                .then(function (data) {
                    if (data.success) {
                        var a      = data.announcement;
                        var words  = a.posted_by.replace(/^(Mr\.|Mrs\.|Ms\.|Dr\.)\s*/i, '').trim().split(/\s+/);
                        var inits  = ((words[0] || 'A')[0] + (words[words.length - 1] || '')[0]).toUpperCase();
                        ANNOUNCEMENTS.unshift({
                            id:       a.id,
                            date:     a.target_date,
                            author:   a.posted_by,
                            initials: inits,
                            title:    a.title,
                            content:  a.content,
                            category: a.category,
                            audience: a.audience,
                        });
                        currentPage = 1;
                        hideModal();
                        renderTable();
                        updateHeaderCounts();
                        renderCalendar();
                        showToast('Announcement posted successfully.');
                    }
                });
        }
    });

    // Initial render
    updateHeaderCounts();
    renderTable();
    renderCalendar();
});
