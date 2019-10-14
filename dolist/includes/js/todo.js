$('.todo-form').submit(function(e) {
	e.preventDefault();

	$.ajax({
		type: 'POST',
		data: $(this).serialize(),
		url: './processor.php',
		success: function(response) {
			var data = JSON.parse(response);

			var newTodo = `
			<li class='list-group-item d-flex'>
				<div class='mr-5 mr-md-auto'>
					<h6>Title</h6>
					<small>${data.title}</small>
				</div>
				<div class='mr-5 mr-md-auto'>
					<h6>Date created</h6>
					<small>${data.date}</small>
				</div>
				<div class='mr-5 mr-md-auto'>
					<span class='badge badge-danger badge-pill d-block todo-status'>
						No
					</span>
				</div>
				<div>
					<h6>Actions</h6>
					<div>
						<button class='btn bt-sm btn-success markTodo' id='${data.id}'>
							Mark
						</button>
						<button class='btn bt-sm btn-danger deleteTodo' id='${data.id}'>
							Delete
						</button>
					</div>
				</div>
			</li>`;

			$('.todo-list-group').append(newTodo);
			$('.todo').val('');
		}
	});
});

$(document).on('click', '.deleteTodo', function() {
	var _this = $(this);
	var data = {
		id: $(this).attr('id'),
		delete_todo: ''
	}
	$.ajax({
		type: 'POST',
		data: data,
		url: './processor.php',
		success: function() {
			_this.parent().parent().parent().remove();
		}
	});
});

$(document).on('click', '.markTodo', function() {
	var _this = $(this);
	var data = {
		id: $(this).attr('id'),
		mark_todo: ''
	}
	$.ajax({
		type: 'POST',
		data: data,
		url: './processor.php',
		success: function() {
			_this.parent().parent().prev().children('.todo-status').removeClass('badge-danger').addClass('badge-success').html('Yes');
		}
	});
});

$('.changeSort').on('change', function(e) {
	var val = e.target.value;
	window.location = '?sortBy=' + val;
});