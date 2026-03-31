let tasks = [];

document.querySelectorAll('.task-item').forEach(li => {
  tasks.push({
    id:   li.dataset.id,
    text: li.querySelector('.task-text').textContent.trim(),
    done: li.classList.contains('done')
  });
});

updateStats();
checkEmpty();

document.getElementById('addForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const input = document.getElementById('taskInput');
  const text  = input.value.trim();
  if (!text) return;

  const id   = 'task_' + Date.now();
  const task = { id, text, done: false };
  tasks.push(task);
  renderTask(task);
  updateStats();
  checkEmpty();
  input.value = '';
  input.focus();
  saveToServer();
});

function toggleTask(id) {
  const task = tasks.find(t => t.id === id);
  if (!task) return;
  task.done = !task.done;

  const li = document.querySelector(`[data-id="${id}"]`);
  if (li) {
    li.classList.toggle('done', task.done);
    li.querySelector('.checkmark').textContent = task.done ? '✓' : '';
  }
  updateStats();
  saveToServer();
}

function deleteTask(id) {
  tasks = tasks.filter(t => t.id !== id);
  const li = document.querySelector(`[data-id="${id}"]`);
  if (li) {
    li.style.transition = 'opacity 0.2s, transform 0.2s';
    li.style.opacity    = '0';
    li.style.transform  = 'translateX(20px)';
    setTimeout(() => li.remove(), 200);
  }
  updateStats();
  checkEmpty();
  saveToServer();
}

function clearDone() {
  const doneTasks = tasks.filter(t => t.done);
  if (!doneTasks.length) return;
  doneTasks.forEach(t => deleteTask(t.id));
  setTimeout(saveToServer, 50);
}

function renderTask(task) {
  const list = document.getElementById('taskList');
  const li   = document.createElement('li');
  li.className  = 'task-item' + (task.done ? ' done' : '');
  li.dataset.id = task.id;
  li.innerHTML  = `
    <button class="check-btn" onclick="toggleTask('${task.id}')">
      <span class="checkmark">${task.done ? '✓' : ''}</span>
    </button>
    <span class="task-text">${escapeHtml(task.text)}</span>
    <button class="delete-btn" onclick="deleteTask('${task.id}')">✕</button>
  `;
  list.appendChild(li);
}

function updateStats() {
  const total = tasks.length;
  const done  = tasks.filter(t => t.done).length;
  const pct   = total === 0 ? 0 : Math.round((done / total) * 100);
  document.getElementById('totalCount').textContent    = total + (total === 1 ? ' task' : ' tasks');
  document.getElementById('doneCount').textContent     = done  + ' done';
  document.getElementById('progressFill').style.width  = pct + '%';
}

function checkEmpty() {
  const empty = document.getElementById('emptyState');
  const list  = document.getElementById('taskList');
  if (tasks.length === 0) {
    empty.classList.add('visible');
    list.style.display = 'none';
  } else {
    empty.classList.remove('visible');
    list.style.display = 'flex';
  }
}

function saveToServer() {
  fetch('save_tasks.php', {
    method:  'POST',
    headers: { 'Content-Type': 'application/json' },
    body:    JSON.stringify(tasks)
  }).catch(err => console.warn('Save failed:', err));
}

function escapeHtml(str) {
  const div = document.createElement('div');
  div.textContent = str;
  return div.innerHTML;
}