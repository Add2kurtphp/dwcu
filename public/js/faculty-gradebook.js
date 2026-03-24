// --- STUDENT DATA ---
const STUDENTS = [
  { id: '2024-0001', name: 'Jorez Romo',      grade: 12, section: 'Grade 12 - ICT',         chartData: [85, 92, 78, 95],  avg: '89.5', status: 'active'  },
  { id: '2024-0015', name: 'Alexandra Cruz',   grade: 7,  section: 'Grade 7 - Explorers',    chartData: [90, 88, 92, 94],  avg: '91.0', status: 'active'  },
  { id: '2024-0022', name: 'Michael Flores',   grade: 7,  section: 'Grade 7 - Explorers',    chartData: [75, 80, 70, 85],  avg: '77.5', status: 'active'  },
  { id: '2024-0045', name: 'Mark Zuckerberg',  grade: 8,  section: 'Grade 8 - Researchers',  chartData: [98, 95, 99, 100], avg: '98.0', status: 'active'  },
  { id: '2024-0052', name: 'Emma Hall',         grade: 9,  section: 'Grade 9 - Innovators',   chartData: [88, 82, 90, 85],  avg: '86.3', status: 'active'  },
  { id: '2024-0068', name: 'Steven Santos',     grade: 10, section: 'Grade 10 - Leaders',     chartData: [80, 75, 85, 82],  avg: '80.5', status: 'active'  },
  { id: '2024-0074', name: 'Jessica Reyes',     grade: 12, section: 'Grade 12 - STEM',        chartData: [92, 94, 88, 91],  avg: '91.2', status: 'active'  },
  { id: '2024-0080', name: 'Carlos Mendoza',    grade: 11, section: 'Grade 11 - HUMSS',       chartData: [78, 82, 76, 80],  avg: '79.0', status: 'active'  },
  { id: '2024-0091', name: 'Maria Santos',      grade: 8,  section: 'Grade 8 - Researchers',  chartData: [88, 90, 85, 92],  avg: '88.8', status: 'active'  },
  { id: '2024-0102', name: 'Luis Garcia',       grade: 10, section: 'Grade 10 - Leaders',     chartData: [70, 75, 68, 72],  avg: '71.3', status: 'dropped' },
  { id: '2024-0113', name: 'Anna Lim',          grade: 9,  section: 'Grade 9 - Innovators',   chartData: [95, 92, 98, 96],  avg: '95.3', status: 'active'  },
  { id: '2024-0124', name: 'Pedro Cruz',        grade: 7,  section: 'Grade 7 - Explorers',    chartData: [60, 65, 58, 62],  avg: '61.3', status: 'active'  },
];

// --- TABLE STATE ---
let perfChart;
let questionCount = 0;
const ROWS_PER_PAGE = 10;
let currentPage = 1;
let sortState = { col: null, dir: 1 };
let selectedStudentIdx = 0;
let dropdownTargetIdx = null;

// --- FILTERING & SORTING ---
function getFilteredSorted() {
  const q = document.getElementById('studentSearch').value.toLowerCase();
  let arr = STUDENTS.filter(s =>
    s.name.toLowerCase().includes(q) ||
    s.id.includes(q) ||
    s.section.toLowerCase().includes(q)
  );
  if (sortState.col) {
    arr.sort((a, b) => {
      if (sortState.col === 'grade')  return (a.grade - b.grade) * sortState.dir;
      if (sortState.col === 'status') return a.status.localeCompare(b.status) * sortState.dir;
      return 0;
    });
  }
  return arr;
}

// --- TABLE RENDER ---
function renderTable() {
  const data = getFilteredSorted();
  const totalPages = Math.max(1, Math.ceil(data.length / ROWS_PER_PAGE));
  if (currentPage > totalPages) currentPage = totalPages;

  const start  = (currentPage - 1) * ROWS_PER_PAGE;
  const slice  = data.slice(start, start + ROWS_PER_PAGE);
  const tbody  = document.getElementById('studentTableBody');
  tbody.innerHTML = '';

  slice.forEach(student => {
    const idx = STUDENTS.indexOf(student);
    const isSelected = idx === selectedStudentIdx;
    const tr = document.createElement('tr');
    tr.className = 'student-row' + (isSelected ? ' selected' : '');
    tr.onclick = () => selectStudentByIdx(idx);

    const badge = student.status === 'active'
      ? '<span class="status-active">Active</span>'
      : '<span class="status-dropped">Dropped</span>';

    tr.innerHTML = `
      <td class="td-name">${student.name}<div class="td-sid">${student.id}</div></td>
      <td class="td-grade">${student.grade}</td>
      <td>${badge}</td>
      <td onclick="event.stopPropagation()">
        <button class="action-edit-btn" onclick="toggleDropdown(event, ${idx})">
          Edit <i class="fas fa-chevron-down" style="font-size:0.65rem;"></i>
        </button>
      </td>`;
    tbody.appendChild(tr);
  });

  // Pagination controls
  const bar = document.getElementById('paginationBar');
  bar.style.display = data.length > ROWS_PER_PAGE ? 'flex' : 'none';
  document.getElementById('pageInfo').textContent  = `Page ${currentPage} of ${totalPages}`;
  document.getElementById('prevBtn').disabled = currentPage <= 1;
  document.getElementById('nextBtn').disabled = currentPage >= totalPages;
}

// --- SORTING ---
function sortTable(col) {
  sortState.dir = sortState.col === col ? -sortState.dir : 1;
  sortState.col = col;
  ['grade', 'status'].forEach(c => {
    const el = document.getElementById(c + '-sort-icon');
    if (el) el.textContent = '↕';
  });
  const icon = document.getElementById(col + '-sort-icon');
  if (icon) icon.textContent = sortState.dir === 1 ? '↑' : '↓';
  currentPage = 1;
  renderTable();
}

// --- PAGINATION ---
function changePage(dir) {
  const data = getFilteredSorted();
  const totalPages = Math.max(1, Math.ceil(data.length / ROWS_PER_PAGE));
  currentPage = Math.max(1, Math.min(totalPages, currentPage + dir));
  renderTable();
}

// --- STUDENT SELECTION ---
function selectStudentByIdx(idx) {
  selectedStudentIdx = idx;
  const s = STUDENTS[idx];
  document.getElementById('display-name').innerText    = s.name;
  document.getElementById('display-section').innerText = s.section;
  document.getElementById('display-avg').innerText     = s.avg;
  if (perfChart) {
    perfChart.data.datasets[0].data = s.chartData;
    perfChart.update();
  }
  renderTable();
}

// --- ACTION DROPDOWN ---
function toggleDropdown(event, idx) {
  const dd = document.getElementById('actionDropdown');
  if (dropdownTargetIdx === idx && dd.style.display === 'block') {
    dd.style.display = 'none';
    dropdownTargetIdx = null;
    return;
  }
  dropdownTargetIdx = idx;
  const btn      = event.currentTarget;
  const rect     = btn.getBoundingClientRect();
  const ddWidth  = 160;
  const leftPos  = rect.right - ddWidth < 0 ? rect.left : rect.right - ddWidth;
  dd.style.position = 'fixed';
  dd.style.top   = (rect.bottom + 4) + 'px';
  dd.style.left  = Math.max(4, Math.min(leftPos, window.innerWidth - ddWidth - 4)) + 'px';
  dd.style.display = 'block';
}

function setStudentStatus(status) {
  if (dropdownTargetIdx === null) return;
  STUDENTS[dropdownTargetIdx].status = status;
  document.getElementById('actionDropdown').style.display = 'none';
  dropdownTargetIdx = null;
  renderTable();
}

// --- URL PARAMETERS ---
function checkURLParameters() {
  const urlParams  = new URLSearchParams(window.location.search);
  const studentId  = urlParams.get('id');
  if (!studentId) return;
  const idx = STUDENTS.findIndex(s => s.id === studentId || s.id.includes(studentId));
  if (idx !== -1) {
    const data = getFilteredSorted();
    const sortedIdx = data.findIndex(s => STUDENTS.indexOf(s) === idx);
    if (sortedIdx !== -1) currentPage = Math.floor(sortedIdx / ROWS_PER_PAGE) + 1;
    selectStudentByIdx(idx);
  }
}

// --- SCROLL LOCK ---
function lockScroll()   { document.body.classList.add('modal-open');    }
function unlockScroll() { document.body.classList.remove('modal-open'); }

// --- MODAL CONTROLS ---
function openSelectionModal() {
  closeAllModals();
  document.getElementById('selectionModal').style.display = 'flex';
  lockScroll();
}

function openTaskModal(modalId) {
  closeAllModals();
  document.getElementById(modalId).style.display = 'flex';
  lockScroll();
  if (modalId === 'quizModal') loadQuizDraft();
}

function closeAllModals() {
  document.querySelectorAll('.modal-overlay').forEach(m => (m.style.display = 'none'));
  unlockScroll();
}

// --- SUBJECT PICKER (Module 1) ---
let _subjectTarget = null;

function openSubjectPicker(triggerId) {
  _subjectTarget = triggerId;
  document.getElementById('subjectPickerModal').style.display = 'flex';
  lockScroll();
}

function selectSubject(name) {
  if (!_subjectTarget) return;
  const trigger = document.getElementById(_subjectTarget);
  trigger.querySelector('.subj-trigger-text').textContent = name;
  trigger.classList.add('has-value');
  closeSubjectPicker();
}

function closeSubjectPicker() {
  document.getElementById('subjectPickerModal').style.display = 'none';
  _subjectTarget = null;
  lockScroll();
}

// --- ADD NEW SUBJECT MODAL ---
function addNewSubject() {
  document.getElementById('newSubjectName').value = '';
  document.getElementById('newSubjectGrade').value = '';
  document.getElementById('addSubjectModal').style.display = 'flex';
  lockScroll();
  setTimeout(() => document.getElementById('newSubjectName').focus(), 50);
}

function closeAddSubjectModal() {
  document.getElementById('addSubjectModal').style.display = 'none';
  lockScroll();
}

function saveNewSubject() {
  const nameInput  = document.getElementById('newSubjectName');
  const gradeInput = document.getElementById('newSubjectGrade');
  const subjectName = nameInput.value.trim();
  const gradeLabel  = gradeInput.value.trim();

  if (!subjectName) {
    nameInput.focus();
    nameInput.style.borderColor = '#e11d48';
    setTimeout(() => (nameInput.style.borderColor = ''), 1500);
    return;
  }

  const grid    = document.getElementById('customSubjGrid');
  const addCard = document.getElementById('addSubjCard');
  const displayLabel = gradeLabel ? `${subjectName} (${gradeLabel})` : subjectName;

  const card = document.createElement('div');
  card.className = 'subj-card';
  card.onclick = () => selectSubject(displayLabel);
  card.innerHTML = `
    <div class="subj-icon-wrap" style="background:#e8eeff;color:#1e2f7a;">
      <i class="fas fa-book-open"></i>
    </div>
    ${displayLabel}
  `;

  grid.insertBefore(card, addCard);
  closeAddSubjectModal();
}

// --- QUIZ MAKER LOGIC ---
function toggleQuestionType(select) {
  const card     = select.closest('.q-card');
  const saFields = card.querySelector('.sa-fields');
  const mcFields = card.querySelector('.mc-fields');
  if (select.value === 'multiple') {
    saFields.style.display = 'none';
    mcFields.style.display = 'block';
  } else {
    saFields.style.display = 'block';
    mcFields.style.display = 'none';
  }
  saveQuizDraft();
}

function addQuestion() {
  questionCount++;
  const list = document.getElementById('questionList');
  const div  = document.createElement('div');
  div.className = 'q-card';
  div.innerHTML = `
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
      <span style="font-weight:700;color:#1e2f7a;font-family:'Afacad',sans-serif;">QUESTION ${questionCount}</span>
      <div style="display:flex;gap:10px;align-items:center;">
        <select class="type-dropdown" onchange="toggleQuestionType(this)" style="padding:6px;border-radius:6px;border:1px solid #cbd5e1;">
          <option value="short">Short Answer</option>
          <option value="multiple">Multiple Choice</option>
        </select>
        <i class="fas fa-trash-can" onclick="removeQuestion(this)" style="color:#e11d48;cursor:pointer;font-size:1.1rem;"></i>
      </div>
    </div>
    <input type="text" placeholder="Enter your question here..." class="q-input-main" oninput="saveQuizDraft()"
      style="width:100%;padding:10px;border:1px solid #cbd5e1;border-radius:8px;margin-bottom:10px;box-sizing:border-box;font-family:'Afacad',sans-serif;">

    <!-- Short Answer -->
    <div class="sa-fields">
      <input type="text" placeholder="Type the correct answer..." class="ans-input" oninput="saveQuizDraft()"
        style="width:100%;padding:10px;border:1px solid #68d391;background:#f0fdf4;border-radius:8px;box-sizing:border-box;font-family:'Afacad',sans-serif;">
    </div>

    <!-- Multiple Choice -->
    <div class="mc-fields" style="display:none;" data-qid="${questionCount}">
      <p class="mc-hint"><i class="fas fa-circle-info"></i> Select the radio button next to the correct answer.</p>
      <div class="mc-choice-row">
        <input type="radio" name="correct_${questionCount}" onchange="saveQuizDraft()">
        <input type="text" placeholder="Choice 1" oninput="saveQuizDraft()"
          style="flex:1;padding:8px 10px;border:1px solid #cbd5e1;border-radius:7px;font-family:'Afacad',sans-serif;">
        <button type="button" class="remove-choice-btn" onclick="removeChoice(this)" title="Remove choice">&#x2715;</button>
      </div>
      <button type="button" class="add-choice-btn-mc" onclick="addChoice(this)">&#43; Add Choice</button>
    </div>`;
  list.appendChild(div);
  saveQuizDraft();
}

// --- DYNAMIC CHOICE ADD / REMOVE (Module 2) ---
function addChoice(addBtn) {
  const mcFields  = addBtn.closest('.mc-fields');
  const qid       = mcFields.dataset.qid;
  const choiceNum = mcFields.querySelectorAll('.mc-choice-row').length + 1;

  const row = document.createElement('div');
  row.className = 'mc-choice-row';
  row.innerHTML = `
    <input type="radio" name="correct_${qid}" onchange="saveQuizDraft()">
    <input type="text" placeholder="Choice ${choiceNum}" oninput="saveQuizDraft()"
      style="flex:1;padding:8px 10px;border:1px solid #cbd5e1;border-radius:7px;font-family:'Afacad',sans-serif;">
    <button type="button" class="remove-choice-btn" onclick="removeChoice(this)" title="Remove choice">&#x2715;</button>`;
  mcFields.insertBefore(row, addBtn);
  saveQuizDraft();
}

function removeChoice(btn) {
  const mcFields = btn.closest('.mc-fields');
  if (mcFields.querySelectorAll('.mc-choice-row').length <= 1) {
    alert('A multiple choice question needs at least one choice.');
    return;
  }
  btn.closest('.mc-choice-row').remove();
  saveQuizDraft();
}

function removeQuestion(btn) {
  btn.closest('.q-card').remove();
  saveQuizDraft();
}

// --- AUTO-SAVE LOGIC ---
function saveQuizDraft() {
  const questions = [];
  document.querySelectorAll('.q-card').forEach(card => {
    questions.push({
      question: card.querySelector('.q-input-main').value,
      type:     card.querySelector('.type-dropdown').value,
      answer:   card.querySelector('.ans-input') ? card.querySelector('.ans-input').value : '',
      options:  Array.from(card.querySelectorAll('.mc-fields input[type="text"]')).map(o => o.value),
    });
  });
  localStorage.setItem('dwcu_quiz_draft', JSON.stringify(questions));
}

function loadQuizDraft() {
  const saved = localStorage.getItem('dwcu_quiz_draft');
  if (!saved) return;
  const questions = JSON.parse(saved);
  if (questions.length === 0) return;
  document.getElementById('questionList').innerHTML = '';
  questionCount = 0;

  questions.forEach(q => {
    addQuestion();
    const cards    = document.querySelectorAll('.q-card');
    const lastCard = cards[cards.length - 1];

    lastCard.querySelector('.q-input-main').value  = q.question;
    lastCard.querySelector('.type-dropdown').value = q.type;
    if (lastCard.querySelector('.ans-input')) {
      lastCard.querySelector('.ans-input').value = q.answer || '';
    }

    if (q.type === 'multiple' && q.options && q.options.length > 0) {
      const mcFields = lastCard.querySelector('.mc-fields');
      const addBtn   = mcFields.querySelector('.add-choice-btn-mc');
      const firstRow = mcFields.querySelector('.mc-choice-row');

      firstRow.querySelector('input[type="text"]').value = q.options[0] || '';

      for (let i = 1; i < q.options.length; i++) {
        addChoice(addBtn);
        const rows = mcFields.querySelectorAll('.mc-choice-row');
        rows[rows.length - 1].querySelector('input[type="text"]').value = q.options[i];
      }
    }

    toggleQuestionType(lastCard.querySelector('.type-dropdown'));
  });
}

// --- PREVIEW LOGIC ---
function showQuizPreview() {
  const previewModal   = document.getElementById('previewModal');
  const previewContent = document.getElementById('previewContent');
  const questions      = document.querySelectorAll('.q-card');
  if (questions.length === 0) { alert('Add some questions first!'); return; }

  let html = '';
  questions.forEach((card, index) => {
    const questionText = card.querySelector('.q-input-main').value || '(Empty Question)';
    const type         = card.querySelector('.type-dropdown').value;
    html += `<div style="background:white;padding:15px;border-radius:10px;margin-bottom:15px;border:1px solid #e2e8f0;">
               <p style="font-weight:700;color:#1e2f7a;margin-bottom:10px;">${index + 1}. ${questionText}</p>`;
    if (type === 'multiple') {
      card.querySelectorAll('.mc-fields input[type="text"]').forEach(opt => {
        if (opt.value) {
          html += `<div style="display:flex;align-items:center;gap:10px;margin:5px 0;">
                     <div style="width:16px;height:16px;border:1px solid #cbd5e1;border-radius:50%;"></div>
                     <span>${opt.value}</span>
                   </div>`;
        }
      });
    } else {
      html += `<div style="border-bottom:1px solid #cbd5e1;height:30px;margin-top:10px;width:80%;"></div>`;
    }
    html += `</div>`;
  });
  previewContent.innerHTML   = html;
  previewModal.style.display = 'flex';
}

// --- INIT ---
window.onclick = (e) => {
  if (!e.target.classList.contains('modal-overlay')) return;
  if (e.target.id === 'addSubjectModal') {
    closeAddSubjectModal();
    return;
  }
  closeAllModals();
};

window.onload = function () {
  // Mobile nav drawer
  const hamburgerBtn = document.getElementById('hamburger-btn');
  const overlay      = document.getElementById('mobile-nav-overlay');
  const drawer       = document.getElementById('mobile-nav-drawer');
  const closeBtn     = document.getElementById('mobile-nav-close');
  const openDrawer   = () => { drawer.classList.add('open'); overlay.classList.add('open'); };
  const closeDrawer  = () => { drawer.classList.remove('open'); overlay.classList.remove('open'); };
  if (hamburgerBtn) hamburgerBtn.addEventListener('click', openDrawer);
  if (closeBtn)     closeBtn.addEventListener('click', closeDrawer);
  if (overlay)      overlay.addEventListener('click', closeDrawer);

  // Chart
  const ctx = document.getElementById('performanceChart').getContext('2d');
  perfChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Quiz 1', 'Quiz 2', 'Asst 1', 'Asst 2'],
      datasets: [{ label: 'Scores (%)', data: [85, 92, 78, 95], backgroundColor: '#1e2f7a', borderRadius: 8 }],
    },
    options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true, max: 100 } } },
  });

  // Table
  renderTable();
  selectStudentByIdx(0);
  checkURLParameters();

  // Grade & Section custom dropdowns
  ['gbDd-google', 'gbDd-quiz', 'gbDd-assign'].forEach(id => {
    const dd = document.getElementById(id);
    if (!dd) return;
    const trigger = dd.querySelector('.gb-dd-trigger');
    const menu    = dd.querySelector('.gb-dd-menu');
    const label   = dd.querySelector('.gb-dd-label');

    trigger.addEventListener('click', (e) => {
      e.stopPropagation();
      document.querySelectorAll('.gb-custom-dropdown.open').forEach(o => { if (o !== dd) o.classList.remove('open'); });
      dd.classList.toggle('open');
    });

    menu.addEventListener('click', (e) => {
      const opt = e.target.closest('.gb-dd-option');
      if (!opt) return;
      menu.querySelectorAll('.gb-dd-option').forEach(o => o.classList.remove('selected'));
      opt.classList.add('selected');
      label.textContent = opt.dataset.value;
      dd.classList.remove('open');
    });
  });

  document.addEventListener('click', (e) => {
    if (!e.target.closest('.gb-custom-dropdown')) {
      document.querySelectorAll('.gb-custom-dropdown.open').forEach(o => o.classList.remove('open'));
    }
  });

  // Close action dropdown when clicking outside or scrolling
  document.addEventListener('click', (e) => {
    const dd = document.getElementById('actionDropdown');
    if (!e.target.closest('.action-edit-btn') && !e.target.closest('#actionDropdown')) {
      dd.style.display = 'none';
      dropdownTargetIdx = null;
    }
  });
  window.addEventListener('scroll', () => {
    const dd = document.getElementById('actionDropdown');
    dd.style.display = 'none';
    dropdownTargetIdx = null;
  }, true);
};
