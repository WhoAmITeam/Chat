// Загрузка файла
//
function ekUpload(){
	function Init() {

		console.log("Загрузка Инициализирована");

		var fileSelect    = document.getElementById('file-upload'),
			fileDrag      = document.getElementById('file-drag'),
			submitButton  = document.getElementById('submit-button');

		fileSelect.addEventListener('change', fileSelectHandler, false);

		// XHR2 доступен?
		var xhr = new XMLHttpRequest();
		if (xhr.upload) {
			// File Drop
			fileDrag.addEventListener('dragover', fileDragHover, false);
			fileDrag.addEventListener('dragleave', fileDragHover, false);
			fileDrag.addEventListener('drop', fileSelectHandler, false);
		}
	}

	function fileDragHover(e) {
		var fileDrag = document.getElementById('file-drag');

		e.stopPropagation();
		e.preventDefault();

		fileDrag.className = (e.type === 'dragover' ? 'hover' : 'modal-body file-upload');
	}

	function fileSelectHandler(e) {
		// Fetch FileList object
		var files = e.target.files || e.dataTransfer.files;

		// Отменить событие и стиль
		fileDragHover(e);

		// Обрабатывать все файловые объекты
		for (var i = 0, f; f = files[i]; i++) {
			parseFile(f);
			uploadFile(f);
		}
	}

	function output(msg) {
		var m = document.getElementById('messages');
		m.innerHTML = msg;
	}

	function parseFile(file) {

		console.log(file.name);
		output(
			'<strong>' + '</strong>'
		);

		// var fileType = file.type;
		// console.log(fileType);
		var imageName = file.name;

		//var isGood = (/\.(?=gif|jpg|png|jpeg)/gi).test(imageName);
		var isGood = 1;
		if (isGood) {
			document.getElementById('start').classList.add("hidden");
			document.getElementById('response').classList.remove("hidden");
			document.getElementById('notimage').classList.add("hidden");
			// Предварительный просмотр
			document.getElementById('file-image').classList.remove("hidden");
			document.getElementById('file-image').src = URL.createObjectURL(file);
		}
		else {
			document.getElementById('file-image').classList.add("hidden");
			document.getElementById('notimage').classList.remove("hidden");
			document.getElementById('start').classList.remove("hidden");
			document.getElementById('response').classList.add("hidden");
			document.getElementById("file-upload-form").reset();
		}
	}

	function setProgressMaxValue(e) {
		var pBar = document.getElementById('file-progress');

		if (e.lengthComputable) {
			pBar.max = e.total;
		}
	}

	function updateFileProgress(e) {
		var pBar = document.getElementById('file-progress');

		if (e.lengthComputable) {
			pBar.value = e.loaded;
		}
	}

	function uploadFile(file) {

		var xhr = new XMLHttpRequest(),
			fileInput = document.getElementById('class-roster-file'),
			pBar = document.getElementById('file-progress'),
			fileSizeLimit = 1024; // В MB
		if (xhr.upload) {
			// Проверка, если размер файла меньше x MB
			if (file.size <= fileSizeLimit * 1024 * 1024) {
				// Индикатор выполнения
				pBar.style.display = 'inline';
				xhr.upload.addEventListener('loadstart', setProgressMaxValue, false);
				xhr.upload.addEventListener('progress', updateFileProgress, false);

				// Файл получен / сбой
				xhr.onreadystatechange = function(e) {
					if (xhr.readyState == 4) {
						// Всё хорошо!

						// progress.className = (xhr.status == 200 ? "success" : "failure");
						// document.location.reload(true);
					}
				};

				// Начать загрузку
				xhr.open('POST', document.getElementById('file-upload-form').action, true);
				xhr.setRequestHeader('X-File-Name', file.name);
				xhr.setRequestHeader('X-File-Size', file.size);
				xhr.setRequestHeader('Content-Type', 'multipart/form-data');
				xhr.send(file);
			} else {
				output('Пожалуйста, загрузите файл меньше, чем (< ' + fileSizeLimit + ' MB).');
			}
		}
	}

	// Проверьте наличие поддержки различных файловых API.
	if (window.File && window.FileList && window.FileReader) {
		Init();
	} else {
		document.getElementById('file-drag').style.display = 'none';
	}
}
ekUpload();