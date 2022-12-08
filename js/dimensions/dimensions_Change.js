    
    /* Dimension Test */


    document.write(`

		<form name="dimensions">
			<div class="Dimensions form-check form-switch ps-0">
			  <label class="form-check-label float-start content-label" for="show-dimensions">Dimensions</label>
			  <input class="form-check-input" type="checkbox" id="show-dimensions" >
			</div>


			<div class="Units">

				<label for="Units" class="content-label">Units:</label>
				
				<div id='Units'>
					<input class="form-check-input" name="Units" type="radio" value="cm" id="units-cm-input" checked>
					<label class="form-check-label content-text" for="units-cm-input">
						cm
					</label>
					<input class="form-check-input" name="Units" type="radio" value="m" id="units-cm-input">
					<label class="form-check-label content-text" for="units-m-input">
						m
					</label>
					<input class="form-check-input" name="Units" type="radio" value="in" id="units-in-input">
					<label class="form-check-label content-text" for="units-in-input">
						in
					</label>
					<input class="form-check-input" name="Units" type="radio" value="ft" id="units-ft-input">
					<label class="form-check-label content-text" for="units-ft-input">
						ft
					</label>
				</div>

			</div>
		</form> 
    `);

        window.onload = function () {
        
       modelviewer.addEventListener('load', () => {


        const hotSpot = modelviewer.querySelectorAll('button');
                hotSpot.forEach((hotspot) => {
                hotspot.classList.add('hide');
                });

        
        const center = modelviewer.getCameraTarget();
        const size = modelviewer.getDimensions();
        const x2 = size.x / 2;
        const y2 = size.y / 2;
        const z2 = size.z / 2;

        //Model Viewer By Default Calculates the Dimensions in Meters
        
        var tempUnitMul = 100;
        var tempUnit = "cm";

        var Units = {
            m : 1,
            cm : 100,
            in : 39.37,
            ft : 3.28,
        };

        UnitsCal();
		
		var radios = document.forms['dimensions'].elements["Units"];
		for(var i = 0, max = radios.length; i < max; i++) {
			radios[i].onclick = function() {
				UnitsConvert();
				UnitsCal();
			}
		}


        function UnitsConvert(){
            tempUnit = event.target.value;
            tempUnitMul = Units[tempUnit];
            //console.log(tempUnit);
            //console.log(tempUnitMul);
       };

       // Calculates the Size

       function UnitsCal(){

            modelviewer.querySelector('button[slot="hotspot-dim+X-Y"]').textContent =
            `${(size.z * tempUnitMul).toFixed(2)} ${(tempUnit)}`;

            modelviewer.querySelector('button[slot="hotspot-dim+X-Z"]').textContent =
            `${(size.y * tempUnitMul).toFixed(2)} ${(tempUnit)}`;

            modelviewer.querySelector('button[slot="hotspot-dim+Y-Z"]').textContent =
            `${(size.x * tempUnitMul).toFixed(2)} ${(tempUnit)}`;

            modelviewer.querySelector('button[slot="hotspot-dim-X-Z"]').textContent =
            `${(size.y * tempUnitMul).toFixed(2)} ${(tempUnit)}`;

            modelviewer.querySelector('button[slot="hotspot-dim-X-Y"]').textContent =
            `${(size.z * tempUnitMul).toFixed(2)} ${(tempUnit)}`;
       };


       // Places HotSpots
 
        modelviewer.updateHotspot({
        name: 'hotspot-dot+X-Y+Z',
        position: `${center.x + x2} ${center.y - y2} ${center.z + z2}`
        });

        modelviewer.updateHotspot({
        name: 'hotspot-dim+X-Y',
        position: `${center.x + x2} ${center.y - y2} ${center.z}`
        });


        modelviewer.updateHotspot({
        name: 'hotspot-dot+X-Y-Z',
        position: `${center.x + x2} ${center.y - y2} ${center.z - z2}`
        });

        modelviewer.updateHotspot({
        name: 'hotspot-dim+X-Z',
        position: `${center.x + x2} ${center.y} ${center.z - z2}`
        });


        modelviewer.updateHotspot({
        name: 'hotspot-dot+X+Y-Z',
        position: `${center.x + x2} ${center.y + y2} ${center.z - z2}`
        });

        modelviewer.updateHotspot({
        name: 'hotspot-dim+Y-Z',
        position: `${center.x} ${center.y + y2} ${center.z - z2}`
        });


        modelviewer.updateHotspot({
        name: 'hotspot-dot-X+Y-Z',
        position: `${center.x - x2} ${center.y + y2} ${center.z - z2}`
        });

        modelviewer.updateHotspot({
        name: 'hotspot-dim-X-Z',
        position: `${center.x - x2} ${center.y} ${center.z - z2}`
        });


        modelviewer.updateHotspot({
        name: 'hotspot-dot-X-Y-Z',
        position: `${center.x - x2} ${center.y - y2} ${center.z - z2}`
        });

        modelviewer.updateHotspot({
        name: 'hotspot-dim-X-Y',
        position: `${center.x - x2} ${center.y - y2} ${center.z}`
        });


        modelviewer.updateHotspot({
        name: 'hotspot-dot-X-Y+Z',
        position: `${center.x - x2} ${center.y - y2} ${center.z + z2}`
        });
    });


     /* Dimensions Switch */
     const checkbox = document.querySelector('#show-dimensions');
     const hotSpot = modelviewer.querySelectorAll('button');

     checkbox.addEventListener('change', () => {
    
     hotSpot.forEach((hotspot) => {
        
      if (checkbox.checked) {
        hotspot.classList.remove('hide');
        //console.log("0");
      } else {
        hotspot.classList.add('hide');
        //console.log("1");
      }
        });
      });};