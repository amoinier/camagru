// Put event listeners into place
window.addEventListener("DOMContentLoaded", function() {
	// Grab elements, create settings, etc.
	var canvas = document.getElementById("canvas"),
		context = canvas.getContext("2d"),
		video = document.getElementById("video"),
		videoObj = { "video": true },
		errBack = function(error) {
			console.log("Video capture error: ", error.code);
		};

	// Put video listeners into place
	if(navigator.getUserMedia) { // Standard
		navigator.getUserMedia(videoObj, function(stream) {
			video.src = stream;
			video.play();
		}, errBack);
	} else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
		navigator.webkitGetUserMedia(videoObj, function(stream){
			video.src = window.URL.createObjectURL(stream);
			video.play();
		}, errBack);
	}
	else if(navigator.mozGetUserMedia) { // Firefox-prefixed
		navigator.mozGetUserMedia(videoObj, function(stream){
			video.src = window.URL.createObjectURL(stream);
			video.play();
		}, errBack);
	}

	// Trigger photo take
	document.getElementById("snapbut").addEventListener("click", function() {
		var filterok = document.getElementById("filterid").selectedIndex;
		var donn = document.getElementsByTagName("option")[filterok].value;
		if (donn.toString() !== "") {
			var img = new Image();
			img.src = 'resources/filtres/'+ donn;
			img.onload = function() {
				context.drawImage(video, 0, 0, 640, 480);
				context.drawImage(img, 0, 0, img.width, img.height);
			}
		}
		else {
			alert("Selectionez un filtre");
		}
	});

	document.getElementById("savebut").addEventListener("click", function() {
		var filterok = document.getElementById("filterid").selectedIndex;
		var donn = document.getElementsByTagName("option")[filterok].value;
		if (donn.toString() !== "")
			post('snap.php', {img: canvas.toDataURL("image/png"), sub: 'save', filterpost: donn});
		else
			alert("Selectionez un filtre");
	});
}, false);

function post(path, params) {
    method = "post";
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);
            form.appendChild(hiddenField);
         }
    }
    document.body.appendChild(form);
    form.submit();
}
