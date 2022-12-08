<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Green Glass Study Lamp</title>
	<link rel="stylesheet" href="./main.css">
		 <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&family=Red+Hat+Display&family=Ubuntu&display=swap" rel="stylesheet">
	<!-- Bootstrap link -->
	    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

	<?php
    		$glFile="Green_Glass_Study_Lamp_InScene_Draco.glb";
			$source="../../../../estore_vault/Lamps/Desk_Lamps/Green_Glass_Study_Lamp/models";
    		$dest="models";
    		copy($source.'/'.$glFile, $dest.'/'.$glFile);
	?>

</head>

<body>
<div class="Backgoung-image">
	<img src="LightGradient.png">
</div>
		<div class=" ModelViewrMain gx-0 p-4">

	<div class="col-12 col-md-7 col-lg-9">

		<div id="loadingBar">
			<div id="loadingProgress"></div>

		</div>


		<div id="Poster">
			<img src="./images/Inscene_Poster.jpg" id="posterImage" style="width: 120%;">

		</div>

		<div id="ModelViewer" style="width: 120%;">

		</div>

		<script type="module">

			const container = document.querySelector('#ModelViewer');
			var w = container.clientWidth;
			var h = container.clientHeight;



			import * as THREE from '../../../js/ThreeJs/jsm/three.module.js';
			import { OrbitControls } from '../../../js/ThreeJs/jsm/OrbitControls.js';
			import { GLTFLoader } from '../../../js/ThreeJs/jsm/GLTFLoader.js';
			import { RGBELoader } from '../../../js/ThreeJs/jsm/RGBELoader.js';
			import { RoughnessMipmapper } from '../../../js/ThreeJs/jsm/RoughnessMipmapper.js';
			import { DRACOLoader } from '../../../js/ThreeJs/jsm/DRACOLoader.js';
			import TWEEN from '../../../js/TweenJs/tween.esm.js';


			var scene = new THREE.Scene();

			var manager = new THREE.LoadingManager();
			var progressBar = document.querySelector('#loadingProgress');
			var progressBarContainer = document.querySelector('#loadingBar')
			var Poster = document.querySelector("#Poster");
			var progress;

			function fadeOutEffect(fadeTarget) {
					var fadeEffect = setInterval(function () {
						if (!fadeTarget.style.opacity) {
							fadeTarget.style.opacity = 1;
						}
						if (fadeTarget.style.opacity > 0) {
							fadeTarget.style.opacity -= 0.1;
						} else {
							clearInterval(fadeEffect);
						}
					}, 10);
				}

			manager.onStart = function (url, itemsLoaded, itemsTotal) {

				console.log('Started loading file: ' + url + '.\nLoaded ' + itemsLoaded + ' of ' + itemsTotal + ' files.');

			};

			manager.onLoad = function () {

				fadeOutEffect(progressBar);
				fadeOutEffect(progressBarContainer);
				fadeOutEffect(Poster);
				setTimeout(function () {
					progressBar.parentElement.removeChild(progressBar);
					progressBarContainer.parentElement.removeChild(progressBarContainer);
					Poster.parentElement.removeChild(Poster);
				}, 300);

				console.log('Loading complete!');
			};


			manager.onProgress = function (url, itemsLoaded, itemsTotal) {

				//console.log('Loading file: ' + url + '.\nLoaded ' + itemsLoaded + ' of ' + itemsTotal + ' files.');
				progressBar.style.width = (itemsLoaded / itemsTotal * 100) + '%';
				progress = progressBar.style.width;

			};

			var camera = new THREE.PerspectiveCamera(50, w / h, 0.1, 1000);

			var renderer = new THREE.WebGLRenderer({ antialias: true });
			renderer.setSize(w, h);
			renderer.toneMapping = THREE.ReinhardToneMapping;
			renderer.shadowMap.enabled = true;
			renderer.shadowMap.type = THREE.VSMShadowMap;
			renderer.physicallyCorrectLights = true;
			renderer.toneMappingExposure = 2.3;

			container.appendChild(renderer.domElement);

			//Adds Responsiveness to 3D viewer
			function resize() {
				renderer.setSize(container.clientWidth, container.clientHeight);
				camera.aspect = container.clientWidth / container.clientHeight;
				camera.updateProjectionMatrix();
			};

			window.addEventListener("resize", resize);


			//Camera Orbit Controls
			camera.position.z = 1.5;
			camera.position.y = 0.8;

			var cameraControls = new OrbitControls(camera, renderer.domElement);
			cameraControls.target.set(0, 0.5, 0);

			// autorotate
			var checkBox = document.getElementById("auto-rotate-id");
			checkBox.addEventListener('change', function () {

				if (checkBox.checked == true) {
					cameraControls.autoRotate = true;
					console.log("true");
				} else {
					cameraControls.autoRotate = false;
					console.log("flase");
				}
			});

			cameraControls.enableZoom = true;
			cameraControls.autoRotateSpeed = 0.5;
			cameraControls.enableDamping = true;
			cameraControls.dampingFactor = 0.1;
			//cameraControls.saveState();

			//Ambient Light Source
			var light = new THREE.HemisphereLight(0xffeeb1, 0x080820, 1);
			light.position.set(10, 10, 25);
			scene.add(light);



			//HDR and BackGround Selector
			let HDRpath = '../../../hdri/lebombo_1k.hdr';
			let backgroundPath = '../../../hdri/lebombo_1k.jpg';

			document.querySelector("#hdris").addEventListener("input", (event) => {

				let x;
				let temp;
				x = event.target.value;
				temp = new Array();
				temp = x.split(";");
				HDRpath = temp[0];
				backgroundPath = temp[1];

				EnvironmentLoader()

			});

			EnvironmentLoader();

			//Loads and Sets HDR and BackGround Images
			function EnvironmentLoader() {

				var HDRLoader = new RGBELoader();
				HDRLoader.setDataType(THREE.UnsignedByteType)
				HDRLoader.load(HDRpath,
					function (texture) {
						var envMap = pmremGenerator.fromEquirectangular(texture).texture;
						scene.environment = envMap;
						texture.dispose();
						pmremGenerator.dispose();
						HDRLoader.needUpdate = true;
					})

				var backgroundLoader = new THREE.TextureLoader();
				backgroundLoader.load(backgroundPath, function (texture) {

					var envMap = pmremGenerator.fromEquirectangular(texture).texture;
					scene.background = envMap;
					backgroundLoader.needUpdate = true;
				});
			};

			//Light COntrolls
			var GLTFlight;
			var lightColor;

			var Lights = document.getElementById("Lights");
			Lights.addEventListener('change', lightsEvent);

			function lightsEvent() {


				if (Lights.checked == true) {
					for(var object in studyLampObject){
						updateSceneObjectProperty(studyLampObject[object], "switch", true);
					}
					renderer.toneMappingExposure = 2.3;

					colorred.disabled = false;
					colorgreen.disabled = false;
					colorblue.disabled = false;

					brightnessUI.disabled = false;
				} else {

					for(var object in studyLampObject){
						updateSceneObjectProperty(studyLampObject[object], "switch", false);
					}

					renderer.toneMappingExposure = 1.0;


					colorred.disabled = true;
					colorgreen.disabled = true;
					colorblue.disabled = true;

					brightnessUI.disabled = true;
				}
			}

			//LightBrightnessCTRL

			var brightnessUI = document.getElementById("brighntessrange");
			var colorred = document.getElementById("colorname_red");
			var colorgreen = document.getElementById("colorname_green");
			var colorblue = document.getElementById("colorname_blue");

			var lightcolorUI = document.getElementById("lightColor");

			brightnessUI.oninput = function () {
				brightnessCTRL();
			}



			function brightnessCTRL() {
				var val = brightnessUI.value;
				for(var object in studyLampObject){
					updateSceneObjectProperty(studyLampObject[object], "brightness", val);
				}
			}

			//LightColorCTRL


			colorsUIchange();

			function colorsUIchange() {
				colorred.style.background = `rgb(255,0,0)`;
				colorgreen.style.background = `rgb(0,255,0)`;
				colorblue.style.background = `rgb(0,0,255)`;

			}



			//LightColorCTRL


			colorred.oninput = function () {
				colorCTRL();
			}

			colorgreen.oninput = function () {
				colorCTRL();
			}

			colorblue.oninput = function () {
				colorCTRL();
			}

			//List of Colors



			function colorCTRL() {
				var colorsNew = colorProcess();
				for(var object in studyLampObject){
					updateSceneObjectProperty(studyLampObject[object], "color", colorsNew);
				}

			}

			colorProcess();

			function colorProcess() {
				var Red = document.getElementById("colorname_red").value;
				var Green = document.getElementById("colorname_green").value;
				var Blue = document.getElementById("colorname_blue").value;
				var redValue, greenValue, blueValue;
				brightnessUI.style.background = `linear-gradient(to right, rgb(${Red*200}, ${Green*200}, ${Blue*200}),   rgb(${Red*400}, ${Green*400}, ${Blue*400}) 70%)`;




				return {
					redValue: Red,
					greenValue: Green,
					blueValue: Blue,

				}
			}



			var studyLampObject;

			var pmremGenerator = new THREE.PMREMGenerator(renderer);
			pmremGenerator.compileEquirectangularShader();

			//GLTF Loader with Light Adjutments

			// Draco GLTF Loader
			var dracoLoader = new DRACOLoader();
			dracoLoader.setDecoderPath('../../../js/ThreeJs/draco/');

			var loader = new GLTFLoader(manager);
			loader.setDRACOLoader(dracoLoader);

			loader.setPath('models/');
			loader.load('Green_Glass_Study_Lamp_InScene_Draco.glb', function (gltf) {

				scene.add(gltf.scene);


				studyLampObject = {
					Light : scene.getObjectByName("Point001_Orientation"),
				};
				deleter();

			});

			async function updateSceneObjectProperty(sceneObject, prop, value){
				await null;

					if(prop == "brightness"){
						sceneObject.intensity = value;
					}
					else if(prop == "color"){
						sceneObject.color.setRGB(value.redValue, value.greenValue, value.blueValue);
					}
					else{
						sceneObject.visible = value;
					}
			}


			// resetview
			function ResetCamera() {
				var currentCameraPosition = { px: camera.position.x, py: camera.position.y, pz: camera.position.z, rx: camera.rotation.x, ry: camera.rotation.y, rz: camera.rotation.z }; // Start at (0, 0)
				var cameraTarget = { px: 0, py: 0.8, pz: 1.5, rx: -0.197, ry: 0, rz: 0 };
				var tween = new TWEEN.Tween(currentCameraPosition).to(cameraTarget, 1000);
				tween.onUpdate(function () {
					camera.position.x = currentCameraPosition.px;
					camera.position.y = currentCameraPosition.py;
					camera.position.z = currentCameraPosition.pz;

					camera.rotation.x = currentCameraPosition.rx;
					camera.rotation.y = currentCameraPosition.ry;
					camera.rotation.z = currentCameraPosition.rz;
				});
				tween.easing(TWEEN.Easing.Cubic.InOut);
				tween.interpolation(TWEEN.Interpolation.Bezier);
				tween.start();
			};

			document.getElementById("ResetView").addEventListener("click", ResetView);

			function ResetView() {
				ResetCamera();
				console.log(camera.position)
				console.log(camera.rotation)

			}






			//Updates Every Frame
			function animate() {

				TWEEN.update();
				requestAnimationFrame(animate);
				cameraControls.update();
				renderer.render(scene, camera);
			}

			animate();

			var Reload = document.getElementById("Reload");
			Reload.addEventListener('click', function () {
				document.getElementById("colorname_red").value = "0.5";
				document.getElementById("colorname_green").value = "0.5";
				document.getElementById("colorname_blue").value = "0.5";
				document.getElementById("brighntessrange").value = "20";

				document.getElementById("Lights").checked=true;
				lightsEvent();

				colorCTRL()
				brightnessCTRL();
				console.log("test");
				});
		</script>
		</div>


	<div class="col">

		<div id="title">
				<h1>Green Glass Study Lamp</h1>
				<span>$299.99</span>
		</div>
		<div class="playground">
		<div class="EnvironmentImage mt-2">
			<label for="hdris" class="hdris-label content-label mt-1">Environment: </label>
			<select id="hdris" class="content-text">
				<option  value="../../../hdri/wooden_lounge_0.5k.hdr;../../../hdri/wooden_lounge_1k.jpg">
							Wooden lounge
						</option>
				<option  value="../../../hdri/ballroom_1k.hdr;../../../hdri/ballroom_1k.jpg">
					Ballroom
				</option>
				<option value="../../../hdri/anniversary_lounge_1k.hdr;../../../hdri/anniversary_lounge_1k.jpg">
					Anniversary lounge
				</option>
				<option value="../../../hdri/autoshop_01_1k.hdr;../../../hdri/autoshop_01_1k.jpg">
					Autoshop
				</option>
				<option value="../../../hdri/studio003small.hdr;../../../hdri/studio003small.jpg">
					Studio small
				</option>
				<option value="../../../hdri/kiara_interior_1k.hdr;../../../hdri/kiara_interior_1k.jpg">
					Kiara interior
				</option>
				<option selected="selected" value="../../../hdri/lebombo_1k.hdr;../../../hdri/lebombo_1k.jpg">
					Lebombo
				</option>

			</select>
		</div>



	<!-- <section class="ModelViewrUI"> -->


		<div class="UIButtons">Lights
			<label for="Lights"></label>
			<input id="Lights" class="form-check-input" type="checkbox" checked="" style="border-radius: 30px;" />
		</div>

		<!-- <div class="Details"></div>
		<div class="DetailsObjects">
			<p><span class="lightColor" id="lightColor"> </span></p>


		</div> -->

		<div class="row">
			<div class="col-3">
				<div class="color color_name" style="font-weight: normal; ">Red</div>
			</div>
			<div class="col pt-2">
				<input type="range" min="0" max="1" value="0.5" step="0.1" class="slider" id="colorname_red">
			</div>
		</div>
		<div class="row">
			<div class="col-3">
				<div class="green color_name_Green" style="font-weight: normal;">Green </div>
			</div>
			<div class="col pt-2">
				<input type="range" min="0" max="1" value="0.5" step="0.1" class="slider" id="colorname_green">
			</div>
		</div>
		<div class="row">
			<div class="col-3">
				<div class="red color_name_Blue" style="font-weight: normal; ">Blue </div>
			</div>
			<div class="col pt-2">
				<input type="range" min="0" max="1" value="0.5" step="0.1" class="slider" id="colorname_blue">
			</div>
		</div>
		<div class="row">
			<div class="col-3">
				<div class="brightness brightness_name" style="font-weight: normal; ">Brightness </div>
			</div>
			<div class="col pt-2">
				<input type="range" min="0" max="41" value="19" step="4" class="slider" id="brighntessrange">
			</div>
		</div>


				<!-- <div class="d-flex flex-wrap justify-content-between align-items-end"> -->
				<div class="flex-con">
					<div >
						<br><br><br>
						<!-- <script src="../../../js/dimensions/dimensions_Change.js"></script>
						<link rel="stylesheet" href="../../../css/dimensions/dimensions.css"> -->

					</div>
					<div id="model-controls">

						<div class="AutoRotate">
							<label for="auto-rotate-id">AutoRotate:</label>
							<input id="auto-rotate-id" onclick="auto_rotate()" type="checkbox" checked="false">
						</div>

						<div class="ResetView">
							<button id="ResetView" class="reset-view-btn" type="button" data-toggle="tooltip" data-bs-placement="top" title="Reset View">

								<img src="../../../images/reset-view-icon.png" />
								<!-- <span class="tooltiptext">Reset View</span> -->

							</button>

						</div>

						<div class="Reload">
							<button id="Reload" class="reset-model-btn" type="button" data-toggle="tooltip" data-bs-placement="top" title="Reset Model">
								<img  src="../../../images/reset-model-icon.png"/>
							</button>
						</div>
					</div>
				</div>
			</div>

		<!-- <div class="brightness_name">Brightness</div> -->


	<!-- </section> -->
<!-- 	<div class="ResetView" id="ResetView">
			<button type="button">Reset View</button>
	</div> -->
	<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
</script>
</div>
</div>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


	<script>
		function deleter(){
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.open("GET","deleter.php?glFile=<?php echo $glFile;?>");
			xmlhttp.send();
			console.log("Deletion done");
		};
	</script>

</body>

</html>
