<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gradebook | DWCU Faculty Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css'])
    <style>
        /* ── Fix logo centering ── */
        .school-logo-img { display: block !important; margin: 0 auto !important; }

        /* ── Portal accent overrides ── */
        .portal-identity                            { color: #ccff00 !important; }
        .nav-link-item.active                       { background: #ccff00 !important; color: #0d1b44 !important; box-shadow: 0 4px 15px rgba(204,255,0,0.2) !important; border-left-color: #0d1b44 !important; }
        .mobile-nav-drawer .nav-item.active-drawer  { background: #ccff00 !important; color: #0d1b44 !important; }

        /* ── Page title & profile ── */
        .page-title       { font-size: 1.6rem; font-weight: 800; color: #0d1b44; margin: 0; }
        .no-underline     { text-decoration: none; color: inherit; }
        .text-inherit     { color: inherit; }
        .profile-icon-box { width: 36px; height: 36px; background: linear-gradient(135deg,#1e2f7a,#0d1b44); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #ccff00; font-size: 0.95rem; }

        /* ── Grade badges ── */
        .gb-badge { display: inline-flex; align-items: center; justify-content: center; width: 22px; height: 22px; border-radius: 6px; font-size: 0.68rem; font-weight: 700; flex-shrink: 0; }
        .g7  { background: #dbeafe; color: #1d4ed8; }
        .g8  { background: #ede9fe; color: #6d28d9; }
        .g9  { background: #dcfce7; color: #15803d; }
        .g10 { background: #fef9c3; color: #a16207; }
        .g11 { background: #ffedd5; color: #c2410c; }
        .g12 { background: #fce7f3; color: #be185d; }

        /* ══════════════════════════════════════════
           GRADEBOOK MAIN LAYOUT
        ══════════════════════════════════════════ */
        .gradebook-main-layout {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .gradebook-content-area { flex: 1; }

        /* ── Student Selector Sidebar ── */
        .student-selector {
            width: 420px;
            background: #fff;
            border-radius: 12px;
            border: 1px solid #eef0f7;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            height: fit-content;
            position: sticky;
            top: 20px;
            padding: 15px;
            display: flex;
            flex-direction: column;
        }

        .selector-header h3 { color: #1e2f7a; margin-bottom: 12px; font-size: 1.1rem; }

        .search-mini {
            display: flex; align-items: center;
            background: #f4f7fe; padding: 8px 12px;
            border-radius: 8px; margin-bottom: 15px;
        }
        .search-mini i { color: #a0aec0; margin-right: 8px; }
        .search-mini input { background: transparent; border: none; outline: none; width: 100%; font-size: 0.9rem; }

        /* ── Student Table ── */
        .student-table-wrapper { overflow: hidden; border-radius: 10px; border: 1px solid #eef0f7; }

        .student-table { width: 100%; border-collapse: collapse; font-size: 0.83rem; font-family: 'Afacad', sans-serif; }

        .student-table thead th {
            background: #f0f4ff; color: #1e2f7a; font-weight: 700;
            padding: 10px 9px; text-align: left;
            font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;
        }

        .th-sortable { cursor: pointer; user-select: none; transition: background 0.15s; }
        .th-sortable:hover { background: #dce6ff; }
        .sort-arrow { color: #9aa8c8; font-size: 0.7rem; margin-left: 3px; }

        .student-row { border-bottom: 1px solid #f0f0f0; cursor: pointer; transition: background 0.15s; }
        .student-row:hover { background: #f0f4ff; }
        .student-row.selected { background: #1e2f7a; color: white; }
        .student-row.selected .td-sid   { color: #93c5fd; }
        .student-row.selected .td-grade { color: #93c5fd; }

        .student-table td { padding: 9px; vertical-align: middle; }
        .td-name  { font-weight: 600; }
        .td-sid   { font-size: 0.68rem; color: #a0aec0; margin-top: 2px; }
        .td-grade { text-align: center; font-weight: 700; color: #1e2f7a; }

        /* ── Status badges ── */
        .status-active  { display: inline-block; background: #dcfce7; color: #166534; padding: 3px 9px; border-radius: 20px; font-size: 0.72rem; font-weight: 700; white-space: nowrap; }
        .status-dropped { display: inline-block; background: #fee2e2; color: #991b1b; padding: 3px 9px; border-radius: 20px; font-size: 0.72rem; font-weight: 700; white-space: nowrap; }

        /* ── Action edit button ── */
        .action-edit-btn {
            background: #fff; border: 1px solid #cbd5e1;
            padding: 5px 10px; border-radius: 6px; font-size: 0.76rem; font-weight: 600;
            color: #374151; cursor: pointer; display: inline-flex; align-items: center; gap: 5px;
            font-family: 'Afacad', sans-serif; transition: all 0.15s;
        }
        .action-edit-btn:hover { border-color: #1e2f7a; color: #1e2f7a; background: #f0f4ff; }
        .student-row.selected .action-edit-btn { background: rgba(255,255,255,0.15); border-color: rgba(255,255,255,0.4); color: white; }

        /* ── Action dropdown ── */
        .action-dropdown {
            position: absolute; background: white; border: 1px solid #e2e8f0;
            border-radius: 10px; box-shadow: 0 8px 25px rgba(0,0,0,0.13);
            z-index: 9998; min-width: 185px; overflow: hidden;
        }
        .dropdown-item {
            display: flex; align-items: center; gap: 9px; padding: 11px 16px;
            border: none; background: none; width: 100%; text-align: left;
            font-family: 'Afacad', sans-serif; font-size: 0.88rem; font-weight: 600;
            cursor: pointer; transition: background 0.15s;
        }
        .dropdown-item:hover { background: #f8fafc; }
        .drop-active  { color: #16a34a; }
        .drop-dropped { color: #dc2626; }

        /* ── Pagination ── */
        .pagination-bar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 12px 2px 0; border-top: 1px solid #eef0f7; margin-top: 10px; gap: 8px;
        }
        .page-btn {
            background: #1e2f7a; color: white; border: none; padding: 7px 14px;
            border-radius: 7px; font-size: 0.8rem; font-weight: 700; cursor: pointer;
            font-family: 'Afacad', sans-serif; transition: background 0.2s, transform 0.1s;
        }
        .page-btn:hover:not(:disabled) { background: #3f51b5; transform: translateY(-1px); }
        .page-btn:disabled { background: #e2e8f0; color: #94a3b8; cursor: not-allowed; transform: none; }
        .page-info { font-size: 0.8rem; color: #64748b; font-weight: 600; white-space: nowrap; }

        /* ══════════════════════════════════════════
           GRADEBOOK CONTENT AREA
        ══════════════════════════════════════════ */
        .gradebook-header-box { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }

        .primary-add-btn {
            background-color: #ffffff; color: #1e2f7a; border: 1px solid #d1d5db;
            padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 0.85rem;
            cursor: pointer; display: flex; align-items: center; gap: 8px;
            transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            font-family: 'Afacad', sans-serif;
        }
        .primary-add-btn:hover { background-color: #f9fafb; border-color: #1e2f7a; transform: translateY(-1px); box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .primary-add-btn i { font-size: 0.9rem; color: #1e2f7a; }

        .analytics-row { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 25px; }

        .graph-card {
            background: white; padding: 20px; border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            height: 350px; display: flex; flex-direction: column;
        }
        .graph-card h3 { color: #1e2f7a; margin: 0 0 12px; font-size: 1rem; font-weight: 700; }

        #performanceChart { width: 100% !important; height: 100% !important; max-height: 280px !important; }

        .summary-card {
            background: white; padding: 20px; border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            display: flex; flex-direction: column; align-items: center;
            justify-content: center; text-align: center;
        }
        .summary-card h3 { color: #1e2f7a; margin: 0 0 10px; font-size: 1rem; font-weight: 700; }
        .summary-card p  { color: #64748b; font-size: 0.85rem; margin: 0; }
        .average-score   { font-size: 3rem; font-weight: 800; color: #1e2f7a; margin: 8px 0; }

        .assessment-container {
            background: #f0f2f5; padding: 25px; border-radius: 15px;
            margin-bottom: 30px; border: 1px solid #e0e0e0;
        }
        .assessment-container h3 { color: #1e2f7a; margin: 0 0 4px; font-size: 1rem; font-weight: 700; }

        .assessment-row {
            background: white; padding: 18px; border-radius: 10px; margin-top: 12px;
            display: flex; justify-content: space-between; align-items: center;
            border: 1px solid #dee2e6; box-shadow: 0 2px 6px rgba(0,0,0,0.03);
            transition: transform 0.2s ease;
        }
        .assessment-row:hover { transform: translateY(-2px); border-color: #3f51b5; }

        .sync-status { display: flex; align-items: center; gap: 6px; color: #22c55e; font-size: 0.82rem; font-weight: 600; }

        /* ── Report card grades editor ── */
        .grades-editor-table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; }
        .grades-editor-table th {
            background: #eef1fb; color: #1e2f7a; font-weight: 700; padding: 10px 12px;
            text-align: center; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .grades-editor-table th:first-child { text-align: left; }
        .grades-editor-table td { padding: 8px 12px; border-top: 1px solid #f0f2f8; text-align: center; }
        .td-subject { text-align: left !important; font-weight: 600; color: #1e2f7a; font-size: 0.88rem; }
        .td-final   { font-weight: 700; color: #1e2f7a; }
        .grade-cell-input {
            width: 55px; padding: 6px; text-align: center; border: 1.5px solid #dbe0ee;
            border-radius: 6px; font-family: 'Afacad', sans-serif; font-size: 0.88rem;
        }
        .grade-cell-input:focus { outline: none; border-color: #1e2f7a; background: #f8f9ff; }

        /* ══════════════════════════════════════════
           MODAL SYSTEM
        ══════════════════════════════════════════ */
        .modal-overlay {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.6); backdrop-filter: blur(5px);
            z-index: 9999; justify-content: center; align-items: center;
        }
        .modal-card {
            background: white; padding: 35px; border-radius: 20px;
            width: 90%; max-width: 500px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.25);
            font-family: 'Afacad', sans-serif; position: relative;
            animation: modalFadeIn 0.3s ease-out;
        }
        @keyframes modalFadeIn { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }

        .modal-title { color: #1e2f7a; margin-bottom: 25px; font-size: 1.6rem; font-weight: 800; }

        .close-modal { position: absolute; top: 20px; right: 25px; font-size: 30px; cursor: pointer; color: #bbb; transition: color 0.2s; }
        .close-modal:hover { color: #ff4b2b; }

        /* ── Form elements ── */
        .form-row { display: flex; gap: 15px; margin-bottom: 10px; }
        .form-row .form-group { flex: 1; }

        .form-group { margin-bottom: 18px; display: flex; flex-direction: column; }
        .form-group label { font-weight: 700; margin-bottom: 8px; color: #444; font-size: 0.9rem; text-transform: uppercase; display: block; }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 12px; border: 1.5px solid #eee; border-radius: 10px;
            font-family: inherit; font-size: 1rem; transition: border-color 0.3s;
        }
        .form-group input:focus,
        .form-group select:focus { outline: none; border-color: #1e2f7a; background-color: #fbfbfb; }

        textarea { width: 100%; padding: 12px; border: 1.5px solid #eee; border-radius: 10px; font-family: inherit; resize: vertical; }

        /* ── Modal buttons ── */
        .modal-buttons { display: flex; justify-content: flex-end; gap: 12px; margin-top: 30px; }

        .btn-primary {
            background: #1e2f7a; color: white; border: none; padding: 12px 25px;
            border-radius: 10px; cursor: pointer; font-weight: 700; font-family: 'Afacad', sans-serif;
            transition: all 0.3s ease;
        }
        .btn-primary:hover { background: #3f51b5; box-shadow: 0 5px 15px rgba(30,47,122,0.3); }

        .btn-secondary {
            background: #f1f5f9; border: none; padding: 12px 22px; border-radius: 10px;
            cursor: pointer; font-weight: 600; font-family: 'Afacad', sans-serif; color: #475569; transition: background 0.2s;
        }
        .btn-secondary:hover { background: #e2e8f0; }

        .btn-cancel {
            background: #f1f3f4; color: #555; border: none; padding: 12px 25px;
            border-radius: 10px; font-weight: 600; cursor: pointer; font-family: 'Afacad', sans-serif;
        }

        .btn-cancel-full {
            width: 100%; padding: 12px; background: #f1f3f4; border: none;
            border-radius: 10px; cursor: pointer; font-weight: 600; font-family: 'Afacad', sans-serif;
        }

        /* ── Task selection ── */
        .task-selection-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin: 30px 0; }

        .task-item { text-align: center; cursor: pointer; transition: transform 0.2s; }
        .task-item:hover { transform: translateY(-5px); }

        .task-icon {
            width: 70px; height: 70px; border-radius: 50%; margin: 0 auto 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; color: white;
        }
        .google { background: #4285F4; }
        .quiz   { background: #1e2f7a; }
        .assign { background: #34A853; }
        .task-item p { font-weight: 600; font-size: 0.9rem; color: #333; }

        /* ── Gradebook custom dropdown ── */
        .gb-custom-dropdown { position: relative; width: 100%; font-family: 'Afacad', sans-serif; }

        .gb-dd-trigger {
            width: 100%; display: flex; align-items: center; justify-content: space-between;
            background: #f8f9ff; border: 1.5px solid #e2e8f0; border-radius: 10px;
            padding: 10px 14px; cursor: pointer; font-family: 'Afacad', sans-serif; gap: 10px;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .gb-dd-trigger:hover,
        .gb-custom-dropdown.open .gb-dd-trigger { border-color: #3f51b5; background: white; box-shadow: 0 0 0 3px rgba(63,81,181,0.1); }

        .gb-dd-left { display: flex; align-items: center; gap: 8px; font-size: 0.88rem; font-weight: 600; color: #1e2f7a; }
        .gb-dd-left i { color: #3f51b5; font-size: 0.88rem; }

        .gb-dd-chevron { color: #3f51b5; font-size: 0.7rem; transition: transform 0.2s; flex-shrink: 0; }
        .gb-custom-dropdown.open .gb-dd-chevron { transform: rotate(180deg); }

        .gb-dd-menu {
            display: none; position: absolute; top: calc(100% + 6px); left: 0; right: 0;
            background: white; border: 1.5px solid #e2e8f0; border-radius: 12px;
            box-shadow: 0 8px 24px rgba(30,47,122,0.13); z-index: 99999;
            list-style: none; margin: 0; padding: 6px;
            max-height: 240px; overflow-y: auto; animation: gbDropIn 0.15s ease;
        }
        .gb-custom-dropdown.open .gb-dd-menu { display: block; }
        @keyframes gbDropIn { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:translateY(0); } }

        .gb-dd-group { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8; padding: 8px 10px 4px; }
        .gb-dd-option { display: flex; align-items: center; gap: 8px; padding: 8px 10px; border-radius: 8px; font-size: 0.86rem; font-weight: 600; color: #1e2f7a; cursor: pointer; transition: background 0.15s; }
        .gb-dd-option:hover    { background: #f1f3fb; }
        .gb-dd-option.selected { background: #eef1fb; }

        /* ── Quiz maker ── */
        #quizModal .modal-card { max-width: 600px; width: 90%; overflow-x: hidden; }

        .modal-body-scroll { max-height: 60vh; overflow-y: auto; padding-right: 10px; margin-bottom: 20px; }

        .modal-footer-fixed { display: flex; justify-content: flex-end; gap: 12px; padding-top: 20px; border-top: 1px solid #eee; }

        .q-card {
            background: #ffffff; padding: 20px; border-radius: 12px; margin-bottom: 20px;
            border: 1px solid #e0e6ed; border-left: 5px solid #1e2f7a;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05); transition: transform 0.2s ease;
            animation: cardAppear 0.3s ease-out; position: relative; width: 100%; box-sizing: border-box;
        }
        @keyframes cardAppear { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }

        .q-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .q-card-header span { font-size: 0.85rem; font-weight: 700; color: #1e2f7a; text-transform: uppercase; letter-spacing: 0.5px; }

        .btn-delete { background: none; border: none; color: #dc3545; cursor: pointer; font-size: 1rem; padding: 5px; transition: color 0.2s, transform 0.2s; }
        .btn-delete:hover { color: #a71d2a; transform: scale(1.1); }

        .type-select { padding: 4px 8px; border-radius: 4px; border: 1px solid #ddd; font-size: 0.8rem; margin-left: auto; margin-right: 10px; }

        .q-input-main { width: 100% !important; box-sizing: border-box; margin-bottom: 12px !important; font-weight: 500; }

        .add-q-btn {
            width: 100%; padding: 15px; background: #f0f4ff; border: 2px dashed #1e2f7a;
            color: #1e2f7a; border-radius: 10px; cursor: pointer; font-weight: 700;
            font-family: 'Afacad', sans-serif; transition: 0.3s; margin: 10px 0;
        }
        .add-q-btn:hover { background: #1e2f7a; color: white; }

        /* ── Multiple choice ── */
        .mc-choice-row { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; }
        .mc-choice-row input[type="radio"] { width: 17px; height: 17px; accent-color: #1e2f7a; flex-shrink: 0; cursor: pointer; margin: 0; }
        .mc-choice-row input[type="text"] { flex: 1; padding: 8px 10px; border: 1px solid #cbd5e1; border-radius: 7px; font-family: 'Afacad', sans-serif; font-size: 0.92rem; transition: border-color 0.2s; }
        .mc-choice-row input[type="text"]:focus { border-color: #1e2f7a; outline: none; }
        .mc-choice-row.is-correct input[type="text"] { border-color: #22c55e; background: #f0fdf4; }

        .remove-choice-btn {
            background: none; border: 1px solid #fecaca; color: #ef4444;
            width: 26px; height: 26px; border-radius: 50%; flex-shrink: 0;
            cursor: pointer; font-size: 0.75rem; display: flex; align-items: center; justify-content: center;
            transition: background 0.15s; padding: 0;
        }
        .remove-choice-btn:hover { background: #fee2e2; }

        .add-choice-btn-mc {
            width: 100%; padding: 8px; margin-top: 6px;
            background: #f8fafc; border: 1.5px dashed #cbd5e1;
            color: #64748b; border-radius: 8px; cursor: pointer;
            font-family: 'Afacad', sans-serif; font-weight: 600; font-size: 0.84rem; transition: all 0.2s;
        }
        .add-choice-btn-mc:hover { border-color: #1e2f7a; color: #1e2f7a; background: #f0f4ff; }

        .mc-hint { font-size: 0.72rem; color: #94a3b8; margin-bottom: 8px; display: flex; align-items: center; gap: 5px; }

        .ans-input { border-left: 4px solid #22c55e !important; background: #f0fdf4 !important; font-weight: 500; }

        /* ── Subject Picker ── */
        #subjectPickerModal { z-index: 10001; }
        #subjectPickerModal .modal-card { max-width: 560px; width: 94%; }

        .subj-trigger {
            display: flex; align-items: center; gap: 10px;
            padding: 11px 14px; border: 1.5px solid #eee; border-radius: 10px;
            cursor: pointer; font-family: 'Afacad', sans-serif;
            font-size: 0.95rem; color: #9aa8c8; background: white; transition: all 0.2s;
        }
        .subj-trigger:hover { border-color: #1e2f7a; background: #fafbff; }
        .subj-trigger.has-value { color: #1e2f7a; font-weight: 700; border-color: #1e2f7a; background: #f5f8ff; }
        .subj-trigger .subj-trigger-text { flex: 1; }
        .subj-trigger .fa-chevron-right { font-size: 0.72rem; color: #cbd5e1; margin-left: auto; }

        .subj-picker-scroll { max-height: 65vh; overflow-y: auto; padding-right: 4px; }

        .subj-group { margin-bottom: 20px; }
        .subj-group:last-child { margin-bottom: 4px; }

        .subj-group-label {
            font-size: 0.7rem; font-weight: 800; color: #94a3b8;
            text-transform: uppercase; letter-spacing: 0.7px;
            margin: 0 0 10px; display: flex; align-items: center; gap: 6px;
        }
        .subj-group-label::after { content: ''; flex: 1; height: 1px; background: #f1f5f9; }

        .subj-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; }

        .subj-card {
            display: flex; flex-direction: column; align-items: center; gap: 8px;
            padding: 14px 8px; border: 1.5px solid #e2e8f0; border-radius: 12px;
            cursor: pointer; text-align: center; background: white;
            font-family: 'Afacad', sans-serif; font-weight: 600; font-size: 0.8rem; color: #374151;
            transition: all 0.18s ease;
        }
        .subj-card:hover { border-color: #1e2f7a; background: #f0f4ff; color: #1e2f7a; transform: translateY(-2px); }
        .subj-card:hover .subj-icon-wrap { background: #1e2f7a !important; }
        .subj-card:hover .subj-icon-wrap i { color: white !important; }

        .subj-icon-wrap {
            width: 44px; height: 44px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.15rem; transition: background 0.18s;
        }

        .subj-card-add {
            display: flex; flex-direction: column; align-items: center; gap: 8px;
            padding: 14px 8px; border: 2px dashed #1e2f7a; border-radius: 12px;
            cursor: pointer; text-align: center; background: #f5f8ff;
            font-family: 'Afacad', sans-serif; font-weight: 600; font-size: 0.8rem; color: #1e2f7a;
            transition: all 0.18s ease;
        }
        .subj-card-add:hover { background: #e8eeff; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(30,47,122,0.12); }
        .subj-card-add .subj-icon-wrap { background: #e8eeff; color: #1e2f7a; font-size: 1.3rem; }

        /* ── Add subject modal ── */
        #addSubjectModal { z-index: 10002; }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .gradebook-main-layout { flex-direction: column; }
            .student-selector { width: 100%; position: static; }
            .analytics-row { grid-template-columns: 1fr; }
            .subj-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 480px) {
            .subj-grid { grid-template-columns: repeat(3, 1fr); }
            .task-selection-grid { grid-template-columns: repeat(3, 1fr); gap: 12px; }
        }
    </style>
</head>
<body>

<div class="dashboard-wrapper">

    {{-- ── SIDEBAR ── --}}
    <aside class="sidebar-container">
        <div class="sidebar-top-branding">
            <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo" class="school-logo-img">
            <div class="school-title-text">DIVINE WORD COLLEGE <br> OF URDANETA</div>
            <div class="portal-identity">Faculty Portal</div>
        </div>
        <nav class="nav-links-list">
            <a href="{{ route('faculty.students') }}"      class="nav-link-item"><i class="fas fa-users"></i> Student List</a>
            <a href="{{ route('faculty.calendar') }}"      class="nav-link-item"><i class="fas fa-calendar-alt"></i> Calendar</a>
            <a href="{{ route('faculty.gradebook') }}"     class="nav-link-item active"><i class="fas fa-book-open"></i> Gradebook</a>
            <a href="{{ route('faculty.announcements') }}" class="nav-link-item"><i class="fas fa-bullhorn"></i> Announcement</a>
            <a href="{{ route('faculty.logs') }}"          class="nav-link-item"><i class="fas fa-history"></i> Activity Logs</a>
        </nav>
        <div class="sidebar-footer-action">
            <form method="POST" action="{{ route('faculty.logout') }}">
                @csrf
                <button type="submit" class="exit-system-link w-full cursor-pointer border-none bg-transparent">
                    <i class="fas fa-sign-out-alt"></i> Log out
                </button>
            </form>
        </div>
    </aside>

    {{-- ── MAIN CONTENT ── --}}
    <main class="main-viewport-content">

        {{-- ── HEADER ── --}}
        <header class="top-nav-bar">
            <div class="flex items-center gap-3">
                <button class="hamburger-btn" id="hamburger-btn" aria-label="Open menu">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title">Grade Book</h1>
            </div>
            <a href="{{ route('faculty.profile') }}" class="no-underline text-inherit">
                <div class="user-quick-profile">
                    <div class="profile-info">
                        <span class="user-name">{{ session('faculty_name') }}</span>
                        <span class="user-role">Faculty Member</span>
                    </div>
                    <div class="profile-icon-box">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                </div>
            </a>
        </header>

        <div class="admin-content-grid">

            {{-- ── GRADEBOOK LAYOUT ── --}}
            <div class="gradebook-main-layout">

                {{-- ── Student Selector Sidebar ── --}}
                <aside class="student-selector">
                    <div class="selector-header">
                        <h3>Student List</h3>
                        <div class="search-mini">
                            <i class="fas fa-search"></i>
                            <input type="text" id="studentSearch" placeholder="Search name, grade, or section..." oninput="renderTable()">
                        </div>
                    </div>
                    <div class="student-table-wrapper">
                        <table class="student-table" id="studentTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th class="th-sortable" onclick="sortTable('grade')">Grade <span class="sort-arrow" id="grade-sort-icon">↕</span></th>
                                    <th class="th-sortable" onclick="sortTable('status')">Status <span class="sort-arrow" id="status-sort-icon">↕</span></th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="studentTableBody"></tbody>
                        </table>
                    </div>
                    <div class="pagination-bar" id="paginationBar" style="display:none;">
                        <button class="page-btn" id="prevBtn" onclick="changePage(-1)">&#8592; Prev</button>
                        <span class="page-info" id="pageInfo">Page 1 of 1</span>
                        <button class="page-btn" id="nextBtn" onclick="changePage(1)">Next &#8594;</button>
                    </div>
                </aside>

                {{-- ── Gradebook Content ── --}}
                <div class="gradebook-content-area">
                    <section class="gradebook-header-box">
                        <div class="student-info-main">
                            <h2 id="display-name">Academic Management</h2>
                            <p id="display-section">Select a student to view records</p>
                        </div>
                        <div class="header-actions">
                            <button class="primary-add-btn" onclick="openSelectionModal()">
                                <i class="fas fa-plus"></i> Add New Task
                            </button>
                        </div>
                    </section>

                    <div class="analytics-row">
                        <div class="graph-card">
                            <h3>Performance Analysis</h3>
                            <canvas id="performanceChart"></canvas>
                        </div>
                        <div class="summary-card">
                            <h3>Automated Average</h3>
                            <h2 class="average-score" id="display-avg">89.5</h2>
                            <p>Weighted Score</p>
                        </div>
                    </div>

                    <div class="assessment-container">
                        <h3>Automated Grading Breakdown</h3>
                        <div class="assessment-row">
                            <span>Quizzes (Summative): <strong>60%</strong></span>
                            <span class="sync-status"><i class="fas fa-sync"></i> Auto-Synced</span>
                        </div>
                        <div class="assessment-row">
                            <span>Assignments (Formative): <strong>40%</strong></span>
                            <span class="sync-status"><i class="fas fa-sync"></i> Auto-Synced</span>
                        </div>
                    </div>

                    <div class="assessment-container">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">
                            <h3>Report Card Grades</h3>
                            <button type="button" id="saveGradesBtn" class="primary-add-btn" onclick="saveStudentGrades()">
                                <i class="fas fa-save"></i> Save Grades
                            </button>
                        </div>
                        <p style="color:#64748b;font-size:0.82rem;margin:0 0 14px;">Editing feeds directly into this student's SF9/SF10 report forms.</p>
                        <div style="overflow-x:auto;">
                            <table class="grades-editor-table">
                                <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Q1</th>
                                        <th>Q2</th>
                                        <th>Q3</th>
                                        <th>Q4</th>
                                        <th>Final</th>
                                    </tr>
                                </thead>
                                <tbody id="gradesTableBody">
                                    <tr><td colspan="6" style="text-align:center;color:#94a3b8;padding:20px;">Select a student to view grades.</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="assessment-container">
                        <h3>My Quizzes</h3>
                        <div id="myQuizzesList"><p style="color:#64748b;font-size:0.9rem;">Loading…</p></div>
                    </div>
                </div>{{-- /gradebook-content-area --}}

            </div>{{-- /gradebook-main-layout --}}

        </div>{{-- /admin-content-grid --}}
    </main>
</div>

{{-- ── Task Type Selection Modal ── --}}
<div id="selectionModal" class="modal-overlay">
    <div class="modal-card">
        <h2 class="modal-title">Select Task Type</h2>
        <div class="task-selection-grid">
            <div class="task-item" onclick="openTaskModal('googleModal')">
                <div class="task-icon google"><i class="fab fa-google"></i></div>
                <p>Google Form</p>
            </div>
            <div class="task-item" onclick="openTaskModal('quizModal')">
                <div class="task-icon quiz"><i class="fas fa-pen-to-square"></i></div>
                <p>Quiz Maker</p>
            </div>
            <div class="task-item" onclick="openTaskModal('assignmentModal')">
                <div class="task-icon assign"><i class="fas fa-file-arrow-up"></i></div>
                <p>Assignment</p>
            </div>
        </div>
        <button class="btn-cancel-full" onclick="closeAllModals()">Cancel</button>
    </div>
</div>

{{-- ── Google Form Modal ── --}}
<div id="googleModal" class="modal-overlay">
    <div class="modal-card">
        <h2 class="modal-title">Link Google Form</h2>
        <form>
            <div class="form-row">
                <div class="form-group">
                    <label>GRADE &amp; SECTION</label>
                    <div class="gb-custom-dropdown" id="gbDd-google">
                        <button class="gb-dd-trigger" type="button">
                            <span class="gb-dd-left"><i class="fas fa-layer-group"></i><span class="gb-dd-label">Select section...</span></span>
                            <i class="fas fa-chevron-down gb-dd-chevron"></i>
                        </button>
                        <ul class="gb-dd-menu">
                            <li class="gb-dd-group">Junior High School</li>
                            <li class="gb-dd-option" data-value="Grade 7 - Explorers"><span class="gb-badge g7">7</span>Grade 7 — Explorers</li>
                            <li class="gb-dd-option" data-value="Grade 8 - Researchers"><span class="gb-badge g8">8</span>Grade 8 — Researchers</li>
                            <li class="gb-dd-option" data-value="Grade 9 - Innovators"><span class="gb-badge g9">9</span>Grade 9 — Innovators</li>
                            <li class="gb-dd-option" data-value="Grade 10 - Leaders"><span class="gb-badge g10">10</span>Grade 10 — Leaders</li>
                            <li class="gb-dd-group">Senior High School — Grade 11</li>
                            <li class="gb-dd-option" data-value="Grade 11 - STEM"><span class="gb-badge g11">11</span>Grade 11 — STEM</li>
                            <li class="gb-dd-option" data-value="Grade 11 - ICT"><span class="gb-badge g11">11</span>Grade 11 — ICT</li>
                            <li class="gb-dd-option" data-value="Grade 11 - HUMSS"><span class="gb-badge g11">11</span>Grade 11 — HUMSS</li>
                            <li class="gb-dd-group">Senior High School — Grade 12</li>
                            <li class="gb-dd-option" data-value="Grade 12 - STEM"><span class="gb-badge g12">12</span>Grade 12 — STEM</li>
                            <li class="gb-dd-option" data-value="Grade 12 - ICT"><span class="gb-badge g12">12</span>Grade 12 — ICT</li>
                            <li class="gb-dd-option" data-value="Grade 12 - HUMSS"><span class="gb-badge g12">12</span>Grade 12 — HUMSS</li>
                        </ul>
                    </div>
                </div>
                <div class="form-group">
                    <label>SUBJECT</label>
                    <div class="subj-trigger" id="subj-google" onclick="openSubjectPicker('subj-google')">
                        <i class="fas fa-book-open" style="color:#1e2f7a;font-size:0.9rem;"></i>
                        <span class="subj-trigger-text">Click to select a subject</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>ACTIVITY TITLE</label>
                <input type="text" placeholder="e.g., Quiz #1: Algebra">
            </div>
            <div class="form-group">
                <label>GOOGLE FORM LINK</label>
                <input type="url" placeholder="https://docs.google.com/forms/...">
            </div>
            <div class="modal-buttons">
                <button type="button" class="btn-secondary" onclick="openSelectionModal()">Back</button>
                <button type="submit" class="btn-primary">Publish Task</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Quiz Maker Modal ── --}}
<div id="quizModal" class="modal-overlay">
    <div class="modal-card">
        <h2 class="modal-title">Quiz Maker</h2>
        <div class="modal-body-scroll">
            <div class="form-row">
                <div class="form-group">
                    <label>GRADE &amp; SECTION</label>
                    <div class="gb-custom-dropdown" id="gbDd-quiz">
                        <button class="gb-dd-trigger" type="button">
                            <span class="gb-dd-left"><i class="fas fa-layer-group"></i><span class="gb-dd-label">Select section...</span></span>
                            <i class="fas fa-chevron-down gb-dd-chevron"></i>
                        </button>
                        <ul class="gb-dd-menu">
                            <li class="gb-dd-group">Junior High School</li>
                            <li class="gb-dd-option" data-value="Grade 7 - Explorers"><span class="gb-badge g7">7</span>Grade 7 — Explorers</li>
                            <li class="gb-dd-option" data-value="Grade 8 - Researchers"><span class="gb-badge g8">8</span>Grade 8 — Researchers</li>
                            <li class="gb-dd-option" data-value="Grade 9 - Innovators"><span class="gb-badge g9">9</span>Grade 9 — Innovators</li>
                            <li class="gb-dd-option" data-value="Grade 10 - Leaders"><span class="gb-badge g10">10</span>Grade 10 — Leaders</li>
                            <li class="gb-dd-group">Senior High School — Grade 11</li>
                            <li class="gb-dd-option" data-value="Grade 11 - STEM"><span class="gb-badge g11">11</span>Grade 11 — STEM</li>
                            <li class="gb-dd-option" data-value="Grade 11 - ICT"><span class="gb-badge g11">11</span>Grade 11 — ICT</li>
                            <li class="gb-dd-option" data-value="Grade 11 - HUMSS"><span class="gb-badge g11">11</span>Grade 11 — HUMSS</li>
                            <li class="gb-dd-group">Senior High School — Grade 12</li>
                            <li class="gb-dd-option" data-value="Grade 12 - STEM"><span class="gb-badge g12">12</span>Grade 12 — STEM</li>
                            <li class="gb-dd-option" data-value="Grade 12 - ICT"><span class="gb-badge g12">12</span>Grade 12 — ICT</li>
                            <li class="gb-dd-option" data-value="Grade 12 - HUMSS"><span class="gb-badge g12">12</span>Grade 12 — HUMSS</li>
                        </ul>
                    </div>
                </div>
                <div class="form-group">
                    <label>SUBJECT</label>
                    <div class="subj-trigger" id="subj-quiz" onclick="openSubjectPicker('subj-quiz')">
                        <i class="fas fa-book-open" style="color:#1e2f7a;font-size:0.9rem;"></i>
                        <span class="subj-trigger-text">Click to select a subject</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>QUIZ TITLE</label>
                <input type="text" id="quizTitle" placeholder="Chapter 1 Test">
            </div>
            <div id="questionList"></div>
            <button type="button" class="add-q-btn" onclick="addQuestion()">+ Add Question</button>
        </div>
        <div class="modal-footer-fixed">
            <button type="button" class="btn-secondary" onclick="openSelectionModal()">Back</button>
            <button type="button" style="background:#64748b;color:white;border:none;padding:12px 22px;border-radius:10px;cursor:pointer;font-weight:700;font-family:'Afacad',sans-serif;" onclick="showQuizPreview()">Preview</button>
            <button type="button" class="btn-primary" onclick="submitQuiz()">Create Quiz</button>
        </div>
    </div>
</div>

{{-- ── Assignment Modal ── --}}
<div id="assignmentModal" class="modal-overlay">
    <div class="modal-card">
        <h2 class="modal-title">New Assignment</h2>
        <form>
            <div class="form-row">
                <div class="form-group">
                    <label>GRADE &amp; SECTION</label>
                    <div class="gb-custom-dropdown" id="gbDd-assign">
                        <button class="gb-dd-trigger" type="button">
                            <span class="gb-dd-left"><i class="fas fa-layer-group"></i><span class="gb-dd-label">Select section...</span></span>
                            <i class="fas fa-chevron-down gb-dd-chevron"></i>
                        </button>
                        <ul class="gb-dd-menu">
                            <li class="gb-dd-group">Junior High School</li>
                            <li class="gb-dd-option" data-value="Grade 7 - Explorers"><span class="gb-badge g7">7</span>Grade 7 — Explorers</li>
                            <li class="gb-dd-option" data-value="Grade 8 - Researchers"><span class="gb-badge g8">8</span>Grade 8 — Researchers</li>
                            <li class="gb-dd-option" data-value="Grade 9 - Innovators"><span class="gb-badge g9">9</span>Grade 9 — Innovators</li>
                            <li class="gb-dd-option" data-value="Grade 10 - Leaders"><span class="gb-badge g10">10</span>Grade 10 — Leaders</li>
                            <li class="gb-dd-group">Senior High School — Grade 11</li>
                            <li class="gb-dd-option" data-value="Grade 11 - STEM"><span class="gb-badge g11">11</span>Grade 11 — STEM</li>
                            <li class="gb-dd-option" data-value="Grade 11 - ICT"><span class="gb-badge g11">11</span>Grade 11 — ICT</li>
                            <li class="gb-dd-option" data-value="Grade 11 - HUMSS"><span class="gb-badge g11">11</span>Grade 11 — HUMSS</li>
                            <li class="gb-dd-group">Senior High School — Grade 12</li>
                            <li class="gb-dd-option" data-value="Grade 12 - STEM"><span class="gb-badge g12">12</span>Grade 12 — STEM</li>
                            <li class="gb-dd-option" data-value="Grade 12 - ICT"><span class="gb-badge g12">12</span>Grade 12 — ICT</li>
                            <li class="gb-dd-option" data-value="Grade 12 - HUMSS"><span class="gb-badge g12">12</span>Grade 12 — HUMSS</li>
                        </ul>
                    </div>
                </div>
                <div class="form-group">
                    <label>SUBJECT</label>
                    <div class="subj-trigger" id="subj-assign" onclick="openSubjectPicker('subj-assign')">
                        <i class="fas fa-book-open" style="color:#1e2f7a;font-size:0.9rem;"></i>
                        <span class="subj-trigger-text">Click to select a subject</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>ASSIGNMENT TITLE</label>
                <input type="text" placeholder="Essay: Modern History">
            </div>
            <div class="form-group">
                <label>INSTRUCTIONS</label>
                <textarea rows="4" placeholder="Type instructions here..."></textarea>
            </div>
            <div class="modal-buttons">
                <button type="button" class="btn-secondary" onclick="openSelectionModal()">Back</button>
                <button type="submit" class="btn-primary">Post Task</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Quiz Preview Modal ── --}}
<div id="previewModal" class="modal-overlay" style="z-index:10000;">
    <div class="modal-card" style="max-width:600px;width:90%;">
        <h2 class="modal-title" style="border-bottom:2px solid #1e2f7a;padding-bottom:10px;">Quiz Preview</h2>
        <div id="previewContent" style="max-height:60vh;overflow-y:auto;margin:15px 0;"></div>
        <button class="btn-primary" onclick="document.getElementById('previewModal').style.display='none'" style="width:100%;">Close Preview</button>
    </div>
</div>

{{-- ── Subject Picker Modal ── --}}
<div id="subjectPickerModal" class="modal-overlay">
    <div class="modal-card">
        <h2 class="modal-title" style="margin-bottom:18px;">
            <i class="fas fa-book-open" style="margin-right:8px;font-size:1.2rem;"></i>Select Subject
        </h2>
        <div class="subj-picker-scroll">

            <div class="subj-group">
                <p class="subj-group-label">JHS — Grade 7 to 10</p>
                <div class="subj-grid">
                    <div class="subj-card" onclick="selectSubject('Science')">
                        <div class="subj-icon-wrap" style="background:#dcfce7;color:#166534;"><i class="fas fa-flask"></i></div>
                        Science
                    </div>
                    <div class="subj-card" onclick="selectSubject('English')">
                        <div class="subj-icon-wrap" style="background:#dbeafe;color:#1e40af;"><i class="fas fa-book"></i></div>
                        English
                    </div>
                    <div class="subj-card" onclick="selectSubject('Mathematics')">
                        <div class="subj-icon-wrap" style="background:#fef3c7;color:#92400e;"><i class="fas fa-calculator"></i></div>
                        Mathematics
                    </div>
                    <div class="subj-card" onclick="selectSubject('TLE')">
                        <div class="subj-icon-wrap" style="background:#f3e8ff;color:#6b21a8;"><i class="fas fa-tools"></i></div>
                        TLE
                    </div>
                </div>
            </div>

            <div class="subj-group">
                <p class="subj-group-label">SHS — STEM</p>
                <div class="subj-grid">
                    <div class="subj-card" onclick="selectSubject('Pre-Calculus / Basic Cal')">
                        <div class="subj-icon-wrap" style="background:#fef3c7;color:#92400e;"><i class="fas fa-infinity"></i></div>
                        Pre-Calculus
                    </div>
                    <div class="subj-card" onclick="selectSubject('General Biology')">
                        <div class="subj-icon-wrap" style="background:#dcfce7;color:#166534;"><i class="fas fa-dna"></i></div>
                        Gen. Biology
                    </div>
                    <div class="subj-card" onclick="selectSubject('General Chemistry')">
                        <div class="subj-icon-wrap" style="background:#dbeafe;color:#1e40af;"><i class="fas fa-atom"></i></div>
                        Gen. Chemistry
                    </div>
                </div>
            </div>

            <div class="subj-group">
                <p class="subj-group-label">SHS — HUMSS</p>
                <div class="subj-grid">
                    <div class="subj-card" onclick="selectSubject('Political Science / Gov\'t')">
                        <div class="subj-icon-wrap" style="background:#ffe4e6;color:#9f1239;"><i class="fas fa-landmark"></i></div>
                        PolGov
                    </div>
                    <div class="subj-card" onclick="selectSubject('Creative Writing')">
                        <div class="subj-icon-wrap" style="background:#f0fdf4;color:#166534;"><i class="fas fa-pen-nib"></i></div>
                        Creative Writing
                    </div>
                </div>
            </div>

            <div class="subj-group">
                <p class="subj-group-label">SHS — ICT</p>
                <div class="subj-grid">
                    <div class="subj-card" onclick="selectSubject('Programming')">
                        <div class="subj-icon-wrap" style="background:#1e2f7a;color:white;"><i class="fas fa-code"></i></div>
                        Programming
                    </div>
                    <div class="subj-card" onclick="selectSubject('Computer System Servicing')">
                        <div class="subj-icon-wrap" style="background:#f1f5f9;color:#475569;"><i class="fas fa-server"></i></div>
                        CSS
                    </div>
                </div>
            </div>

            <div class="subj-group">
                <p class="subj-group-label">Custom</p>
                <div class="subj-grid" id="customSubjGrid">
                    <div class="subj-card-add" id="addSubjCard" onclick="addNewSubject()">
                        <div class="subj-icon-wrap"><i class="fas fa-plus"></i></div>
                        Add Subject
                    </div>
                </div>
            </div>

        </div>
        <button class="btn-cancel-full" style="margin-top:18px;" onclick="closeSubjectPicker()">Cancel</button>
    </div>
</div>

{{-- ── Add New Subject Modal ── --}}
<div id="addSubjectModal" class="modal-overlay">
    <div class="modal-card">
        <span class="close-modal" onclick="closeAddSubjectModal()">&times;</span>
        <h2 class="modal-title">Create New Subject</h2>
        <div class="form-group">
            <label>Subject Name</label>
            <input type="text" id="newSubjectName" placeholder="e.g., Practical Research" autocomplete="off">
        </div>
        <div class="form-group">
            <label>Grade Level</label>
            <input type="text" id="newSubjectGrade" placeholder="e.g., Grade 11 – STEM" autocomplete="off">
        </div>
        <div class="modal-buttons">
            <button type="button" class="btn-cancel" onclick="closeAddSubjectModal()">Cancel</button>
            <button type="button" class="btn-primary" onclick="saveNewSubject()">
                <i class="fas fa-save" style="margin-right:6px;"></i>Save Subject
            </button>
        </div>
    </div>
</div>

{{-- ── Action Dropdown ── --}}
<div id="actionDropdown" class="action-dropdown" style="display:none;">
    <button class="dropdown-item drop-active"  onclick="setStudentStatus('active')"><i class="fas fa-user-check"></i> Mark as Active</button>
    <button class="dropdown-item drop-dropped" onclick="setStudentStatus('dropped')"><i class="fas fa-user-slash"></i> Mark as Dropped</button>
</div>

{{-- ── Mobile nav ── --}}
<div class="mobile-nav-overlay" id="mobile-nav-overlay"></div>
<div class="mobile-nav-drawer" id="mobile-nav-drawer">
    <button class="mobile-nav-close" id="mobile-nav-close" aria-label="Close menu">
        <i class="fas fa-times"></i>
    </button>
    <div class="mobile-brand">
        <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo" style="width:70px;display:block;margin:0 auto 10px;">
        <p>DIVINE WORD COLLEGE<br>OF URDANETA</p>
        <span>Faculty Portal</span>
    </div>
    <a href="{{ route('faculty.students') }}"      class="nav-item"><i class="fas fa-users"></i> Student List</a>
    <a href="{{ route('faculty.calendar') }}"      class="nav-item"><i class="fas fa-calendar-alt"></i> Calendar</a>
    <a href="{{ route('faculty.gradebook') }}"     class="nav-item active-drawer"><i class="fas fa-book-open"></i> Gradebook</a>
    <a href="{{ route('faculty.announcements') }}" class="nav-item"><i class="fas fa-bullhorn"></i> Announcement</a>
    <a href="{{ route('faculty.logs') }}"          class="nav-item"><i class="fas fa-history"></i> Activity Logs</a>
    <div class="mobile-logout">
        <form method="POST" action="{{ route('faculty.logout') }}">
            @csrf
            <button type="submit" style="background:none;border:none;cursor:pointer;color:#fca5a5;font-weight:600;padding:10px;width:100%;border-radius:8px;font-family:'Afacad',sans-serif;font-size:1rem;">
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
            'grade'     => $grade,
            'section'   => $s->section ?? '',
            'status'    => $s->status ?? 'active',
        ];
    })->values();
@endphp
<script type="application/json" id="students-data">{!! json_encode($studentsJson, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}</script>
<script>
    window.STUDENTS = JSON.parse(document.getElementById('students-data').textContent);

    window.quizRoutes = {
        store:      "{{ route('faculty.quizzes.store') }}",
        index:      "{{ route('faculty.quizzes.index') }}",
        submissions: "{{ url('faculty/quizzes') }}", // + /{id}/submissions
    };

    window.gradeRoutes = {
        base: "{{ url('faculty/students') }}", // + /{id}/grades
    };
</script>
<script src="{{ asset('js/faculty-gradebook.js') }}"></script>
</body>
</html>
