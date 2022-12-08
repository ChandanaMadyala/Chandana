function auto_rotate() {
	var checkbox = document.getElementById("auto-rotate-id");
	var viewer = document.getElementById("model-viewer-id");
	
	if(checkbox.checked) {
		viewer.setAttribute("auto-rotate", true); 
		viewer.setAttribute("auto-rotate-delay", "1000");
		//alert("auto-rotate true"); for debugging.
	} else {
		//viewer.setAttribute("auto-rotate", false); //did not work.
		viewer.removeAttribute("auto-rotate");
		//alert("auto-rotate false"); for debugging
	}
}