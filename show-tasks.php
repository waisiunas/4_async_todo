<?php
session_start();
if (!isset($_SESSION['user']) && empty($_SESSION['user'])) {
	header('location: ./');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

	<link rel="preconnect" href="https://fonts.gstatic.com" />
	<link rel="shortcut icon" href="./assets/img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

	<title>Tasks</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	<link href="./assets/css/app.css" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet" />
</head>

<body>
	<div class="wrapper">
		<?php require_once('./partials/side-navbar.php'); ?>

		<div class="main">
			<?php require_once('./partials/top-navbar.php'); ?>

			<main class="content">
				<div class="container-fluid p-0">
					<h1 class="h3 mb-3">Tasks</h1>
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">
									<h3 class="text-center">Add Task</h3>
									<div id="error"></div>
									<form action="" id="add-form">
										<div class="row">
											<div class="col-md-10">
												<input type="text" class="form-control" name="task-input" id="task-input" placeholder="Please enter the task!">
											</div>
											<div class="col-md-2">
												<input type="submit" value="Add" class="btn btn-primary">
											</div>
										</div>
									</form>
								</div>

								<div class="card-body">
									<h5>Tasks</h5>
									<div id="tasks">
										<!-- <div class="row mb-2">
											<div class="col-md-9">
												<input type="text" class="form-control" id="task-" value="Database Value" placeholder="Please enter the task!" readonly>
											</div>
											<div class="col">
												<button class="btn btn-info" id="edit-" onclick="editTask(1)">Edit</button>
											</div>
											<div class="col">
												<button class="btn btn-danger" id="delete-" onclick="editTask(1)">Delete</button>
											</div>
										</div> -->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>

			<?php require_once('./partials/footer.php'); ?>
		</div>
	</div>

	<script src="./assets/js/app.js"></script>
	<script>
		showTasks();

		const addFormElement = document.getElementById('add-form');
		const errorElement = document.getElementById('error');

		addFormElement.addEventListener('submit', function(e) {
			e.preventDefault();

			const taskInputElement = document.getElementById('task-input');

			let taskInputValue = taskInputElement.value;

			errorElement.innerHTML = "";
			taskInputElement.classList.remove('is-invalid');

			if (taskInputValue == "") {
				taskInputElement.classList.add('is-invalid');
				errorElement.innerHTML = alert('danger', 'Please provide the task!');
			} else {
				const data = {
					text: taskInputValue,
					submit: 1,
				};

				fetch('./add-task.php', {
						method: 'POST',
						body: JSON.stringify(data),
						headers: {
							'Content-Type': 'application.json'
						}
					})
					.then(function(response) {
						return response.json();
					})
					.then(function(result) {
						if (result.taskError) {
							taskElement.classList.add('is-invalid');
							errorElement.innerHTML = alert('danger', result.taskError);
						} else if (result.error) {
							errorElement.innerHTML = alert('danger', result.error);
						} else if (result.success) {
							errorElement.innerHTML = alert('success', result.success);
							addFormElement.reset();
							showTasks();
						} else {
							errorElement.innerHTML = alert('danger', 'Something went wrong!');
						}
					})
			}
		});

		function showTasks() {
			fetch('./fetch-tasks.php')
				.then(function(response) {
					return response.json();
				})
				.then(function(result) {
					let tasksElement = '';
					result.forEach(function(value) {
						tasksElement += `<div class="row mb-2">
											<div class="col-md-9">
												<input type="text" class="form-control" id="task-${value.id}" value="${value.text}" placeholder="Please enter the task!" readonly>
											</div>
											<div class="col">
												<button class="btn btn-info" id="edit-${value.id}" onclick="editTask(${value.id})">Edit</button>
											</div>
											<div class="col">
												<button class="btn btn-danger" id="delete-${value.id}" onclick="deleteTask(${value.id})">Delete</button>
											</div>
										</div>`;
					});

					const mainTasksElement = document.getElementById('tasks');
					mainTasksElement.innerHTML = tasksElement;
				})
		}

		function editTask(id) {
			const btnEditElement = document.getElementById('edit-' + id);
			const taskElement = document.getElementById('task-' + id);

			let taskValue = taskElement.value;

			if (btnEditElement.innerText == "Edit") {
				btnEditElement.innerText = "Save";
				taskElement.removeAttribute('readonly');
				taskElement.focus();
				taskElement.setSelectionRange(taskValue.length, taskValue.length);
			} else {

				errorElement.innerHTML = "";
				taskElement.classList.remove('is-invalid');

				if (taskValue == "") {
					taskElement.classList.add('is-invalid');
					errorElement.innerHTML = alert('danger', 'Please provide the task!');
				} else {
					const data = {
						text: taskValue,
						id: id,
						submit: 1,
					};

					fetch('./edit-task.php', {
							method: 'POST',
							body: JSON.stringify(data),
							headers: {
								'Content-Type': 'application.json'
							}
						})
						.then(function(response) {
							return response.json();
						})
						.then(function(result) {
							if (result.taskError) {
								taskElement.classList.add('is-invalid');
								errorElement.innerHTML = alert('danger', result.taskError);
							} else if (result.error) {
								errorElement.innerHTML = alert('danger', result.error);
							} else if (result.success) {
								errorElement.innerHTML = alert('success', result.success);
								addFormElement.reset();
								showTasks();
							} else {
								errorElement.innerHTML = alert('danger', 'Something went wrong!');
							}
							btnEditElement.innerText = "Edit";
							taskElement.setAttribute('readonly', true);
						})
				}
			}
		}

		function deleteTask(id) {
			const data = {
				id: id,
				submit: 1,
			};

			fetch('./delete-task.php', {
					method: 'POST',
					body: JSON.stringify(data),
					headers: {
						'Content-Type': 'application.json'
					}
				})
				.then(function(response) {
					return response.json();
				})
				.then(function(result) {
					if (result.error) {
						errorElement.innerHTML = alert('danger', result.error);
					} else if (result.success) {
						errorElement.innerHTML = alert('success', result.success);
						addFormElement.reset();
						showTasks();
					}
				})
				.catch(function(error) {
					console.log(error);
				})
		}

		function alert(cls, msg) {
			return `<div class="alert alert-${cls} alert-dismissible fade show" role="alert">${msg}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
		}
	</script>
</body>

</html>