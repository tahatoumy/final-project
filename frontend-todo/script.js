const taskInput = document.getElementById('taskInput');
const addTaskBtn = document.getElementById('addTaskBtn');
const taskList = document.getElementById('taskList');
const toggleTheme = document.getElementById('toggleTheme');

// Add new task
addTaskBtn.addEventListener('click', () => {
  const taskText = taskInput.value.trim();
  if (taskText !== '') {
    createTask(taskText);
    taskInput.value = '';
  }
});

// Pressing "Enter" adds task
taskInput.addEventListener('keypress', (e) => {
  if (e.key === 'Enter') {
    addTaskBtn.click();
  }
});

// Toggle light/dark mode
toggleTheme.addEventListener('click', () => {
  document.body.classList.toggle('dark');
});

// Create task item
function createTask(text) {
  const li = document.createElement('li');

  const taskLeft = document.createElement('div');
  taskLeft.classList.add('task-left');

  const checkbox = document.createElement('input');
  checkbox.type = 'checkbox';
  checkbox.addEventListener('change', () => {
    li.classList.toggle('completed', checkbox.checked);
  });

  const span = document.createElement('span');
  span.textContent = text;

  taskLeft.appendChild(checkbox);
  taskLeft.appendChild(span);

  const editBtn = document.createElement('button');
  editBtn.textContent = '✏️';
  editBtn.onclick = () => {
    const input = document.createElement('input');
    input.type = 'text';
    input.value = span.textContent;
    input.onblur = () => {
      span.textContent = input.value;
      taskLeft.replaceChild(span, input);
    };
    taskLeft.replaceChild(input, span);
    input.focus();
  };

  const deleteBtn = document.createElement('button');
  deleteBtn.textContent = '🗑️';
  deleteBtn.onclick = () => {
    li.remove();
  };

  const btnGroup = document.createElement('div');
  btnGroup.classList.add('task-buttons');
  btnGroup.appendChild(editBtn);
  btnGroup.appendChild(deleteBtn);

  li.appendChild(taskLeft);
  li.appendChild(btnGroup);
  taskList.appendChild(li);
}
