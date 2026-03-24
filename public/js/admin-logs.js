// ============================================================
// DWCU ADMIN — SYSTEM AUDIT LOGS
// Data comes from PHP via window.LOGS (set in blade template)
// ============================================================

let LOGS = window.LOGS || [];

// ── State ────────────────────────────────────────────────────
let searchQuery  = '';
let portalFilter = '';
let typeFilter   = '';
let currentPage  = 1;
const ROWS_PER_PAGE = 12;
let sortCol = 'timestamp';
let sortDir = 'desc';

// ── Helpers ──────────────────────────────────────────────────
function fmtDate(iso) {
    const d = new Date(iso);
    return d.toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' });
}
function fmtTime(iso) {
    const d = new Date(iso);
    return d.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
}

function getFiltered() {
    const q = searchQuery.toLowerCase();
    return LOGS.filter(l => {
        const matchSearch = !q ||
            l.user.toLowerCase().includes(q) ||
            l.action.toLowerCase().includes(q) ||
            l.portal.toLowerCase().includes(q) ||
            l.actionType.toLowerCase().includes(q);
        const matchPortal = !portalFilter || l.portal === portalFilter;
        const matchType   = !typeFilter   || l.actionType === typeFilter;
        return matchSearch && matchPortal && matchType;
    });
}

function getSorted(rows) {
    return [...rows].sort((a, b) => {
        let va, vb;
        if      (sortCol === 'timestamp')  { va = new Date(a.timestamp).getTime(); vb = new Date(b.timestamp).getTime(); }
        else if (sortCol === 'user')       { va = a.user.toLowerCase();       vb = b.user.toLowerCase(); }
        else if (sortCol === 'actionType') { va = a.actionType.toLowerCase(); vb = b.actionType.toLowerCase(); }
        else if (sortCol === 'portal')     { va = a.portal.toLowerCase();     vb = b.portal.toLowerCase(); }
        else if (sortCol === 'status')     { va = a.status.toLowerCase();     vb = b.status.toLowerCase(); }
        else                               { va = a.action.toLowerCase();     vb = b.action.toLowerCase(); }
        if (va < vb) return sortDir === 'asc' ? -1 : 1;
        if (va > vb) return sortDir === 'asc' ?  1 : -1;
        return 0;
    });
}

const TYPE_META = {
    drop:         { label: 'Student Drop', icon: 'fa-user-minus',      cls: 't-drop'         },
    announcement: { label: 'Announcement', icon: 'fa-bullhorn',         cls: 't-announcement' },
    login:        { label: 'Login/Logout', icon: 'fa-right-to-bracket', cls: 't-login'        },
    system:       { label: 'System Event', icon: 'fa-gear',             cls: 't-system'       },
};

const PORTAL_META = {
    admin:   { label: 'Admin Portal',   cls: 'p-admin'   },
    faculty: { label: 'Faculty Portal', cls: 'p-faculty' },
    jhs:     { label: 'JHS Portal',     cls: 'p-jhs'     },
    shs:     { label: 'SHS Portal',     cls: 'p-shs'     },
    system:  { label: 'System',         cls: 'p-system'  },
};

const STATUS_META = {
    success: { label: 'Success', cls: 's-success' },
    info:    { label: 'Info',    cls: 's-info'    },
    warning: { label: 'Warning', cls: 's-warning' },
};

const AVATAR_CLS = {
    admin:   '',
    faculty: 'av-faculty',
    jhs:     'av-jhs',
    shs:     'av-shs',
    system:  'av-system',
};

// ── Render Table ─────────────────────────────────────────────
function renderTable() {
    const filtered = getFiltered();
    const sorted   = getSorted(filtered);
    const total    = sorted.length;
    const pages    = Math.max(1, Math.ceil(total / ROWS_PER_PAGE));
    if (currentPage > pages) currentPage = pages;

    const start = (currentPage - 1) * ROWS_PER_PAGE;
    const slice = sorted.slice(start, start + ROWS_PER_PAGE);

    // Header subtitles
    const dropCount = LOGS.filter(l => l.actionType === 'drop').length;
    document.getElementById('headerSubtitle').textContent =
        LOGS.length + ' total entries across all portals \u00b7 ' + dropCount + ' student drop' + (dropCount !== 1 ? 's' : '') + ' recorded';
    document.getElementById('cardSubtitle').textContent =
        'Showing ' + total + ' of ' + LOGS.length + ' log entries';

    // Tbody
    const tbody = document.getElementById('logTbody');
    tbody.innerHTML = '';

    if (slice.length === 0) {
        tbody.innerHTML =
            '<tr><td colspan="6" style="text-align:center;padding:44px;color:#94a3b8;">' +
            '<i class="fas fa-search" style="font-size:1.6rem;display:block;margin-bottom:8px;"></i>' +
            'No logs match your filter.</td></tr>';
    } else {
        slice.forEach(l => {
            const tm     = TYPE_META[l.actionType]  || TYPE_META.system;
            const pm     = PORTAL_META[l.portal]    || PORTAL_META.system;
            const sm     = STATUS_META[l.status]    || STATUS_META.info;
            const av     = AVATAR_CLS[l.portal]     || '';
            const isDrop = l.actionType === 'drop';

            tbody.innerHTML +=
                '<tr' + (isDrop ? ' class="drop-row" data-id="' + l.id + '"' : '') + '>' +
                '<td style="color:#5a6685;" data-label="Timestamp">' +
                    '<span class="log-date">' + fmtDate(l.timestamp) + '</span>' +
                    '<span class="log-time">' + fmtTime(l.timestamp) + '</span>' +
                '</td>' +
                '<td data-label="User">' +
                    '<div class="log-user-cell">' +
                        '<div class="log-avatar ' + av + '">' + l.initials + '</div>' +
                        '<span class="log-user-name">' + l.user + '</span>' +
                    '</div>' +
                '</td>' +
                '<td class="log-action-cell" data-label="Action">' +
                    (isDrop ? '<i class="fas fa-triangle-exclamation drop-flag"></i>' : '') +
                    l.action +
                    (isDrop ? ' <span class="view-drop-hint"><i class="fas fa-eye"></i> View Details</span>' : '') +
                '</td>' +
                '<td data-label="Type">' +
                    '<span class="type-badge ' + tm.cls + '"><i class="fas ' + tm.icon + '"></i> ' + tm.label + '</span>' +
                '</td>' +
                '<td data-label="Portal">' +
                    '<span class="portal-badge ' + pm.cls + '">' + pm.label + '</span>' +
                '</td>' +
                '<td data-label="Status">' +
                    '<span class="status-pill ' + sm.cls + '">' + sm.label + '</span>' +
                '</td>' +
                '</tr>';
        });
    }

    // Sort icons
    document.querySelectorAll('.log-table th[data-col]').forEach(th => {
        const icon = th.querySelector('.sort-icon');
        if (!icon) return;
        if (th.dataset.col === sortCol) {
            icon.className = 'sort-icon fas fa-arrow-' + (sortDir === 'asc' ? 'up' : 'down') + ' active';
        } else {
            icon.className = 'sort-icon fas fa-sort';
        }
    });

    // Pagination info
    document.getElementById('paginationInfo').textContent =
        total === 0 ? '' : 'Showing ' + (start + 1) + '\u2013' + Math.min(start + ROWS_PER_PAGE, total) + ' of ' + total;

    // Pagination controls
    const ctrl = document.getElementById('paginationControls');
    ctrl.innerHTML = '';
    if (pages <= 1) return;

    function addBtn(label, page, disabled, active) {
        const b = document.createElement('button');
        if (active) b.classList.add('active');
        b.disabled = disabled;
        b.innerHTML = label;
        b.addEventListener('click', () => { currentPage = page; renderTable(); });
        ctrl.appendChild(b);
    }

    addBtn('<i class="fas fa-chevron-left"></i>', currentPage - 1, currentPage === 1, false);
    for (let i = 1; i <= pages; i++) {
        if (pages > 7 && i > 2 && i < pages - 1 && Math.abs(i - currentPage) > 1) {
            if (i === 3 || i === pages - 2) {
                const sp = document.createElement('span');
                sp.className = 'page-ellipsis'; sp.textContent = '\u2026';
                ctrl.appendChild(sp);
            }
            continue;
        }
        addBtn(i, i, false, i === currentPage);
    }
    addBtn('<i class="fas fa-chevron-right"></i>', currentPage + 1, currentPage === pages, false);
}

// ── Drop Details Modal ────────────────────────────────────────
function openDropModal(logId) {
    const log = LOGS.find(l => l.id === logId);
    if (!log || !log.dropDetail) return;

    document.getElementById('dropModalMeta').textContent =
        fmtDate(log.timestamp) + ' \u00b7 ' + fmtTime(log.timestamp);

    const d  = log.dropDetail;
    const av = AVATAR_CLS[log.portal] || '';

    document.getElementById('dropModalBody').innerHTML =
        '<div class="drop-info-row">' +
            '<div class="drop-info-icon"><i class="fas fa-user-graduate"></i></div>' +
            '<div><div class="drop-info-label">Student Name</div><div class="drop-info-value">' + d.name + '</div></div>' +
        '</div>' +
        '<div class="drop-info-row">' +
            '<div class="drop-info-icon"><i class="fas fa-id-badge"></i></div>' +
            '<div><div class="drop-info-label">Student ID</div><div class="drop-info-value">' + d.studentId + '</div></div>' +
        '</div>' +
        '<div class="drop-info-row">' +
            '<div class="drop-info-icon"><i class="fas fa-layer-group"></i></div>' +
            '<div><div class="drop-info-label">Section / Grade Level</div><div class="drop-info-value">' + d.section + '</div></div>' +
        '</div>' +
        '<div class="drop-info-row">' +
            '<div class="drop-info-icon"><i class="fas fa-user-shield"></i></div>' +
            '<div><div class="drop-info-label">Dropped By</div>' +
            '<div class="drop-admin-cell">' +
                '<div class="drop-admin-avatar ' + av + '">' + log.initials + '</div>' +
                '<div><div class="drop-info-value">' + log.user + '</div><div class="drop-info-sub">Admin Portal</div></div>' +
            '</div></div>' +
        '</div>' +
        '<div class="drop-info-row">' +
            '<div class="drop-info-icon"><i class="fas fa-clock"></i></div>' +
            '<div><div class="drop-info-label">Date &amp; Time</div>' +
            '<div class="drop-info-value">' + fmtDate(log.timestamp) + '</div>' +
            '<div class="drop-info-sub">' + fmtTime(log.timestamp) + '</div></div>' +
        '</div>';

    document.getElementById('dropModal').classList.add('active');
}

function closeDropModal() {
    document.getElementById('dropModal').classList.remove('active');
}

// ── Sorting ───────────────────────────────────────────────────
function setupSorting() {
    document.querySelectorAll('.log-table th[data-col]').forEach(th => {
        th.addEventListener('click', () => {
            const col = th.dataset.col;
            if (sortCol === col) {
                sortDir = sortDir === 'asc' ? 'desc' : 'asc';
            } else {
                sortCol = col;
                sortDir = col === 'timestamp' ? 'desc' : 'asc';
            }
            currentPage = 1;
            renderTable();
        });
    });
}

// ── Filter Dropdowns ─────────────────────────────────────────
function setupFilterDropdown(panelId, triggerId, labelId, onSelect) {
    const panel   = document.getElementById(panelId);
    const trigger = document.getElementById(triggerId);

    trigger.addEventListener('click', e => {
        e.stopPropagation();
        const isOpen = panel.classList.contains('open');
        closeAllDropdowns();
        if (!isOpen) {
            panel.classList.add('open');
            trigger.classList.add('open');
        }
    });

    panel.querySelectorAll('.filter-opt').forEach(opt => {
        opt.addEventListener('click', e => {
            e.stopPropagation();
            panel.querySelectorAll('.filter-opt').forEach(o => o.classList.remove('active'));
            opt.classList.add('active');
            const label = opt.querySelector('.opt-text')
                ? opt.querySelector('.opt-text').textContent.trim()
                : opt.textContent.trim();
            document.getElementById(labelId).textContent = label;
            panel.classList.remove('open');
            trigger.classList.remove('open');
            onSelect(opt.dataset.value);
        });
    });
}

function closeAllDropdowns() {
    document.querySelectorAll('.filter-panel').forEach(p => p.classList.remove('open'));
    document.querySelectorAll('.filter-trigger').forEach(t => t.classList.remove('open'));
}

// ── Export CSV ────────────────────────────────────────────────
function exportCSV() {
    const filtered = getSorted(getFiltered());
    const header   = ['Timestamp', 'User', 'Action', 'Type', 'Portal', 'Status'];
    const rows     = filtered.map(l => [
        fmtDate(l.timestamp) + ' ' + fmtTime(l.timestamp),
        l.user,
        l.action,
        TYPE_META[l.actionType]  ? TYPE_META[l.actionType].label  : l.actionType,
        PORTAL_META[l.portal]    ? PORTAL_META[l.portal].label    : l.portal,
        l.status,
    ]);
    const csv = [header].concat(rows)
        .map(r => r.map(v => '"' + String(v).replace(/"/g, '""') + '"').join(','))
        .join('\r\n');

    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const url  = URL.createObjectURL(blob);
    const a    = document.createElement('a');
    a.href = url; a.download = 'DWCU_System_Audit_Logs.csv';
    document.body.appendChild(a); a.click();
    document.body.removeChild(a); URL.revokeObjectURL(url);
}

// ── Init ─────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {

    // Mobile nav
    const hamburgerBtn   = document.getElementById('hamburger-btn');
    const overlay        = document.getElementById('mobile-nav-overlay');
    const drawer         = document.getElementById('mobile-nav-drawer');
    const mobileCloseBtn = document.getElementById('mobile-nav-close');
    const openDrawer  = () => { drawer.classList.add('open');    overlay.classList.add('open'); };
    const closeDrawer = () => { drawer.classList.remove('open'); overlay.classList.remove('open'); };
    if (hamburgerBtn)   hamburgerBtn.addEventListener('click', openDrawer);
    if (mobileCloseBtn) mobileCloseBtn.addEventListener('click', closeDrawer);
    if (overlay)        overlay.addEventListener('click', closeDrawer);

    // Search
    document.getElementById('logSearch').addEventListener('input', e => {
        searchQuery = e.target.value;
        currentPage = 1;
        renderTable();
    });

    // Filter dropdowns
    setupFilterDropdown('portalPanel', 'portalTrigger', 'portalTriggerLabel', val => {
        portalFilter = val; currentPage = 1; renderTable();
    });
    setupFilterDropdown('typePanel', 'typeTrigger', 'typeTriggerLabel', val => {
        typeFilter = val; currentPage = 1; renderTable();
    });

    // Close dropdowns on outside click
    document.addEventListener('click', e => {
        if (!e.target.closest('.custom-filter-dropdown')) closeAllDropdowns();
    });

    // Sorting
    setupSorting();

    // Drop row click → modal
    document.getElementById('logTbody').addEventListener('click', e => {
        const row = e.target.closest('tr.drop-row');
        if (row) openDropModal(parseInt(row.dataset.id, 10));
    });

    // Drop modal close
    document.getElementById('dropModalClose').addEventListener('click', closeDropModal);
    document.getElementById('dropModal').addEventListener('click', e => {
        if (e.target === document.getElementById('dropModal')) closeDropModal();
    });

    // Export CSV
    document.getElementById('exportCsvBtn').addEventListener('click', exportCSV);

    // Initial render
    renderTable();
});
