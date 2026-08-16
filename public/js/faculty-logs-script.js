/**
 * DWCU Faculty Portal — Activity Logs
 */

// ─── Log Data (from the server, via window.FACULTY_LOGS_INITIAL) ──────────────
const logsData = (window.FACULTY_LOGS_INITIAL || []).map(l => ({
    id: l.id,
    timestamp: new Date(l.timestamp),
    category: l.category,
    activity: l.activity,
    detail: l.detail,
}));

// Sort newest first
logsData.sort((a, b) => b.timestamp - a.timestamp);

// ─── State ────────────────────────────────────────────────────────────────────
const LOGS_PER_PAGE = 10;
let currentPage   = 1;
let activeFilter  = 'All';
let activeSection = 'All';
let filteredLogs  = [...logsData];

// ─── Filtering ────────────────────────────────────────────────────────────────
function applyFilters() {
    currentPage  = 1;
    filteredLogs = logsData.filter(log => {
        const categoryMatch = activeFilter === 'All' || log.category === activeFilter;
        const sectionMatch  = activeSection === 'All' || log.detail.includes(activeSection);
        return categoryMatch && sectionMatch;
    });
    renderTable();
}

function applyFilter(filter) {
    activeFilter = filter;
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.filter === filter);
    });
    applyFilters();
}

function applySection(section) {
    activeSection = section;
    applyFilters();
}

// ─── Rendering ────────────────────────────────────────────────────────────────
function renderTable() {
    const tbody   = document.getElementById('logTableBody');
    const empty   = document.getElementById('logEmpty');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const info    = document.getElementById('pageInfo');

    const totalPages = Math.max(1, Math.ceil(filteredLogs.length / LOGS_PER_PAGE));
    currentPage      = Math.min(currentPage, totalPages);

    const start = (currentPage - 1) * LOGS_PER_PAGE;
    const page  = filteredLogs.slice(start, start + LOGS_PER_PAGE);

    if (page.length === 0) {
        tbody.innerHTML     = '';
        empty.style.display = 'flex';
    } else {
        empty.style.display = 'none';
        tbody.innerHTML     = page.map(buildRow).join('');
    }

    info.textContent  = `Page ${currentPage} of ${totalPages}`;
    prevBtn.disabled  = currentPage === 1;
    nextBtn.disabled  = currentPage === totalPages;
}

function buildRow(log) {
    const date = log.timestamp.toLocaleDateString('en-PH', { year:'numeric', month:'short', day:'numeric' });
    const time = log.timestamp.toLocaleTimeString('en-PH', { hour:'2-digit', minute:'2-digit', second:'2-digit' });

    const badgeClass = `badge-${log.category.toLowerCase()}`;
    const detailIcon = getDetailIcon(log.category);
    const isGrade    = log.category === 'Grade' && log.students;
    const isDrop     = log.category === 'Drop'  && log.dropDetail;

    let rowAttrs = '';
    if (isGrade) rowAttrs = ` class="grade-row" data-log-id="${log.id}" title="Click to view student scores"`;
    if (isDrop)  rowAttrs = ` class="drop-row"  data-log-id="${log.id}" title="Click to view drop details"`;

    return `
        <tr${rowAttrs}>
            <td class="td-timestamp" data-label="Timestamp">
                <span class="log-date">${date}</span>
                <span class="log-time">${time}</span>
            </td>
            <td data-label="Category">
                <span class="category-badge ${badgeClass}">
                    <span class="dot"></span>
                    ${log.category}
                </span>
            </td>
            <td class="activity-text" data-label="Activity">
                ${isDrop ? '<i class="fas fa-triangle-exclamation drop-flag"></i> ' : ''}${log.activity}
                ${isGrade ? '<span class="view-students-hint"><i class="fas fa-users"></i> View Students</span>' : ''}
                ${isDrop  ? '<span class="view-drop-hint"><i class="fas fa-eye"></i> View Details</span>'    : ''}
            </td>
            <td data-label="Details">
                <span class="detail-text">
                    <i class="${detailIcon}"></i>
                    ${log.detail}
                </span>
            </td>
        </tr>`;
}

function getDetailIcon(category) {
    switch (category) {
        case 'Pass':         return 'fas fa-id-card';
        case 'Grade':        return 'fas fa-book-open';
        case 'Announcement': return 'fas fa-bullhorn';
        case 'Drop':         return 'fas fa-user-minus';
        default:             return 'fas fa-desktop';
    }
}

// ─── Drop Modal ───────────────────────────────────────────────────────────────
function openDropModal(log) {
    const d    = log.dropDetail;
    const date = log.timestamp.toLocaleDateString('en-PH', { year:'numeric', month:'short', day:'numeric' });
    const time = log.timestamp.toLocaleTimeString('en-PH', { hour:'2-digit', minute:'2-digit', hour12:true });

    document.getElementById('dropModalMeta').textContent = date + ' · ' + time;
    document.getElementById('dropModalBody').innerHTML =
        '<div class="drop-info-row">' +
            '<div class="drop-info-icon"><i class="fas fa-user-graduate"></i></div>' +
            '<div><div class="drop-info-label">Student Name</div>' +
            '<div class="drop-info-value">' + d.name + '</div></div>' +
        '</div>' +
        '<div class="drop-info-row">' +
            '<div class="drop-info-icon"><i class="fas fa-id-badge"></i></div>' +
            '<div><div class="drop-info-label">Student ID</div>' +
            '<div class="drop-info-value">' + d.studentId + '</div></div>' +
        '</div>' +
        '<div class="drop-info-row">' +
            '<div class="drop-info-icon"><i class="fas fa-layer-group"></i></div>' +
            '<div><div class="drop-info-label">Section / Grade Level</div>' +
            '<div class="drop-info-value">' + d.section + '</div></div>' +
        '</div>' +
        '<div class="drop-info-row">' +
            '<div class="drop-info-icon"><i class="fas fa-user-shield"></i></div>' +
            '<div><div class="drop-info-label">Dropped By</div>' +
            '<div class="drop-admin-cell">' +
                '<div class="drop-admin-avatar">' + d.droppedByInitials + '</div>' +
                '<div><div class="drop-info-value">' + d.droppedBy + '</div>' +
                '<div class="drop-info-sub">' + d.droppedByPortal + '</div></div>' +
            '</div></div>' +
        '</div>' +
        '<div class="drop-info-row">' +
            '<div class="drop-info-icon"><i class="fas fa-clock"></i></div>' +
            '<div><div class="drop-info-label">Date &amp; Time</div>' +
            '<div class="drop-info-value">' + date + '</div>' +
            '<div class="drop-info-sub">' + time + '</div></div>' +
        '</div>';

    document.getElementById('dropModal').classList.add('active');
}

// ─── Grade Modal ──────────────────────────────────────────────────────────────
function openGradeModal(log) {
    const subject = log.activity.replace(/^Posted \w+ (score|grade) — /, '');
    const section = log.detail.split(' · ')[0];
    document.getElementById('gradeModalTitle').textContent = subject;
    document.getElementById('gradeModalMeta').textContent  = section + ' · ' + log.students.length + ' students';
    document.getElementById('gradeModalBody').innerHTML = log.students.map((s, i) => {
        const [score, total] = s.score.split('/').map(Number);
        const pct     = total ? Math.round(score / total * 100) : 0;
        const remarks = pct >= 90 ? 'Excellent' : pct >= 80 ? 'Good' : pct >= 75 ? 'Satisfactory' : 'Needs Improvement';
        const cls     = pct >= 90 ? 'r-excellent' : pct >= 80 ? 'r-good' : pct >= 75 ? 'r-satisfactory' : 'r-needs';
        return `<tr>
            <td>${i + 1}</td>
            <td>${s.name}</td>
            <td><span class="grade-score-value">${s.score}</span></td>
            <td><span class="remarks-badge ${cls}">${remarks}</span></td>
        </tr>`;
    }).join('');
    document.getElementById('gradeModal').classList.add('active');
}

// ─── Pagination ───────────────────────────────────────────────────────────────
function changePage(direction) {
    const totalPages = Math.ceil(filteredLogs.length / LOGS_PER_PAGE);
    currentPage = Math.min(Math.max(1, currentPage + direction), totalPages);
    renderTable();
}

// ─── Init ─────────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {

    // Category filter buttons
    document.getElementById('filterGroup').addEventListener('click', (e) => {
        const btn = e.target.closest('.filter-btn');
        if (btn) applyFilter(btn.dataset.filter);
    });

    // Section dropdown
    const dropdown = document.getElementById('sectionDropdown');
    const trigger  = document.getElementById('dropdownTrigger');
    const menu     = document.getElementById('dropdownMenu');
    const label    = document.getElementById('dropdownLabel');

    trigger.addEventListener('click', (e) => { e.stopPropagation(); dropdown.classList.toggle('open'); });

    menu.addEventListener('click', (e) => {
        const option = e.target.closest('.dropdown-option');
        if (!option) return;
        menu.querySelectorAll('.dropdown-option').forEach(o => o.classList.remove('selected'));
        option.classList.add('selected');
        label.textContent = option.dataset.value === 'All' ? 'All Sections' : option.dataset.value;
        dropdown.classList.remove('open');
        applySection(option.dataset.value);
    });

    document.addEventListener('click', (e) => {
        if (!dropdown.contains(e.target)) dropdown.classList.remove('open');
    });

    // Initial render
    renderTable();

    // Grade row click
    document.getElementById('logTableBody').addEventListener('click', (e) => {
        const row = e.target.closest('tr.grade-row');
        if (!row) return;
        const log = logsData.find(l => l.id === parseInt(row.dataset.logId, 10));
        if (log && log.students) openGradeModal(log);
    });

    // Drop row click
    document.getElementById('logTableBody').addEventListener('click', (e) => {
        const row = e.target.closest('tr.drop-row');
        if (!row) return;
        const log = logsData.find(l => l.id === parseInt(row.dataset.logId, 10));
        if (log && log.dropDetail) openDropModal(log);
    });

    // Drop modal close
    const dropModal = document.getElementById('dropModal');
    document.getElementById('dropModalClose').addEventListener('click', () => dropModal.classList.remove('active'));
    dropModal.addEventListener('click', (e) => { if (e.target === dropModal) dropModal.classList.remove('active'); });

    // Grade modal close
    const gradeModal = document.getElementById('gradeModal');
    document.getElementById('gradeModalClose').addEventListener('click', () => gradeModal.classList.remove('active'));
    gradeModal.addEventListener('click', (e) => { if (e.target === gradeModal) gradeModal.classList.remove('active'); });

    // Mobile nav
    const hamburgerBtn = document.getElementById('hamburger-btn');
    const overlay      = document.getElementById('mobile-nav-overlay');
    const drawer       = document.getElementById('mobile-nav-drawer');
    const closeBtn     = document.getElementById('mobile-nav-close');
    const openDrawer   = () => { drawer.classList.add('open'); overlay.classList.add('open'); document.body.style.overflow = 'hidden'; };
    const closeDrawer  = () => { drawer.classList.remove('open'); overlay.classList.remove('open'); document.body.style.overflow = ''; };
    if (hamburgerBtn) hamburgerBtn.addEventListener('click', openDrawer);
    if (closeBtn)     closeBtn.addEventListener('click', closeDrawer);
    if (overlay)      overlay.addEventListener('click', closeDrawer);
});
