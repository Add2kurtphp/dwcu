// ─── Real announcement data (from the server, via window.ANNOUNCEMENTS_INITIAL) ──
let ANNOUNCEMENTS_DATA = window.ANNOUNCEMENTS_INITIAL ? window.ANNOUNCEMENTS_INITIAL.slice() : [];

function csrfToken() {
  const m = document.querySelector('meta[name="csrf-token"]');
  return m ? m.content : '';
}

function loadAnnouncements() { return ANNOUNCEMENTS_DATA; }

const EVENTS_DATA = window.EVENTS_INITIAL ? window.EVENTS_INITIAL.slice() : [];
function loadEvents() { return EVENTS_DATA; }

// ─── Utilities ────────────────────────────────────────────────────────────────
function isExpired(expiryStr) {
  const d = new Date(expiryStr + 'T00:00:00');
  const today = new Date(); today.setHours(0,0,0,0);
  return d < today;
}
function formatDate(str) {
  const d = new Date(str + 'T00:00:00');
  return d.toLocaleDateString('en-US', { month:'long', day:'numeric', year:'numeric' });
}

const CAT_CLS  = { 'Quiz':'cat-quiz','Assignment':'cat-assignment','Exam':'cat-exam-bdg','Examination':'cat-exam-bdg','Meeting':'cat-meeting','Holiday':'cat-holiday','General':'cat-general','Academic':'cat-quiz','Urgent':'cat-exam-bdg','Event':'cat-meeting' };
const CAT_ICON = { 'Quiz':'fas fa-lightbulb','Assignment':'fas fa-tasks','Exam':'fas fa-clipboard-list','Examination':'fas fa-clipboard-list','Meeting':'fas fa-users','Holiday':'fas fa-umbrella-beach','General':'fas fa-bullhorn','Academic':'fas fa-book','Urgent':'fas fa-exclamation-circle','Event':'fas fa-calendar-check' };
const CAT_BG   = { 'Quiz':'blue-bg','Assignment':'green-bg','Exam':'red-bg','Examination':'red-bg','Meeting':'purple-bg','Holiday':'orange-bg','General':'gray-bg','Academic':'blue-bg','Urgent':'red-bg','Event':'purple-bg' };
function catCls(c)  { return CAT_CLS[c]  || 'cat-general'; }
function catIcon(c) { return CAT_ICON[c] || 'fas fa-bullhorn'; }
function catBg(c)   { return CAT_BG[c]   || 'gray-bg'; }

// ─── Render Announcements ─────────────────────────────────────────────────────
function renderAnnouncements(section) {
  const feed     = document.getElementById('annFeed');
  const empty    = document.getElementById('annEmpty');
  const data = loadAnnouncements();
  let filtered = data;
  if (section) {
    const gradeMatch = section.match(/\d+/);
    const level = gradeMatch && parseInt(gradeMatch[0]) >= 11 ? 'shs' : 'jhs';
    filtered = data.filter(a => a.audience === level || a.audience === 'all');
  }

  if (filtered.length === 0) {
    feed.innerHTML = '';
    empty.style.display = 'flex';
    return;
  }
  empty.style.display = 'none';
  feed.innerHTML = filtered.map(ann => `
    <div class="post-card${isExpired(ann.expiry) ? ' is-expired' : ''}">
      <div class="post-header">
        <div class="post-icon-box ${catBg(ann.category)}">
          <i class="${catIcon(ann.category)}"></i>
        </div>
        <div class="post-meta">
          <h4>${ann.title}${isExpired(ann.expiry) ? ' <span class="expired-badge">Expired</span>' : ''}</h4>
          <span class="post-date">${formatDate(ann.expiry)}</span>
          <span class="cat-badge ${catCls(ann.category)}" style="margin-left:6px;">${ann.category}</span>
        </div>
      </div>
      <p class="post-body">${ann.desc || ''}</p>
      <div class="post-footer">
        <div class="author-tag">
          <div class="avatar-circle"></div>
          <span>${ann.author || 'Faculty'}</span>
        </div>
        <a href="${typeof CALENDAR_URL !== 'undefined' ? CALENDAR_URL : '/faculty/calendar'}" class="details-btn">View in Calendar</a>
      </div>
    </div>
  `).join('');
}

// ─── Render Sidebar Events ────────────────────────────────────────────────────
function renderSidebarEvents(section) {
  const list   = document.getElementById('sidebarEventList');
  const data   = loadEvents();
  const events = (section ? data.filter(e => e.section === section || !e.section) : data)
    .sort((a,b) => new Date(a.date) - new Date(b.date)).slice(0, 4);

  if (events.length === 0) {
    list.innerHTML = '<p style="color:#94a3b8;font-size:0.82rem;text-align:center;padding:10px 0;">No upcoming events.</p>';
    return;
  }
  list.innerHTML = events.map(ev => `
    <div class="event-item">
      <span class="event-day">${new Date(ev.date + 'T00:00:00').getDate()}</span>
      <div class="event-text">
        <p>${ev.title}</p>
        <span>${ev.category}</span>
      </div>
    </div>
  `).join('');
}

// ─── Date hero ────────────────────────────────────────────────────────────────
function updateDateHero() {
  const hero = document.getElementById('dateHero');
  if (!hero) return;
  const d = new Date();
  const months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
  const days   = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
  hero.innerHTML = `<p>${months[d.getMonth()]} ${d.getFullYear()}</p><h2>${d.getDate()}</h2><p>${days[d.getDay()]}</p>`;
}

// ─── Modal ────────────────────────────────────────────────────────────────────
const modal     = document.getElementById('announcementModal');
const openBtn   = document.getElementById('openModalBtn');
const closeBtn  = document.getElementById('closeModalBtn');
const cancelBtn = document.getElementById('cancelModalBtn');

function openModal()  { modal.classList.add('active'); }
function closeModal() { modal.classList.remove('active'); }

openBtn.addEventListener('click', openModal);
closeBtn.addEventListener('click', closeModal);
cancelBtn.addEventListener('click', closeModal);
window.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });

// ─── DOMContentLoaded ─────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {

  // Mobile nav drawer
  const hamburgerBtn = document.getElementById('hamburger-btn');
  const overlay      = document.getElementById('mobile-nav-overlay');
  const drawer       = document.getElementById('mobile-nav-drawer');
  const mobileClose  = document.getElementById('mobile-nav-close');
  const openDrawer   = () => { drawer.classList.add('open'); overlay.classList.add('open'); };
  const closeDrawer  = () => { drawer.classList.remove('open'); overlay.classList.remove('open'); };
  if (hamburgerBtn) hamburgerBtn.addEventListener('click', openDrawer);
  if (mobileClose)  mobileClose.addEventListener('click', closeDrawer);
  if (overlay)      overlay.addEventListener('click', closeDrawer);

  // ── Section filter dropdown ──
  const annDropdown = document.getElementById('annSectionDropdown');
  const annTrigger  = document.getElementById('annDropdownTrigger');
  const annMenu     = document.getElementById('annDropdownMenu');
  const annLabel    = document.getElementById('annDropdownLabel');

  annTrigger.addEventListener('click', (e) => { e.stopPropagation(); annDropdown.classList.toggle('open'); });

  annMenu.addEventListener('click', (e) => {
    const option = e.target.closest('.ann-dropdown-option');
    if (!option) return;
    annMenu.querySelectorAll('.ann-dropdown-option').forEach(o => o.classList.remove('selected'));
    option.classList.add('selected');
    const val = option.dataset.value;
    annLabel.textContent = val || 'All Sections';
    annDropdown.classList.remove('open');
    renderAnnouncements(val);
    renderSidebarEvents(val);
  });

  document.addEventListener('click', (e) => {
    if (!annDropdown.contains(e.target)) annDropdown.classList.remove('open');
  });

  // ── Modal section dropdown ──
  const modalDd      = document.getElementById('modalSectionDropdown');
  const modalTrigger = document.getElementById('modalDdTrigger');
  const modalMenu    = document.getElementById('modalDdMenu');
  const modalLabel   = document.getElementById('modalDdLabel');
  const modalInput   = document.getElementById('modalSectionValue');

  modalTrigger.addEventListener('click', (e) => { e.stopPropagation(); modalDd.classList.toggle('open'); });

  modalMenu.addEventListener('click', (e) => {
    const option = e.target.closest('.modal-dd-option');
    if (!option) return;
    modalMenu.querySelectorAll('.modal-dd-option').forEach(o => o.classList.remove('selected'));
    option.classList.add('selected');
    modalLabel.textContent     = option.dataset.value;
    modalLabel.style.color     = '#1e2f7a';
    modalLabel.style.fontWeight = '600';
    modalInput.value           = option.dataset.value;
    modalDd.classList.remove('open');
  });

  document.addEventListener('click', (e) => {
    if (!modalDd.contains(e.target)) modalDd.classList.remove('open');
  });

  // ── Form submit ──
  const form = document.querySelector('.modal-form');
  if (form) {
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const title   = form.querySelector('input[type="text"]').value.trim();
      const content = form.querySelector('textarea').value.trim();
      const section = modalInput.value;
      if (!title || !content || !section) return;

      fetch(window.announcementRoutes.store, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': csrfToken(),
        },
        body: JSON.stringify({ title, content, section }),
      })
        .then(r => { if (!r.ok) return r.json().then(e => Promise.reject(e)); return r.json(); })
        .then(data => {
          const a = data.announcement;
          ANNOUNCEMENTS_DATA.unshift({
            id: a.id, title: a.title, category: a.category.charAt(0).toUpperCase() + a.category.slice(1),
            expiry: a.target_date, desc: a.content, author: a.posted_by, audience: a.audience,
          });

          form.reset();
          modalLabel.textContent      = 'Select a class...';
          modalLabel.style.color      = '#94a3b8';
          modalLabel.style.fontWeight = '500';
          modalInput.value            = '';
          modalMenu.querySelectorAll('.modal-dd-option').forEach(o => o.classList.remove('selected'));
          closeModal();

          const currentVal = annMenu.querySelector('.ann-dropdown-option.selected')?.dataset?.value || '';
          renderAnnouncements(currentVal);
        })
        .catch(() => alert('Error posting announcement.'));
    });
  }

  // ── Initial render ──
  updateDateHero();
  renderAnnouncements('');
  renderSidebarEvents('');
});
