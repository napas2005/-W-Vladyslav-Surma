document.addEventListener('DOMContentLoaded', function () {
    const completedTasksContainer = document.getElementById('completed-tasks');
    const slug = document.querySelector('meta[name="category-slug"]').getAttribute('content');

    document.body.addEventListener('change', function (event) {
        if (event.target.classList.contains('task-checkbox')) {
            const checkbox = event.target;
            const taskId = checkbox.getAttribute('data-task_id');
            const isCompleted = checkbox.checked ? 1 : 0;

            fetch(`/tasks/${taskId}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ is_completed: isCompleted })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        fetch(`/categories/${slug}/completed-tasks`)
                            .then(response => response.text())
                            .then(html => {
                                completedTasksContainer.innerHTML = html;
                            });
                    } else {
                        console.error('Помилка оновлення статусу');
                    }
                })
                .catch(error => console.error('Ajax Error:', error));
        }
    });

    document.body.addEventListener('change', function (event) {
        if (event.target.name === 'filter-radio') {
            const isCompleted = event.target.id === 'filter-radio-example-1' ? 1 : 0;

            fetchTasks(isCompleted);
        }
    });

    function fetchTasks(isCompleted = null) {
        const url = isCompleted !== null
            ? `/categories/${slug}/tasks?is_completed=${isCompleted}`
            : `/categories/${slug}/tasks`;

        fetch(url)
            .then(response => response.text())
            .then(html => {
                completedTasksContainer.innerHTML = html;
            })
            .catch(error => console.error('Ajax Error:', error));
    }

    const dropdownButton = document.getElementById("dropdownRadioButton");
    const radioInputs = document.querySelectorAll('input[name="filter-radio"]');

    radioInputs.forEach((radio) => {
        radio.addEventListener("change", () => {
            const label = radio.nextElementSibling;
            if (label) {
                dropdownButton.childNodes[2].nodeValue = label.textContent.trim();
            }
        });
    });
});
