// ─── Shared Data Storage Keys ────────────────────────────────────────────────
const ANN_STORAGE_KEY = 'dwcu_announcements';
const EVT_STORAGE_KEY = 'dwcu_events';

// ─── Default Announcement Data ────────────────────────────────────────────────
const DEFAULT_ANNOUNCEMENTS = [
  { id:1,  title:'Quiz in Mathematics (Algebra)',      category:'Quiz',       expiry:'2026-03-14', desc:'Preparation for the upcoming Algebra quiz. Focus on Linear Equations and Factoring.',    section:'Grade 9 - Innovators',  author:'Edward Zeller' },
  { id:2,  title:'English Essay Submission',           category:'Assignment', expiry:'2026-03-16', desc:'Deadline for the descriptive essay submission. Submit your drafts via the portal.',      section:'Grade 9 - Innovators',  author:'Karen Kemper'  },
  { id:3,  title:'Faculty Meeting – SHS Department',  category:'Meeting',    expiry:'2026-03-25', desc:'Mandatory attendance for all SHS faculty. Venue: AVR Room 3, 3:00 PM.',                  section:'Grade 11 - STEM',       author:'Admin'         },
  { id:4,  title:'Quarterly Examination Schedule',    category:'Exam',       expiry:'2026-04-01', desc:'Exam week is scheduled April 7–11. Please prepare review materials.',                    section:'Grade 12 - STEM',       author:'Admin'         },
  { id:5,  title:'Science Fair Judging Day',           category:'Exam',       expiry:'2026-03-22', desc:'Grade 10 science fair entries will be judged on March 22, Hall B.',                     section:'Grade 10 - Leaders',    author:'Science Dept'  },
  { id:6,  title:'TLE Performance Task',              category:'Assignment', expiry:'2026-03-24', desc:'Submit your TLE performance task output to your subject teacher.',                       section:'Grade 8 - Researchers', author:'TLE Dept'      },
  { id:7,  title:'Mathematics Long Quiz #2',          category:'Quiz',       expiry:'2026-03-28', desc:'Coverage includes Quadratic Equations and Systems of Linear Equations.',                 section:'Grade 9 - Innovators',  author:'Math Dept'     },
  { id:8,  title:'ICT Programming Project',           category:'Assignment', expiry:'2026-04-05', desc:'Submit your final programming project on the portal. Language: Python or Java.',         section:'Grade 11 - ICT',        author:'ICT Dept'      },
  { id:9,  title:'HUMSS Research Paper Deadline',     category:'Assignment', expiry:'2026-04-03', desc:'Final research paper must be submitted to your HUMSS adviser.',                          section:'Grade 11 - HUMSS',      author:'HUMSS Dept'    },
  { id:10, title:'STEM Chemistry Lab Report',         category:'Assignment', expiry:'2026-03-27', desc:'Laboratory report for the acid-base experiment is due Friday.',                          section:'Grade 12 - STEM',       author:'Science Dept'  },
  { id:11, title:'Grade 7 Science Activity',          category:'Assignment', expiry:'2026-03-25', desc:'Complete the leaf classification activity and submit illustrations.',                     section:'Grade 7 - Explorers',   author:'Science Dept'  },
  { id:12, title:'Grade 8 Math Quiz – Integers',      category:'Quiz',       expiry:'2026-03-21', desc:'Quiz on integers and rational numbers. Review your notes on absolute values.',           section:'Grade 8 - Researchers', author:'Math Dept'     },
  { id:13, title:'Grade 10 Midterm Exam',             category:'Exam',       expiry:'2026-03-26', desc:'Midterm examination covers all topics from 1st semester. Study all reviewer sheets.',    section:'Grade 10 - Leaders',    author:'Admin'         },
  { id:14, title:'Grade 12 ICT Capstone Defense',     category:'Exam',       expiry:'2026-04-10', desc:'Final capstone project defense schedule will be posted this week. Prepare your slides.', section:'Grade 12 - ICT',        author:'ICT Dept'      },
  { id:15, title:'HUMSS G12 Oral Defense',            category:'Exam',       expiry:'2026-04-08', desc:'Oral defense of research papers begins April 8. Consult your adviser for schedule.',     section:'Grade 12 - HUMSS',      author:'HUMSS Dept'    },
];

// ─── Default Event Data ───────────────────────────────────────────────────────
const DEFAULT_EVENTS = [
  { id:1, title:'Mathematics Quiz (Algebra)',   day:14, category:'Quiz',        expiry:'2026-03-14', section:'Grade 9 - Innovators'  },
  { id:2, title:'English Essay Submission',     day:16, category:'Assignment',  expiry:'2026-03-16', section:'Grade 9 - Innovators'  },
  { id:3, title:'Science Quarterly Exam',       day:20, category:'Examination', expiry:'2026-03-20', section:'Grade 9 - Innovators'  },
  { id:4, title:'TLE Performance Task',         day:24, category:'Assignment',  expiry:'2026-03-24', section:'Grade 8 - Researchers' },
  { id:5, title:'Mathematics Long Quiz #2',     day:28, category:'Quiz',        expiry:'2026-03-28', section:'Grade 9 - Innovators'  },
  { id:6, title:'Science Fair Judging',         day:22, category:'Examination', expiry:'2026-03-22', section:'Grade 10 - Leaders'    },
  { id:7, title:'ICT Programming Project Due',  day: 5, category:'Assignment',  expiry:'2026-04-05', section:'Grade 11 - ICT'        },
  { id:8, title:'STEM Chemistry Lab Report',    day:27, category:'Assignment',  expiry:'2026-03-27', section:'Grade 12 - STEM'       },
];

// ─── Storage helpers ──────────────────────────────────────────────────────────
function loadAnnouncements() {
  try { const s = localStorage.getItem(ANN_STORAGE_KEY); return s ? JSON.parse(s) : DEFAULT_ANNOUNCEMENTS; }
  catch { return DEFAULT_ANNOUNCEMENTS; }
}
function saveAnnouncements(data) { localStorage.setItem(ANN_STORAGE_KEY, JSON.stringify(data)); }
function loadEvents() {
  try { const s = localStorage.getItem(EVT_STORAGE_KEY); return s ? JSON.parse(s) : DEFAULT_EVENTS; }
  catch { return DEFAULT_EVENTS; }
}

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

const CAT_CLS  = { 'Quiz':'cat-quiz','Assignment':'cat-assignment','Exam':'cat-exam-bdg','Examination':'cat-exam-bdg','Meeting':'cat-meeting','Holiday':'cat-holiday','General':'cat-general' };
const CAT_ICON = { 'Quiz':'fas fa-lightbulb','Assignment':'fas fa-tasks','Exam':'fas fa-clipboard-list','Examination':'fas fa-clipboard-list','Meeting':'fas fa-users','Holiday':'fas fa-umbrella-beach','General':'fas fa-bullhorn' };
const CAT_BG   = { 'Quiz':'blue-bg','Assignment':'green-bg','Exam':'red-bg','Examination':'red-bg','Meeting':'purple-bg','Holiday':'orange-bg','General':'gray-bg' };
function catCls(c)  { return CAT_CLS[c]  || 'cat-general'; }
function catIcon(c) { return CAT_ICON[c] || 'fas fa-bullhorn'; }
function catBg(c)   { return CAT_BG[c]   || 'gray-bg'; }

// ─── Render Announcements ─────────────────────────────────────────────────────
function renderAnnouncements(section) {
  const feed     = document.getElementById('annFeed');
  const empty    = document.getElementById('annEmpty');
  const data     = loadAnnouncements();
  const filtered = section ? data.filter(a => a.section === section) : data;

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
  const events = (section ? data.filter(e => e.section === section) : data)
    .sort((a,b) => a.day - b.day).slice(0, 4);

  if (events.length === 0) {
    list.innerHTML = '<p style="color:#94a3b8;font-size:0.82rem;text-align:center;padding:10px 0;">No upcoming events.</p>';
    return;
  }
  list.innerHTML = events.map(ev => `
    <div class="event-item">
      <span class="event-day">${ev.day}</span>
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
      if (!title || !section) return;

      const data  = loadAnnouncements();
      const newId = data.length ? Math.max(...data.map(a => a.id)) + 1 : 1;
      data.unshift({
        id: newId, title, category: 'General',
        expiry: new Date().toISOString().split('T')[0],
        desc: content, section, author: 'Faculty'
      });
      saveAnnouncements(data);
      form.reset();
      modalLabel.textContent      = 'Select a class...';
      modalLabel.style.color      = '#94a3b8';
      modalLabel.style.fontWeight = '500';
      modalInput.value            = '';
      modalMenu.querySelectorAll('.modal-dd-option').forEach(o => o.classList.remove('selected'));
      closeModal();

      const currentVal = annMenu.querySelector('.ann-dropdown-option.selected')?.dataset?.value || '';
      renderAnnouncements(currentVal);
      renderSidebarEvents(currentVal);
    });
  }

  // ── Initial render ──
  updateDateHero();
  renderAnnouncements('');
  renderSidebarEvents('');
});
