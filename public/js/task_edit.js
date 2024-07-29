function updateTaskEditIndices() {
    const tasks = document.querySelectorAll('.task-item:not(.template)');
    tasks.forEach((task, index) => {
        task.querySelector('input[name^="tasks["][name$="[id]"]').setAttribute('name', `tasks[${index}][id]`);
        task.querySelector('input[name^="tasks["][name$="[name]"]').setAttribute('name', `tasks[${index}][name]`);
        task.querySelector('textarea[name^="tasks["][name$="[description]"]').setAttribute('name', `tasks[${index}][description]`);
        task.querySelector('select[name^="tasks["][name$="[priority]"]').setAttribute('name', `tasks[${index}][priority]`);
        task.querySelector('select[name^="tasks["][name$="[status]"]').setAttribute('name', `tasks[${index}][status]`);
        task.querySelector('input[name^="tasks["][name$="[deadline]"]').setAttribute('name', `tasks[${index}][deadline]`);
    });
}

function addEditTask() {
    const container = document.getElementById('tasks-container');
    let template = document.querySelector('.task-item.template');

    if (!template) {
        console.error('Template task item not found.');
        return;
    }

    const taskItem = template.cloneNode(true);
    taskItem.classList.remove('template');
    taskItem.style.display = '';

    // Очистка значений в клонированных полях
    taskItem.querySelector('input[name^="tasks["][name$="[id]"]').value = '';
    taskItem.querySelector('input[name^="tasks["][name$="[name]"]').value = '';
    taskItem.querySelector('textarea[name^="tasks["][name$="[description]"]').value = '';
    taskItem.querySelector('select[name^="tasks["][name$="[priority]"]').selectedIndex = 0;
    taskItem.querySelector('select[name^="tasks["][name$="[status]"]').selectedIndex = 0;
    taskItem.querySelector('input[name^="tasks["][name$="[deadline]"]').value = '';

    container.appendChild(taskItem);
    updateTaskEditIndices();
}

function removeEditTask(button) {
    const taskItem = button.closest('.task-item');
    taskItem.remove();
    updateTaskEditIndices();
}

function validateForm() {
    // Удалить все шаблонные задачи перед отправкой формы
    document.querySelectorAll('.task-item.template').forEach(template => {
        template.remove();
    });

    // Проверить, есть ли пустые обязательные поля
    const tasks = document.querySelectorAll('.task-item:not(.template)');
    tasks.forEach(task => {
        const name = task.querySelector('input[name^="tasks["][name$="[name]"]').value;
        if (!name) {
            task.querySelector('input[name^="tasks["][name$="[name]"]').focus();
            return false;
        }
    });

    // Отправить форму
    document.getElementById('project-form').submit();
}

document.addEventListener('DOMContentLoaded', () => {
    updateTaskEditIndices();
});