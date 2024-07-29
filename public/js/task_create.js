function updateTaskIndices() {
    const tasks = document.querySelectorAll('.task-item');
    tasks.forEach((task, index) => {
        task.querySelector('input[name^="tasks["]').setAttribute('name', `tasks[${index}][name]`);
        task.querySelector('textarea[name^="tasks["]').setAttribute('name', `tasks[${index}][description]`);
        task.querySelector('select[name^="tasks["][name*="[priority]"]').setAttribute('name', `tasks[${index}][priority]`);
        task.querySelector('select[name^="tasks["][name*="[status]"]').setAttribute('name', `tasks[${index}][status]`);
        task.querySelector('input[name^="tasks["][type="datetime-local"]').setAttribute('name', `tasks[${index}][deadline]`);
    });
}

function addTask() {
    const container = document.getElementById('tasks-container');
    const firstTask = container.querySelector('.task-item');
    const taskItem = firstTask.cloneNode(true);

    // Очистка значений в клонированных полях
    taskItem.querySelector('input[name^="tasks["]').value = '';
    taskItem.querySelector('textarea[name^="tasks["]').value = '';
    taskItem.querySelector('select[name^="tasks["][name*="[priority]"]').selectedIndex = 0;
    taskItem.querySelector('select[name^="tasks["][name*="[status]"]').selectedIndex = 0;
    taskItem.querySelector('input[name^="tasks["][type="datetime-local"]').value = '';

    container.appendChild(taskItem);
    updateTaskIndices();
}

function removeTask(button) {
    const taskItem = button.closest('.task-item');
    taskItem.remove();
    updateTaskIndices();
}

document.addEventListener('DOMContentLoaded', () => {
    updateTaskIndices();
});